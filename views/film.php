<?php

namespace views;

class film
{


    function render($film)
    {
        $this->viewDates();
        $this->viewFilm($film);
    }

    function viewDates()
    {
        require_once './views/date.php';
    }

    function viewFilm($films)
    {
        $film = $films['films'];
        $seans = $films['seans'];

        ?>
        <div class="container-film">
            <div class="information-film">
                <div class="poster-film">
                    <img src="./resource/uploads/afisha/<?= $film['movie_image'] ?>" alt="">
                </div>
                <div class="restriction-film">
                    <span>
                        <?= $film['movie_restriction'] ?>+
                    </span>
                </div>
                <div class="title-film">
                    <h2>
                        <?= $film['movie_title'] ?>
                    </h2>
                </div>

                <div class="genre-film">
                    <span class="podtext">Жанр</span>
                    <h3>
                        <?= $film['movie_genre'] ?>
                    </h3>
                </div>
                <div class="country-film">
                    <span class="podtext">Страна</span>
                    <h3>
                        <?= $film['movie_country'] ?>
                    </h3>
                </div>
                <div class="duration-film">
                    <span class="podtext">Продолжительность</span>
                    <p>
                        <?= date("g \ч. i \мин.", strtotime($film['movie_duration'])); ?>
                    </p>
                </div>
            </div>
            <div class="content-film-container">
                <div class="tickets-film">

                    <div class="seans-container-film">
                        <h1>Сеансы 2D</h1>
                        <div class="container-card">
                            <?php
                            $this->viewSeans($seans, $film)
                            ?>
                        </div>
                    </div>

                </div>
                <div class="description-film">
                    <span>
                        <?= $film['movie_description'] ?>
                    </span>
                </div>
                <div class="trailer">
                    <iframe width="700" height="400" src="<?= $film['movie_trailer'] ?>"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <?
    }

    function viewSeans($seanses, $film)
    {
        ?>
        <?php
        $id_film = (isset($film)) ? $film['id'] : (isset($_GET['id']) ? $_GET['id'] : null);
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
                        echo '<div class="block-time">';
                        echo '<h2>' . date("G:i", strtotime($one_seans['time_movie'])) . '<span class="price-seans">' . $one_seans['price'] . ' ₽</span></h2>';
                        echo '</div>';
                    }
                } else {
                    if (
                        $one_seans['movie_id'] == $id_film &&
                        $one_seans['date_movie'] == $selectedDate
                    ) {
                        $emply = false;
                        echo '<div class="block-time">';
                        echo '<h2>' . date("G:i", strtotime($one_seans['time_movie'])) . '<span class="price-seans">' . $one_seans['price'] . ' ₽</span></h2>';
                        echo '</div>';
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