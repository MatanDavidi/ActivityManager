<?php

require_once "application/controller/controller.php";

class WorkHoursController extends Controller
{

    public function index()
    {

        require "application/views/shared/header.php";
        require "application/views/workHours/index.php";
        require "application/views/shared/footer.php";

    }

    public function register()
    {

        $this->redirect("activities", "dettagli", Array(0));

    }

}