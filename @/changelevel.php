<?php
    $str;
    Тут надо вписать логин и пароль администратора сервера.
    if ($_COOKIE['account'] != $str) exit;
    $user = $_POST['user'];
    if (($user == "account_header") || ($user == 'changelevel')) exit;
    if (!file_exists('_LEVELOF_'.$user)) exit;
    $addlevel = floatval($_POST['newlvl']);
    $level = floatval(file_get_contents('_LEVELOF_'.$user));
    if ($addlevel + $level > 9.99) exit;
    $newlevel = $addlevel + $level;
    file_put_contents("_LEVELOF_".$user, $newlevel);
    header("Location: ".$user.".php");
?>