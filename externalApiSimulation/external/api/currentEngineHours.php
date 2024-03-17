<?php

// Функция для генерации случайного числа от 1 до 30000
function getRandomNumber()
{
    return rand(0, 30000);
}

// Генерация массива объектов
$data = [];
for ($i = 0; $i < 2999; $i++) {
    $data[] = ['number' => getRandomNumber()];
}

// Устанавливаем заголовок Content-Type для JSON
header('Content-Type: application/json');

// Возвращаем JSON
echo json_encode($data);
