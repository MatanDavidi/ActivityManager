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

        //If the user isn't logged in, redirect them to the homepage
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        //Decode the name passed as parameter (in case, for example, of values containing spaces)
        $name = urldecode($name);

        //Get the data of the resource to display
        $resource = new Resource();
        $resource = $resource->getResourceByName($name);
        //If it is null redirect the user to the list of activities
        if (is_null($resource)) {
            $this->redirect("resources");
        }

        //Get the resource that corresponds to the one the user logged in with
        $loginResource = new Resource();
        $loginResource = $loginResource->getResourceByName($_SESSION["userName"]);

        //If the user that logged in is not an administrator and is not the resource
        //of which they requested the details, they have no permission to view the
        //page, so redirect them to the resources list
        if ($_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE && !$resource->equals($loginResource)) {

            $this->redirect("resources");

        }

        $baseAssignment = new Assignment();
        $assignedActivities = $baseAssignment->getActivitiesAssignedToResource($resource);
        $assignedActivitiesCount = count($assignedActivities);

        require "application/views/shared/header.php";
        require "application/views/resources/details.php";
        require "application/views/shared/footer.php";

    }

    public function add()
    {

        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        if ($_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE) {
            $this->redirect("resources");
        }

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/resources/add.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //Check if the POST values are present
            if (isset($_POST["nome"]) && isset($_POST["costo"])) {

                //Save all POST values to their respective variable
                $name = $this->sanitizeInput($_POST["nome"]);
                $cost = floatval($_POST["costo"]);
                $password = $this->sanitizeInput($_POST["password"]);
                $role = $this->sanitizeInput($_POST["ruolo"]);

                //Create a new object of type Resource with the POST values
                $resource = new Resource($name, $cost, $password, $role);

                //Add the resource to the database, if the operation is successful, redirect
                //the user to the resources list, otherwise show them an error message
                if ($resource->addResource($resource)) {
                    //Redirect to the list of activities
                    $this->redirect("resources");
                } else {

                    $err_msg = "Impossibile aggiungere la risorsa specificata";
                    require "application/views/shared/header.php";
                    require "application/views/resources/add.php";
                    require "application/views/shared/footer.php";

                }

            } else {

                $this->redirect("resources", "add");

            }

        }

    }

}