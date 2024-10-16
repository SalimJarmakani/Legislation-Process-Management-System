<?php

require_once './BaseController.php';
require_once './repositories/BillRepository.php';
require_once './repositories/AmendmentRepository.php';

class BillController extends BaseController
{
    private $billRepository;
    private $amendmentRepository;

    public function __construct()
    {

        $this->billRepository = new BillRepository();
        $this->amendmentRepository = new AmendmentRepository();
    }

    public function addBill()
    {

        $this->render("Bill/new_bill");
    }

    public function createBill($title, $description, $draft)
    {

        $authorId = $_SESSION["Id"];

        if (!isset($authorId)) throw new Error("Please Login and Try Again");
        // Create an instance of the Bill class
        $bill = new Bill(null, $title, $description, $authorId, $draft, "Draft", null, null);
        // Call the CreateBill method from BillRepository
        try {
            $result = $this->billRepository->CreateBill($bill);

            if ($result) {
                // Bill created successfully
                return "Bill created successfully.";
            } else {
                // Handle failure to create bill
                return "Failed to create the bill.";
            }
        } catch (Exception $e) {
            // Handle exception
            return "Error: " . $e->getMessage();
        }
    }

    public function startBillVoting($billId)
    {
        $result = $this->billRepository->initiateBillVoting($billId);

        $adminDashboardPath = $GLOBALS["BASE_URL"] . "AdminDashboard";

        header("Location: $adminDashboardPath");
    }

    public function reviewBill($billData)
    {

        extract($billData);
        $bill = $this->billRepository->getBillById($billId);

        $amendments = $this->amendmentRepository->getBillAmendments($billId);

        $this->render("Bill/reviewBill", ["bill" => $bill, "amendments" => $amendments]);
    }

    public function voting($billData)
    {

        extract($billData);

        $bill = $this->billRepository->getBillById($billId);

        $this->render("Bill/voting", ["bill" => $bill]);
    }

    public function addAmendment($amendment, $comment, $billId)
    {
        try {
            $authorId = $_SESSION["Id"];
            $amendment = new Amendment(null, $billId, $authorId, $amendment, $comment, null, null);

            $result = $this->billRepository->addAmendment($amendment);
            $bill = $this->billRepository->getBillById($billId);
            if ($result) {

                $this->render("Bill/reviewBill", ["bill" => $bill, "error" => "error adding amendment please try again"]);
            } else $this->render("Bill/reviewBill", ["bill" => $bill]);
        } catch (Exception $ex) {
            $this->render("Bill/reviewBill", ["bill" => $bill, "error" => "error adding amendment please try again"]);
        }
    }
}
