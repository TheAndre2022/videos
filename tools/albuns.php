<?php
$caminho = '/var/www/oliveira2022/';
$caminhoArquivoCSV = '/var/www/opentracker/server/datas/linhas.csv';
$tabela = 'albuns';
$handle = fopen($caminhoArquivoCSV, 'r');

try {
  
    if ($handle !== FALSE) {
        $xx = 4;

        while (($data = fgetcsv($handle, 2000, ',')) !== FALSE) {
            $album = pg_escape_string($data[1]);

            $sql = "SELECT * FROM $tabela WHERE album_name = '$album' LIMIT 1";
            $result = pg_query($conn, $sql);

            if ($result && pg_num_rows($result) == 0) {
                $numero = $xx;
                $xx++;

                $sql = "INSERT INTO $tabela (album_name, total_albuns) VALUES ('$album', '0')";
                $result = pg_query($conn, $sql);

                if (!$result) {
                    echo "Erro ao inserir dados: " . pg_last_error($conn);
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
    // Fechar a conexão com o banco de dados
    pg_close($conn);
}
?>
 
