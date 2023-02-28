<?
$test = json_decode($_POST["response"]);
$seats = json_decode($_POST["seats"]);
$price = json_decode($_POST["price"]);
$count = 0;
foreach($seats as $item){
    $count++;
}
echo '<span> Выбрано билетов: '. $count .'</span>';
echo '<span> Цена билета: '. $_POST["price"] .'</span>';
echo '<span> Итоговая цена: '. $_POST["price"]*$count .'</span>';