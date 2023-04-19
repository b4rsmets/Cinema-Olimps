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
        $sessions = $this->database->select('seans', ['id', 'name', 'description']);
        ?>
        <div id="wrapper">


        <div class="sidebar">
            <ul>
                <div class="img-side"><img src="../admin/source/img/clapper.png" alt=""><li><button class="sidebar-button" data-panel-id="films">Фильмы</button></li></div>
                <div class="img-side"><img src="../admin/source/img/calendar.png" alt=""><li><button class="sidebar-button" data-panel-id="sessions">Сеансы</button></li></div>
                <div class="img-side"><img src="../admin/source/img/users.png" alt=""> <li><button class="sidebar-button" data-panel-id="users">Пользователи</button></li></div>
            </ul>
        </div>

        <div class="content">
            <div id="films" class="panel" style="display:none;">
                <h2>Фильмы</h2>
                <div class="container-admin-films">
                <?php foreach ($films as $film) { ?>
        <div class="card-movie-admin">
                    <div class="movie-img-admin"><img src="../resource/uploads/afisha/<?=$film['movie_image']?>" alt=""></div>
                    <div class="name-film-admin"><span><?=$film['movie_title']?></span></div>
        </div>
                <?php } ?>
            </div></div>

            <div id="sessions" class="panel" style="display:none;">
                <h2>Сеансы</h2>
                <?php foreach ($sessions as $session) { ?>
                    <div><?php echo htmlspecialchars($session['name']) ?>: <?php echo htmlspecialchars($session['description']) ?></div>
                <?php } ?>
            </div>

            <div id="users" class="panel" style="display:none;">
                <h2>Пользователи</h2>
                <?php foreach ($users as $user) { ?>
                    <div class="user-row" id="user-<?php echo $user['id'] ?>">
                        <div>
                            <?php echo htmlspecialchars($user['login']) ?> (<span class="user-role"><?php echo $user['role'] === 'admin' ? 'Админ' : 'Пользователь'; ?></span>)
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
                                                data-user-role="<?php echo $user['role'] ?>">Дать права Администратора
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
