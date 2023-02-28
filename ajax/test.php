<?
$test = json_decode($_POST["response"]);
$seats = json_decode($_POST["seats"]);
$price = json_decode($_POST["price"]);
$count = 0;
foreach($seats as $item){
    $count++;
}
echo '<span> Билетов выбрано: '. $count .'</span>';
echo '<span> Цена билета: '. $price .'</span>';
echo '<span> Итоговая цена: '. $price*$count .'</span>';
?>