<?php
echo " <h1> Daqui para frente é o reino do arquivo linhas2 </h1>"; 
set_time_limit(0);

$caminho = '/var/www/oliveira2022/';
$caminhoArquivoSaida = '/var/www/opentracker/server/datas/linhas.csv';

// Função para obter linhas de diretórios e gravar no arquivo de saída
function processarLinhasDiretorio($diretorio, $arquivoSaida) {
    $lsOutput = shell_exec("ls --recursive $diretorio");

    $linhas = explode("\n", $lsOutput);

    $x = 1;
    $diretorioPrincipal = '';

    foreach ($linhas as $linha) {
        $linha = trim($linha);

        if (substr($linha, -1) == ':') {
            $diretorioPrincipal = rtrim($linha, ':');
           // echo "<font color = red> Este é o diretório principal =".$diretorioPrincipal.'</font> <br>'; 

        } else {
            if (!empty($linha)) {
                $sublinhas = explode('-', $linha);

                for ($cp = 0; $cp < 5; $cp++) {
                    $sublinhas[$cp] = isset($sublinhas[$cp]) ? trim($sublinhas[$cp]) : 'nada';
                }

                $linhaseparada = implode(',', array_slice($sublinhas, 0, 4));
                $caminhoCompleto = "$x,$linhaseparada,$diretorioPrincipal/$linha";

                $tmp = explode('.', $sublinhas[3]);
                $tmptipo = isset($tmp[1]) ? $tmp[1] : 'noextension';

           //     if (in_array($tmptipo, ['mp4', 'webm', 'mp3', 'ogg'])) {
                    $x++;
                   // echo $linhaseparada.'<br>';
                    fwrite($arquivoSaida, $caminhoCompleto . PHP_EOL);
           //     }
            }
        }
    }
echo "linhas processadas ".$x; 
    return $x;
}

try {
    // Abrir o arquivo de saída para gravação
    $arquivoSaida = fopen($caminhoArquivoSaida, 'w');

    if ($arquivoSaida !== FALSE) {
        $x = processarLinhasDiretorio('/home/andre/videos', $arquivoSaida);

        // Fechar o arquivo de saída
        fclose($arquivoSaida);

        echo "Dados inseridos com sucesso no arquivo em $caminhoArquivoSaida.";
    } else {
        echo "Erro ao abrir o arquivo de saída.";
    }
} catch (Exception $e) {
    echo "Erro ao processar a saída do comando ls: " . $e->getMessage();
}
?>
 
