<?php

$jsonFilePath = '../home/home_data.json';

$jsonData = file_get_contents($jsonFilePath);

$postsData = json_decode($jsonData, true);

if ($postsData === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "Ошибка при чтении JSON: " . json_last_error_msg();
    $postsData = [];
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Пример страницы</title>
    <link href="../home/front/front.css" type="text/css" rel="stylesheet" />
    <link href="../home/style_home/home.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <?php foreach ($postsData as $post): ?>
            <div class="post">
                <img src="<?php echo htmlspecialchars($post['avatar']); ?>"
                     alt="аватарка"
                     style="width: 32px; height: 32px; border-radius: 6px;">

                <div class="author"><?php echo htmlspecialchars(isset($post['author']) ? $post['author'] : 'Автор'); ?></div>
                <img src="<?php echo htmlspecialchars($post['image']); ?>"
                     alt="Изображение поста">
                <div class="content"><?php echo htmlspecialchars(isset($post['content']) ? $post['content'] : 'Текст поста'); ?></div>
                <div class="date"><?php echo htmlspecialchars(isset($post['date']) ? $post['date'] : 'Дата'); ?></div>
                <button class="button">
                    <span class="heart-icon">❤️</span>
                    <?php echo htmlspecialchars(isset($post['likes']) ? $post['likes'] : '0'); ?>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
