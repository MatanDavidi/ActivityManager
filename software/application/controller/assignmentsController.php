<?php

require_once "application/controller/controller.php";
require_once "application/models/assignment.php";

class AssignmentsController extends Controller
{

    /**
     * Depending on the request method, either shows the page containing the form to assign a
     * resource to an activity (GET) or adds a assignment to table 'assegna' of the database (POST).
     * @param string $activityName The name of the activity to show on the page or to which the resource has to be assigned.
     */
    public function assign(string $activityName)
    {
        //Check if the user has logged in, otherwise send them back to homepage
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        //Check if the user has permission to view this page, otherwise send them back to the activity's details page
        if ($_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE) {
            $this->redirect("activities", "details", [$activityName]);
        }

        //Decode the activity's name from the URL
        $activityName = urldecode($activityName);

        //Create two empty objects of type Activity e Resource respectively
        $baseActivity = new Activity();
        $baseResource = new Resource();

        //If the request method is get, show them the page, otherwise add an assignment to the database
        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            $this->showIndexView($activityName);

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //Check if a value for both the activity and the resource's names has been passed
            if (isset($_POST["lavoro"]) && isset($_POST["risorsa"])) {
                //Check if the value that was passed for the activity's name is the same as the one passed as parameter
                if ($_POST["lavoro"] === $activityName) {

                    //Save the resource's name to a variable
                    $resourceName = $this->sanitizeInput($_POST["risorsa"]);

                    //Get the activity and resource with the same name as the values passed from the form
                    $activity = $baseActivity->getActivityByName($activityName);
                    $resource = $baseResource->getResourceByName($resourceName);

                    //If such an activity and resource exist, add a new assignment to the database
                    if (!is_null($activity) && !is_null($resource)) {

                        $assignment = new Assignment($activity, $resource);
                        if ($assignment->addAssignment($assignment)) {

                            //If the insertion was successful, redirect the user to the page containing the activity's
                            //details
                            $this->redirect("activities", "details", [urlencode($activityName)]);

                        }

                    }

                }

            }

            //If something went wrong, show the 'assignments/index' view with an error message
            $this->showIndexView($activityName, "Impossibile assegnare la risorsa al lavoro");

        }

    }

    private function showIndexView(string $activityName, $err_msg = "")
    {
        //Create two empty objects of type Activity e Resource respectively
        $baseActivity = new Activity();
        $baseResource = new Resource();

        //Get the activity on which the resource has worked
        $activity = $baseActivity->getActivityByName($activityName);

        //If there's no activity with that name, redirect the user to the list of activities
        if (is_null($activity)) {
            $this->redirect("activities");
        }

        //Get all resources to show them on the page
        $resources = $baseResource->getAllResources();

        //Show the page
        require "application/views/shared/header.php";
        require "application/views/assignments/index.php";
        require "application/views/shared/footer.php";
    }

}