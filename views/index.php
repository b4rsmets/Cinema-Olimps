<?php
namespace views;

class index
{
    function render($data)
    {
        if (isset($data['slider'])) {
            $this->viewSlider($data['slider']);
        } else {
            echo 'Ничего нет';
        }
        $this->viewDates();
        $this->viewFilms($data['films']);

    }
    function viewSlider($sliders)
    {
        ?>
        <div id="slider">
            <?php
            if (is_array($sliders))
                foreach ($sliders as $slide) {
                    ?>
                    <img src="/resource/uploads/posters/<?= $slide['slider_image'] ?>" alt="Slide">

                    <?php
                }
            ?>
            <div id="slide-indicators">
            </div>
        </div>
    <?
    }
    function viewDates()
    {

        require_once './views/date.php';

    }
    function viewFilms($data)
    {
        $films = $data['films'];
        ?>
        <div class="container-catalog">
            <?php
            if (is_array($films))
                foreach ($films as $film) {
                    ?>

                    <div data-aos="zoom-in" class="card">
                        <div class="image-card">
                            <img src="./resource/uploads/afisha/<?= $film['movie_image'] ?>" alt="">
                        </div>
                        <div class="information">
                            <a href="film?id=<?= $film['id'] ?>">
                                <div class="title-card">

                                    <h2>
                                        <?= $film['movie_title']; ?>
                                    </h2>
                                </div>
                            </a>
                            <div class="info-card">
                                <span>
                                    <?= $film['movie_genre']; ?>
                                </span> - <br><span>
                                    <?= date("g \ч. i \мин.", strtotime($film['movie_duration'])); ?>
                                </span>
                            </div>
                            <div class="raspes-card">
                                <h3>Сеансы 2D</h3>
                                <div class="container-times">

                                    <?php

                                    $this->viewSeans($data['seans'], $film['id']);
                                    ?>

                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                }
            if (empty($films)) {
                echo 'Пока что нет фильмов в прокате';
            }
            ?>
        </div>
    <?
    }
    function viewSeans($seanses, $film)
    {
        ?>
        <?php
        $id_film = (isset($film)) ? $film : (isset($_GET['id']) ? $_GET['id'] : null);
        $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $now = strtotime(date('Y-m-d H:i:s'));

        if (is_array($seanses)) {
            $emply = true;
            foreach ($seanses as $one_seans) {
                if ($selectedDate == date('Y-m-d')) {
                    if (
                        $one_seans['movie_id'] == $id_film &&
                        $one_seans['date_movie'] == $selectedDate &&
                        strtotime($one_seans['time_movie']) >= $now
                    ) {
                        $emply = false;
                        echo '<a href="/booking"><div class="block-time">';
                        echo '<h2>' . date("G:i", strtotime($one_seans['time_movie'])) . '<span class="price-seans">' . $one_seans['price'] . ' ₽</span></h2>';
                        echo '</div></a>';
                    }
                } else {
                    if (
                        $one_seans['movie_id'] == $id_film &&
                        $one_seans['date_movie'] == $selectedDate
                    ) {
                        $emply = false;
                        echo '<a href="/booking"><div class="block-time">';
                        echo '<h2>' . date("G:i", strtotime($one_seans['time_movie'])) . '<span class="price-seans">' . $one_seans['price'] . ' ₽</span></h2>';
                        echo '</div></a>';
                    }
                }
            }
            if ($emply) {
                echo '<div class="empty">';
                echo '<span>Нет сеансов</span>';
                echo '</div>';
            }
        }
        ?>

    <?
    }

}