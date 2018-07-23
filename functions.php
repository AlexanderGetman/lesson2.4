<?php
session_start();

function login($login, $password) {
    $user = getUser ($login);
    if ($user && $user['password'] == $password) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function getUsers() {
    $filedata = file_get_contents(__DIR__.'/data/users.json');
    $users = json_decode($filedata, true);
    if(!$users) {
        return [];
    }
    return $users;
}

function getUser($login)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['login'] == $login) {
            return $user;
      }
    }
    return null;
}
