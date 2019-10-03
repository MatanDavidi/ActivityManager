<?php

require_once "application/controller/controller.php";

class RisorseController extends Controller
{

    public function index()
    {

        require "application/views/shared/header.php";
        require "application/views/risorse/index.php";
        require "application/views/shared/footer.php";

    }

    public function dettagli(string $name)
    {

        //TODO: Add database logic
        require "application/views/shared/header.php";
        require "application/views/risorse/dettagli.php";
        require "application/views/shared/footer.php";

    }

}