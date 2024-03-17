<?php 
set_time_limit(0);
session_name("Sakura");
session_start();
function gerarNumero($conn, $endereco)
{
    $faixas = [
        [1, 100],
        [101, 2000],
        [2001, 2500],
        [101, 300],
        [301, 400],
        [403, 500],
        [501,600],
        [601,700], 
        [701,10000],
        [10001, 15000]          
    ];

    $x= explode ('.', $endereco); 
$x [2] = isset ($x[2]) ? $x[2] : 'nada'; 
$x [1] = isset ($x[1]) ? $x[1] : 'nada';
$x [2] = isset ($x[0]) ? $x[0] : 'nada';  

    if (!($x[1] == 'mp4' || $x[2] == 'mp4' || $x[0] == 'mp4'))
    { 
       $faixas = [
       [35001,59700]
           ];    
    }
  
    foreach ($faixas as $faixa) {
        $numeroAleatorio = mt_rand($faixa[0], $faixa[1]);
              
        $sql = 'SELECT numero FROM datavideos WHERE numero =' . $numeroAleatorio;
        $result = pg_query($conn, $sql);

        if (pg_num_rows($result) == 0) {
            return $numeroAleatorio;
        }

        // Incrementa o número apenas se não for o último da faixa
        if ($numeroAleatorio + 1 <= $faixa[1]) {
            $numeroAleatorio++;
           
            echo ' <br> Ver se temos disponível este número ' . $numeroAleatorio.' <br> <br>';
            
            $sql = 'SELECT numero FROM datavideos WHERE numero =' . $numeroAleatorio;
            $result = pg_query($conn, $sql);

            if (pg_num_rows($result) == 0) {
                echo 'Tenho sim <br>'; 

                return $numeroAleatorio;
            }
        }
    }

    // Retorna algo (pode ser um valor padrão) caso nenhum número seja encontrado

    return null;
}

$caminho = '/var/www/oliveira2022/';
include_once($caminho . 'bancodedados/db_cls_connect.php');
include_once($caminho . 'login/funcoeslogin.php');
$db = new dbObj();
$conn = $db->getConnstring();
$sql = 'delete from albuns'; 
$y = pg_query($conn, $sql); 
$sql = 'delete from datavideos'; 
$y = pg_query($conn, $sql); 
include 'linhas2.php'; 
include 'albuns.php'; 
include 'carregardatavideos.php'; 
echo "Preciso chegar até aqui... "; 
$sql = 'delete from datavideos where numero > 35000'; 
$b = new dbObj();
$con = $b->getConnstring();
$y = pg_query($con, $sql); 
echo "<br> Saindo graciosamente do sistema e apagando tudo que não for mp4 da tabela"; 
