<?php include 'backend/logger.php' ?>
<?php
  $filename = $_REQUEST['filename'];
  if ((!$filename) or (!file_exists('backend/files/' . $filename))) {
     if ($lvl > 1) header("Location: /index.php?filename=main.JSON");
     if ($lvl == 1) header("Location: /index.php?filename=chat-dlya-novichkov.JSON");
     if ($lvl < 1) header("Location: /signup.php");
     exit;
  }
  $content = json_decode(file_get_contents('backend/files/' . $filename), true);
  if ($content["read"] > $lvl) {
     echo "<script>document.getElementsByTagName('body')[0].innerHTML = '<p style=\"color: white\">Недостаточно прав для чтения файла. Попробуйте <a href=\"signup.php\">зарегистрироваться</a> или <a href=\"login.php\">войти</a>.</p>'</script>";
     exit;
  }
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
     if ($content["write"] > $lvl) {
         echo "Ошибка. Недостаточно прав для записи в файл";
         exit;
     }
     for ($i = intval($_POST['minlvl']); $i <= intval($_POST['maxlvl']); $i++) {
          $content[$i] = $content[$i] . "<b><a style='color: pink' href='/@/".$account.".php'>$account</a>:</b> " . htmlspecialchars($_POST['chat']) . '<br><br>';
     }
     file_put_contents('backend/files/' . $filename, json_encode($content));
     header("Location: /index.php?filename=" . $filename);
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<title>Секретные документы Антихакеров</title>
<style>
* {
  font-size: 24px;
  font-family: monospace;
}
body {
  background-color: #222222;
  color: #66FF00;
  text-align: center;
}
#footer {
  background-color: #555;
}
#chat {
  margin-top: 5px;
  width: 97%;
  border-radius: 0px;
  height: 40px;
  margin-left: 0px;
}
.central {
  width: 60%;
  margin-left: auto;
  margin-right: auto;
  overflow: scrool;
  padding: 5px;
  position: relative;
}
.small_div {
  width: 20%;
}
#msgs {
  padding: 5px;
  height: 500px;
  overflow: scroll;
  text-align: left;
  background-color: #777777;
}
button {
  border-radius: 0px;
  margin: 5px;
  font-family: Verdana;
}
#subbutton {
  height: 40px;
  width: 50%;
}
input[type=number] {
  width: 70px;
}
form {
  display: inline;
}
#panel {
  text-align: left;
  background-color: #777777;
  padding: 5px;
}
</style>
<script>
function hideName() {
   for (var i = 0; i < document.getElementsByTagName("b").length; i++) {
        document.getElementsByTagName('b')[i].setAttribute("hidden", 1);
   };
   var t = document.getElementById('pb2');
   t.innerText = "Показать отправителей";
   t.setAttribute("onclick", "showName()");
};
function showName() {
   for (var i = 0; i < document.getElementsByTagName("b").length; i++) {
        document.getElementsByTagName('b')[i].removeAttribute("hidden");
   };
   var t = document.getElementById('pb2');
   t.innerText = "Спрятать отправителей";
   t.setAttribute("onclick", "hideName()");
};
function openFile() {
   document.getElementById("pb3").click();
};
function getReady() {
   var s = document.getElementById('filename');
   var arr = <?=json_encode(json_decode(file_get_contents("backend/catalog.json"), true)[strval($lvl)])?>;
   for (var i = 0; i < arr.length; i++) {
       let x = document.createElement("option");
       x.setAttribute("value", arr[i]);
       x.innerHTML = arr[i];
       s.appendChild(x);
   };
   const write = <?=$content["write"]?>;
   if (write > <?=$lvl?>) {
       document.getElementById('footer').innerHTML = '<p style="padding: 3px; color: red; cursor: not-allowed">Вы не можете писать в этот файл</p>';
   }
};
</script>
</head>
<body>
<div class='small_div'></div>
<div class='central'>
<div id='panel'>
<button id='pb1' onclick='openFile()'>Открыть выбранный файл..</button>
<form action='new.php'><button id='pb4' type='submit'>+ Новый файл</button></form>
<button id='pb2' onclick='hideName()'>Спрятать отправителей</button>
<form action='index.php' id='fileform'>
<select name='filename' id='filename' placeholder="Выберите файл..">
<option value="">Выберите файл..</option>
</select>
<button type='submit' hidden='1' id='pb3'></button>
</form>
</div>
<hr>
<div id='msgs'>
<?=$content[strval($lvl)]?>
<input autofocus id='dltme'>
</div>
<hr>
<div id='footer'>
<form action='index.php' method='POST'>
<input name='chat' id='chat' autocomplete='off' placeholder='<?=$content["placeholder"]?>' required>
<input name='filename' hidden='1' value='<?=$filename?>'>
<p>Видимость: от уровня <input value='<?=$content["read"]?>' type='number' min='<?=$content["read"]?>' max='10' name='minlvl'> до <input value='10' type='number' min='<?=$content["read"]?>' max='10' name='maxlvl'> <button type="submit" id='subbutton'>Отправить!</button></p>
</form></div>
</div>
<div class='small_div'></div>
<script>
  $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
  getReady();
  setTimeout(function () { document.getElementById('dltme').setAttribute('hidden', 1) }, 10);
</script>
</body>
</html>
