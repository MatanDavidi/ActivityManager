<?php

require_once "application/controller/controller.php";
require_once "application/models/assignment.php";

class ResourcesController extends Controller
{

    public function index()
    {
        if (!(isset($_SESSION["userRole"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        $baseResource = new Resource();

        if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE) {
            $resources = $baseResource->getAllResources();
        } else {
            $resources = [$baseResource->getResourceByName($_SESSION["userName"])];
        }

        $resourcesCount = count($resources);
        require "application/views/shared/header.php";
        require "application/views/resources/index.php";
        require "application/views/shared/footer.php";

    }

    public function details(string $name)
    {

        //TODO: Add database logic
        require "application/views/shared/header.php";
        require "application/views/resources/details.php";
        require "application/views/shared/footer.php";

    }

    public function add()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/resources/add.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //TODO: Add database logic
            $this->redirect("resources");

        }

    }

}