<?php

require_once "application/controller/controller.php";
require_once "application/models/workHours.php";

class WorkHoursController extends Controller
{

    public function register(string $activityName)
    {
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        $activityName = urldecode($activityName);

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            $this->showIndexView($activityName);

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $baseActivity = new Activity();
            $baseResource = new Resource();
            $baseAssignment = new Assignment();

            //Check if a value for both the activity and the resource's names has been passed
            if (isset($_POST["lavoro"]) &&
                isset($_POST["risorsa"]) &&
                isset($_POST["data"]) &&
                isset($_POST["numeroOre"])) {
                //Check if the value that was passed for the activity's name is the same as the one passed as parameter
                if ($_POST["lavoro"] === $activityName) {

                    //Save the resource's name to a variable
                    $resourceName = $this->sanitizeInput($_POST["risorsa"]);
                    $date = DateTime::createFromFormat("Y-m-d", $_POST["data"]);
                    $hoursNumber = intval($_POST["numeroOre"]);

                    //Get the activity and resource with the same name as the values passed from the form
                    $activity = $baseActivity->getActivityByName($activityName);
                    $resource = $baseResource->getResourceByName($resourceName);

                    if ($date > $activity->getDeliveryDate()) {
                        $err_msg =
                            "Impossibile registrare le ore di lavoro: " .
                            "la data di lavoro non può essere oltre quella di consegna del progetto.";
                    } elseif ($date < $activity->getStartDate()) {
                        $err_msg =
                            "Impossibile registrare le ore di lavoro: " .
                            "la data di lavoro non può precedere quella di inizio del progetto.";
                    }

                    //If such an activity and resource exist, add a new assignment to the database
                    if (!is_null($activity) && !is_null($resource)) {

                        if ($baseAssignment->isAssigned($activity, $resource)) {

                            $workHours = new WorkHours($activity, $resource, $date, $hoursNumber);

                            if ($workHours->addWorkHours($workHours)) {
                                $this->redirect("activities", "details", [urlencode($activityName)]);
                            }

                        } else {
                            $err_msg =
                                "Impossibile registrare le ore di lavoro: " .
                                "la risorsa '$resourceName' non è assegnata al lavoro '$activityName'";
                        }

                    }

                }

            }

            if (!isset($err_msg)) {
                $err_msg = "Impossibile registrare le ore di lavoro.";
            }

            //If something went wrong, show the 'assignments/index' view with an error message
            $this->showIndexView($activityName, $err_msg);

        }
    }

    private function showIndexView($activityName, $err_msg = "")
    {

        $baseActivity = new Activity();
        $baseResource = new Resource();
        $baseAssignment = new Assignment();

        $activity = $baseActivity->getActivityByName($activityName);

        $loginResource = new Resource();
        $loginResource = $loginResource->getResourceByName($_SESSION["userName"]);

        if (is_null($activity) ||
            (
                $_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE &&
                !$baseAssignment->isAssigned($activity, $loginResource)
            )) {
            $this->redirect("activities");
        }

        if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE) {
            $resources = $baseAssignment->getResourcesAssignedToActivity($activity);
        } elseif ($_SESSION["userRole"] == Resource::USER_ROLE) {
            $resources = [$baseResource->getResourceByName($_SESSION["userName"])];
        }

        require "application/views/shared/header.php";
        require "application/views/workHours/index.php";
        require "application/views/shared/footer.php";

    }

}