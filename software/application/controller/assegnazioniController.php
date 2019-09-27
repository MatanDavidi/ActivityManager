<?php

require_once "application/controller/controller.php";

class AssegnazioniController extends Controller
{

    public function index()
    {

        require "application/views/shared/header.php";
        require "application/views/assegnazioni/index.php";
        require "application/views/shared/footer.php";

    }

}