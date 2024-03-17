<?php 

if ($cookie == 'zero') { 
    $data ['erro'] = 'Procedimento de login abortado, quero cookies e você não os têm!';
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode ($data); 
    exit; 
}

$empCls = new Employee($conn);

 
if ($thekeys =='nada') {
header("Location: https://oliveira2022.jumpingcrab.com");
exit; 
}
$result = $empCls->check_keys($thekeys);

if ($result['erro']) {
  header("Location: https://oliveira2022.jumpingcrab.com");
  exit; 
}
include_once $caminho.'htmls/header.php'; 

?>
<!DOCTYPE html>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>

<div class="container">
	<div class="row">
        <h2>Multi level dropdown menu in Bootstrap 3</h2>
        <hr>
        <div class="dropdown">
            <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="#">
                Dropdown <span class="caret"></span>
            </a>
    		<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li><a href="https://oliveira2022.jumpingcrab.com/videoplayer.php">How About some videos</a></li>
              <li><a href="https://oliveira2022.jumpingcrab.com/uniqueid/videoplayer-unique.php?chave=<?php echo $thekeys;?>">Quero Playlists </a></li>
              <li><a href="#">Some other action</a></li>
              <li class="divider"></li>
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Hover me for more options</a>
                <ul class="dropdown-menu">
                  <li><a tabindex="-1" href="#">Second level</a></li>
                  <li class="dropdown-submenu">
                    <a href="#">Even More..</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">3rd level</a></li>
                    	<li><a href="#">3rd level</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Second level</a></li>
                  <li><a href="#">Second level</a></li>
                </ul>
              </li>
            </ul>
        </div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>

<h1> <button type = 'button' id ='botaologout'> <a href="<?php echo $site; ?>/login/logout.php" class="tm-page-link-icon"> 
  Vamos sair daqui? - logout </a> </button> </h1>