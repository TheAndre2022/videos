<?php 
//include ('global/global.php');
$cookie = isset($_COOKIE['youarewelcome']) ?  $_COOKIE['youarewelcome'] : 'nada'; 
$mensageminicial = isset ($_SESSION['mensagem']) ? $_SESSION['mensagem'] : 'Bem vindo ao meu site de Testes'; 
$title = $site; 
if ($action == 'fazerlogin') {
$title = "Area reservada para Login -".$site; 
} else { 
   $username = isset ( $_SESSION['username']) ? $_SESSION['username'] :'Anonimo'; 

    $title = "Seja Bem Vindo! ".$username;  }

?>
<!DOCTYPE html>
<html lang="pt-br">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
     <meta name="description" content="Página de Testes Pessoal"/>
     <meta name="author" content="Tchaikovsky 2024" />
    <meta http-equiv="content-language" content="pt-br" />
    <link rel="stylesheet" type="text/css" href="<?php echo $site; ?>css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $site; ?>css/style.css?php=<?php echo time(); ?>5">
    <link rel="stylesheet" type="text/css" href="<?php echo $site; ?>css/fonts-icones.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" /> <!-- https://fonts.google.com/ -->
    <script type="text/javascript" src="<?php echo $site; ?>js/login.js?versap=2"></script>
    <script src="<?php echo $site; ?>js/jquery.js"></script>
    <title>    <?php echo $title ?> </title> 
    <?php 
   ?>
</head>
