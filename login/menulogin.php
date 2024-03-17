<?php 
include ('../global/global.php');
// Aqui, a lógica para se fazer o login
$empCls = new Employee($conn);


$nome = isset($_POST['nome']) ? $_POST['nome'] : 'erro';  
$senha = isset($_POST['senha']) ? $_POST['senha'] : 'erro';

if ($nome =='erro'){
    $nome = isset($_REQUEST['nome']) ? $_REQUEST['nome'] : 'erro';  
    $senha = isset($_REQUEST['senha']) ? $_REQUEST['senha'] : 'erro';

}
$nome = pg_escape_string ($nome); 
$senha = pg_escape_string ($senha);

$data = $result = $empCls->login($nome, $senha);
$name = 'login2024'; 
$value = base64_encode(json_encode($data)); 
setcookie($name, $value, [
    'expires' => time() + 7200,
    'path' => '/',
    'domain' => 'oliveira2022.jumpingcrab.com',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None'
]);

$_SESSION['login'] = $data['login'];
$_SESSION['novaschaves'] = $data ['thekeys']; 
$_SESSION['username'] = $data ['username'];



header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>



