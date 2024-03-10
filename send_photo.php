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
        if ($_FILES['photo']['size'] > 2097152) {
            die('Ошибка Файл не должен быть больше 2 Мбайт.');
        }

        $allowed_extensions = array('jpg', 'jpeg', 'png');
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

        if (!in_array($file_extension, $allowed_extensions)) {
            die('Ошибка Разрешены только файлы с форматом .jpg и .png...');
        }

        move_uploaded_file($_FILES['photo']['tmp_name'], './images/' . $_FILES['photo']['name']);
        $_SESSION['sent']++;
        header('Location: ./images/' . $_FILES['photo']['name']);
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$sent = $_SESSION['sent'];
?>

<p>Количество успешных загрузок: <?php echo $sent; ?></p>
