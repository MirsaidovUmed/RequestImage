<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Отправка фотографии</title>
</head>
<body>
<form action="send_photo.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="check_session" value="1">
    <input type="file" name="photo">
    <input type="submit" value="Отправить">
</form>
</body>
</html>

<?php

session_start();

if (!isset($_SESSION['sent'])) {
    $_SESSION['sent'] = 0;
}

if (isset($_FILES['photo'])) {
    try {
        $file = $_FILES['photo'];
        if ($_FILES['photo']['size'] > 2097152) {
            die('Ошибка Файл не должен быть больше 2 Мбайт.');
        }

        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

        $mime_type = mime_content_type($file['tmp_name']);

        if (!in_array($file_extension, $allowed_extensions) || !in_array($mime_type, ['image/jpg', 'image/jpeg', 'image/png'])) {
            die('Ошибка Разрешены только файлы с форматом .jpg и .png...');
        }

    } catch (Exception $e) {
        die('Ошибка ' . $e->getMessage());
    }
}

$sent = $_SESSION['sent'];
?>

<p>Количество успешных загрузок: <?php echo $sent; ?></p>
