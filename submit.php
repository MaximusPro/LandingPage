<?php

if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', 'localhost'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
// Проверяем, что форма пришла методом POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Неправильный метод запроса");
}

// Забираем данные
$name    = $_POST['name']    ?? '';
$email   = $_POST['email']   ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Очень базовая очистка (лучше использовать filter_var + валидацию)
$name    = trim(strip_tags($name));
$email   = trim(filter_var($email, FILTER_SANITIZE_EMAIL));
$subject = trim(strip_tags($subject));
$message = trim(strip_tags($message));

// Простая проверка
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    if(empty($name))
        die("Заполни все поля, агент. Поле 'Name' пустое!");
    else if(empty($email))
        die("Заполни все поля, агент. Поле 'email' пустое!");
    else if(empty($subject))
        die("Заполни все поля, агент. Поле 'Subject' пустое!");
    else if(empty($message))
        die("Заполни все поля, агент. Поле 'Message' пустое!");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Квантовый канал некорректен...");
}

// Здесь можно отправить письмо, записать в базу, отправить в Telegram и т.д.
// Пример — отправка на почту
$to      = "твой@email.com";
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$body = "Новое сообщение из матрицы:\n\n";
$body .= "Neural ID: $name\n";
$body .= "Quantum Channel: $email\n";
$body .= "Mission: $subject\n\n";
$body .= "Transmission:\n$message\n";

/* $sent = mail($to, "Matrix Transmission: $subject", $body, $headers);

if ($sent) {
    // Для AJAX удобно вернуть JSON
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Сигнал доставлен в ядро']);
    } else {
        // для обычной отправки формы — можно сделать редирект
        header("Location: thanks.html");
        exit;
    }
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Ошибка передачи сигнала']);
} */
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'status'  => 'success',
    'message' => 'Сигнал принят в матрицу! (почта отключена для теста)'
]);
exit;

?>