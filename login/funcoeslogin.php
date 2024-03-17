<?php


class Employee {
    protected $conn;
    protected $data = array();
    private $salt = 'There is something weird about my salt keys_chave_salt_fixa_aqui';

    function __construct($connString) {
        $this->conn = $connString;
    }
    function generateIdentifierFromFile($filePath) {
        if (!file_exists($filePath)) {
            return 'NOTFOUND';
            // Ele não pode interromper o script, precisa sinalar, mas deve prosseguir até o final!!
        }
        
        // Obter informações do arquivo
        $fileName = basename($filePath);
        $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
        $fileSize = filesize($filePath);
        
        // Gerar um hash único baseado nos dados do arquivo
        $uniqueHash = hash('sha512', $fileName . $fileType . $fileSize . $this->salt);
        
        // Codificar o hash em base64 e limitar o comprimento para 30 caracteres
        $base = base64_encode($uniqueHash); 
        $identifier = substr($base, 0, 5). '-'. substr($base, 11, 5) . '-'. substr($base, 40, 5) . '-'. substr($base, 26, 12);
        
        return $identifier;
    }
   

    function check_keys($chave){
        $conn2 = $this->conn; 
        $sql = "select id, createday from logged where chave='".$chave."' limit 1"; 
        $result = pg_query ($conn2, $sql); 
        if (!$result) {$data['erro'] = true; $data['id'] = 9999;  return $data; }
        $linhas = pg_num_rows($result); 
        if ($linhas ==0) { $data['erro'] = true; $data['id'] = 9999;  return $data; }
        $data  = pg_fetch_array($result); 
        $data['erro'] = false; 
              return $data;  
        }


    function login($nome, $senha) {
        $data = array(); // Initialize data here
        $data['username'] = $data['thekeys'] ='nao existe'; 
		// tinha um erro besta aqui, troquei a validação pelo nome das variaveis no formulario index.php
        if(isset($nome) AND isset($senha)) {
            
            $user_email = pg_escape_string(trim($nome));
            $user_password = hash ('sha512', trim ($senha).$user_email); 
           // $data ['senha'] = $user_password; 
            $sql = "SELECT id, username, email FROM usuarios WHERE password = '$user_password'";
            $resultset = pg_query($this->conn, $sql); 

            if (!$resultset) {
                $data['erro'] = "An error occurred.";
            } else {
                if (pg_num_rows($resultset) == 0 ) {
                    $data['erro'] ="Erro aqui!!";
                    $data['login'] = "Wrong Credential."; // wrong details
                    //$data ['senha'] = 'falha de segurança '.$user_password; //falha de segurança, retirar...
                } else {
                    $row = pg_fetch_array($resultset);
                    $data['login'] = 'sucesso';
                    $data ['username'] = $row['username'];
                    $id = $row['id']; 
                    $con2 = $this->conn; 
                    $data['thekeys'] =  $thekeys = atualiza_chaves ($con2, $id); 
                    $data['qrcode'] = qrcode($thekeys,$row['username']);
                  
				// no futuro, gravar essa chave no banco de dados, para cada ação do cliente, verificar se ela existe 
				}
            }
        }
        
        return $data;
    }

}

include '/var/www/opentracker/phpqrcode/qrlib.php';
function qrcode ($chaves, $user)
{

if ($chaves == null || $user == null)
{ $chaves = 'mistaken'; $user = 'mistaken';}
$cha64= $chaves; 
$user64= chaves(); 
$caminhoQRCode = '/var/www/opentracker/server/datas/'.$user64.'-'.$user.'.png';
$linkqrcode = 'https://opentracker.jumpingcrab.com/datas/'.$user64.'-'.$user.'.png';
$dados = 'https://opentracker.jumpingcrab.com/login.php?minhachave='.$cha64; 
QRcode::png($dados, $caminhoQRCode, QR_ECLEVEL_L, 80);
return $linkqrcode; }

function cookiesplease ($chave) {
$name = 'youarewelcome'; 
// define uma chave e salva para o usuário, uso anonimo
// 7200 = duas horas, né? 

setcookie($name, $chave, [
    'expires' => time() + 469200,
    'path' => '/',
    'domain' => 'oliveira2022.jumpingcrab.com',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None'
]);
$_SESSION['keys'] = $chave; 
return true; 
}

function atualiza_chaves($conn, $id) {
    $thekeys = hash('sha512', chaves().'miercoles'); 
    $base = base64_encode($thekeys); 
    $thekeys = $identifier =substr($thekeys, 30, 25).'-'. substr($base, 6, 5) . '-'. substr($base, 10, 5). 
        '-'. substr($base, 15, 5);

    // Exclui os registros antigos
    $sql = "DELETE FROM logged WHERE id = '$id'";
    $result = pg_query($conn, $sql);

    if (!$result) {
        echo "Erro ao excluir registros antigos: " . pg_last_error($conn);
        exit;
    }

    // Insere um novo registro
    $sql = "INSERT INTO logged (id, online, chave) VALUES ('$id', true, '$thekeys')";
    $result = pg_query($conn, $sql);

    if (!$result) {
        echo "Erro ao inserir novo registro: " . pg_last_error($conn);
        exit;
    }

    return $thekeys;
}

