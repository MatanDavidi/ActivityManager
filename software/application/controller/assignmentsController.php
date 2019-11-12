<?php

require_once "application/controller/controller.php";
require_once "application/models/assignment.php";

class AssignmentsController extends Controller
{

    public function assign(string $activityName)
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            require "application/views/shared/header.php";
            require "application/views/assignments/index.php";
            require "application/views/shared/footer.php";

        } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //TODO: Add database logic
            $this->redirect("activities", "dettagli", Array(0));

        }

    }

}