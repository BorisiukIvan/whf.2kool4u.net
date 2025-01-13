<?php include 'backend/logger.php' ?>
<?php
  if (file_exists('@/_LEVELOF_'.$account)) {
    $lvl = floor(intval(file_get_contents('@/_LEVELOF_'.$account)));
  } else $lvl = 0;
  if ($lvl < 2) {
      echo("Создание файла доступно только при уровне 2 или выше");
      exit;
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Новый документ</title>
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
}
input[type=text] {
  width: 90%;
}
input[type=radio] {
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}
textarea {
  width: 90%;
  height: 500px;
  font-size: 15px;
}
button[type=submit] {
  width: 50%;
  padding: 12px 18px;
  background-color: #666666;
}
button[type=submit]:hover {
  font-size: 30px;
}
section {
  width: 95%;
  background-color: #333333;
  padding: 5px;
}
section * {
  font-size: 20px;
  color: yellow;
}
</style>
<script>
function showArea(id) {
  document.getElementById(id).removeAttribute("hidden");
  if (id == "t2") document.getElementById("fileToUpload").click();
};
</script>
</head>
<body>
<br>
<div id='central'>
<div id='form'>
<form action='upload.php' method='POST' enctype='multipart/form-data'>
<p style='color: #ee0000'>Внимание! Пожалуйста, не пытайтесь взломать систему!</p>
<label for='name'><b>Выберите имя файла:</b></label>
<input name='name' autofocus='1' required='1' maxlength=25>.JSON<br><br>
<label for='minlevel'><b>Уровень, который надо иметь, чтобы видеть файл:</b></label>
<input name='minlevel' type='number' min='0' max='10' value='' required='1'><br><br>
<section>
<b>Советы:</b>
<p>*. Создавать новые файлы рекомендуется только в том случае, когда есть важная информация или надо обсудить какую-то важную информацию. <b>Ни в коем случае не забывайте, что необходимо выставить правильные уровни для чтения и записи!</b></p>
<p>*. Поподробнее про систему уровней можно прочитать здесь: <a href='/docs/levels.html' style='color: pink'>/docs/levels.html</a>.</p>
<p>*. Вы можете выставить минимальный уровень, который необходим для доступа к файлу, который больше вашего, но при этом вы не будете иметь доступ к этому файлу.</p>
</section><br>
<label for='minlevelallow'><b>Уровень, который надо иметь, чтобы дописывать в файл:</b></label>
<input name='minlevelallow' type='number' min='1' max='10' value='' required='1'><br><br>
<label for='placeholder'><b>Короткое описание файла:</b></label><br><b style=' color: white; font-size: 14px'>Будет виднo всем, что имеет право писать в файл</b><br>
<input name='placeholder' maxlength='75' style='width: 90%' value='' required='1'><br><br>
<fieldset><legend><b>Выберите способ создания файла:</b></legend>
<div> <input type="radio" id="1" name="method" value="1" onclick='showArea("t1")'> <label for="huey">Набрать в нашем редакторе</label><br>
<div id='t1' hidden='1'><br>
<textarea name='text'>
Ваш текст увидят все люди, которые имеют уровень больше или равный указанному выше.
</textarea><br><br></div>
</div>
<div> <input type="radio" id="2" name="method" value="2" onclick='showArea("t2")'> <label for="louie">Загрузить с устройства</label>
<div id='t2' hidden='1'><br>
<input type='file' name='uploaded_text' id='fileToUpload'>
<br></div>
</div></fieldset><br>
<div style='text-align: center'><button type='submit'>Загрузить файл</button></div>
</form>
</div>
</div>
</body>
</html>
