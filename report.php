<?php
    if (key_exists('val', $_REQUEST)) {
         $val = $_REQUEST['val'];
    } else $val = '';
    if (key_exists('ok', $_REQUEST)) {
         $ok = 1;
    } else $ok = '';
?>
<?php include 'backend/logger.php' ?>
<html>
<head>
<title>Жалоба</title>
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
</style>
</head>
<body>
<div id="central"><br>
<div id='ok' style='border-width: 1px; border-color: #aaa; background-color: #00f' hidden='1'>
     Ваша жалоба отправлена! <button onclick='window.open("index.php", "_self")'>Вернуться на главную</button>
</div>
<div id="form">
<p style='color: #ee0000;'><b>Внимание! Пожалуйста, не посылайте бессмысленных жалоб</b>!</p>
<form action='/report2.php' method='POST'>
<label for='who2'><b>Никнейм нарушителя:</b><br>
<input name='who2' id='who2' style='width: 90%'><br><br>
<label for='body'><b>Опишите, что случилось (чем точнее, тем лучше):</b><br>
<textarea name='body' style='width: 90%; height: 500px; required'></textarea>
<p style='font-size: 20px'><b>Просьба описать поточнее, скинуть ссылки. Это поможет нам разобратся в ситуации.</b></p>
<div style='text-align: center'><button type='submit' id='s'>Отправить жалобу</button></div>
</form>
</section>
</div>
</div>
<script>
   var val = '<?=$val?>';
   document.getElementById("who2").value = val;
   var ok = '<?=$ok?>';
   if (ok) {
       document.getElementById('ok').hidden = 0;
       document.getElementById('s').disabled = 1;
       var x = 10;
       var k = setInterval(function () {document.getElementById('s').innerText = x; x--; if (!x) {clearInterval(k); document.getElementById('s').disabled=0; document.getElementById('s').innerText = 'Отправить жалобу';}}, 1000);
   };
</script>
</body>
</html>
