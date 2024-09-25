<?php

/*we use this to include all the controllers in the controller file so we don't have to

*/


$files = glob("./Controllers/*.*"); // Use *.* to match all files

foreach ($files as $file) {
    include $file; // Or require $file
}


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

            $controller->$action($data);
        } else {
            throw new \Exception("Not A Valid Route: $uri");
        }
    }
}
