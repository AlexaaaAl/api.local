<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

header('Content-Type: application/json');

global $USER;

if (!$USER->IsAuthorized()) {
    http_response_code(401);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

$userId = $USER->GetID();

$rsUser = CUser::GetByID($userId);
$arUser = $rsUser->Fetch();

echo json_encode([
    'id' => $arUser['ID'],
    'email' => $arUser['EMAIL'],
    'login' => $arUser['LOGIN'],
    'name' => $arUser['NAME'],
    'last_name' => $arUser['LAST_NAME']
]);
