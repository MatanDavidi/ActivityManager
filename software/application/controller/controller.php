<?php


class Controller
{

    /**
     * Allows to redirect to an action of a controller class from anywhere in a controller's code.
     * @param string $controller The name of the controller that has to handle the request.
     * @param string $action The name of the action (function) to which you want to redirect.
     * This parameter is optional and has a default value of "index".
     * @param array $parameters Any parameters you want to send to the action as an array.
     * This parameter is optional and has a default value of an empty array, which means that no parameters are passed.
     */
    protected function redirect(string $controller, string $action = "index", Array $parameters = Array())
    {
        //Thanks to Robert Pitt for answering the question at https://stackoverflow.com/questions/4979614/redirection-php-inside-mvc

        //Build the request URL with the base URL of the application,
        //the name of the controller, that of the function and its arguments.
        $location = URL . $controller . "/" . $action . "/" . implode("/", $parameters);

        //Redirect that browser to that URL
        header("Location: $location");

        //Stop the code's execution to prevent unwanted results
        die();

    }

    /**
     * Sanitizes an input string by trimming its whitespaces, filtering it.
     * @param string $input The input string to be sanitized.
     * @return string The sanitized input string.
     */
    protected function sanitizeInput(string $input): string
    {
        $input = trim($input);
        $input = filter_var($input, FILTER_SANITIZE_STRING);
        return $input;
    }

}