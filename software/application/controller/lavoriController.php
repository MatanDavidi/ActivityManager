<?php

require_once "application/controller/controller.php";

class LavoriController extends Controller
{

    public function index()
    {
        require "application/views/shared/header.php";
        require "application/views/lavori/index.php";
        require "application/views/shared/footer.php";
    }

}