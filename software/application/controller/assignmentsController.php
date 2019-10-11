<?php

require_once "application/controller/controller.php";

class AssignmentsController extends Controller
{

    public function index()
    {

        require "application/views/shared/header.php";
        require "application/views/assignments/index.php";
        require "application/views/shared/footer.php";

    }

    public function assign()
    {

        //TODO: Add database logic
        $this->redirect("activities", "dettagli", Array(0));

    }

}