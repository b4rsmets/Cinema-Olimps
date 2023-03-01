<?php

namespace views;

use QRcode;

class profile
{
    function render()
    {
        if (!empty($_SESSION['auth'])) {
            $this->viewProfile();
        } else {
            header("location: /auth");
        }

    }

    function viewProfile()
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
                <div class="order-info">
                    <div class="image-order">
                        <img src="../resource/uploads/afisha/avatar.jpg" alt="">
                    </div>
                    <div class="order-info-place">
                        <div class="ticket-order">
                            <span><b>Номер билета<br></b>#5198410</span>
                        </div>
                        <div class="place-order">
                            <span><b>Зал: </b>1</span><br>
                            <span><b>Ряд: </b>4</span><br>
                            <span><b>Место: </b>10</span><br>
                            <span><b>Время: </b>18:30</span>
                        </div>
                    </div>
                    <div class="qr-code-container">
                        <?
                        
                        QRcode::png('PHP QR Code :)');
                        ?>
                    </div>
                </div>

                <div class="order-info">
                    <div class="image-order">
                        <img src="../resource/uploads/afisha/cheburashka.jpg" alt="">
                    </div>
                    <div class="order-info-place">
                        <div class="ticket-order">
                            <span><b>Номер билета<br></b>#5173125</span>
                        </div>
                        <div class="place-order">
                            <span><b>Зал: </b>2</span><br>
                            <span><b>Ряд: </b>5</span><br>
                            <span><b>Место: </b>2</span><br>
                            <span><b>Время: </b>21:30</span>
                        </div>
                    </div>
                    <div class="qr-code-container">


                    </div>
                </div>

            </div>
        </div>
        <?
    }
}

?>
