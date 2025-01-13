<?php
    $path;
    Тут надо указать путь к папкам
    file_put_contents($path . 'backend/server_logs/RequestsBase', $_SERVER['HTTP_USER_AGENT'] . ' ' .$_SERVER['REMOTE_ADDR'] . ' ' . date('d.m.Y h:i:s A') . ' ' . $_SERVER["SCRIPT_NAME"] . ' ' . json_encode($_REQUEST) . ' ' . json_encode($_COOKIE) . "\n", FILE_APPEND);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            file_put_contents('backend/server_logs/RequestsPost', $_SERVER['HTTP_USER_AGENT'] . ' ' .$_SERVER['REMOTE_ADDR'] . ' ' . date('d.m.Y h:i:s A') . ' ' . $_SERVER["SCRIPT_NAME"] . ' ' . json_encode($_REQUEST) . ' ' . json_encode($_COOKIE) . "\n", FILE_APPEND);
    };

    $exit = 0;
    $ips = explode("\n", file_get_contents($path . "backend/BlockedIPS"));
    if (in_array($_SERVER["REMOTE_ADDR"], $ips)) {
        $exit = 1;
    } 

    if ($exit) {
       if (!in_array($_SERVER['REMOTE_ADDR'], $ips)) file_put_contents($path . "backend/BlockedIPS", $_SERVER['REMOTE_ADDR']."\n", FILE_APPEND);
       exit;
    }


    if (key_exists('account', $_COOKIE)) {
        if (!file_exists($path . "backend/LOGPASS/" . $_COOKIE['account'])) {
            header("Location: /login.php");
            exit;
        } else {
            $account = explode('-', $_COOKIE['account'])[0];
            file_put_contents($path . "@/_LASTSEEN_".$account, date("d.m.Y"));
        }
    } else $account='Гость';

    if (file_exists($path . '@/_LEVELOF_'.$account)) {
       $lvl = floor(intval(file_get_contents($path . '@/_LEVELOF_'.$account)));
    } else $lvl = 0;


?>
<html>
<head>
<link rel="icon" type="image/jpg" href="/siteicon.jpg"/>
<script>
/*function checkNotify() {
    var req = new XMLHttpRequest();
    req.open("GET", "/notify_read.php", false);
    req.send();
    var arr = JSON.parse(req.responseText);
    for (var i = arr.length-1; i >= 0; i--) {
        var elem = document.createElement("a");
        elem.setAttribute("href", arr[i].link);
        elem.innerHTML = '<b class="notify_b">' + arr[i].sender + '</b><br><br><span class="notify_txt">' + arr[i].text + '</span>';
        if (arr[i].readers.includes('fish224')) {
            elem.className = 'notify';
        } else {
            elem.className = 'notify new';
            document.getElementById('notify_parent').className = 'dropbtn new';
        };
        document.getElementById('notify_list').appendChild(elem);
    };
}
function clearNotify() {
    var req = new XMLHttpRequest();
    req.open("POST", "/notify_read.php", false);
    req.send();
    location.reload();
}*/
</script>
<style>
body {
  background-image: url("https://cdn.hashnode.com/res/hashnode/image/upload/v1639242096707/pf_pCVF8e.jpeg?w=1600&h=840&fit=crop&crop=entropy&auto=compress,format&format=webp");
}

header ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #38444d;
}

li.item {
  float: left;
}

a.item, .dropbtn {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

a.item:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

li.dropdown {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  max-width: 300px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;
}

.notify {
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    padding: 20px;
}

.notify_b {
    font-size: 14px;
}

.new {
    background-color: orange;
}

.newF {
    background-color: green;
}

</style>
</head>
<body>
<header>
<ul>
  <li class="item"><a href="http://antihackers.ezyro.com/" class="item">Сайт для всех</a></li>
  <li class="item"><a href="/" class="item">Чаты</a></li>
  <li class="item"><a href="/inbox.php" class="item">ЛС</a></li>
  <li class="item"><a href='/console.php' class='item'>Консоль кулхацкера</a></li>
  <li style="float: right" class="item"><a href='/report.php' class="item">Жалоба</a></li>
  <li class="dropdown item" style="float: right">
    <a href="javascript:void(0)" class="dropbtn item"><?=$account?> (<b style='color: #5af'><?=$lvl?></b>)</a>
    <div class="dropdown-content">
    <?php
     if ($account != 'Гость') {
         echo "<a href='/@/".$account.".php'>Мой профиль</a>";
         echo "<a href='/logout.php'>Выйти</a>";
     } else {
         echo "<a href='/signup.php'>Регистрация</a>";
         echo "<a href='/login.php'>Вход</a>"; 
     }
     ?>
     </div>
  </li>
  <!-- <li class="dropdown item" style="float: right">
      <a href="javascript:void(0)" class="dropbtn item" id="notify_parent">Уведомления</a>
      <div class="dropdown-content" id='notify_list'>
         <button onclick='clearNotify()' style='border-radius: 0px; width: 100%'>Пометить всё как прочитанное</button>
      </div>
  </li> -->
</ul>
</header>
<script>
/*checkNotify();*/
</script>
</html>