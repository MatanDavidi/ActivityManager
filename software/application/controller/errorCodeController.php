<?php


class ErrorCodeController
{

    public static function error404()
    {

        require "application/views/shared/header.php";
        require "application/views/errors/404.php";
        require "application/views/shared/footer.php";

    }

}