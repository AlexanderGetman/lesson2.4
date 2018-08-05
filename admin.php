<?php
require_once './functions.php';
header('Content-Type: text/html; charset=utf-8');

if (empty($_SESSION['guest'] == false)) {
    http_response_code(403);
    exit('Авторизуйтесь');
}

if(isset($_POST['submit'])){
    header('Location: list.php');
}

$dest = __DIR__.'/test'.'/test'.$_FILES['test']['name'];

if (move_uploaded_file($_FILES['test']['tmp_name'], $dest)) {
    echo "Файл загружен";
} else {
    echo "Файл не загружен";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Домашнее задание</title>
</head>
<body>
<?php if ($_SESSION['user'] !== true) : ?>
<form method="post" enctype="multipart/form-data">
    Отправить: <input name="test" type="file">
    </br>
        <input type="submit" name="submit" value="Отправить файл">

</form>
<?php endif; ?>
<p>Привет, <?php echo $_SESSION['user']['username'];?></p>
<a href="logout.php">Выход</a>
</body>
</html>
