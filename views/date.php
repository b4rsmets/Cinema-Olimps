<?php
$date = date('d.m.Y H:i');
$href = (isset($_GET['id'])) ? "?id=" . $_GET['id'] . "&date=" : "?date=";
$monthes = array(
    1 => 'Янв', 2 => 'Фев', 3 => 'Мар', 4 => 'Апр',
    5 => 'Мая', 6 => 'Июня', 7 => 'Июль', 8 => 'Авг',
    9 => 'Сен', 10 => 'Окт', 11 => 'Ноя', 12 => 'Дек'
);
$days = array(
    'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
    'Четверг', 'Пятница', 'Суббота'
);
?>
<div class="date-container"> 
    <div class="choose-date"> 
        <a id="today" href="<?= $href . date('Y-m-d') ?>" class="<?php if (date('Y-m-d') == date('Y-m-d', strtotime($date))) { echo 'active'; } ?>">Сегодня</a> 
        <a id="tomorrow" href="<?= $href . date('Y-m-d', strtotime('+1 day')) ?>" class="<?php if (date('Y-m-d', strtotime('+1 day')) == date('Y-m-d', strtotime($date))) { echo 'active'; } ?>">Завтра</a> 
        <a id="day2" href="<?= $href . date('Y-m-d', strtotime('+2 day')) ?>" class="<?php if (date('Y-m-d', strtotime('+2 day')) == date('Y-m-d', strtotime($date))) { echo 'active'; } ?>"><?php echo $days[(date('w', strtotime('+2 day')))]; ?></a> 
        <a id="day3" href="<?= $href . date('Y-m-d', strtotime('+3 day')) ?>" class="<?php if (date('Y-m-d', strtotime('+3 day')) == date('Y-m-d', strtotime($date))) { echo 'active'; } ?>"><?php echo $days[(date('w', strtotime('+3 day')))]; ?></a> 
        <a id="day4" href="<?= $href . date('Y-m-d', strtotime('+4 day')) ?>" class="<?php if (date('Y-m-d', strtotime('+4 day')) == date('Y-m-d', strtotime($date))) { echo 'active'; } ?>"> <?php echo $days[(date('w', strtotime('+4 day')))]; ?></a> 
        <a id="day5" href="<?= $href . date('Y-m-d', strtotime('+5 day')) ?>" class="<?php if (date('Y-m-d', strtotime('+5 day')) == date('Y-m-d', strtotime($date))) { echo 'active'; } ?>"> <?php echo $days[(date('w', strtotime('+5 day')))]; ?></a> 
    </div> 
</div>