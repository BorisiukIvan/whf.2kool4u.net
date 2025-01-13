<?php include 'backend/logger.php' ?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Регистрация</title>
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
  background-color: #182;
  margin: 10px;
}
section {
  width: 95%;
  background-color: #222;
  padding: 5px;
}
section * {
  font-size: 20px;
  color: yellow;
}
#qqq * {
  margin: 1px;
}
</style>
</head>
<body>
<br>
<div id='central'>
<div id='form'>
<p style='text-align: right; font-size: 15px; margin: 0px'>Уже есть аккаунт? <a href='login.php' style='font-size: 15px; color: pink; padding-right: 10px'>Войти</a></p>
<form action='register.php' method='POST'>
<p style='color: yellow'>Зарегистрироваться на сайте</p>
<label for='login' ><b>Придумайте никнейм:</b></label><br>
<input name='login' autofocus='1' required='1' maxlength=25><br><br>
<label for='password'><b>Придумайте пароль:</b></label><br>
<input name='password' type='password' minlength=5 required='1'><br><br>
<section>
<big>Советы:</big>
<p>1. <b>Пароль и логин не могут содержать русские буквы (кириллицу) и/или пробелы, учти это!</b></p> 
<p>2. Если ты не хочешь, чтобы люди узнали, что ты здесь, выбери никнейм, который отличается от тех, которые у тебя на других сайтах.</p>
<p>3. Не ставь слишком ненадёжные пароли, потому что аккаунт могут взломать. Ссылку на статью про простые и сложные пароли см. ниже.</p>
<p>4. Либо сделай достаточно простой пароль, чтобы его запомнить, либо сохрани пароль в браузере, так как сбросить или поменять его <b>нельзя</b>!</p>
<p>5. Желаем приятно провести время :)</p>
<hr style='color: #777;'>
<p>Про правила сайта можно прочитать здесь: <a href='docs/rules.html' style='color: pink'>/docs/rules.html</a></p>
<p>Про надёжные и ненадёжные пароли можно прочитать здесь: <a href='docs/pwds.html' style='color: pink'>/docs/pwds.html</a></p>
</section><br>
<div id='qqq'>
<label for='description'><b>Статус:</b></label><br>
<h6 style='font-size: 14px; color: white'>Статус - это краткая надпись про тебя, может быть цитатой. Она необязательная.</h6> 
<input name='description' maxlength='50'><br><br>
</div>
<div style='text-align: center'><button type='submit'>Зарегистрироваться</button></div>
</form>
</div>
</div>
</body>
</html>
