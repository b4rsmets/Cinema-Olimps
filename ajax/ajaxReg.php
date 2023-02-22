<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
$str = substr($_POST['data'], 1, -1);
parse_str($str, $data);
$regmodel = new \models\reg();
$issetlogin = $regmodel->checkUser($data['login']);
if ($issetlogin){
    echo $issetlogin;
    return true;
}
else{
    $regmodel->addUser($data['login'], $data['password']);
}
