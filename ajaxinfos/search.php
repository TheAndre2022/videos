<?php 
include '/var/www/videos2022/global/global.php'; 
include $caminho.'streaming/funcoes-streaming.php'; 
include $caminho.'ajaxinfos/video_libs.php';
include $caminho.'ajaxinfos/playlist-videolibs.php';
include $caminho.'ajaxinfos/sugestoes.php';
// Aqui, a lógica para se fazer o login
//$empCls = new Employee($conn);

$termo = isset ($_POST['termo']) ? $_POST['termo'] : ''; 
if ($termo =='') {

    $termo = isset ($_request['termo']) ? $_request['termo'] : ''; 


}


// Verifica se o formulário foi submetido
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (true) { 
        // Limpa o termo de pesquisa para evitar SQL injection
        $termo = pg_escape_string($conn, $termo);

        // Monta a consulta SQL dinâmica
        $sql = "SELECT d.unique_id, d.numero, d.nome, d.endereco,  d.atorprincipal, a.album_name FROM datavideos d inner join albuns a  on a.album_id = d.album_id 
         WHERE d.atorprincipal ILIKE '%$termo%' OR d.unique_id ILIKE '%$termo%' OR a.album_name ILIKE '%$termo%'  OR d.nome ILIKE '%$termo%'  OR d.endereco ILIKE '%$termo%' order by random() limit 20";
        
        // Executa a consulta
        $result = pg_query($conn, $sql);

        if (!$result) {
            die("Erro na consulta ao banco de dados.");
        }

        $div = 'pesquisa'; 
       $c=0;  
       $data = array();        
        while ($row = pg_fetch_assoc($result)) {

$data ['ouvindoagora'] [$c] =  makediv ( $row ['unique_id'],  $row ['numero'], 
            $row ['atorprincipal'],   $row ['album_name'], $div); 

$c++; 
        }
       $data ['ouvindoagora'] ['totallinhas'] = $c; 


        // Fecha a conexão com o banco de dados
        pg_close($conn);
    } else {
        $c= 0 ; 
        $data ['totallinhas'] = $c; 
    }

$thedata ['ouvindoagora'] = $data;  
$data ['login'] = 'sucesso'; 
    ksort ($thedata); 
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_PRETTY_PRINT);
    
