<?php

require_once "application/controller/controller.php";

class RisorseController extends Controller
{

    public function index()
    {

        require "application/views/shared/header.php";
        require "application/views/risorse/index.php";
        require "application/views/shared/footer.php";

    }

    public function dettagli(string $name)
    {

        //TODO: Add database logic
        require "application/views/shared/header.php";
        require "application/views/risorse/dettagli.php";
        require "application/views/shared/footer.php";

    }

    public function aggiungi()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/risorse/aggiungi.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //TODO: Add database logic
            $this->redirect("risorse");

        }

    }

}