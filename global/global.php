<?php
$global = '/home/gigante/configs/global.ini';

    $chaves = parse_ini_file($global, true);
 

    $site = isset($chaves ['CONFIG']['site']) ? $chaves['CONFIG']['site'] : 'opentracker.jumpingcrab.com';
    $site2 = isset($chaves['CONFIG']['site2']) ? $chaves['CONFIG']['site2'] : 'opentracker.jumpingcrab.com';
    $caminho = isset($chaves['CONFIG']['caminho']) ? $chaves['CONFIG'] ['caminho'] : '/var/www/oliveira2020/';
    $uploader = isset($chaves['CONFIG'] ['uploader']) ? $chaves['CONFIG']['uploader'] : 'seste';

    $servername = isset($chaves['BD'] ['servername']) ? $chaves ['BD']['servername'] : 'oliveira2020';
    $username = isset($chaves ['BD'] ['username']) ? $chaves ['BD'] ['username'] : 'www/';
    $password = isset($chaves ['BD']['password']) ? $chaves['BD']['password'] : 'cat';
    $dbname = isset($chaves ['BD']["dbname"]) ? $chaves['BD'] ['dbname'] : 'cat';
    $port = isset($chaves ['BD']['port']) ? $chaves ['BD']['port'] : 5432;
    $salt = isset($chaves['SALT']['salt']) ? $chaves['SALT']['salt'] : '1972';

    session_name('abacate'); 
    session_start(); 
 
include_once ($caminho.'bancodedados/db_cls_connect.php'); 
include_once ($caminho.'login/funcoeslogin.php'); 
//
$bancodedados = new dbObj(); 
$bancodedados->set_environment ($servername, $username, $password, $dbname, $port); 
$conn = $bancodedados->getConnstring(); 
// Para ser usado em todo o código, definidas como globais
// Basicamente define as variaveis e liga o banco de dados, retorna na $conn, a conexão a ser usada; 

$name = 'newstartup'; 
// define uma chave e salva para o usuário, uso anonimo

$cookie = isset($_COOKIE['newstartup']) ?  $_COOKIE['newstartup'] : 'zero';  
if ($cookie =='zero') {
    $value = chaves(); 
   }
else { $value = $cookie; } 

// 7200 = duas horas, né? 

$sit7 = $_SERVER['HTTP_HOST'].'/'; 
//
//setcookie($name, $value, [
//    'expires' => time() + 7200,
//    'path' => '/',
//    'domain' => $sit7,
//    'secure' => true,
//    'httponly' => true,
//    'samesite' => 'None'
//]);

$_SESSION['keys'] = $value; 
$thekeys = isset ($_SESSION['novaschaves']) ? $_SESSION['novaschaves'] : 'nada';
$username = isset ($_SESSION['username']) ? $_SESSION['username'] : 'nada'; 
$login = isset ($_SESSION['login']) ? $_SESSION['login'] : 'nada'; 
$cookie = isset($_COOKIE['youarewelcome']) ?  $_COOKIE['youarewelcome'] : 'zero';  