<?php

namespace views;
class api
{
    function render($test)
    {
        $this->viewApi($test);
    }

    function viewApi($test)
    {

    ?>
        <div id="movie_info">
            <img src="/img/<?=$test['id']?>.jpg" alt="">
            <p>Name: <?=$test['name']?></p>
            <p>Year: <?=$test['year']?></p>
            <p>Description: <?=$test['description']?></p>
            <p>Genres: <?=$test['genres']?></p>
            <p>Countries: <?=$test['countries']?></p>
            <p>KP rating: <?=$test['kpRating']?></p>
            <p>Age rating: <?=$test['age']?></p>
        </div>

        <input type="text" id="movie_id" placeholder="Введите ID фильма">
        <button id="get_movie_btn">Получить информацию</button>
    <?
    }
}
