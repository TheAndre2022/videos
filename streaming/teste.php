<?php
include '/var/www/videos2022/global/global.php'; 
include $caminho.'streaming/funcoes-streaming.php'; 
include $caminho.'ajaxinfos/video_libs.php';
include $caminho.'ajaxinfos/playlist-videolibs.php';
include $caminho.'ajaxinfos/sugestoes.php';

$chaves = isset($_REQUEST['chave']) ? $_REQUEST['chave'] : '2c08980702696c2808b51a6e4-AyODZ-ZjYzl-iNDg3';

$db = new dbObj();
$conn = $db->getConnstring();
$empCls = new Employee($conn);
$result = $empCls->check_keys($chaves);
$_SESSION['chave'] = $chaves; 

$id_prime = isset ($result ['id']) ? $result ['id'] : 9999; 

if ($result['erro']) {
    $data['erro'] = 'Chave não autorizada ou usuário não existe'; 
    $data['tabelavideos'] = isset ($tabelavideos) ? $tabelavideos : '<div id = "alert"> Key not found!! Try to log again </div>';
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit; 
    }

$data = quaisvideos($conn, $id_prime); 
$data2 ['sugestoes']= oquemesugere($conn, $id_prime); 

