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
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        if ($_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE) {
            $this->redirect("activities", "details", [$activityName]);
        }

        $activityName = urldecode($activityName);

        $baseActivity = new Activity();
        $baseResource = new Resource();

        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            $activity = $baseActivity->getActivityByName($activityName);

            if (is_null($activity)) {
                $this->redirect("activities");
            }

            $resources = $baseResource->getAllResources();

            require "application/views/shared/header.php";
            require "application/views/assignments/index.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if (isset($_POST["lavoro"]) && isset($_POST["risorsa"])) {

                if ($_POST["lavoro"] === $activityName) {

                    $resourceName = $this->sanitizeInput($_POST["risorsa"]);

                    $activity = $baseActivity->getActivityByName($activityName);
                    $resource = $baseResource->getResourceByName($resourceName);

                    if (!is_null($activity) && !is_null($resource)) {

                        $assignment = new Assignment($activity, $resource);
                        if ($assignment->addAssignment($assignment)) {

                            $this->redirect("activities", "details", [urlencode($activityName)]);

                        }

                    }

                }

            }

            $err_msg = "Impossibile assegnare la risorsa al lavoro";
            require "application/views/shared/header.php";
            require "application/views/assignments/index.php";
            require "application/views/shared/footer.php";

        }

    }

}