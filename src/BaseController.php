<?php

class BaseController
{
    protected function render($view, $data = [])
    {
        extract($data);
        include "Views/$view.php";
    }
}
