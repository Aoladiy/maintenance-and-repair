import pandas as pd
import numpy as np
import pymysql

# Читаем Excel файл
xl = pd.ExcelFile('db.xlsx')

# Забираем название нужного листа в экселе
sheet_name = xl.sheet_names[3]
df = xl.parse(sheet_name)

lst = []
last_site_id = None
last_equipment_id = None
last_inventory_id = None
last_node_id = None
last_component_id = None
prev_last_site_id = None
prev_last_equipment_id = None
prev_last_inventory_id = None
prev_last_node_id = None
prev_last_component_id = None

for index, row in df.iterrows():
    index += 1
    if isinstance(row['Участок'], str):
        last_site_id = index
        last_changed_id = 'site'
    if isinstance(row['Наименование оборудования'], str):
        prev_last_site_id = last_site_id
        last_equipment_id = index
        last_changed_id = 'equipment'
    if isinstance(row['Инвентарный номер'], str) or isinstance(row['Инвентарный номер'], int):
        prev_last_equipment_id = last_equipment_id
        last_inventory_id = index
        last_changed_id = 'inventory'
    if isinstance(row['Агрегат/ узел'], str):
        prev_last_inventory_id = last_inventory_id
        last_node_id = index
        last_changed_id = 'node'
    if isinstance(row['Деталь'], str):
        prev_last_node_id = last_node_id
        last_component_id = index
        last_changed_id = 'component'

    if last_changed_id == 'site':
        parent_id = None
    elif last_changed_id == 'equipment':
        parent_id = prev_last_site_id
    elif last_changed_id == 'inventory':
        parent_id = prev_last_equipment_id
    elif last_changed_id == 'node':
        parent_id = prev_last_inventory_id
    elif last_changed_id == 'component':
        parent_id = prev_last_node_id

    row_dict = row.to_dict()
    row_dict['parent_id'] = parent_id
    lst.append(row_dict)

# Проходим по списку словарей и заменяем NaN на None
for item in lst:
    for key, value in item.items():
        if pd.isna(value):
            item[key] = None
        if item.get('parent_id') is not None:
            item['parent_id'] = int(item['parent_id'])

# Подключаемся к базе данных и вставляем данные
try:
    # Connect to the MySQL database
    connection = pymysql.connect(
        host='localhost',
        port=3307,
        user='root',
        password='Root-123',
        database='maintenance_and_repair'
    )

    # Create a cursor object
    cursor = connection.cursor()

    # Define the SQL query to insert data into the 'items' table
    sql_query = "INSERT INTO items (id, site, equipment_name, inventory_number, node, component, vendor_code, operation, service_period_in_days, service_period_in_engine_hours, mileage, amount, parent_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"

    # Execute the SQL query for each dictionary in the list
    current_index = 1
    for item in lst:
        values = (
            current_index,
            item.get('Участок'),
            item.get('Наименование оборудования'),
            item.get('Инвентарный номер'),
            item.get('Агрегат/ узел'),
            item.get('Деталь'),
            item.get('Идентификатор (артикул)'),
            item.get('Наименование ТОиР'),
            item.get('Период обслуживания (дни)'),
            item.get('Период обслуживания (моточасы)'),
            item.get('Пробег (км)'),
            item.get('Количество'),
            item.get('parent_id')
        )
        try:
            cursor.execute(sql_query, values)
            # print(current_index, values) # для отладки
        except Exception as e:
            print("Error occurred at index:", current_index)
            print("Error in data:", values)
            raise e  # Пробрасываем ошибку для прекращения выполнения программы

        current_index += 1

    # Commit the transaction
    connection.commit()
    print("All data inserted successfully.")

except Exception as e:
    # Rollback the transaction if an error occurs
    connection.rollback()
    print("Error occurred:", e)

finally:
    # Close the cursor and database connection
    cursor.close()
    connection.close()

# Спорные моменты:
# 123 строчка, Конвейерный транспортер производства РФ.
# 703 строчка, Буровая самоходная установка Titon 500.
# Без инвентарного номера и агрегата / узла
#
# Обратить внимание на аномалию, не требует дополнительных действий
# 588 строчка инвентарный номер 00-000038. К чему относится Период обслуживания 365 дней?
#
# Я решил, что относится к оборудованию, а не к инвентарному номеру
# 1289 строчка УКДМ CDM856М (3) (4) (5) (6) (7) (8) - 6 шт. один тип 00-000031 00-000042 00-000051 00-000103 00-000104 00-000129 наименования оборудования записаны одной строчкой, а относящиеся к ним инвентарные номера каждый в отдельной строке - эта аномалия не позволяет записать в виде древовидной структуры
#
# я решил перезаписать все инвентарные номера в одну соответсвующую строку
# Удалить содержимое поля Агрегат / узел для каждого инвентарного номера
