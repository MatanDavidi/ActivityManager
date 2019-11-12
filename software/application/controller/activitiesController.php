<?php

require_once "application/controller/controller.php";
require_once "application/models/workHours.php";

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

        if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE) {
            $baseActivity = new Activity();
            $activities = $baseActivity->getAllActivities();
        } else {
            $baseAssignment = new Assignment();
            $resource = new Resource();
            $resource = $resource->getResourceByName($_SESSION["userName"]);
            $activities = $baseAssignment->getActivitiesAssignedToResource($resource);
        }

        $assignedResourcesCounts = [];
        foreach ($activities as $activity) {

            $baseAssignment = new Assignment();
            $assignedResources = $baseAssignment->getResourcesAssignedToActivity($activity);
            $resourcesNumber = count($assignedResources);
            array_push($assignedResourcesCounts, $resourcesNumber);

        }

        require "application/views/shared/header.php";
        require "application/views/activities/index.php";
        require "application/views/shared/footer.php";
    }

    /**
     * Shows the activity's details page containing a single activity's details.
     * @param string $name The name of the activity of which to show the details.
     */
    public function details(string $name)
    {
        //If the user isn't logged in, redirect them to the homepage
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        //Decode the name passed as parameter (in case, for example, of values containing spaces)
        $name = urldecode($name);

        //Get the data of the activity to display
        $activity = new Activity();
        $activity = $activity->getActivityByName($name);
        //If it is null redirect the user to the list of activities
        if (is_null($activity)) {
            $this->redirect("activities");
        }

        //Get the resource that corresponds to the one the user logged in with
        $loginResource = new Resource();
        $loginResource = $loginResource->getResourceByName($_SESSION["userName"]);

        //Get the assigned resources
        $baseAssignment = new Assignment();
        $assignedResources = $baseAssignment->getResourcesAssignedToActivity($activity);
        $resourcesNumber = count($assignedResources);

        //Variable that defines if the user that is currently logged in can view the details page or not.
        //If the user is an administrator or they're assigned to the activity, they can view the page.
        $canResourceView = ($loginResource->getRole() == Resource::ADMINISTRATOR_ROLE ? true : false);

        //To check that, loop all assigned resources and see if one of them is the same as the one that logged in
        for ($i = 0; !$canResourceView && $i < count($assignedResources); ++$i) {
            $assignedResource = $assignedResources[$i];
            if ($assignedResource->equals($loginResource)) {
                $canResourceView = true;
            }
        }

        //If the user cannot view the page, redirect them to the activities list
        if (!$canResourceView) {
            $this->redirect("activities");
        }

        //Get the work hours assigned to this activity
        $baseWorkHours = new WorkHours();
        $assignedWorkHours = $baseWorkHours->getWorkHoursByActivity($activity);
        $workHoursCosts = [];
        $totalCost = 0.0;
        //Loop through each of them to calculate the costs
        foreach ($assignedWorkHours as $workHour) {

            $resource = $workHour->getResource();
            $cost = ($resource->getHourCost() * $workHour->getHoursNumber());
            array_push($workHoursCosts, $cost);
            $totalCost += $cost;

        }

        require "application/views/shared/header.php";
        require "application/views/activities/details.php";
        require "application/views/shared/footer.php";

    }

    public function new()
    {

        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        if ($_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE) {
            $this->redirect("activities");
        }

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/activities/new.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //Check if the POST values are present
            if (isset($_POST["nome"]) &&
                isset($_POST["note"]) &&
                isset($_POST["data_inizio"]) &&
                isset($_POST["data_consegna"]) &&
                isset($_POST["ore"])) {

                //Save all POST values to their respective variable
                $name = $this->sanitizeInput($_POST["nome"]);
                $startDate = $this->sanitizeInput($_POST["data_inizio"]);
                $startDate = DateTime::createFromFormat("Y-m-d", $startDate);
                $deliveryDate = $this->sanitizeInput($_POST["data_consegna"]);
                $deliveryDate = DateTime::createFromFormat("Y-m-d", $deliveryDate);
                $hoursNumber = intval($_POST["ore"]);
                $notes = $this->sanitizeInput($_POST["note"]);

                //Create a new object of type Activity with the POST values
                $activity = new Activity($name, $notes, $startDate, $deliveryDate, $hoursNumber);

                //Add the activity to the database
                $activity->addActivity($activity);
                //Redirect to the list of activities
                $this->redirect("activities");

            }

        }

    }

}