<?
session_start();
$_SESSION['pickedSeat'] = $_POST['seats'];
 $count = 0;
// // вывести эхо на экран
?>
<div id="seats-count"  data-book="15-1">
                                    <span>Билетов fgdgdвыбрано: <span class="selected_seat"></span><?=var_dump($_SESSION['pickedseat'])?></span>

                                </div>
                               <div class="price-count" data-price=<?= $data['price'] ?>>
                                   <span>Цена за один билет <?= $data['price'] ?></span>

                                </div>                                 
                                <div class="price-itog">
                                    <span>Итоговая цена: 0</span>
                                </div> 

