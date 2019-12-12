<?php

require_once "application/controller/controller.php";
require_once "application/models/workHours.php";

class WorkHoursController extends Controller
{

    /**
     * Depending on the request method, either shows the page containing the form to register hours during which a
     * resource has worked on an activity (GET) or adds a row to table 'ore_lavoro' of the database (POST).
     * @param string $activityName The name of the activity to show on the page or on which the resource has worked.
     */
    public function register(string $activityName)
    {
        //Check if the user has logged in, otherwise send him back to homepage
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        //Decode the activity's name from the URL
        $activityName = urldecode($activityName);

        //If the user has only requested the page, show them the page. If they have submitted the form that is contained
        //in the page, add the work hours to the database
        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            $this->showIndexView($activityName);

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //Instantiate three empty objects of type Activity, Resource and Assignment respectively,
            // to use their functions
            $baseActivity = new Activity();
            $baseResource = new Resource();
            $baseAssignment = new Assignment();

            //Check if a value for both the activity and the resource's names has been passed, as well as the date and
            // number of hours of the work
            if (isset($_POST["lavoro"]) &&
                isset($_POST["risorsa"]) &&
                isset($_POST["data"]) &&
                isset($_POST["numeroOre"])) {
                //Check if the value that was passed for the activity's name is the same as the one passed as parameter
                if ($_POST["lavoro"] === $activityName) {

                    //Save the resource's name to a variable
                    $resourceName = $this->sanitizeInput($_POST["risorsa"]);
                    //Save the date on which the work took place to a variable
                    $date = DateTime::createFromFormat("Y-m-d", $_POST["data"]);
                    //Save the number of hours that the resource has worked to a variable
                    $hoursNumber = intval($_POST["numeroOre"]);

                    //Get the activity and resource with the same name as the values passed from the form
                    $activity = $baseActivity->getActivityByName($activityName);
                    $resource = $baseResource->getResourceByName($resourceName);

                    //If the work date is invalid, show an error message, otherwise carry on with your business
                    if ($date > $activity->getDeliveryDate()) {
                        $err_msg =
                            "Impossibile registrare le ore di lavoro: " .
                            "la data di lavoro non può essere oltre quella di consegna del progetto.";
                    } elseif ($date < $activity->getStartDate()) {
                        $err_msg =
                            "Impossibile registrare le ore di lavoro: " .
                            "la data di lavoro non può precedere quella di inizio del progetto.";
                    } else {

                        //If such an activity and resource exist, add a new assignment to the database
                        if (!is_null($activity) && !is_null($resource)) {

                            //If the resource is actually assigned to the activity, add it to the database, otherwise
                            // show an error message.
                            if ($baseAssignment->isAssigned($activity, $resource)) {

                                //Create a new object of type WorkHours and add it to the database
                                $workHours = new WorkHours($activity, $resource, $date, $hoursNumber);
                                //If the addition is successful send the user to the activity's details page.
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

            }

            //If no error message has been defined already, but there still was an error, show a generic error message
            if (!isset($err_msg)) {
                $err_msg = "Impossibile registrare le ore di lavoro.";
            }

            //If something went wrong, show the 'workHours/index' view with an error message
            $this->showIndexView($activityName, $err_msg);

        }
    }

    /**
     * Gets the data to fill the view containing the form to register work hours.
     * @param string $activityName The name of the activity to show on the page.
     * @param string $err_msg The error message that may be shown on the page.
     */
    private function showIndexView(string $activityName, string $err_msg = "")
    {
        //Instantiate three empty objects of type Activity, Resource and Assignment respectively,
        // to use their functions
        $baseActivity = new Activity();
        $baseResource = new Resource();
        $baseAssignment = new Assignment();

        //Get the activity whose name will be shown on the page
        $activity = $baseActivity->getActivityByName($activityName);

        //Get the resource with which the user logged in
        $loginResource = new Resource();
        $loginResource = $loginResource->getResourceByName($_SESSION["userName"]);

        //If the activity could not be found or the user has no permission to view the page, redirect them to the page
        // containing the list of activities
        if (is_null($activity) ||
            (
                $_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE &&
                !$baseAssignment->isAssigned($activity, $loginResource)
            )) {
            $this->redirect("activities");
        }

        //If the user is an administrator, allow them to register the work hours of any resource, otherwise they can
        // only register their own
        if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE) {
            $resources = $baseAssignment->getResourcesAssignedToActivity($activity);
        } elseif ($_SESSION["userRole"] == Resource::USER_ROLE) {
            $resources = [$baseResource->getResourceByName($_SESSION["userName"])];
        }

        require "application/views/shared/header.php";
        require "application/views/workHours/index.php";
        require "application/views/shared/footer.php";

    }

    /**
     * Depending on request method either shows the page with the monthly report
     * form (GET) or gets the work hours of the specified month (POST).
     */
    public function monthlyReport()
    {

        //Check if the user has logged in, otherwise send him back to homepage
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        //If the user does not have the role of administrator, they do not have
        //permission to view the page, redirect them to the activities list
        if ($_SESSION["userRole"] != Resource::ADMINISTRATOR_ROLE) {
            $this->redirect("activites");
        }

        //If the user has not submitted the form yet, show them the page
        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/workHours/monthlyReport.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //If the user has submitted the form, fetch the monthly report's data
            $month = $this->sanitizeInput($_POST["mese"]);
            $workHours = new WorkHours();
            echo $workHours->getWorkHoursByMonth($month);

        }

    }

    /**
     * Depending on request method either shows the page with the daily report form (GET)
     * or gets the work hours of the specified resource for the specified date (POST).
     */
    public function dailyReport()
    {

        //Check if the user has logged in, otherwise send him back to homepage
        if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
            $this->redirect("home");
        }

        //Create an empty object of type resource to use its functions
        $baseResource = new Resource();

        //If the request method is GET show the form
        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            //Get the resource to show in the form's select input
            $resources = [];
            //If the user is an administrator, allow them to choose to see the report for every resource
            if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE) {
                $resources = $baseResource->getAllResources();
            } else if ($_SESSION["userRole"] == Resource::USER_ROLE) {
                //Otherwise if the user is a regular user, allow them to only see their own report
                $resources = [$baseResource->getResourceByName($_SESSION["userName"])];
            }
            //Show the page
            require "application/views/shared/header.php";
            require "application/views/workHours/dailyReport.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //Otherwise if the request method is POST get and print the resource's work hours for the given date
            //Check if the correct data was passed
            if (isset($_POST["risorsa"]) && isset($_POST["data"])) {

                //Sanitize the resource's name and save it to a variable
                $resourceName = $this->sanitizeInput($_POST["risorsa"]);
                //Check if the resource's name isn't made up of only white space
                if (strlen(trim($resourceName)) > 0) {
                    //Get the resource of which to get the report
                    $resource = $baseResource->getResourceByName($resourceName);
                    //Get the resource that logged in
                    $loginResource = $baseResource->getResourceByName($_SESSION["userName"]);
                    //If a resource with the given name exists, go on
                    if (!is_null($resource)) {
                        //If the user has permission to view the report (either they are the resource
                        //of which they requested the report or they have the role of administrator), go on
                        if ($resource->equals($loginResource) ||
                            $loginResource->getRole() == Resource::ADMINISTRATOR_ROLE) {
                            //If the date is in the correct format
                            $date = DateTime::createFromFormat("Y-m-d", $_POST["data"]);
                            if ($date) {
                                //Create an empty object of type WorkHours
                                $baseWorkHours = new WorkHours();
                                //Get work hours of specified resource on given date
                                $workHoursReport = $baseWorkHours->getWorkHoursByDate($resource, $date);
                                echo $workHoursReport;
                            } else {
                                echo "La data deve seguire il seguente formato: YYYY-mm-dd";
                            }
                        } else {
                            echo "Non hai il permesso di visualizzare il resoconto giornaliero di questo collaboratore";
                        }
                    } else {
                        echo "Impossibile trovare la risorsa specificata";
                    }
                } else {
                    echo "Specificare una risorsa";
                }

            } else {
                echo "Specificare una risorsa e una data per visualizzarne il resoconto";
            }

        }

    }

}