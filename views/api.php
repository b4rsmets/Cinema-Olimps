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

        print_r($test);
    ?>
        <img src="/img/<?=$test['id']?>.jpg" alt="">
    <?
    }
}
