<?php 

function procura_playlists ($conn, $id_prime, $playlist) {
    // Não mexa aqui, nada a ver com a sua meta agora!!
    $data ['erro'] = 'erro'; 
    $playlist = pg_escape_string ($playlist); 
    if ($playlist == '') { return $data; }
    $sql = "select p.numero_video, d.nome, d.unique_id from playlists p 
    inner join datavideos d  on p.numero_video = d.numero where usuario_id ='".$id_prime."'and playlist_name='".$playlist."' limit 20"; 
    $result = pg_query ($conn, $sql); 
    if (!$result) { echo 'Erro de conexão!!'; die(' Die without honor'); }
    $data ['linha'] =  $linha = pg_num_rows ($result); 
    $x=1; 
    $data ['erro'] = 'sucesso'; 
    $data [$x] ['sql'] = trim($sql);
if ($linha>0) {
    do{
    $mine = pg_fetch_array($result); 
    $data [$x] ['unique_id'] = $mine ['unique_id'];
    $data [$x] ['nome'] = trim($mine ['nome']);
    $data [$x] ['numero'] = trim($mine ['numero_video']);
     $x++; 
    } while ($x < $linha); 
}

    return $data;     
    }
     
