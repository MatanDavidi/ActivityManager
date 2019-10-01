<?php

require_once "application/controller/controller.php";

class OreLavoroController extends Controller
{

    public function index()
    {

        require "application/views/shared/header.php";
        require "application/views/oreLavoro/index.php";
        require "application/views/shared/footer.php";

    }

    public function registra()
    {

        $this->redirect("lavori", "dettagli", Array(0));

    }

}