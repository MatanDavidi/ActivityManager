<?php

class Application
{
    private $url_controller = null;
    private $url_action = null;
    private $url_parameter_1 = null;
    private $url_parameter_2 = null;

    /**
     * Splits the URL
     */
    private function splitUrl()
    {
        if (isset($_GET['url'])) {

            // remove the '/' character from the end of the string
            // $url = rtrim($_GET['url'], '/');
            $url = trim($_SERVER["REQUEST_URI"], '/');
            $url = trim($_SERVER["REQUEST_URI"], '/');
            // remove any illegal characters from the string
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //split an array based on character '/'
            $url = explode('/', $url);

            // divide the URL's parts based on controller, action and 3 parameters
            $this->url_controller = (isset($url[0]) ? $url[0] : null);
            $this->url_action = (isset($url[1]) ? $url[1] : null);
            $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
            $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
            $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);

            // For debugging only
            // echo 'Controller: ' . $this->url_controller . '<br />';
            // echo 'Action: ' . $this->url_action . '<br />';
            // echo 'Parameter 1: ' . $this->url_parameter_1 . '<br />';
            // echo 'Parameter 2: ' . $this->url_parameter_2 . '<br />';
            // echo 'Parameter 3: ' . $this->url_parameter_3 . '<br />';
        }
    }

    private $url_parameter_3 = null;

    public function __construct()
    {
        $this->splitUrl(); //function to create to divide the URL

        if (strlen($this->url_controller) > 0 &&
            !file_exists('./application/controller/' . $this->url_controller . '.php') &&
            file_exists('./application/controller/' . $this->url_controller . 'Controller.php')) {
            $this->url_controller .= "Controller";
        }

        if (file_exists('./application/controller/' . $this->url_controller . '.php')) {
            require './application/controller/' . $this->url_controller . '.php';
            $this->url_controller = new $this->url_controller();
            if (method_exists($this->url_controller, $this->url_action)) {
                try {
                    if (isset($this->url_parameter_3)) {
                        $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2,
                            $this->url_parameter_3);
                    } elseif (isset($this->url_parameter_2)) {
                        $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
                    } elseif (isset($this->url_parameter_1)) {
                        $this->url_controller->{$this->url_action}($this->url_parameter_1);
                    } else {
                        $this->url_controller->{$this->url_action}();
                    }
                } catch (ArgumentCountError $ace) {
                    require "application/controller/errorCodeController.php";
                    ErrorCodeController::error404();
                }
            } else {

                if (strlen($this->url_action) == 0 && method_exists($this->url_controller, "index")) {
                    $this->url_controller->index();
                } else {
                    require "application/controller/errorCodeController.php";
                    ErrorCodeController::error404();
                }

            }
        } else {
            require "application/controller/errorCodeController.php";
            ErrorCodeController::error404();
        }
    }
}
