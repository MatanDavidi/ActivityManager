<?php

require_once "application/controller/controller.php";

class LavoriController extends Controller
{

    public function index()
    {
        require "application/views/shared/header.php";
        require "application/views/lavori/index.php";
        require "application/views/shared/footer.php";
    }

    public function dettagli(string $nome)
    {

        require "application/views/shared/header.php";
        require "application/views/lavori/dettagli.php";
        require "application/views/shared/footer.php";

    }

    public function nuovo()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/lavori/nuovo.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //TODO: Add database logic

        }

    }

}