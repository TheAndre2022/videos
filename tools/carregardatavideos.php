<?php
$caminho = '/var/www/oliveira2022/';
$caminhoArquivoCSV = '/var/www/opentracker/server/datas/linhas.csv';
$tabela = 'datavideos';
$db = new dbObj();
$conn = $db->getConnstring();
$zz=1; 
$handle = fopen($caminhoArquivoCSV, 'r');

try {
    if ($handle !== FALSE) {
        $xx = 15001;
        $campesinato = new Employee($conn);

        while (($data = fgetcsv($handle, 2000, ',')) !== FALSE) {
            $name = pg_escape_string($data[4]);
            $cantor = pg_escape_string($data[3]);
            $descricao = pg_escape_string($data[2]);
            $album = pg_escape_string($data[1]);
            $address = pg_escape_string($data[5]);

            $sql2 = "SELECT * FROM albuns WHERE album_name = '$album'";
            $result = pg_query($conn, $sql2);

            if ($result && pg_num_rows($result) == 0) {
                echo 'Há um erro aqui, não prosseguirei';
                echo ' ' . $sql2;
                exit;
            }

            $meualbum = pg_fetch_array($result);
            $album_id = $meualbum['album_id'];

            $sql = "SELECT * FROM $tabela WHERE endereco = '$address' LIMIT 1";
            $result = pg_query($conn, $sql);

            if ($result && pg_num_rows($result) == 0) {
                $numero = $xx;

                $aunique_id = $campesinato->generateIdentifierFromFile($address);

            //    if ($aunique_id == 'NOTFOUND') {
            //        $numero = $zz;
            //        $zz++;
            //    } else {
                    $xx++;
            //    }

// gerar um numero e consultar se ele já existe

$name = trim($name); 
$numero = gerarnumero($conn, $name);
if ($numero == null) {
$numero = $xx; 
}
$sql = "INSERT INTO $tabela (unique_id, numero, nome, endereco, descricao, atorprincipal, album_id) VALUES ('$aunique_id','$numero','$name', '$address', '$descricao', '$cantor', '$album_id')";
                $result = pg_query($conn, $sql);

                if (!$result) {
                    echo "Erro ao inserir dados: " . pg_last_error($conn);
                    break;
                }

                $sql = "INSERT INTO savings (id, numero, quando) VALUES ('13', '$numero', current_timestamp)";
                $result = pg_query($conn, $sql);

                if (!$result) {
                    echo "Erro ao inserir dados: (controle de upload) " . pg_last_error($conn);
                    break;
                }
            }
        }

        fclose($handle);

        echo "Dados inseridos com sucesso na tabela $tabela.";
    } else {
        echo "Erro ao abrir o arquivo CSV.";
    }
} catch (Exception $e) {
    echo "Erro ao processar o arquivo CSV: " . $e->getMessage();
} finally {
    $sql = "DELETE FROM datavideos WHERE unique_id = 'NOTFOUND'";
    $result = pg_query($conn, $sql);

    // Fechar a conexão com o banco de dados
    pg_close($conn);
}
?>
