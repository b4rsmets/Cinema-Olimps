<?php

namespace views;

class booking
{

    function render($data, $seats, $booking)
    {
        $date = date('Y-m-d');
        $time = date("H:i:s");
        $timeSeans = date("H:i:s", strtotime($data['time_movie']));
        $movieDate = strtotime($data['date_movie']);

        if ($movieDate >= strtotime($date) && ($movieDate == strtotime($date) && $time < $timeSeans || $movieDate > strtotime($date))) {
            $this->viewPlace($data, $seats, $booking);
        } else {
            require './views/seansUnavaiable.php';
        }
    }


    function viewPlace($data, $seats, $booking)
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
                            <div class="age-booking-film">
                                <span><?= $data['movie_restriction'] ?>+</span>
                            </div>
                            <div class="duration-booking-film">
                                <h3>Длительность: </h3>
                                <span><?= date("g \ч. i \мин.", strtotime($data['movie_duration'])); ?></span>
                            </div>
                        </div>
                        <div class="time-date-booking-film">
                            <div class="time-film">
                                <img src="../resource/images/cloak.png" alt=""> <span><?= date("G:i", strtotime($data['time_movie']))?></span>
                            </div>
                            <div class="date-film">
                                <img src="../resource/images/calendar.png" alt="">  <span><?= date("F j", strtotime($data['date_movie']))?></span>
                            </div>
                        </div>

                    </div>
                    <div class="brone">
                        <div class="screen"></div>
                        <div class="seats">

                            <?

                            if (is_array($seats)) {
                                foreach ($seats as $seat) {
                                    $is_booked = false;
                                    foreach ($booking as $book) {
                                        if ($book['id_seat'] == $seat['id'] && $book['id_seans'] == $data["id"]) {
                                            $is_booked = true;
                                            break;
                                        }
                                    }


                                    ?>

                                    <div data-seat="<?= $seat['row'] ?>-<?= $seat['place'] ?>"
                                         class="seat <?php echo $is_booked ? "unavailable" : "available"; ?>">
                                        <?php echo $seat['place'] ?>
                                    </div>
                                    <?php

                                }
                            }
                            if ($seats == null) {
                                ?>
                                <div class="err-seats">
                                    <span>Места пока что недоступны</span>
                                </div>

                                <?
                            }
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
                                <div id="seats-count" data-book="">
                                    <span>Билетов выбрано: <span
                                                class="selected_seat"></span>0</span>

                                </div>
                                <div class="price-count" data-price=<?= $data['price'] ?>>
                                    <span>Цена за один билет <?= $data['price'] ?></span>

                                </div>
                                <div class="price-itog">
                                    <span>Итоговая цена: 0</span>
                                </div>

                            </div>
                            <div class="btn-order">

                                <input type="submit" value="Оформить заказ">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <?

    }
}
