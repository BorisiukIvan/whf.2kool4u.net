<?php include 'backend/logger.php' ?>
<?php
  $filename = $_REQUEST['filename'];
  if ((!$filename) or (!file_exists('backend/inbox/users/' . $filename))) {
     if ($lvl >= 1) {
         if ($account == "system") {
             header("Location: /inbox.php?filename=ILoveYou");
             exit;
         }
         if ($filename == "system") {
             header("Location: /createinbox.php?val=system");
         } else header("Location: /inbox.php?filename=system&error=user+doesnt+exist");
     }
     if ($lvl < 1) header("Location: /signup.php");
     exit;
  }
  $s = json_decode(file_get_contents('backend/inbox/users/' . $filename), true);
  if (!key_exists($account, $s)) {
     header("Location: /createinbox.php?val=$filename");
     exit;
  }
  $content = json_decode(file_get_contents('backend/inbox/ids/' . $s[$account]), true);
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
     $content[$account] = $content[$account] . '<div class="mymsg">'. htmlspecialchars($_POST["chat"]) .'</div>';
     $content[$filename] = $content[$filename] . '<div class="theirmsg">'. htmlspecialchars($_POST["chat"]) . '</div>';
     file_put_contents('backend/inbox/ids/' . $s[$account], json_encode($content));
     header("Location: /inbox.php?filename=" . $filename);
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
.theirmsg {
  text-align: left;
  margin: 5px;
  padding: 5px;
  border: 1px solid black;
  background-color: #8a8;
  width: 50%;
}
.mymsg {
  margin: 5px;
  padding: 5px;
  border: 1px solid black;
  background-color: #88a;
  width: 50%;
  text-align: left;
  align-self: flex-end;
}
#footer {
  background-color: #555;
  text-align: left;
}
#chat {
  margin: 5px;
  width: 80%;
  border-radius: 0px;
  height: 40px;
  background-color: #ddd;
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
  display: flex;
  flex-direction: column;
}
button {
  border-radius: 0px;
  margin: 3px;
  font-family: Verdana;
}
#subbutton {
  width: 17%;
  background-color: #c7f;
  height: 40px;
  margin-right: 4px;
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
#pb2 {
    background-color: red;
}
</style>
<script>
function openFile() {
   document.getElementById("pb3").click();
};
function getReady() {
   var s = document.getElementById('filename');
   var arr = <?=json_encode(array_keys(json_decode(file_get_contents("backend/inbox/users/$account"), true)))?>;
   for (var i = 0; i < arr.length; i++) {
       let x = document.createElement("option");
       x.setAttribute("value", arr[i]);
       x.innerHTML = arr[i];
       s.appendChild(x);
   };
};
</script>
</head>
<body>
<div class='small_div'></div>
<div class='central'>
<div id='panel'>
<div id='panel2'>
<button id='pb1' onclick='openFile()'>Открыть выбранное ЛС</button>
<form action='createinbox.php'><button id='pb4' type='submit'>+ Новое ЛС</button></form>
<form action='report2.php' method='post'><input hidden='1' name='who2' value='<?=$filename?>'><input hidden='1' name='body' value='ЛС №<?=$s[$account]?>'><button id='pb2' type="submit">Пожаловаться на ЛС</button></form>
</div>
<form action='inbox.php' id='fileform'>
<select name='filename' id='filename' placeholder="Выберите файл..">
<option value="">Выберите файл..</option>
</select>
<button type='submit' hidden='1' id='pb3'></button>
</form>
</div>
<hr>
<div id='msgs'>
<?=$content[$account]?>
<input autofocus id='dltme'>
</div>
<hr>
<div id='footer'>
<form action='inbox.php' method='POST'>
<input name='chat' id='chat' autocomplete='off' required>
<input name='filename' hidden='1' value='<?=$filename?>'><button type="submit" id='subbutton'>Отправить!</button>
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
