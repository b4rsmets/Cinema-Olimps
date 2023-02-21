<?php
namespace views;

class profile
{
function render(){
    $this->viewProfile();
}
function viewProfile(){
    ?>
    <div class="profile-container">
    <div class="user-info">
        <h2>Информация о вас</h2>
        <div class="name-user">
            <span>Имя:<span> Вячеслав</span></span>
            <span>Фамилия:<span class="block-info-user-opacity"> Попов</span></span>
        </div>
        <div class="email-user">
            <span>Email:<span> slavunq@mail.ru</span></span>
        </div>
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
            <img src="../resource/qrcodes/32131231.png" alt="">
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