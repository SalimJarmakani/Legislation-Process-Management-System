<?php
require_once __DIR__ . '/../BaseController.php';
require_once __DIR__ . '/../Repositories/BillRepository.php';
require_once __DIR__ . '/../Repositories/AmendmentRepository.php';

class DashBoardController extends BaseController
{

    private $billRepository;
    private $amendmentRepository;

    public function __construct()
    {
        $this->billRepository = new BillRepository();
        $this->amendmentRepository = new AmendmentRepository();
    }

    public function MPDashboard()
    {

        $allBills = $this->billRepository->getAllBills();


        $this->render("Dashboard/MP_Dashboard", ["bills" => $allBills]);
    }

    public function reviewDashboard()
    {

        try {

            $userId = $_SESSION["Id"];
            $allBills = $this->billRepository->getAllBills();
            $userAmendments = $this->amendmentRepository->getUserAmendments($userId);
            $this->render("Dashboard/Review_Dashboard", ["bills" => $allBills, "amendments" => $userAmendments]);
        } catch (Exception $e) {
            $this->render("Dashboard/Review_Dashboard", ["error" => "Problem Getting Dashboard Data Please Refresh"]);
        }
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
