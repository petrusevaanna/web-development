<?php

$jsonFilePath = '../login/login_data.json'; 
$jsonData = file_get_contents($jsonFilePath);
$loginData = json_decode($jsonData, true); 
if ($loginData === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "Ошибка при чтении JSON: " . json_last_error_msg(); 
    $loginData = []; 
}

$title = isset($loginData['title']) ? $loginData['title'] : 'Войти'; 
$imageSrc = isset($loginData['image']) ? $loginData['image'] : 'картинка'; 
$labelEmail = isset($loginData['label_email']) ? $loginData['label_email'] : 'Электропочта';
$placeholderEmail = isset($loginData['placeholder_email']) ? $loginData['placeholder_email'] : 'Введите электропочту';
$labelPassword = isset($loginData['label_password']) ? $loginData['label_password'] : 'Пароль';
$placeholderPassword = isset($loginData['placeholder_password']) ? $loginData['placeholder_password'] : 'Введите пароль';
$buttonText = isset($loginData['button_text']) ? $loginData['button_text'] : 'Продолжить';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="../login/front/front.css" type="text/css" rel="stylesheet" />
    <link href="../login/style/login.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="content">
        <h1 class="titue"><?php echo htmlspecialchars($title); ?></h1>
        <img class="images" src="<?php echo htmlspecialchars($imageSrc); ?>" title="<?php echo htmlspecialchars($title); ?>" alt="упс картинка не загрузилась">
        <form class="from">
            <label class="label" for="email"><?php echo htmlspecialchars($labelEmail); ?></label>
            <input id="email" type="email" class="input input-error" placeholder="<?php echo htmlspecialchars($placeholderEmail); ?>" />
            <span class="input-info input-info-error"><?php echo htmlspecialchars($placeholderEmail); ?></span>
            <label class="label" for="password"><?php echo htmlspecialchars($labelPassword); ?></label>
            <input id="password" type="password" class="input input-error" placeholder="<?php echo htmlspecialchars($placeholderPassword); ?>"/>
            <span class="input-info input-info-error"><?php echo htmlspecialchars($placeholderPassword); ?></span>
            <input type="submit" class="button" value="<?php echo htmlspecialchars($buttonText); ?>" />
        </form>
    </div>
</body>
</html>