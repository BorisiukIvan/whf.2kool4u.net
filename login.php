<?php
    $website;
    Здесь надо указать домен веб-сайта, например $website = "whf.2kool4u.net";
 
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
       $login = $_POST['login'];
       $password = $_POST['password'];
       file_put_contents('backend/server_logs/TRIES_TO_LOGIN', $_SERVER['REMOTE_ADDR'] . ' ' . $login . ' ' . $password . ' ' . $_SERVER['REQUEST_TIME'] . "\n", FILE_APPEND);
       if (!file_exists('@/' . $_POST['login'] . '.php')) {
           $login_status = 'Ошибка: такого логина не существует';
           header('Location: /login.php?error=login-doesnt-exist');
           exit;
       }
       $old_version = file_get_contents('backend/server_logs/TRIES_TO_LOG_IN_' . $login);
       file_put_contents('backend/server_logs/TRIES_TO_LOG_IN_' . $login, $_SERVER['REMOTE_ADDR'] . ' ' . $password . ' ' . $_SERVER['REQUEST_TIME'] . "\n" . $old_version);
       if (file_exists("backend/LOGPASS/" . $login . '-' . $password)) {
           setcookie('account', $login . '-' . $password, time() + 10 * 365 * 31 * 24 * 60, "/", $website, 0);
           header('Location: /');
       } else {
           http_response_code(401);
           $login_status = 'Ошибка: неправильный логин или пароль';
       }
    } else $login_status = '';
?>
<?php include 'backend/logger.php' ?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Вход</title>
<style>
* {
  font-size: 24px;
  font-family: monospace;
}
body {
  text-align: center;
  color: #66FF00;
  background-color: #222222;
}
#central {
  width: 60%;
  margin-left: auto;
  margin-right: auto;
}
#form {
  background-color: #444444;
  text-align: left;
  padding: 5px 0px 5px 10px;
}
input {
  background-color: #ddd;
  margin-top: 8px;
  width: 60%;
}
textarea {
  width: 90%;
  height: 500px;
  font-size: 15px;
}
button {
  width: 40%;
  padding: 12px 18px;
  background-color: purple;
  margin: 10px;
}
section {
  width: 95%;
  background-color: #222;
  padding: 5px;
}
section * {
  font-size: 20px;
  color: red;
}
</style>
</head>
<body>
<br>
<div id='central'>
<div id='form'>
<p style='text-align: right; font-size: 15px; margin: 0px'>Ещё нет аккаунта? <a href='signup.php' style='font-size: 15px; color: pink; padding-right: 10px'>Зарегистрироваться</a></p>
<form action='login.php' method='POST'>
<p style='color: yellow'>Вход в систему</p>
<label for='login' ><b>Введите свой никнейм:</b></label><br>
<input name='login' autofocus='1' required='1' maxlength=25'><br><br>
<label for='password'><b>Введите свой пароль:</b></label><br>
<input name='password' type='password' required='1'><br><br>
<section>
<b>Внимание!</b>
<p>Все попытки входа записываются. Если ты будешь пытаться войти в чужие аккаунты, мы примем меры. Так что давай жить дружно :)</p>
</section><br>
<div style='text-align: center'><button type='submit'>Войти</button></div>
</form>
</div>
</div>
</body>
</html>
