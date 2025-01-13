<?php
    include 'backend/logger.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user_1 = $account;
        if (!$user_1) exit;

        $user_2 = $_POST['filename'];
        if (!$user_2) exit;
        if (!file_exists("@/$user_2.php")) {
            header("Location: /createinbox.php?error=Такого пользователя не существует");
            exit;
        }
        if ($user_2 == $user_1) {
            header("Location: /createinbox.php?error=Нельзя создать переписку с самим собой");
            exit;
        }

        if ( !file_exists("backend/inbox/users/$user_1") ) {
            echo("no that file exists 1");
            $arr_1 = array();
        } else $arr_1 = json_decode(file_get_contents("backend/inbox/users/$user_1"), true);

        if ( !file_exists("backend/inbox/users/$user_2") ) {
            echo("no that file exists 2");
            $arr_2 = array();
        } else {
              $s = json_decode(file_get_contents("backend/inbox/users/$user_2"), true);
              if ( key_exists($user_1, $s)) {
                 header("Location: /createinbox.php?error=Переписка между вами уже существует!");
                 exit;
              }
            $arr_2 = json_decode(file_get_contents("backend/inbox/users/$user_2"), true);
        };

        $id = file_get_contents("backend/inbox/_ids");
        file_put_contents( "backend/inbox/_ids", strval(intval($id)+1) );

        $content = array($user_1 => "<div style='text-align: center'>Начало переписки</div>", $user_2 => "<div style='text-align: center'>Начало переписки</div>");

        file_put_contents( "backend/inbox/ids/$id", json_encode($content));
        $arr_1[$user_2] = $id;
        $arr_2[$user_1] = $id;
        file_put_contents( "backend/inbox/users/$user_1", json_encode($arr_1));
        file_put_contents( "backend/inbox/users/$user_2", json_encode($arr_2));
        header("Location: /inbox.php?filename=$user_2");
        exit;
    }
?>
<html>
<head>
<title>Новая переписка</title>
<meta charset='utf-8'>
<style>
* {
  font-size: 20px;
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
#s {
	background-color: #c0c;
	font-size: 24px;
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
</style>
</head>
<body>
<div id="central"><br>
<div id="form">
<form action='/createinbox.php' method='POST'>
<label for='filename'><b>Введите никнейм человека, с которым хотите создать переписку:</b><br>
<input name='filename' id='filename' style='width: 90%'><br><br>
<section>
<b>Интересный факт</b>:<br>
<p>Вы не можете ни читать, ни писать сообщения, пока не создадите переписку с <i>system</i> (или пока <i>system</i> не создаст переписку с вами). Просим извинения за неудобства!</p>
</section><br>
<div style='text-align: center'><button type='submit' id='s'>Создать переписку</button></div>
</form>
</section>
</div>
</div>
<script>
   var val = '<?=$_GET['val']?>';
   document.getElementById("filename").value = val;
</script>
</body>
</html>
