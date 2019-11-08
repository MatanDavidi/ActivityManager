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

        if ($_SESSION["userRole"] == "amministratore") {
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
        $name = urldecode($name);
        $activity = new Activity();
        $activity = $activity->getActivityByName($name);
        if (is_null($activity)) {
            $this->redirect("activities");
        }

        $baseAssignment = new Assignment();
        $assignedResources = $baseAssignment->getResourcesAssignedToActivity($activity);
        $resourcesNumber = count($assignedResources);

        $baseWorkHours = new WorkHours();
        $assignedWorkHours = $baseWorkHours->getWorkHoursByActivity($activity);
        $workHoursCosts = [];
        $totalCost = 0.0;
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

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/activities/new.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //TODO: Add database logic

        }

    }

}