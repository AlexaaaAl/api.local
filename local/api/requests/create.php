<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Currency\CurrencyManager;

header('Content-Type: application/json');

global $USER;

if (!$USER->IsAuthorized()) {
    http_response_code(401);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

if (!Loader::includeModule('sale')) {
    http_response_code(500);
    echo json_encode(['error' => 'Модуль sale не подключён']);
    exit;
}

$title = $_POST['title'] ?? '';

if (!$title) {
    http_response_code(400);
    echo json_encode(['error' => 'Описание заявки обязательно']);
    exit;
}

// Создаём заказ
$order = Order::create(SITE_ID, $USER->GetID());
$order->setPersonTypeId(1); // физ. лицо 
$order->setField('CURRENCY', CurrencyManager::getBaseCurrency());
$order->setField('USER_DESCRIPTION', $title); // текст заявки

//  Пустая корзина 
$basket = Basket::create(SITE_ID);
$order->setBasket($basket);

//  Сохраняем заказ
$result = $order->save();

if (!$result->isSuccess()) {
    http_response_code(400);
    echo json_encode([
        'error' => implode(', ', $result->getErrorMessages())
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'order_id' => $order->getId()
]);
