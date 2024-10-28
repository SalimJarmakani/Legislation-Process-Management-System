<?php

/*we use this to include all the controllers in the controller file so we don't have to

*/


$files = glob("./Controllers/*.*"); // Use *.* to match all files

foreach ($files as $file) {
    include_once $file; // Or require $file
}
include_once "helpers.php";

class Router
{

    public $routeList = [];

    public function addRoute($route, $action, $controller, $requestType = 'GET')
    {

        $this->routeList[$route] = [
            "action" => $action,
            "controller" => $controller,
            'method' => $requestType
        ];
    }

    public function routeLink($uri, $data = [])
    {



        if (array_key_exists($uri, $this->routeList)) {

            $controller = $this->routeList[$uri]["controller"];
            $action = $this->routeList[$uri]["action"];
            $controller = new $controller();

            $method = $this->routeList[$uri]["method"];


            if ($_SERVER["REQUEST_METHOD"] ===  "POST" && $method === "POST") {
                call_user_func_array([$controller, $action], $data);
            } else if ($_SERVER["REQUEST_METHOD"] ===  "GET" && $method === "GET") {
                $controller->$action($data);
            } else {
                $error = "Not a Valid Route";
                include "Views/error/error.php";
            }
        } else {
            $error = "Not a Valid Route";
            include "Views/error/error.php";
        }
    }
}
