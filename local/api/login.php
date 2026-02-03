<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;

header('Content-Type: application/json');

$request = Application::getInstance()->getContext()->getRequest();

$email = $request->getPost("email");
$password = $request->getPost("password");

global $USER;

if (!$USER->Login($email, $password)) {
    http_response_code(401);
    echo json_encode([
        'error' => $USER->GetLastError()
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'user_id' => $USER->GetID()
]);
