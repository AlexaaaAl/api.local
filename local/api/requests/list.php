<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;

header('Content-Type: application/json');

global $USER;

if (!$USER->IsAuthorized()) {
    http_response_code(401);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

Loader::includeModule('sale');

$orders = Order::getList([
    'filter' => [
        'USER_ID' => $USER->GetID()
    ],
    'order' => ['ID' => 'DESC'],
    'select' => ['ID', 'DATE_INSERT', 'STATUS_ID', 'USER_DESCRIPTION']
]);

$result = [];

while ($order = $orders->fetch()) {
    $result[] = [
        'id' => $order['ID'],
        'date' => $order['DATE_INSERT']->toString(),
        'status' => $order['STATUS_ID'],
        'description' => $order['USER_DESCRIPTION']
    ];
}

echo json_encode($result);
