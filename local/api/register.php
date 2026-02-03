<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;

header('Content-Type: application/json');

$request = Application::getInstance()->getContext()->getRequest();

$email = $request->getPost("email");
$password = $request->getPost("password");

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Email и пароль обязательны']);
    exit;
}

$user = new CUser();

$arFields = [
    "LOGIN" => $email,
    "EMAIL" => $email,
    "PASSWORD" => $password,
    "CONFIRM_PASSWORD" => $password,
    "ACTIVE" => "Y",
];

$userId = $user->Add($arFields);

if ($userId > 0) {
    echo json_encode([
        'success' => true,
        'user_id' => $userId
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        'error' => $user->LAST_ERROR
    ]);
}
