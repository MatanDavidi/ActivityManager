<?php


class LavoriController
{

    public function index()
    {
        require "application/views/shared/header.php";
        require "application/views/lavori/index.php";
        require "application/views/shared/footer.php";
    }

}