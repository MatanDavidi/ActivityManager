<?php

require_once "application/controller/controller.php";
require_once "application/models/resource.php";

class HomeController extends Controller
{

    /**
     * Shows the homepage.
     */
    public function index()
    {

        require "application/views/home/index.php";
        require "application/views/shared/footer.php";

    }

    /**
     * Checks whether the request method is GET or POST and either shows the login form if the
     * request is of type GET or checks if the username and data are correct if it is of type POST.
     */
    public function login()
    {
        //If the user has already logged in, redirect him without showing login page
        if (isset($_SESSION["userName"]) && isset($_SESSION["userRole"])) {

            $this->redirect("activities");

        }

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/home/login.php";
            require "application/views/shared/footer.php";

        } else {

            if (isset($_POST["nome"]) &&
                isset($_POST["password"])) {

                //Get the input data:
                //Sanitizes and saves to a variable the username
                $username = $this->sanitizeInput($_POST["nome"]);
                //Sanitizes and saves to a variable the password
                $password = $this->sanitizeInput($_POST["password"]);
                //Create and empty resource to use its functions
                $baseResource = new Resource();
                //If the user exists
                if ($baseResource->login($username, $password)) {

                    //Get all user's data
                    $user = $baseResource->getResourceByName($username);
                    //Add username and role to session
                    $_SESSION["userName"] = $username;
                    $_SESSION["userRole"] = $user->getRole();

                    //Redirect them to the activities' page
                    $this->redirect("activities");

                } else {

                    //Bring them back to the login form and show an error message
                    $err_msg = "Il nome utente o la password inseriti non sono validi";
                    require "application/views/shared/header.php";
                    require "application/views/home/login.php";
                    require "application/views/shared/footer.php";

                }

            }

        }

    }

    /**
     * Logs out the user by destroying all data registered in the session. Afterwards, redirects them to the homepage.
     */
    public function logout()
    {

        session_destroy();
        $this->redirect("home");

    }

}
