<?php

namespace views;

use QRcode;

class profile
{
    function render($orders)
    {
        if (!empty($_SESSION['auth'])) {
            $this->viewProfile($orders);
        } else {
            header("location: /auth");
        }

    }

    function viewProfile($orders)
    {
        ?>
        <div class="profile-container">
            <div class="user-info">
                <h2>Информация о вас</h2>
                <div class="name-user">
                    <span>Имя:<span
                                class="block-info-user-opacity"> <?= $_SESSION['role']['full_name']; ?></span></span>
                </div>
                <div class="email-user">
                    <span>Email:<span> <?= $_SESSION['role']['email']; ?></span></span>
                </div>
                <?
                if (!empty($_SESSION['role']['role'] == 'admin')) {
                    ?>
                    <span>Вы админ</span>
                    <?
                }
                ?>
                <a href="#" id="logout-btn">Выход</a>


            </div>
            <div class="line-user-order"></div>
            <div class="order-user">
                <h2>Ваши заказы:</h2>
                <?
                if (is_array($orders))
                    foreach ($orders as $order) {?>
                <div class="order-info">

                    <div class="image-order">
                        <img src="../resource/uploads/afisha/<?=$order['movie_image']?>" alt="">
                    </div>
                    <div class="order-info-place">
                        <div class="ticket-order">
                            <span><b>Номер билета<br></b>#<?=$order['ticket_number']?></span>
                        </div>
                        <div class="place-order">
                            <span><b>Зал: </b><?=$order['hall_id']?></span><br>
                            <span><b>Ряд: </b><?=$order['row']?></span><br>
                            <span><b>Место: </b><?=$order['place']?></span><br>
                            <span><b>Время: </b><?=date("G:i", strtotime($order['time_movie']))?></span>
                        </div>
                    </div>
                    <div class="qr-code-container">
                        <img src="../resource/qrcodes/bilet_<?=$order['qr']?>.png" alt="">
                    </div>
                </div>
                <?
                }?>

            </div>
        </div>
        <?
    }
}

?>
