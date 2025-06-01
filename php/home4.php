<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'validation.php';

$jsonFilePath = 'home_data.json';

if (isset($_GET['id'])) {
    $profileUserId = $_GET['id'];

    // Исправленная проверка: id должен быть цифровым и > 0
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

    if ($userInfo !== null) {
        if (!validateLength($userInfo['author'], 2, 50)) {
            throw new Exception("Ошибка валидации: Длина имени автора должна быть от 2 до 50 символов.");
        }
        if (!validateString($userInfo['author'])) {
            throw new Exception("Ошибка валидации: Имя автора должно быть строкой.");
        }
        if (!validateInteger($userInfo['user_id'])) {
            throw new Exception("Ошибка валидации: user_id должно быть целым числом.");
        }
    }

} catch (Exception $e) {
    echo "<div style='color: red; border: 1px solid red; padding: 10px;'>Ошибка: " . htmlspecialchars($e->getMessage()) . "</div>";
    $userPosts = [];
    $userInfo = null;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Профиль пользователя <?php echo htmlspecialchars($profileUserId); ?></title>
    <link href="../home/front/front.css" rel="stylesheet" />
    <link href="../home/style_home/home.css" rel="stylesheet" />
    <style>
        .profile-info {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Профиль пользователя <?php echo htmlspecialchars($profileUserId); ?></h1>

    <?php if ($userInfo !== null): ?>
        <div class="profile-info">
            <img src="" alt="Аватар" style="width: 50px; height: 50px;">
            <p>Автор: <?php echo htmlspecialchars($userInfo['author'] ?? 'Неизвестно'); ?></p>
        </div>
    <?php else: ?>
        <p>Информация о пользователе не найдена.</p>
    <?php endif; ?>