<?php
require_once './BaseController.php';
require_once './Repositories/BillRepository.php';
class DashBoardController extends BaseController
{

    private $billRepository;

    public function __construct()
    {
        $this->billRepository = new BillRepository();
    }

    public function MPDashboard()
    {

        $allBills = $this->billRepository->getAllBills();


        $this->render("Dashboard/MP_Dashboard", ["bills" => $allBills]);
    }
}
