<?php

/*we use this to include all the controllers in the controller file so we don't have to

*/


$files = glob("./Controllers/*.*"); // Use *.* to match all files

foreach ($files as $file) {
    include $file; // Or require $file
}
include_once "helpers.php";

class Router
{

    public $routeList = [];

    public function addRoute($route, $action, $controller)
    {

        $this->routeList[$route] = ["action" => $action, "controller" => $controller];
    }

    public function routeLink($uri, $data = [])
    {

        if (array_key_exists($uri, $this->routeList)) {

            $controller = $this->routeList[$uri]["controller"];
            $action = $this->routeList[$uri]["action"];
            $controller = new $controller();


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                call_user_func_array([$controller, $action], $data);
            } else {
                $controller->$action($data);
            }
        } else {
            $error = "Not a Valid Route";
            include "Views/error/error.php";
        }
    }
}
