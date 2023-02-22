<?
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
$str = substr($_POST['data'], 1, -1);
parse_str($str, $data);
$authmodel = new \models\auth();
$issetUser = $authmodel->authUser($data['login'], $data['password']);
if ($issetUser){
    $_SESSION['auth']['login']=$data['login'];
    $_SESSION['auth']['role']=$issetUser;
    echo  $issetUser;
}
else{

 echo  $issetUser;
}
