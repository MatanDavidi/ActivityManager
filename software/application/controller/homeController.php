<?php


class HomeController extends Controller
{

    public function index()
    {

        require "application/views/home/index.php";
        require "application/views/shared/footer.php";

    }

    public function login()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/home/login.php";
            require "application/views/shared/footer.php";

        } else {

            //TODO: Add login logic

            $this->redirect("lavori");
            exit;

        }

    }

}
