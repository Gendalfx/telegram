<?php
// Токен телеграм бота
$tg_bot_token = "7161940055:AAHh7PtHzGRzfH_akZiyK7p9ZNu9IvQ7zl8";
// ID Чата
$chat_id = "-1002005242948";

$text = '';

foreach ($_POST as $key => $val) {
    $text .= $key . ": " . $val . "\n";
}

$text .= "\n" . $_SERVER['REMOTE_ADDR'];
$text .= "\n" . date('d.m.y H:i:s');

$param = [
    "chat_id" => $chat_id,
    "text" => $text
];

$url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendMessage?" . http_build_query($param);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
if ($response === false) {
    echo 'Ошибка curl: ' . curl_error($ch);
}
curl_close($ch);

foreach ($_FILES as $file) {
    $url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendDocument";

    $document = curl_file_create($file['tmp_name'], $file['type'], $file['name']);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ["chat_id" => $chat_id, "document" => $document]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Ошибка curl: ' . curl_error($ch);
    }
    curl_close($ch);
}

die('1');
?>
