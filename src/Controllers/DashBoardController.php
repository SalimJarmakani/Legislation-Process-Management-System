<?php
require_once './BaseController.php';
class DashBoardController extends BaseController
{



    public function MPDashboard()
    {
        $this->render("Dashboard/MP_Dashboard");
    }
}
