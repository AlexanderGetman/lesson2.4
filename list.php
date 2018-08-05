<?php
require_once './functions.php';
header('Content-Type: text/html; charset=utf-8');

if (empty($_SESSION['user'])) {
    http_response_code(403);
    exit('Авторизуйтесь');
}

$dir = __DIR__.'/test';
$list = array_diff(scandir($dir), array('..', '.'));
$counter = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список тестов</title>
</head>
<body>
<h1>Список тестов</h1>
<p>Привет, <?php if($_SESSION['guest'] == false)
{
    echo $_SESSION['user']['username'];
} else
    {
        echo $_SESSION['user'];
    };?></p>
<?php foreach ($list as $tests): ?>
<li><?php echo 'Тест номер '.$counter++.' / имя файла: '.$tests.'</br>';?></li>
<?php endforeach;?>
</body>
</html>

<?php if($_SESSION['guest'] == false)
{

    foreach($list as $tests)
    {
    $fileLink = $dir.'/'.$tests;

    echo '<a href="'.$fileLink.'">'.$tests.'</a>'.' ';
    echo '<a href="delete.php?file='.$tests.'">Удалить</a>'.'</br>';
    }
}
echo '<p><a href="logout.php">Выход</a></body></p>';
