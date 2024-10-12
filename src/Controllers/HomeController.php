<?php
require_once './BaseController.php';
class HomeController extends BaseController
{

    public function index()
    {

        $this->render('home/index', []);
    }

    public function home1()
    {
        $this->render('home/home', []);
    }
}
