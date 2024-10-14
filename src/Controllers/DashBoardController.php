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

    public function reviewDashboard()
    {

        $allBills = $this->billRepository->getAllBills();

        $this->render("Dashboard/Review_Dashboard", ["bills" => $allBills]);
    }

    public function adminDashboard()
    {
        $allBills = $this->billRepository->getAllBills();

        // Initialize arrays for each bill status
        $draftBills = [];
        $underReviewBills = [];
        $approvedBills = [];
        $rejectedBills = [];

        // Iterate through all bills and categorize them
        foreach ($allBills as $bill) {
            switch ($bill->getStatus()) {
                case 'Draft':
                    $draftBills[] = $bill;
                    break;
                case 'Under Review':
                    $underReviewBills[] = $bill;
                    break;
                case 'Approved':
                    $approvedBills[] = $bill;
                    break;
                case 'Rejected':
                    $rejectedBills[] = $bill;
                    break;
            }
        }

        // Pass the categorized arrays to the view
        $this->render("Dashboard/AdminDashboard", [
            "draftBills" => $draftBills,
            "underReviewBills" => $underReviewBills,
            "approvedBills" => $approvedBills,
            "rejectedBills" => $rejectedBills
        ]);
    }
}
