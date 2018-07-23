<?php

$filename = __DIR__.DIRECTORY_SEPARATOR.'test'.DIRECTORY_SEPARATOR.$_GET["test"].'.json';

if (!file_exists($filename)) {
    http_response_code(404);
    exit("404: TEST NOT FOUND");
}

$json = file_get_contents($filename);
$contents = json_decode($json, true);
//print_r($json);
$counter = 1;
$inputName = 'q';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imgtmp = __DIR__ . '\src\losdiplomos.png';
    $userName = $_POST['name'];
    $number = 'Ваша оценка: 5';
    $image = imagecreatefrompng($imgtmp);
    $background = imagecolorexact($image, 0, 0, 0);
    $font = __DIR__ . '\src\couriernew.ttf';
    imagettftext($image, 25, 0, 30, 175, $background, $font, $userName);
    imagettftext($image, 20, 0, 30, 200, $background, $font, $number);
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
</head>
<body>
<h1>Тест</h1>
<form action="" method="post">
<?php foreach ($contents as $item) :?>
    <fieldset>
        <legend><?php echo $item['question']?></legend>
        <?php foreach ($item['answers'] as $variant) :?><label><input type="radio" name="<?php echo $inputName.$counter++?>"><?php echo $variant;?></label><?php endforeach;?>
    </fieldset>
<?php endforeach;?>
    <fieldset>
        Ваше имя: <input name="name" type="text"><br />
    </fieldset>
    <input type="submit" placeholder="Отправить"/>
</form>

</body>
</html>