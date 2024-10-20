import os
from dotenv import load_dotenv
import pandas as pd
import pymysql

# Читаем Excel файл
xl = pd.ExcelFile('db.xlsx')
sheet_name = xl.sheet_names[5]
df = xl.parse(sheet_name)

# Заменяем NaN на None
df = df.replace({pd.NA: None})

# Инициализация списков для каждой таблицы
sites = []
equipment = []
nodes = []
components = []
operations = []
service_characteristics = []
alert_characteristics = []
component_operation_pivot = []

# Словари для отслеживания предыдущих id
site_ids = {}
equipment_ids = {}
node_ids = {}
operation_ids = {}

# Переменные для отслеживания текущих id
last_site_id = 0
last_equipment_id = 0
last_node_id = 0

# Проходим по строкам DataFrame
for index, row in df.iterrows():
    # Преобразуем строку в словарь и заменяем NaN на None
    row = {k: None if pd.isna(v) else v for k, v in row.items()}

    if isinstance(row['Участок'], str):
        if row['Участок'] not in site_ids:
            sites.append({'name': row['Участок']})
            site_ids[row['Участок']] = len(sites)
        last_site_id = site_ids[row['Участок']]

    if isinstance(row['Наименование оборудования'], str) and last_site_id:
        equip_key = (row['Наименование оборудования'], last_site_id)
        if equip_key not in equipment_ids:
            equipment.append(
                {'name': row['Наименование оборудования'], 'inventory_number': row.get('Инвентарный номер'),
                 'site_id': last_site_id})
            equipment_ids[equip_key] = len(equipment)
        last_equipment_id = equipment_ids[equip_key]

    if isinstance(row['Агрегат/ узел'], str) and last_equipment_id:
        node_key = (row['Агрегат/ узел'], last_equipment_id)
        if node_key not in node_ids:
            nodes.append({'name': row['Агрегат/ узел'], 'equipment_id': last_equipment_id})
            node_ids[node_key] = len(nodes)
        last_node_id = node_ids[node_key]

    if isinstance(row['Деталь'], str) and last_node_id:
        component_id = len(components) + 1
        components.append({
            'name': row['Деталь'],
            'vendor_code': row.get('Идентификатор (артикул)'),
            'amount': row.get('Количество'),
            'node_id': last_node_id,
            'unit_id': 1
        })

        service_characteristics.append({
            'serviceable_id': component_id,
            'serviceable_type': 'App\\Models\\Component',
            'service_period_in_days': row.get('Период обслуживания (дни)'),
            'service_period_in_engine_hours': row.get('Период обслуживания (моточасы)'),
            'service_period_in_mileage': row.get('Пробег (км)')
        })

        # Заполняем operations и компонент-операция связи
        operation_name = row.get('Наименование ТОиР')
        if operation_name:
            if operation_name not in operation_ids:
                operations.append({'name': operation_name})
                operation_ids[operation_name] = len(operations)
            component_operation_pivot.append(
                {'component_id': component_id, 'operation_id': operation_ids[operation_name]})

# Подключаемся к базе данных и вставляем данные
try:
    load_dotenv()
    connection = pymysql.connect(
        host=os.getenv('DB_HOST'),
        port=int(os.getenv('DB_PORT')),
        database=os.getenv('DB_DATABASE'),
        user=os.getenv('DB_USERNAME'),
        password=os.getenv('DB_PASSWORD'),
    )
    cursor = connection.cursor()

    # Функция для вставки данных в таблицы
    def insert_data(table_name, data):
        if not data:
            return
        keys = data[0].keys()
        columns = ', '.join(keys)
        placeholders = ', '.join(['%s'] * len(keys))
        sql_query = f"INSERT INTO {table_name} ({columns}) VALUES ({placeholders})"
        for row in data:
            values = tuple(row[key] for key in keys)
            cursor.execute(sql_query, values)

    # Вставляем данные в таблицы
    insert_data('sites', sites)
    insert_data('equipment', equipment)
    insert_data('nodes', nodes)
    insert_data('components', components)
    insert_data('operations', operations)
    insert_data('service_characteristics', service_characteristics)
    insert_data('alert_characteristics', alert_characteristics)
    insert_data('component_operation_pivot', component_operation_pivot)

    connection.commit()
    print("All data inserted successfully.")

except Exception as e:
    connection.rollback()
    print("Error occurred:", e)

finally:
    cursor.close()
    connection.close()
