<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!$_POST['selected_seat']==0){
    $_SESSION['order'] = $_POST['book'];

    // здесь можно обработать данные и вернуть какой-то результат
    $result = 'Заказ оформлен!';

    echo $result;
}
    else {
        echo 'Ошибка';
    }
}
