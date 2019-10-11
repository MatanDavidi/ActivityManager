<?php

require_once "application/controller/controller.php";

class ActivitiesController extends Controller
{

    public function index()
    {
        require "application/views/shared/header.php";
        require "application/views/activities/index.php";
        require "application/views/shared/footer.php";
    }

    public function details(string $nome)
    {

        require "application/views/shared/header.php";
        require "application/views/activities/details.php";
        require "application/views/shared/footer.php";

    }

    public function new()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/activities/new.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //TODO: Add database logic

        }

    }

}