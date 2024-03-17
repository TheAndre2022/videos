<?php 
include ('../global/global.php');
$empCls = new Employee($conn);
$result = $empCls ->check_keys($thekeys); 
// Verifica-se está logado
// qual o usuário ?
if (!$result['erro']) { 
// Se não há erro, pega o ID e apaga a chave

$id_prime = $result['id']; 
if ($id_prime == 9999) { $id_prime = 12000; }

$sql = 'delete from logged where id='.$id_prime; 

//if ($id_prime == '9999') {
    $result = pg_query ($conn, $sql); 

    // impede o logout do usuario nobody
//}
}

// Apaga todas as variáveis da sessão
$_SESSION = array();

// Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
// Nota: Isto destruirá a sessão, e não apenas os dados!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Por último, destrói a sessão
session_destroy();
?>
<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="0; url=https://oliveira2022.jumpingcrab.com">
        <script type="text/javascript">
            window.location.href = "https://oliveira2022.jumpingcrab.com"
        </script>
        <title>Page Redirection</title>
    </head>
    <body>
        <!-- Note: don't tell people to `click` the link, just tell them that it is a link. -->
        If you are not redirected automatically, follow this <a href='https://oliveira2022.jumpingcrab.com'>Volta para Casa!!</a>.
    </body>
</html>




