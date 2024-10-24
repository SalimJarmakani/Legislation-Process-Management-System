<?php

require_once './BaseController.php';
require_once './repositories/BillRepository.php';
require_once './repositories/AmendmentRepository.php';
require_once './repositories/VoteRepository.php';


class BillController extends BaseController
{
    private $billRepository;
    private $amendmentRepository;
    private $voteRepository;

    public function __construct()
    {
        $this->billRepository = new BillRepository();
        $this->amendmentRepository = new AmendmentRepository();
        $this->voteRepository = new VoteRepository();
    }

    // Standardized method to get parameters for rendering pages
    private function getBillPageParams($billId)
    {
        $bill = $this->billRepository->getBillById($billId);
        $amendments = $this->amendmentRepository->getBillAmendments($billId);
        $votes = $this->voteRepository->getVotes($billId);

        return [
            "bill" => $bill,
            "amendments" => $amendments,
            "votes" => $votes,
        ];
    }

    public function addBill()
    {
        $this->render("Bill/new_bill");
    }

    public function createBill($title, $description, $draft)
    {
        $authorId = $_SESSION["Id"];
        if (!isset($authorId)) throw new Error("Please Login and Try Again");

        $bill = new Bill(null, $title, $description, $authorId, $draft, "Draft", null, null);

        try {
            $result = $this->billRepository->CreateBill($bill);
            if ($result) {
                return "Bill created successfully.";
            } else {
                return "Failed to create the bill.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function startBillVoting($billId)
    {
        $this->billRepository->initiateBillVoting($billId);
        $adminDashboardPath = $GLOBALS["BASE_URL"] . "AdminDashboard";
        header("Location: $adminDashboardPath");
    }

    public function reviewBill($billData)
    {
        extract($billData);
        $params = $this->getBillPageParams($billId); // Using the standardized method


        $this->render("Bill/reviewBill", $params);
    }

    public function voting($billData)
    {
        extract($billData);
        $params = $this->getBillPageParams($billId); // Using the standardized method
        $this->render("Bill/voting", $params);
    }

    public function addAmendment($amendment, $comment, $billId)
    {
        try {
            $authorId = $_SESSION["Id"];
            $amendment = new Amendment(null, $billId, $authorId, $amendment, $comment, null, null);

            $result = $this->billRepository->addAmendment($amendment);

            $params = $this->getBillPageParams($billId); // Using the standardized method

            if ($result == false) {
                $params["error"] = "Error adding amendment, please try again.";
            }

            $this->render("Bill/reviewBill", $params);
        } catch (Exception $ex) {
            $params = $this->getBillPageParams($billId);
            $params["error"] = "Error adding amendment, please try again.";
            $this->render("Bill/reviewBill", $params);
        }
    }

    public function submitVote($vote, $billId)
    {
        $mpId = $_SESSION["Id"];
        $currentTime = date('Y-m-d H:i:s');
        $vote = new Vote(null, $billId, $mpId, $vote, $currentTime, null);

        $result = $this->voteRepository->addVote($vote);
        $params = $this->getBillPageParams($billId); // Using the standardized method

        if (!$result) {
            $params["error"] = "Unable to add vote check if you have already Voted.";
        }

        $this->render("Bill/voting", $params);
    }
}
