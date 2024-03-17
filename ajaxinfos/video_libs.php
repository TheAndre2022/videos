<?php 

function quaisvideos($conn, $id_prime){
$video = isset($_REQUEST['video']) ? $_REQUEST['video'] : 0;
$playback_time = isset($_REQUEST['playback_time']) ? $_REQUEST['playback_time'] : 0;
$chave = isset($_REQUEST['chave']) ? $_REQUEST['chave'] : '543edb4727ccec8ea8dbfc43fe745e67-2015';

$data['ouvindoagora'] = latestvideo($conn, $id_prime, 10); 

$x= 0; 
$div ='ouvindo'; 
do {
$data ['ouvindoagora'] [$x] ['unique_id'] = isset($data ['ouvindoagora'] [$x] ['unique_id'] ) ? $data ['ouvindoagora'] [$x] ['unique_id'] : 'naoexiste'; 
$data ['ouvindoagora'] [$x] ['numero'] = isset($data ['ouvindoagora'] [$x] ['numero'] ) ? $data ['ouvindoagora'] [$x] ['numero'] : 'naoexiste'; 
$data ['ouvindoagora'] [$x] ['artista'] = isset($data ['ouvindoagora'] [$x] ['artista'] ) ? $data ['ouvindoagora'] [$x] ['artista'] : 'naoexiste'; 
$data ['ouvindoagora'] [$x] ['album_name'] = isset($data ['ouvindoagora'] [$x] ['album_name'] ) ? $data ['ouvindoagora'] [$x] ['album_name'] : 'naoexiste'; 

$thedata ['ouvindoagora'] [$x] ['div'] = makediv ( $data ['ouvindoagora'] [$x] ['unique_id'],  $data ['ouvindoagora']  [$x]  ['numero'], 
$data ['ouvindoagora'] [$x] ['artista'],   $data ['ouvindoagora'] [$x]  ['album_name'], $div); 
$x++; 
} while ($x < 10); 

// Aqui eu recupero as últimas cinco músicas
// Logo abaixo eu atualizo o andamento dos vídeos que estão sendo tocados
    $playback_timecom30segundos = isset($_SESSION['$playback_timecom30segundos']) ? $_SESSION['$playback_timecom30segundos'] : 0; 
    
    if ($playback_time > 1 && ($playback_time - $playback_timecom30segundos) > 30) {
        $quando = isset ($data['ouvindoagora'][0]['quando']) ? $data['ouvindoagora'][0]['quando'] : ''; 
    
        // Se o playback_time for maior que um e respeitar o intervalo de 30 segundos, o caminho é gravá-lo no banco de dados
        $sql = "UPDATE online SET playback_time = '".$playback_time."' WHERE id = ".$id_prime." AND quando = '".$quando."'";
        
        $result = pg_query($conn, $sql);
    
        if (!$result) {$data ['ouvindoagora'] [120] ['div'] = makediv ( $mine ['unique_id'],  $mine ['numero_video'],  $mine ['nome'],  $sugestao ['album_name']); 
            $data['erro'] = 'Erro genérico aqui';
        } else {
            $_SESSION['$playback_timecom30segundos'] = $playback_time; // Atualiza o tempo do último playback gravado
            $data['ouvindoagora'][0]['playback_time'] = $playback_time; 
        }
    }

return $thedata; 

}

function makediv($unique_id, $numero, $artista, $album, $div) {

    // Verifica se a chave de sessão está definida
    $chave = isset($_SESSION['chave']) ? $_SESSION['chave'] : '';
$artista = trim($artista); 
    // Constrói o HTML para o div
    $data = '<a href="https://oliveira2022.jumpingcrab.com/videoplayer.php?unique_id=' . $unique_id.'"> 
    <img src="https://oliveira2020.zanity.net/streaming/videos-to-play.php?unique_id=' . $unique_id . '&foto=yes" width="150" alt="' . $artista .'-' . $album . '"> </a>';


    return $data;
}
