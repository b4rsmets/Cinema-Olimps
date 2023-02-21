<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
$str = substr($_POST['data'], 1, -1);
parse_str($str, $data);
$usermodel = new \models\user();
$issetlogin = $usermodel->checkUser($data['login']);
echo $issetlogin;
