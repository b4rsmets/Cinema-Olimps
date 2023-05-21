<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../template/jsconnect.php';

use Medoo\Medoo;

$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'cinemaolimp',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);

$films = $database->select('movies', ['id', 'movie_title', 'movie_image', 'movie_restriction']);

foreach ($films as $film) {
    ?>
    <div class="card-movie-admin">
        <div class="movie-img-admin"><img
                    src="../resource/uploads/afisha/<?= $film['movie_image'] ?>" alt=""></div>
        <div class="name-film-admin"><span><?= $film['movie_title'] ?></span></div>
        <button type="button" class="btn btn-danger delete-btn" data-id="<?= $film['id'] ?>">Удалить</button>
        <button type="button" class="btn btn-success">Редактировать</button>
    </div>
    <?php
}
?>
