<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$jsonFilePath = 'home_data.json';
$profileUserId = 1; // ID пользователя по умолчанию

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

    // Фильтруем посты, чтобы получить только посты текущего пользователя
    $userPosts = array_filter($posts, function ($post) use ($profileUserId) {
        return isset($post['user_id']) && $post['user_id'] == $profileUserId;
    });

} catch (Exception $e) {
    echo "<div style='color: red; border: 1px solid red; padding: 10px;'>Ошибка: " . $e->getMessage() . "</div>";
    $userPosts = [];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя <?php echo $profileUserId; ?></title>
    <link href="../home/front/front.css" type="text/css" rel="stylesheet" />
    <link href="../home/style_home/home.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <h1>Профиль пользователя <?php echo $profileUserId; ?></h1>

    <?php if (!empty($userPosts)): ?>
        <?php foreach ($userPosts as $post): ?>
            <?php
            // Проверяем, что нужные ключи существуют
            if (!isset($post['user_id'], $post['avatar'], $post['author'], $post['image'], $post['content'], $post['date'], $post['likes'])) {
                echo "<div style='color: orange; border: 1px solid orange; padding: 5px;'>Не хватает данных для поста с ID: " . ($post['id'] ?? 'N/A') . "</div>";
                continue;
            }
            require 'post1.php'; // Используем тот же шаблон для поста
            ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div>У пользователя <?php echo $profileUserId; ?> нет постов.</div>
    <?php endif; ?>
</div>
</body>
</html>

