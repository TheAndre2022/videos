<?php
include '../global/global.php';
include $caminho . 'streaming/streaming.php';
include $caminho . 'streaming/funcoes-streaming.php';

// Video default - caso não tenha nenhum definido
$video = isset($_REQUEST['unique_id']) ? $_REQUEST['unique_id'] : 'MTk1M-xNDAz-MWRiM-cwZDdiZGQ5N2';
$foto = isset($_REQUEST['foto']) ? $_REQUEST['foto'] : 'nao';


$usuario = new Employee($conn);
$memcacheHandler = new MemcacheHandler('127.0.0.1', 6400);
$result = $usuario -> check_keys($thekeys); 
if ($result['erro']) {
    $filePath = '/var/www/oliveira2022/imagens/nadaerro404.webp';
    $foto = 'sim'; 
}
else {
   $unique_id_antigo = $memcacheHandler->get($thekeys);

if ($unique_id_antigo !== $video) {
    $sql = "SELECT numero FROM datavideos WHERE unique_id='".$video."'";
    $grave = pg_query($conn, $sql);
    if (!$grave) {
        echo 'Erro no banco de dados';
        exit;
    }
    if (pg_num_rows($grave) !== 1) {
        echo 'Erro no banco de dados';
        exit;
    }
    $x = pg_fetch_array($grave);
    $numero = $x['numero'];

    $sql = 'INSERT INTO online (numero, id, unique_id) VALUES ('.$numero.', '.$result["id"]. ', \''.$video.'\')';
    $grave = pg_query($conn, $sql);
}

}


$memcacheHandler->set($thekeys, $video, 500);


// Verifica se os dados do vídeo estão em cache
$filePath = $memcacheHandler->get($video);

// Se não estiver em cache, busca no banco de dados
if ($filePath === false) {
    $filePath = procura_unique_video($conn, $video);
    if ($filePath !== false) {
        // Armazena os dados do vídeo em cache por 500 segundos


        $memcacheHandler->set($video, $filePath, 500);
    } else {
        // Se não encontrar o vídeo, define um valor padrão ou exibe uma mensagem de erro
        $filePath = '/var/www/oliveira2022/imagens/nadaerro404.webp';
        $foto = 'sim'; 
    }
}
// Verifica-se o usuario existe 
// Se $foto tiver algum valor, exibe o script da foto
if ($foto == 'sim') {
    // Lógica para exibir a foto
    $refazer = explode('.', $filePath);
    $webp = $refazer[0] . '.webp';
    $jpg = $refazer[0] . '.jpg';
    $jpeg = $refazer[0] . '.jpeg';

    if (file_exists($webp)) {
        $filePath = $webp;
    } elseif (file_exists($jpg)) {
        $filePath = $jpg;
    } elseif (file_exists($jpeg)) {
        $filePath = $jpeg;
    } else {
        $filePath = '/var/www/oliveira2022/imagens/nadaerro404.webp';
    }

    $filename = basename($filePath);
    $file_extension = strtolower(substr(strrchr($filename, '.'), 1));

    switch ($file_extension) {
        case "gif":
            $ctype = "image/gif";
            break;
        case "png":
            $ctype = "image/png";
            break;
        case "webp":
            $ctype = "image/webp";
            break;
        case "jpeg":
            $ctype = "image/jpeg";
            break;
        case "jpg":
            $ctype = "image/jpeg";
            break;
        case "svg":
            $ctype = "image/svg+xml";
            break;
        default:
            $ctype = "application/octet-stream";
    }

    header('Content-type: ' . $ctype);
    echo file_get_contents($filePath);
} else {


    $stream = new VideoStream($filePath);
    $stream->start();
}
?>
