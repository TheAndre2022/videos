<?php 

  function procura_unique_video2 ($conn, $theunique){
    $filePath = '/home/andre/videos/videosdefault/campanha-dengue2024.mp4'; 
    $sql = "select endereco, score from datavideos where unique_id ='".$theunique."' limit 1"; 
    $result = pg_query($conn, $sql); 
    if (!$result){
    echo 'Erro, não consegui acesso ao Banco de Dados'; 
    exit; 
    } 
    $linhas = pg_num_rows($result); 
    if ($linhas ==1) {
    $row = pg_fetch_array($result); 
    $endereco = pg_unescape_bytea($row['endereco']); 
    if (file_exists($endereco)){ 

$score = $row['score']; 
$score++;
$sql = "update datavideos set score =".$score."  where unique_id=".$theunique." limit 1"; 
$result = pg_query($conn, $sql); 

$filePath = $endereco; }
    }
  return $filePath; 
  }
 


  function procura_unique_video($conn, $theunique) {
    $filePath = '/home/andre/videos/videosdefault/campanha-dengue2024.mp4'; 

    $sql = "SELECT endereco, score FROM datavideos WHERE unique_id = '$theunique' LIMIT 1"; 
    $result = pg_query($conn, $sql); 
    if (!$result) {
        echo 'Erro, não consegui acesso ao Banco de Dados'; 
        exit; 
    } 

    $linhas = pg_num_rows($result); 
    if ($linhas == 1) {
        $row = pg_fetch_array($result); 
        $endereco = pg_unescape_bytea($row['endereco']); 
        if (file_exists($endereco)) {
            // Verifique se $row['score'] é um número válido antes de incrementá-lo
            if (is_numeric($row['score'])) {
                $score = intval($row['score']);
                $score++;
                // Use a função pg_escape_string para escapar o valor de $score
                $escapedScore = pg_escape_string($score);
                // Atualize o score usando prepared statement para garantir a segurança
                $sqlUpdate = "UPDATE datavideos SET score = '$escapedScore' WHERE unique_id = '$theunique' "; 
               
                
                $resultUpdate = pg_query($conn, $sqlUpdate); 
                if (!$resultUpdate) {
                    echo 'Erro ao atualizar o score no Banco de Dados'; 
                    exit; 
                }
                $filePath = $endereco; 
            }
        }
    }
    return $filePath; 
}


function latestvideo($conn, $id, $voltas){
$resposta [0] ['linhasachadas'] = 0; 
$resposta ['erro'] = true; 
if ($voltas ==0 ) { return $resposta;  }
$sql = 'select username from usuarios where id=$1 limit 1';
$params = array($id);
$result = pg_query_params($conn, $sql, $params);
if (!$result) {return $resposta;}
$total = pg_num_rows ($result); 
if ($total ==0) { return $resposta; }
$linha = pg_fetch_array($result); 
$resposta [0] ['quemestaouvindo'] = $linha ['username']; 
$sql = 'select o.quando, o.id, o.numero,  d.nome, o.quando, o.playback_time,  d.unique_id,  d.atorprincipal, d.album_id from online o inner join datavideos d 
on o.numero = d.numero where o.id=$1  order by o.quando desc limit $2'; 
$params = array($id, $voltas);
$result = pg_query_params($conn, $sql, $params);
if (!$result) {return $resposta;}
$total = pg_num_rows ($result); 

if ($total <5) { $resposta ['nada'] = 'nada';  return $resposta; }
$resposta [0] ['linhasachadas'] = $total; 
$resposta ['erro'] = false;
$nada = 0;
 do {
  
    $linha = pg_fetch_array($result); 
    $resposta [$nada] ['artista'] = trim($linha['atorprincipal']);
    $resposta [$nada] ['nome'] = trim($linha['nome']);
    $resposta [$nada] ['numero'] = $linha['numero'];
    $resposta [$nada] ['quando'] = $linha['quando'];
    $resposta [$nada] ['playback_time'] = $linha['playback_time'];
    $resposta [$nada] ['unique_id'] = $linha['unique_id'];
    // playback_time é uma biginter, ou seja, um número monstruoso 

$sql = 'select album_name from albuns where album_id = $1 limit 1'; 
$params = array($linha['album_id']);
$result_albuns = pg_query_params($conn, $sql, $params);
if (!$result_albuns) { echo 'Erro no banco de dados - deixar mais genérica estas mensagens!!'; }
$meualbum = pg_fetch_array($result_albuns); 
$resposta [$nada] ['album_name'] = $meualbum['album_name'];
$nada++;   
 } while ($nada < $total);
    return $resposta; 
}



class MemcacheHandler {
  private $memcache;

  public function __construct($host, $port) {
      if (extension_loaded('memcache')) {
          $this->memcache = new Memcache();
          $connected = $this->memcache->connect($host, $port);

          if (!$connected) {
              die('Não foi possível conectar ao servidor Memcache.');
          }
      } else {
          die('A extensão Memcache não está instalada no PHP.');
      }
  }

  public function set($key, $data, $expiration = 0) {
      $this->memcache->set($key, $data, 0, $expiration);
  }

  public function get($key) {
      return $this->memcache->get($key);
  }
}


function isVideoFile($filePath) {
    $output = shell_exec("ffmpeg -i " . escapeshellarg($filePath) . " 2>&1");
    return preg_match('/Video:/', $output) === 1;
}
