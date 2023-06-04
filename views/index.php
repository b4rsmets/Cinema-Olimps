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
        $this->viewMap();
        $this->viewNews($data['news']);

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
        $hasFilms = false; // Переменная для отслеживания наличия фильмов

        ?>
        <div class="container-catalog">
            <?php
            if (is_array($films)) {
                foreach ($films as $film) {
                    // Проверяем, есть ли сеансы для данного фильма на текущую дату
                    $seanses = $data['seans'];
                    $id_film = $film['id'];
                    $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
                    $now = strtotime(date('Y-m-d H:i:s'));
                    $hasSeans = false;

                    foreach ($seanses as $seans) {
                        if (
                            $seans['movie_id'] == $id_film &&
                            $seans['date_movie'] == $selectedDate &&
                            strtotime($seans['time_movie']) >= $now
                        ) {
                            $hasSeans = true;
                            $hasFilms = true; // Устанавливаем флаг, что есть фильмы
                            break;
                        }
                    }

                    // Если есть сеансы, выводим фильм
                    if ($hasSeans) {
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
                                    Жанр: <?= $film['movie_genre']; ?>
                                </span> <br><span>
                                    <?= $film['movie_duration']; ?> Мин.
                                </span>
                                </div>
                                <div class="raspes-card">
                                    <h3>Сеансы 2D</h3>
                                    <div class="container-times">
                                        <?php
                                        $this->viewSeans($seanses, $film['id']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }

            // Если нет фильмов, выводим сообщение
            if (!$hasFilms) {?>

               <div class="message-films">
                   <img src="../resource/images/message.png" alt="">
                   <h1>Пока что нет фильмов в прокате</h1>
                   <span>Выберите другую дату либо уточните у оператора</span>
               </div>
                <?
            }
            ?>
        </div>
        <?php
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
                        echo "<a href='/booking?id=" . $one_seans['movie_id'] . "&seans=" . $one_seans['id'] . "'><div class='block-time'>";
                        echo '<h2>' . date("G:i", strtotime($one_seans['time_movie'])) . '<span class="price-seans">' . $one_seans['price'] . ' ₽</span></h2>';
                        echo '</div></a>';
                    }
                } else {
                    if (
                        $one_seans['movie_id'] == $id_film &&
                        $one_seans['date_movie'] == $selectedDate
                    ) {
                        $emply = false;
                        echo "<a href='/booking?id=" . $one_seans['movie_id'] . "&seans=" . $one_seans['id'] . "'><div class='block-time'>";
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

    function viewMap()
    {

        require_once './views/map.php';
    }

    function viewNews($news)
    {
        ?>
        <div class="news-container">
            <h1>Новости</h1>
            <?php
            if (is_array($news)) {
                foreach ($news as $new) {
                    ?>
                    <div class="new">
                        <div class="title-new">
                            <?=$new['news_title']; ?>
                        </div>
                        <img class="news-image" src="./resource/uploads/news/<?=$new['news_image']; ?>" alt="News Image">
                        <div class="news-date">
                            <?=$new['news_description']; ?>

                        </div>
                        <div class="news-description">
                            <?=$new['news_date']; ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?
    }


}