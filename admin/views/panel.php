<?php

namespace admin\views;

require_once 'admin/vendor/autoload.php';
require_once 'admin/template/jsconnect.php';

use Medoo\Medoo;

class Panel
{
    private $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'cinemaolimp',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);
    }
    public function render()
    {
        if (!isset($_SESSION['role']['role']) || $_SESSION['role']['role'] !== 'admin') {
            header("Location: /afisha");
            exit;
        }
        $this->viewAdm();
    }

    public function viewAdm()
    {
        require_once 'admin/template/header.php';
        $users = $this->database->select('users', ['id', 'login', 'role']);
        $films = $this->database->select('movies', ['id', 'movie_title', 'movie_image', 'movie_restriction']);
        $sessions = $this->database->select('seans', [
            '[>]movies' => ['movie_id' => 'id']
        ], [
            'seans.id',
            'seans.date_movie',
            'seans.time_movie',
            'movies.id(movie_id)',
            'movies.movie_title',
            'movies.movie_image',
            'movies.movie_restriction'
        ]);
        ?>
        <div id="wrapper">


            <div class="sidebar">
                <ul>
                    <div class="img-side"><img src="../admin/source/img/clapper.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="films">Фильмы</button>
                        </li>
                    </div>
                    <div class="img-side"><img src="../admin/source/img/calendar.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="sessions">Сеансы</button>
                        </li>
                    </div>
                    <div class="img-side"><img src="../admin/source/img/users.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="users">Пользователи</button>
                        </li>

                    </div>
                    <div class="img-side"><img src="../admin/source/img/news.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="news">Новости</button>
                        </li>

                    </div>
                    <div class="img-side"><img src="../admin/source/img/orders.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="orders">Заказы</button>
                        </li>

                    </div>
                </ul>
                <div class="info-panel-user">
                    <span><?= $_SESSION['role']['full_name']; ?>  (<?= $_SESSION['role']['role']; ?>)</span>
                    <a href="#" class="btn btn-danger" id="logout">Выйти с админ аккаунта</a>

                </div>
            </div>

            <div class="content">
                <div class="info-admin">
                    <h3>Вы находитесь в панели администратора кинотеатра Олимп</h3>
                </div>
                <div id="films" class="panel" style="display:none;">
                    <h2>Фильмы</h2>



                    <!-- Modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Добавить фильм в прокат
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Добавление фильма</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="addMovieForm">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">ID Кинопоиска</span>
                                            </div>
                                            <input type="number" class="form-control" name="id_kp">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-primary" id="addMovieButton">Добавить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="error-message" class="" role="alert" style="display: none;"></div>
                    <div id="container-admin-films" class="container-admin-films">

                        <?php foreach ($films as $film) { ?>
                            <div class="card-movie-admin">
                                <div class="movie-img-admin"><img
                                        src="../resource/uploads/afisha/<?= $film['movie_image'] ?>" alt=""></div>
                                <div class="name-film-admin"><span><?= $film['movie_title'] ?></span></div>
                                <button type="button" class="btn btn-danger delete-btn" data-id="<?= $film['id'] ?>">Удалить</button>
                                <button type="button" class="btn btn-success">Редактировать</button>
                                </div>
                        <?php } ?>
                    </div>
                </div>

                <div id="sessions" class="panel" style="display:none;">
                    <h2>Сеансы</h2>
                    <?php foreach ($sessions as $session) { ?>
                        <div><?php print_r($session); ?></div>
                    <?php } ?>
                </div>

                <div id="users" class="panel" style="display:none;">
                    <h2>Пользователи</h2>
                    <?php foreach ($users as $user) { ?>
                        <div class="user-row" id="user-<?php echo $user['id'] ?>">
                            <div>
                                <?php echo htmlspecialchars($user['login']) ?> (<span
                                    class="user-role"><?php echo $user['role'] === 'admin' ? 'Админ' : 'Пользователь'; ?></span>)
                                <form class="update-role-form" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                                    <div>
                                        <?php if ($user['role'] === 'admin') { ?>
                                            <button class="btn btn-secondary btn-remove-admin btn btn-danger"
                                                    data-user-id="<?php echo $user['id'] ?>"
                                                    data-user-role="<?php echo $user['role'] ?>">Забрать права
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-primary btn-give-admin btn btn-success"
                                                    data-user-id="<?php echo $user['id'] ?>"
                                                    data-user-role="<?php echo $user['role'] ?>">Дать права
                                                Администратора
                                            </button>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }

}
