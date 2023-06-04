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
        $users = $this->database->select('users', ['id', 'login', 'role']);
        $orders = $this->database->select('orders', [
            '[>]users' => ['id_user' => 'id'],
            '[>]seans' => ['id_seans' => 'id'],
            '[>]seats' => ['id_seat' => 'id'],
            '[>]movies' => ['seans.movie_id' => 'id']
        ], [
            'orders.id',
            'orders.ticket_number',
            'orders.qr',
            'seats.row',
            'seats.place',
            'users.full_name(full_name)',
            'users.phone(phone)',
            'users.email(email)',
            'seans.hall_id(hall_id)',
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
                                                <input type="hidden" id="movie_id" name="movieId" value="<?php echo $movieId; ?>">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Закрыть
                                                </button>
                                                <button type="button" id="save_changes"
                                                        data-movie-id="<?= $film['id'] ?>" class="btn btn-primary">
                                                    Сохранить изменения
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                <div id="news" class="panel" style="display:none;">
                    <h2>Новости</h2>
                    <?php foreach ($news as $new) { ?>
                        <div><?php print_r($new); ?></div>
                    <?php } ?>
                </div>
                <div id="orders" class="panel" style="display:none;">
                    <h2>Заказы</h2>

                    <label for="selected-date">Выберите дату, чтобы увидеть заказы:</label>
                    <input type="date" id="selected-date" name="selected-date">

                    <button id="filter-btn" type="button" class="btn btn-primary">Смотреть</button>

                    <div class="container-orders-admin" style="display:none;">
                        <?
                        foreach ($orders as $order) {
                            ?>
                            <div class="card-order-admin" style="display:none;">
                                <div class="small-info">
                                    <span>Номер билета: <b><?= $order['ticket_number'] ?></b></span> <br>
                                    <span>Дата показа: <b><?= date('d.m.y', strtotime($order['date_movie'])) ?></b></span> <br>
                                    <span>Время показа: <b><?= date('H:i', strtotime($order['time_movie'])) ?></b></span> <br>
                                    <span>Имя покупателя: <b><?= $order['full_name'] ?></b></span>

                                </div>
                                <div class="right-info-order">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#order-modal-<?= $order['ticket_number'] ?>">
                                        Посмотреть полную информацию
                                    </button>

                                    <div class="modal fade" id="order-modal-<?= $order['ticket_number'] ?>" tabindex="-1"
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
                                                    <span class="date-movie">Дата показа: <?= date('d.m.Y', strtotime($order['date_movie'])) ?></span> <br>
                                                    <span>Время показа: <?= date('H:i', strtotime($order['time_movie']))?></span> <br>
                                                    <span>Фильм: <?= $order['movie_title'] ?></span> <br>
                                                    <img class="fix-image"
                                                         src="../../resource/qrcodes/bilet_<?= $order['qr'] ?>.png"
                                                         alt="Картинка">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" data-order="<?= $order['id'] ?>"
                                                            class="btn btn-danger delete-order">Удалить заказ</button>                                                    <button type="button" class="btn btn-secondary"
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
                        <div id="pagination" class="pagination"></div>
                        <script>
                            var itemsPerPage = 4;
                            document.getElementById("filter-btn").addEventListener("click", function () {
                                var selectedDateStr = document.getElementById("selected-date").value;
                                var selectedDateParts = selectedDateStr.split("-");
                                var selectedDate = selectedDateParts[2] + "." + selectedDateParts[1] + "." + selectedDateParts[0];

                                var orders = document.getElementsByClassName("card-order-admin");

                                // Скрываем все элементы
                                for (var i = 0; i < orders.length; i++) {
                                    orders[i].style.display = "none";
                                }

                                // Фильтруем и отображаем только соответствующие заказы
                                var filteredOrders = [];
                                for (var i = 0; i < orders.length; i++) {
                                    var order = orders[i];
                                    var orderDateStr = order.getElementsByClassName("date-movie")[0].textContent;

                                    if (orderDateStr.includes(selectedDate)) {
                                        filteredOrders.push(order);
                                    }
                                }

                                // Показываем только первые три элемента
                                for (var i = 0; i < filteredOrders.length; i++) {
                                    if (i < itemsPerPage) {
                                        filteredOrders[i].style.display = "flex";
                                    }
                                }

                                // Показываем контейнер с заказами после фильтрации
                                var containerOrders = document.querySelector(".container-orders-admin");
                                containerOrders.style.display = "block";

                                // При каждом фильтре обновляем пагинацию
                                updatePagination(filteredOrders);
                            });

                            // Функция для обновления пагинации
                            function updatePagination(filteredOrders) {
                                var numPages = Math.ceil(filteredOrders.length / itemsPerPage);

                                // Очищаем пагинацию
                                var paginationContainer = document.getElementById("pagination");
                                paginationContainer.innerHTML = "";

                                // Создаем ссылки для пагинации
                                for (var i = 1; i <= numPages; i++) {
                                    var link = document.createElement("a");
                                    link.href = "#";
                                    link.textContent = i;

                                    // Добавляем класс "active" к текущей странице
                                    if (i === 1) {
                                        link.classList.add("active");
                                    }

                                    // Обработчик события при клике на ссылку пагинации
                                    link.addEventListener("click", function (event) {
                                        event.preventDefault();

                                        // Удаляем класс "active" у всех ссылок
                                        var paginationLinks = paginationContainer.getElementsByTagName("a");
                                        for (var j = 0; j < paginationLinks.length; j++) {
                                            paginationLinks[j].classList.remove("active");
                                        }

                                        // Показываем только элементы текущей страницы
                                        var pageNumber = parseInt(this.textContent);
                                        var startIndex = (pageNumber - 1) * itemsPerPage;
                                        var endIndex = startIndex + itemsPerPage;

                                        for (var k = 0; k < filteredOrders.length; k++) {
                                            if (k >= startIndex && k < endIndex) {
                                                filteredOrders[k].style.display = "flex";
                                            } else {
                                                filteredOrders[k].style.display = "none";
                                            }
                                        }

                                        // Добавляем класс "active" к текущей ссылке
                                        this.classList.add("active");
                                    });

                                    paginationContainer.appendChild(link);
                                }
                            }

                        </script>
                    </div>
                </div>



            </div>
        </div>
        <?php
    }

}
