<?php

namespace views;

class booking
{
    function render()
    {
        $this->viewPlace();
    }


    function viewPlace()
    {


        ?>
        <div class="booking-container">
            <div class="left-container-booking">
                <div class="img-booking-film">
                    <img src="../resource/uploads/afisha/cheburashka.jpg" alt="">
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
                            <span>Чебурашка</span>
                        </div>
                    </div>
                    <div class="brone">
                        <div class="screen"></div>
                        <di class="seats">
                            <div class="seat available">1</div>
                            <div class="seat unavailable">2</div>
                            <div class="seat available">3</div>
                            <div class="seat available">4</div>
                            <div class="seat available">5</div>
                            <div class="seat available">6</div>
                            <div class="seat available">7</div>
                            <div class="seat available">8</div>
                            <div class="seat available">9</div>
                            <div class="seat available">10</div>
                            <div class="seat available">11</div>
                            <div class="seat available">12</div>
                            <div class="seat available">13</div>
                            <div class="seat available">14</div>
                            <div class="seat unavailable">15</div>
                            <div class="seat available">16</div>
                            <div class="seat available">17</div>
                            <div class="seat unavailable">18</div>
                            <div class="seat available">1</div>
                            <div class="seat available">2</div>
                            <div class="seat available">3</div>
                            <div class="seat available">4</div>
                            <div class="seat available">5</div>
                            <div class="seat available">6</div>
                            <div class="seat available">7</div>
                            <div class="seat available">8</div>
                            <div class="seat available">9</div>
                            <div class="seat available">10</div>
                            <div class="seat available">11</div>
                            <div class="seat unavailable">12</div>
                            <div class="seat available">13</div>
                            <div class="seat available">14</div>
                            <div class="seat available">15</div>
                            <div class="seat available">16</div>
                            <div class="seat available">17</div>
                            <div class="seat available">18</div>
                            <div class="seat available">1</div>
                            <div class="seat unavailable">2</div>
                            <div class="seat available">3</div>
                            <div class="seat available">4</div>
                            <div class="seat available">5</div>
                            <div class="seat available">6</div>
                            <div class="seat available">7</div>
                            <div class="seat available">8</div>
                            <div class="seat available">9</div>
                            <div class="seat available">10</div>
                            <div class="seat available">11</div>
                            <div class="seat available">12</div>
                            <div class="seat available">13</div>
                            <div class="seat available">14</div>
                            <div class="seat unavailable">15</div>
                            <div class="seat available">16</div>
                            <div class="seat available">17</div>
                            <div class="seat available">18</div>
                            <div class="seat available">1</div>
                            <div class="seat unavailable">2</div>
                            <div class="seat available">3</div>
                            <div class="seat available">4</div>
                            <div class="seat available">5</div>
                            <div class="seat available">6</div>
                            <div class="seat available">7</div>
                            <div class="seat available">8</div>
                            <div class="seat available">9</div>
                            <div class="seat unavailable">10</div>
                            <div class="seat available">11</div>
                            <div class="seat unavailable">12</div>
                            <div class="seat available">13</div>
                            <div class="seat available">14</div>
                            <div class="seat available">15</div>
                            <div class="seat available">16</div>
                            <div class="seat available">17</div>
                            <div class="seat available">18</div>
                            <div class="seat available">1</div>
                            <div class="seat available">2</div>
                            <div class="seat available">3</div>
                            <div class="seat available">4</div>
                            <div class="seat available">5</div>
                            <div class="seat available">6</div>
                            <div class="seat available">7</div>
                            <div class="seat available">8</div>
                            <div class="seat available">9</div>
                            <div class="seat available">10</div>
                            <div class="seat available">11</div>
                            <div class="seat available">12</div>
                            <div class="seat available">13</div>
                            <div class="seat available">14</div>
                            <div class="seat available">15</div>
                            <div class="seat available">16</div>
                            <div class="seat available">17</div>
                            <div class="seat available">18</div>
                            <div class="seat available">1</div>
                            <div class="seat available">2</div>
                            <div class="seat available">3</div>
                            <div class="seat available">4</div>
                            <div class="seat available">5</div>
                            <div class="seat available">6</div>
                            <div class="seat available">7</div>

                            <script>$(' .available').on('click', function () {
                                    $(this).toggleClass('pick');
                                });</script>
                        </di>
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
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?
    }
}