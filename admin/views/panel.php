<?php

namespace admin\views;

require_once 'admin/vendor/autoload.php';
require_once 'admin/template/jsconnect.php';

use Medoo\Medoo;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Panel
{

    private $database;

    public function __construct()
    {
        session_start();
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

        // Формируем условие фильтрации по дате, если она была выбрана
        $users = $this->database->select('users', ['id', 'login', 'role']);
        $settings = $this->database->select('settings', '*');
        $orders = $this->database->select('orders', [
            '[>]users' => ['id_user' => 'id'],
            '[>]seans' => ['id_seans' => 'id'],
            '[>]seats' => ['id_seat' => 'id'],
            '[>]movies' => ['seans.movie_id' => 'id']
        ], [
            'orders.id',
            'orders.ticket_number',
            'orders.qr',
            'orders.id_seans',
            'seats.row',
            'seats.place',
            'users.full_name(full_name)',
            'users.phone(phone)',
            'users.email(email)',
            'seans.hall_id(hall_id)',
            'seans.price',
            'seans.id',
            'seans.date_movie(date_movie)',
            'seans.time_movie(time_movie)',
            'movies.movie_title(movie_title)',
            'movies.movie_image(movie_image)'
        ]);

        // Создаем временный массив для хранения значений date_movie
        $tempDates = [];
        foreach ($orders as $order) {
            $tempDates[] = $order['seans']['date_movie'];
        }

        // Сортируем массивы результатов и временный массив по убыванию date_movie
        array_multisort($tempDates, SORT_DESC, $orders);


        $news = $this->database->select('news', ['id', 'news_image', 'news_title', 'news_date', 'news_description']);
        $films = $this->database->select('movies', ['id', 'movie_title', 'movie_image', 'movie_restriction', 'movie_image', 'movie_genre', 'movie_description', 'movie_duration', 'movie_country', 'movie_trailer']);
        $sessions = $this->database->select('seans', [
            '[>]movies' => ['movie_id' => 'id']
        ], [
            'seans.id',
            'seans.date_movie',
            'seans.time_movie',
            'seans.price',
            'movies.id(movie_id)',
            'movies.movie_title',
            'movies.movie_image',
            'movies.movie_restriction'
        ]);

        $today = date('Y-m-d');
        $sessions = array_filter($sessions, function ($session) use ($today) {
            return $session['date_movie'] >= $today;
        });
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
                            <button class="sidebar-button" data-panel-id="seans">Сеансы</button>
                        </li>

                    </div>
                    <div class="img-side"><img src="../admin/source/img/users.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="users">Пользователи</button>
                        </li>

                    </div>
                    <div class="img-side"><img src="../admin/source/img/news.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="news">Настройки сайта</button>
                        </li>

                    </div>
                    <div class="img-side"><img src="../admin/source/img/orders.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="orders">Заказы</button>
                        </li>

                    </div>
                    <div class="img-side"><img src="../admin/source/img/report.png" alt="">
                        <li>
                            <button class="sidebar-button" data-panel-id="report">Отчет</button>
                        </li>
                    </div>
                </ul>
                <div class="info-panel-user">
                    <span><?= $_SESSION['role']['full_name']; ?>  (<?= $_SESSION['role']['role']; ?>)</span>
                    <a href="#" class="btn btn-danger" id="logout">Выйти с админ аккаунта</a>

                </div>
            </div>
            <div id="error-message" class="" role="alert" style="display: none;"></div>
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
                    <!--Добавления фильма-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel"
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
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="addMovieButton">Добавить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->

                    <div id="container-admin-films" class="container-admin-films">

                        <?php foreach ($films as $film) { ?>
                            <div class="card-movie-admin">
                                <?php
                                if (
                                    $film['movie_title'] == null ||
                                    $film['movie_restriction'] == null ||
                                    $film['movie_image'] == null ||
                                    $film['movie_genre'] == null ||
                                    $film['movie_description'] == null ||
                                    $film['movie_duration'] == null ||
                                    $film['movie_country'] == null ||
                                    $film['movie_trailer'] == null
                                ) {
                                    echo '<div class="danger">Некоторые поля пустые</div>';
                                }
                                ?>
                                <!-- Кнопки работы с фильмами  -->
                                <div class="movie-img-admin"><img
                                            src="../resource/uploads/afisha/<?= $film['movie_image'] ?>" alt=""></div>
                                <div class="name-film-admin"><span><?= $film['movie_title'] ?></span></div>
                                <button type="button" class="btn btn-danger delete-btn" data-id="<?= $film['id'] ?>">
                                    Удалить
                                </button>
                                <button type="button" class="btn btn-primary edit-movie-btn" data-toggle="modal"
                                        data-target="#editMovieModal" data-movie-id="<?= $film['id'] ?>">
                                    Редактировать фильм
                                </button>


                                <!-- Кнопки работы с фильмами  -->
                                <!-- Модальное окно редактирования  -->
                                <div class="modal fade" id="editMovieModal" tabindex="-1" role="dialog"
                                     aria-labelledby="editMovieModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editMovieModalLabel">Редактировать
                                                    фильм</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form enctype="multipart/form-data" method="post">
                                                    <div class="form-group">
                                                        <label for="movie_title">Название фильма</label>
                                                        <input type="text" class="form-control" name="movieTitle"
                                                               id="movie_title" placeholder="Введите название фильма">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="movie_restriction">Ограничение по возрасту</label>
                                                        <input type="text" class="form-control" name="movieRestriction"
                                                               id="movie_restriction"
                                                               placeholder="Введите ограничение по возрасту">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="movie_image">Изображение фильма</label>
                                                        <input type="file" class="form-control-file" name="movieImage"
                                                               id="movie_image">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="movie_genre">Жанр фильма</label>
                                                        <input type="text" class="form-control" name="movie_genre"
                                                               id="movie_genre"
                                                               placeholder="Введите жанр фильма">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="movie_description">Описание фильма</label>
                                                        <textarea class="form-control" name="movie_description"
                                                                  id="movie_description" rows="3"
                                                                  placeholder="Введите описание фильма"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="movie_duration">Продолжительность фильма</label>
                                                        <input type="text" class="form-control" name="movie_duration"
                                                               id="movie_duration"
                                                               placeholder="Введите продолжительность фильма">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="movie_country">Страна производства</label>
                                                        <input type="text" class="form-control" name="movie_country"
                                                               id="movie_country"
                                                               placeholder="Введите страну производства">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="movie_trailer">Ссылка на трейлер</label>
                                                        <input type="text" class="form-control" name="movie_trailer"
                                                               id="movie_trailer"
                                                               placeholder="Введите ссылку на трейлер">
                                                    </div>
                                                    <input type="hidden" id="movie_id" name="movieId"
                                                           value="<?php echo $movieId; ?>">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Закрыть
                                                </button>
                                                <button type="button" id="save_changes-seans"
                                                        data-seansid="<?= $seansId ?>" class="btn btn-primary">Сохранить
                                                    изменения
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Модальное окно редактирования  -->
                            </div>
                        <?php } ?>

                    </div>
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

                <!-- Сеансы -->
                <div id="seans" class="panel" style="display:none;">
                    <h2>Сеансы</h2>
                    <div class="header-seans">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#seansAdd">
                            Добавить сеанс
                        </button>
                        <div class="filters-seans">
                            <label for="movie-select">Выберите фильм:</label>
                            <select id="movie-select" class="form-control">
                                <option value="">Все фильмы</option>
                                <?php foreach ($films as $filmchoose) { ?>
                                    <option value="<?php echo $filmchoose['movie_title']; ?>"><?php echo $filmchoose['movie_title']; ?></option>
                                <?php } ?>
                            </select>
                            <label for="date-select">Выберите дату:</label>
                            <input type="date" id="date-select" class="form-control">
                        </div>
                    </div>
                    <div class="seans-films">
                        <table id="seans-table" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Название фильма</th>
                                <th scope="col">Дата сеанса</th>
                                <th scope="col">Время сеанса</th>
                                <th scope="col">Цена</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sessions as $item) {
                                $seansId = $item['id'];
                                ?>
                                <tr>
                                    <td><?php echo $item['movie_title']; ?></td>
                                    <td><?php echo date('d.m.y', strtotime($item['date_movie'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($item['time_movie'])); ?></td>
                                    <td><?php echo $item['price']; ?> ₽</td>
                                    <td>
                                        <button type="button" id="edit-seans" data-toggle="modal"
                                                data-target="#editSeansModal" data-seansId="<?= $item['id']; ?>"
                                                class="btn btn-success">Редактировать
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" id="delete-seans" data-seansId="<?= $item['id']; ?>"
                                                class="btn btn-danger">Удалить
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editSeansModal" tabindex="-1" role="dialog"
                                     aria-labelledby="editMovieModalLabel" aria-hidden="true">
                                    aria-labelledby="editMovieModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editMovieModalLabel">Редактировать
                                                    сеанс</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form enctype="multipart/form-data" method="post">
                                                    <div class="form-group">
                                                        <label for="date_movie">Выберите дату:</label>
                                                        <input type="date" class="form-control" name="date_movie"
                                                               id="date_movie">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="time_movie">Выберите время:</label>
                                                        <input type="time" class="form-control" id="time_movie"
                                                               name="time_movie">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="price">Цена:</label>
                                                        <input type="number" class="form-control" id="price"
                                                               name="price">
                                                    </div>
                                                    <input type="hidden" id="movie_id" name="movieId"
                                                           value="<?php echo $seansId; ?>">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Закрыть
                                                </button>
                                                <button type="button" id="save_changes-seans"
                                                        data-seansid="<?= $seansId ?>" class="btn btn-primary">
                                                    Сохранить изменения
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--Скрипт на фильтр сеансов-->
                <script src="admin/js/filterSeans.js"></script>
                <!--Скрипт на фильтр сеансов-->

                <!-- Остальной код и модальное окно добавления сеанса -->

                <div class="modal fade" id="seansAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Добавление сеанса</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="addMovieForm">
                                    <div class="form-group">
                                        <label for="movieSelect">Выберите фильм:</label>
                                        <select class="form-control" id="movieSelect" name="movie">
                                            <?php foreach ($films as $filmselect) { ?>
                                                <option value="<?php echo $filmselect['id']; ?>"><?php echo $filmselect['movie_title']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="timeInput">Выберите время:</label>
                                        <input type="time" class="form-control" id="timeInput" name="time">
                                    </div>
                                    <div class="form-group">
                                        <label for="dateInput">Выберите дату:</label>
                                        <input type="date" class="form-control" id="dateInput" name="date">
                                    </div>
                                    <div class="form-group">
                                        <label for="priceInput">Цена:</label>
                                        <input type="number" class="form-control" id="priceInput" name="price">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-primary" id="addSeansButton">Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Сеансы -->


                <!--Настройки сайта-->

                <div id="news" class="panel" style="display:none;">
                    <h2>Настройка сайта</h2>
                    <div class="news-container">
                        <h3>Новости</h3>
                        <button data-toggle="modal" data-target="#addNews" style="margin-bottom: 20px"
                                type="button" class="btn btn-success">Добавить
                            новость
                        </button>
                        <div class="modal fade" id="addNews" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Добавление новости</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" id="addMovieForm">
                                            <div class="form-group">
                                                <label for="news_image">Изображение</label>
                                                <input type="file" class="form-control-file" name="NewsImage"
                                                       id="news_image">
                                            </div>
                                            <div class="form-group">
                                                <label for="news_title">Заголовок новости</label>
                                                <input type="text" class="form-control" id="news_title"
                                                       name="news_title">
                                            </div>
                                            <div class="form-group">
                                                <label for="news_description">Описание новости</label>
                                                <input type="text" class="form-control" id="news_description"
                                                       name="news_description">
                                            </div>


                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Закрыть
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="addSeansButton">Добавить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-deck">
                            <?php foreach ($news

                                           as $new) { ?>

                                <div class="card">

                                    <img class="card-img-top"
                                         src="../../resource/uploads/news/<?= $new['news_image'] ?>"
                                         alt="Card image cap">
                                    <div class="card-body">

                                        <h5 class="card-title"><?= $new['news_title'] ?></h5>
                                        <p class="card-text"><?= $new['news_description'] ?></p>
                                        <p class="card-text"><small class="text-muted"><?= $new['news_date'] ?></small>
                                        </p>

                                    </div>
                                    <div class="btn-containers-news">
                                        <button type="button" class="btn btn-danger">Удалить</button>
                                        <button type="button" class="btn btn-success">Редактировать</button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="slider-container">
                            <h3>Слайдер</h3>
                            <button data-toggle="modal" data-target="#addSlider" style="margin-bottom: 20px"
                                    type="button" class="btn btn-success">Добавить
                                картинку
                            </button>
                            <div class="modal fade" id="addSlider" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Добавление слайдера</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" id="addMovieForm">
                                                <div class="form-group">
                                                    <label for="slider_image">Изображение</label>
                                                    <input type="file" class="form-control-file" name="SliderImage"
                                                           id="slider_image">
                                                </div>
                                                <div class="form-group">
                                                    <label for="title_movie_slider">Заголовок</label>
                                                    <input type="text" class="form-control" id="title_movie_slider"
                                                           name="title_movie_slider">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Закрыть
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="addSeansButton">Добавить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название картинки</th>
                                    <th scope="col">Заголовок</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($settings

                                as $setting) { ?>
                                <tr>

                                    <th scope="row"><?= $setting['id'] ?></th>
                                    <td><?= $setting['slider_image'] ?></td>
                                    <td><?= $setting['title_movie_slider'] ?></td>
                                    <td>
                                        <button type="button" id="delete-slider" data-seansId="<?= $setting['id']; ?>"
                                                class="btn btn-danger">Удалить
                                        </button>
                                    </td>
                                </tr>
                                </tbody>

                                <?php } ?>
                            </table>

                            <div></div>

                        </div>
                    </div>
                    <!--Настройки сайта-->
                </div>

                <!--Заказы-->

                <div id="orders" class="panel" style="display:none;">
                    <h2>Заказы</h2>

                    <label for="selected-date">Выберите дату, чтобы увидеть заказы:</label>
                    <input type="date" id="selected-date" name="selected-date">

                    <button id="filter-btn" type="button" class="btn btn-primary">Смотреть</button>

                    <div class="container-orders-admin" style="display:none;">
                        <?
                        foreach ($orders

                                 as $order) {
                            ?>
                            <div class="card-order-admin" style="display:none;">
                                <div class="small-info">
                                    <span>Номер билета: <b><?= $order['ticket_number'] ?></b></span> <br>
                                    <span>Дата показа: <b><?= date('d.m.y', strtotime($order['date_movie'])) ?></b></span>
                                    <br>
                                    <span>Время показа: <b><?= date('H:i', strtotime($order['time_movie'])) ?></b></span>
                                    <br>
                                    <span>Имя покупателя: <b><?= $order['full_name'] ?></b></span>

                                </div>
                                <div class="right-info-order">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#order-modal-<?= $order['ticket_number'] ?>">
                                        Посмотреть полную информацию
                                    </button>

                                    <div class="modal fade" id="order-modal-<?= $order['ticket_number'] ?>"
                                         tabindex="-1"
                                         role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Информация о
                                                        заказе <?= $order['ticket_number'] ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span>Номер билета: <?= $order['ticket_number'] ?></span> <br>
                                                    <span>Имя покупателя: <?= $order['full_name'] ?></span> <br>
                                                    <span>Телефон: <?= $order['phone'] ?></span> <br>
                                                    <span>Почта: <?= $order['email'] ?></span> <br>
                                                    <span>Ряд: <?= $order['row'] ?></span> <br>
                                                    <span>Место: <?= $order['place'] ?></span> <br>
                                                    <span class="date-movie">Дата показа: <?= date('d.m.Y', strtotime($order['date_movie'])) ?></span>
                                                    <br>
                                                    <span>Время показа: <?= date('H:i', strtotime($order['time_movie'])) ?></span>
                                                    <br>
                                                    <span>Фильм: <?= $order['movie_title'] ?></span> <br>
                                                    <img class="fix-image"
                                                         src="../../resource/qrcodes/bilet_<?= $order['qr'] ?>.png"
                                                         alt="Картинка">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" data-order="<?= $order['id'] ?>"
                                                            class="btn btn-danger delete-order">Удалить заказ
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Закрыть
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                        ?>

                        <!--Скрипт на фильтр заказов-->
                        <script src="admin/js/filterOrders.js"></script>
                        <!--Скрипт на фильтр заказов-->

                        <div id="pagination" class="pagination"></div>

                    </div>
                </div>
                <div id="report" style="display: none" class="panel">
                    <h2>Отчет</h2>
                    <?
                    $now = date('Y-m-d');
                    ?>
                    <form id="report-form" method="post" action="ajaxReport.php">
                        <input type="hidden" name="report-date" value="<?= $now ?>">
                        <button class="btn btn-info" type="submit">Скачать отчет за сегодня</button>
                    </form>

                    <div id="report-content"></div>
                </div>

            </div>
        </div>

        <?php
    }

}
