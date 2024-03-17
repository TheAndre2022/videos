<?php

function oquemesugere($conn, $id_prime)
{
    $data3 = array(); // Inicializa a variável $data3 como um array vazio

    $data2['bonus'] = 'nada';
    $memcacheHandler = new MemcacheHandler('127.0.0.1', 6400);

 
    $sugestoes = select_and_cache_random_video($conn, $memcacheHandler, 'gororobao');
    
    if (!($sugestoes)) {
        die('Erro irrecuperável aqui!!');
    }

    $x = $sugestoes ['totallinhas'];
$c = 0 ; 
    do {
     
     $div = 'ouvindo';

if (!isset($sugestoes [$c] ['unique_id'])) { echo $x.' -- deviamos ter e achamos o Erro na execução número  '.$c; die();  }

     $data3[$c + 10]['div'] = makediv($sugestoes [$c] ['unique_id'], $sugestoes [$c] ['numero'],
    trim($sugestoes [$c] ['atorprincipal']), $sugestoes [$c] ['album_id'], $div);


        $c++;
    } while ($c < $x);

    return $data3;
}

function select_and_cache_random_video($conn, $memcacheHandler, $getup_videos = 'amaxina', $limit = 150)
{
   // $getup_videos = 'Bravo';
    
    // Verificar se os dados já estão na memcache
    $cachedData = $memcacheHandler->get($getup_videos);

    if ($cachedData) {
        return $cachedData;
    }

    // Consulta o banco de dados e seleciona 150 linhas aleatórias (máximo)
    $sql = "SELECT d.numero, d.nome, d.endereco, d.unique_id, d.atorprincipal, d.searching,  a.album_name, a.album_id 
            FROM datavideos d 
            INNER JOIN albuns a ON a.album_id = d.album_id  
            ORDER BY random() LIMIT $limit";
    $result = pg_query($conn, $sql);

    if (!$result || pg_num_rows($result) < 1) {
        return false;
    }

    // Inicializar arrays para armazenar os dados e os álbuns encontrados
    $data = array();
    $uniqueAlbums = array();
    $totalRows = 0;

    // Loop para processar os resultados e garantir pelo menos 30 linhas de dados
    while ($row = pg_fetch_assoc($result)) {
        // Adicionar o registro aos dados
        $data[] = $row;

        if ($row ['searching']) {
        // Adicionar o álbum à lista de álbuns encontrados
        if (!in_array($row['album_id'], $uniqueAlbums)) {
            $uniqueAlbums[] = $row['album_id'];
        }

        $totalRows++;
    }
        // Se já tivermos pelo menos 30 linhas de dados, sair do loop
        if ($totalRows >= 30) {
            break;
        }
    }

    $data['totallinhas'] = $totalRows;

    // Atualizar os dados no cache
    $memcacheHandler->set($getup_videos, $data, 300);

    return $data;
}
