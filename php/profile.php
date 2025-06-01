<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$jsonFilePath = 'home_data.json';

if (isset($_GET['id'])) {
    $profileUserId = $_GET['id'];

    if (!ctype_digit($profileUserId) || intval($profileUserId) < 1) {
        die("<div style='color: red;'>Ошибка: Неверный параметр id.</div>");
    }
    $profileUserId = intval($profileUserId);
} else {
    die("<div style='color: red;'>Ошибка: Параметр id не указан.</div>");
}

try {
    $jsonData = @file_get_contents($jsonFilePath);
    if ($jsonData === false) {
        throw new Exception("Не удалось загрузить файл JSON: $jsonFilePath");
    }

    $posts = json_decode($jsonData, true);

    if ($posts === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Ошибка декодирования JSON: " . json_last_error_msg());
    }

    if (empty($posts) || !is_array($posts)) {
        throw new Exception("Не найдено постов или неверный формат данных.");
    }

    $userInfo = null;
    foreach ($posts as $post) {
        if (isset($post['user_id']) && $post['user_id'] == $profileUserId) {
            $userInfo = $post;
            break;
        }
    }

    $userPosts = array_filter($posts, function ($post) use ($profileUserId) {
        return isset($post['user_id']) && $post['user_id'] == $profileUserId;
    });

    if (empty($userPosts) && $userInfo === null) {
        throw new Exception("Пользователь с ID $profileUserId не найден или у него нет постов.");
    }

} catch (Exception $e) {
    echo "<div style='color: red; border: 1px solid red; padding: 10px;'>Ошибка: " . $e->getMessage() . "</div>";
    $userPosts = [];
    $userInfo = null;
}
?>
