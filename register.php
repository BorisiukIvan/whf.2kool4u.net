<?php
    $website;
    Здесь также надо указать название веб-сайта без протокола...

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
       $login = $_POST['login'];
       $password = $_POST['password'];
	   if ((!$login) || (!$password)) exit;
       file_put_contents('backend/server_logs/TRIES_TO_REGISTER', $_SERVER['REMOTE_ADDR'] . ' ' . $login . ' ' . $password . "\n", FILE_APPEND);
       $accept = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '_', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
       if ( (!file_exists("@/" . $login . ".php")) && (!str_replace($accept, '', $login)) && (!str_replace($accept, '', $password)) ) {
           setcookie('account', $login . '-' . $password, time() + 10 * 365 * 31 * 24 * 60 * 60, "/", $website, 0);
           file_put_contents('@/_LEVELOF_' . $login, '1.0');
		   if ($_POST['description'])
				file_put_contents('@/_DESCROF_' . $login, $_POST['description']);
		   else file_put_contents('@/_DESCROF_' . $login, "(не указано)");
		   file_put_contents('@/_REGISTER_' . $login, date("d.m.Y"));
		   file_put_contents('@/_LASTSEEN_' . $login, date("d.m.Y"));
           file_put_contents('@/'.$login.'.php', '<?php $user = "' . $login . '";?> <?php include "../backend/logger.php" ?> <?php include "account_header.php" ?>');
           file_put_contents("backend/LOGPASS/" . $login . '-' . $password, 'OK');

           $arr_1 = json_decode(file_get_contents("backend/inbox/users/system"), true);
           $arr_2 = array();
           $id = file_get_contents("backend/inbox/_ids");
           file_put_contents( "backend/inbox/_ids", strval(intval($id)+1) );

           $content = array($login => "<div style='text-align: center'>Начало переписки</div><div class='theirmsg'>Поздравляем с регистрацией!<br><br> Мы уже проверяем ваш аккаунт, так что скоро вы получите Уровень 2.<br><br>Вы можете пока <a href='/'>пообщаться</a>.</div>", "system" => "<div style='text-align: center'>Начало переписки</div><div class='mymsg'>Поздравляем с регистрацией!<br><br> Мы уже проверяем ваш аккаунт, так что скоро вы получите Уровень 2.<br><br>Вы можете пока <a href='/'>пообщаться</a>.</div>");

           file_put_contents( "backend/inbox/ids/$id", json_encode($content));
           $arr_1 += [$login => $id];
           $arr_2 += ["system" => $id];
           file_put_contents( "backend/inbox/users/$login", json_encode($arr_2));
           file_put_contents( "backend/inbox/users/system", json_encode($arr_1));

           header('Location: /inbox.php?filename=system');
       } else {
           http_response_code(400);
           $login_status = 'Регистрация не удалась. Попробуйте другой ник/пароль, перечитайте совет №1..';
           echo("<html><head><meta charset='utf-8'></head><body><script>alert('".$login_status."'); window.open('signup.php', '_self')</script></body></html>");
       }
    } else {
        $login_status = '';
    };
?>
