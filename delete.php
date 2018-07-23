<?php
$filename = $_GET['file'];
unlink(__DIR__.'/test'.DIRECTORY_SEPARATOR.$filename);
header('location: list.php');
