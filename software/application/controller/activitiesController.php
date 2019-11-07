<?php

require_once "application/controller/controller.php";
require_once "application/models/assignment.php";

class ActivitiesController extends Controller
{

    /**
     * Shows view "Activities/index", with a list of all activities that the user has permission to see.
     */
    public function index()
    {
        if (!(isset($_SESSION["userRole"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        if ($_SESSION["userRole"] == "amministratore") {
            $baseActivity = new Activity();
            $activities = $baseActivity->getAllActivities();
        } else {
            $baseAssignment = new Assignment();
            $resource = new Resource();
            $resource = $resource->getResourceByName($_SESSION["userName"]);
            $activities = $baseAssignment->getActivitiesAssignedToResource($resource);
        }

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