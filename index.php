<?php
require_once './functions.php';
header('Content-Type: text/html; charset=utf-8');


$errors = [];
if (!empty($_POST)) {
    if (login($_POST ['login'], $_POST ['password'])){
        $_SESSION['guest'] = false;
        header('Location: admin.php');
    } else {
        $errors[] = 'Неверный логин или пароль';
    }
}

if (!empty($_POST)) {
    if (guestLogin($_POST ['guestlogin'])){
        $_SESSION['guest'] = true;
        header('Location: list.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (empty($_SESSION['attempts'])) {
        $_SESSION['attempts'] = 1;
    } else {
        $_SESSION['attempts'] += 1;
    }
    if ($_SESSION['attempts'] >= 11) {
        setcookie('access', 'deny', time() + 3600, '', '', false, true);
        http_response_code(403);
        exit('Подождите часок, мы вас заблокировали, а затем попробуйте снова');
    }
    $usersData = getUsers($filedata);
    $loginCheckingResult = getUser($_POST, $usersData);
    $showCaptcha = $_SESSION['attempts'] >= 6;
    $checkCaptcha = $_SESSION['attempts'] > 6;
    if ($checkCaptcha) {
        $captchaCorrect;
        if (empty($_POST['captcha'])) {
            $captchaCorrect = false;
        } else {
            $currentCaptcha = $_SESSION['captcha'];
            $postCaptcha = (int) $_POST['captcha'];
            $captchaCorrect = $currentCaptcha === $postCaptcha;
        }
        if (!$captchaCorrect) {
            $loginCheckingResult['errors'][] = 'Вы точно не робот?!';
        }
    }
}

?>

<ul>
    <?php foreach ($errors as $error):?>
    <li><?= $error ?></li>
    <?php endforeach;?>
</ul>
<p>Авторизуйтесь как пользователь с паролем:</p>
<form id='login' method='post' accept-charset='UTF-8'>
    <fieldset >
        <legend>Логин</legend>
        <input type='hidden' name='submitted' id='submitted' value='1'/>

        <label for='login' >Имя пользователя*:</label>
        <input type='text' name='login' id='login'  maxlength="50" />

        <label for='password' >Пароль:</label>
        <input type='password' name='password' id='password' maxlength="50" />

        <input type='submit' name='Submit' value='Submit' />

    </fieldset>
</form>

<p>Гостевой вход без пароля:</p>
<form id='login' method='post' accept-charset='UTF-8'>
        <fieldset >
            <legend>Логин</legend>
            <input type='hidden' name='submitted' id='submitted' value='1'/>

            <label for='login' >Имя пользователя*:</label>
            <input type='text' name='guestlogin' id='login'  maxlength="50" />

            <input type='submit' name='Submit' value='Submit' />

        </fieldset>
    </form>
<?php if ($showCaptcha): ?>
    <div>
        <label>
            Докажите, что вы не робот:
            <input name="captcha" type="text">
        </label>
    </div>

    <div>
        <img src="captcha.php" />
    </div>
<?php endif; ?>
