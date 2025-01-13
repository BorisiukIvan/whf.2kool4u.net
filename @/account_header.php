<?php
  if (file_exists('_LEVELOF_'.$account)) {
    $lvl = floor(intval(file_get_contents('_LEVELOF_'.$account)));
  } else $lvl = 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Профиль пользователя <?=$user?></title>
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
  padding: 5px;
}
input {
  background-color: #ddd;
  margin-top: 8px;
  width: auto;
}
textarea {
  width: 90%;
  height: 500px;
  font-size: 15px;
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
button {
  border-radius: 0px;
  font-size: 24px;
  padding-left: 7px;
  padding-right: 7px;
  padding-top: 2px;
  padding-bottom: 2px;
}
#raiselevel input {
    width: 100px;
}
</style>
</head>
<body>
<div id='central'>
<br>
<div id='form'>
<p style='margin-top: 0px'><b style='color: #dfa; font-size: 28px'>Профиль пользователя <?=$user?></b></p>
<span>Уровень: <b style='color: red'><?=file_get_contents("_LEVELOF_$user")?></b> 
<!-- только админы сайта могут менять уровни, на стороне сервера всё защищено. А те кто будут проверять, рискуют получить бан по IP.-->
<form style='display: inline'  action='changelevel.php' method="POST" id='raiselevel'>
<button <?php if ($lvl < 10) echo("hidden='1'")?> type="button" onclick="document.getElementById('newlvl').removeAttribute('hidden')">Изменить</button>
<span id='newlvl' hidden='1'> <b style='font-size: 28px'>+</b><input name='user' hidden='1' value='<?=$user?>'><input name='newlvl' type="number" required="1" min="-10" max="9" value="0" step=".01">
<button type="submit">Готово</button></span>
</form></span> 
<p>Дата регистрации: <b style='color: yellow'><?=file_get_contents("_REGISTER_$user")?></b></p>
<p>Был онлайн: <b style='color: yellow'><?=file_get_contents("_LASTSEEN_$user")?></b></p>
<p>Описание: <i style='color: white'><?=file_get_contents("_DESCROF_$user")?></i></p>
<div style='text-align: center'><button onclick='window.open("../","_self")' style='background-color: #0bb'>Вернуться на главную</button><button onclick='window.open("../report.php?val=<?=$user?>","_self")' style='margin-left: 20px; background-color: #c00'>Пожаловаться на пользователя</button></div>
</div>
</div>
</div>
</body>
</html>
