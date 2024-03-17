<?php
class dbObj {
    /* Database connection start */
    var $servername = "localhost";
    var $username = "oliveira2022";
    var $password = "95ca28xc";
    var $dbname = "oliveira2022";
    var $port = 5432; // Change this to the actual port number if it's not the default (usually 5432)
    var $conn;
function set_environment ($server, $user, $pass, $db, $ports)
{

// Falta checar se os dados estão corretos, 
// vai funcionar, não sei    
$this->servername = $server; 
$this->username = $user;
$this->password= $pass; 
$this->dbname = $db;  
$this->port = $ports; 
return true; 
}

    function getConnstring() {
        $con = pg_connect("host=" . $this->servername . " port=" . $this->port . " dbname=" . $this->dbname . " user=" . $this->username . " password=" . $this->password)
            or die("Connection failed: " . pg_last_error());

        /* check connection */
        if (!$con) {
            printf("Connect failed: %s\n", pg_last_error());
            exit();
        } else {
            $this->conn = $con;
        }
        return $this->conn;
    }
}

function chaves()
{
 
// Obtém bytes aleatórios do espaço aleatório do sistema
$bytes = random_bytes(2048);
$length = 2048; 
// Converte os bytes para um número inteiro usando unpack
$seed = hexdec(bin2hex($bytes));
// Adiciona o tempo atual em microssegundos
mt_srand (microtime(true) * 1000000);
// Gera um número inteiro aleatório entre 1 e 100
$numeroAleatorio = mt_rand(1, 100);
$bytes = random_bytes($length + 1).$numeroAleatorio;
$cliente = ipclient(); 
$salt = isset($_SERVER['SSL_SESSION_ID']) ? $_SERVER['SSL_SESSION_ID'] : 'Nada de errado, por aqui';
$bytes = md5(hash ('sha512', $salt.$cliente.$bytes)).'-'.md5(time()); 
return $bytes; 

}

function ipclient ()
{

if (!empty($_SERVER['HTTP_CLIENT_IP']))   
{
$ip_address = $_SERVER['HTTP_CLIENT_IP'];
}
//verifica se o IP é de algum proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
{
$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//verifica se o IP é de um endereço remoto
else
{
$ip_address = $_SERVER['REMOTE_ADDR'];
}
return $ip_address;
}


function randomXToY($minVal, $maxVal) {
    $randVal = $minVal + (rand() / getrandmax()) * ($maxVal - $minVal);
    return round($randVal);
}
