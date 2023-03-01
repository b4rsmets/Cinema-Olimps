<?php

namespace views;

class booking
{
    function render($data, $seats)
    {
        $date = date('Y-m-d');
        if ($date == $data['date_movie']) {
            $this->viewPlace($data,$seats);
            
        } else {
            require './views/404.php';
        }
    }


    function viewPlace($data,$seats)
    {


        ?>
        <div class="booking-container">
            <div class="left-container-booking">
                <div class="img-booking-film">
                    <img src="../resource/uploads/afisha/<?= $data['movie_image'] ?>" alt="">
                </div>
                <div class="under-img-booking">
                    <div class="left-status-container">
                        <div class="status-order">
                            <div class="activecomplete">
                            </div>
                            <div class="line-complete">

                            </div>
                            <div class="complete">

                            </div>
                            <div class="line-complete">

                            </div>
                            <div class="complete">

                            </div>
                        </div>
                    </div>
                    <div class="right-status-container">
                        <span> Выбор места</span>
                        <span> Оплата</span>
                        <span> Выдача билета</span>
                    </div>
                </div>
            </div>
            <div class="right-container-booking">
                <div class="container-info-booking-film">

                    <div class="info-booking-film">
                        <div class="title-booking-film">
                            <span><?= $data['movie_title'] ?></span>
                        </div>
                    </div>
                    <div class="brone">
                        <div class="screen"></div>
                        <div class="seats">

                            <?
                            
                            if (is_array($seats))
                            foreach ($seats as $seat) {
                            ?>
                            <div  data-seat="<?=$seat['row']?>-<?=$seat['place']?>" class="seat <?if($seat['booking'] == 1){echo "unavailable";} else{echo "available";}?>"><?=$seat['place']?></div>
                            <?}
                            ?>
                        </div>
                        <div class="examples-pick">
                            <div class="info-pick-brone">
                                <div class="seat available"></div>
                                <div class="seat unavailable"></div>
                                <div class="seat pick"></div>
                            </div>
                            <div class="desc-info-pick">
                                <span>- Доступное место</span>
                                <span>- Недоступное место</span>
                                <span>- Выбранное место</span>
                            </div>
                            <div class="info-pay">
                                <div id="seats-count">
                                    <span>Билетов выбрано: <span class="selected_seat">0</span></span>

                                </div>
                                <div class="price-count" data-price=<?= $data['price'] ?>>
                                    <span>Цена за один билет <?= $data['price'] ?></span>

                                </div>
                                <div class="price-itog">
                                    <span>Итоговая цена: 0</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?
    }
    
}
