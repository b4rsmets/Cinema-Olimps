<?php

namespace admin\views;

require_once 'admin/vendor/autoload.php';
require_once 'admin/template/jsconnect.php';

use Medoo\Medoo;

class panel
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
        if (!empty($_SESSION['role']['role'] == 'admin')) {
            $this->viewAdm();
        } else {
            header("location: /afisha");
        }
    }

    function viewAdm()
    {
        require_once 'admin/template/header.php';

        $users = $this->database->select('users', '*');

        foreach ($users as $user) {
            ?>
            <div class="user-row" id="user-<?php echo $user['id'] ?>">
                <div>
                    <?php echo $user['login'] ?> (<span
                            class="user-role"><?php if ($user['role'] == 'admin') {
                            echo 'Админ';
                        } else {
                            echo 'Пользователь';
                        } ?></span>)
                    <form class="update-role-form" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                        <div>
                            <?
                            if ($user['role'] == 'admin') {
                                ?>
                                <button class="btn btn-secondary btn-remove-admin btn btn-danger"
                                        data-user-id="<?php echo $user['id'] ?>"
                                        data-user-role="<?php echo $user['role'] ?>">Забрать права
                                </button>
                                <?
                            } else {
                                ?>
                                <button class="btn btn-primary btn-give-admin btn btn-success"
                                        data-user-id="<?php echo $user['id'] ?>"
                                        data-user-role="<?php echo $user['role'] ?>">Дать права Администратора
                                </button>
                                <?
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>


            <?php
        }
    }
}
