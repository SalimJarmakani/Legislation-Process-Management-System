<?php

require_once  __DIR__ . '/../BaseController.php';
require_once __DIR__ . '/../Repositories/BillRepository.php';
require_once __DIR__ . '/../Repositories/AmendmentRepository.php';
require_once __DIR__ . '/../Repositories/VoteRepository.php';


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
                $this->render("Bill/new_bill", ["message" => "Created Bill Successfully"]);
            } else {
                $this->render("Bill/new_bill", ["message" => "Failed to Create Bill"]);
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function editBill($billData)
    {

        extract($billData);
        $params = $this->getBillPageParams($billId);

        $this->render("Bill/EditBill", $params);
    }

    public function updateBill($billId, $title, $description, $draft_content)
    {
        $authorId = $_SESSION["Id"];

        // Validate that the author ID is set and the bill ID is valid
        if (!isset($authorId)) throw new Error("Please Login and Try Again");
        if (!isset($billId)) throw new Error("Invalid Bill ID");

        // Create a new Bill object with the updated details
        $bill = new Bill(
            $billId,
            $title,
            $description,
            $authorId,
            $draft_content,
            null,
            null,
            date('Y-m-d H:i:s')
        );
        try {
            // Call the repository to update the bill
            $result = $this->billRepository->updateBill($bill);
            if ($result) {
                // Redirect or render a success message
                $successMessage = "Bill updated successfully.";
                $params = $this->getBillPageParams($billId);
                $params['success'] = $successMessage;
                $this->render("Bill/BillPage", $params);
            } else {
                // Handle failure to update
                $params = $this->getBillPageParams($billId);
                $params['error'] = "Failed to update the bill.";
                $this->render("Bill/BillPage", $params);
            }
        } catch (Exception $e) {
            // Handle any exceptions during the update process
            $params = $this->getBillPageParams($billId);
            $params['error'] = "Error: " . $e->getMessage();
            $this->render("Bill/BillPage", $params);
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

    public function viewBill($billData)
    {
        extract($billData);

        $params = $this->getBillPageParams($billId);

        $this->render("Bill/BillPage", $params);
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

    public function billAdmin($billData)
    {

        extract($billData);

        $params = $this->getBillPageParams($billId);
        $this->render("Bill/BillAdmin", $params);
    }

    public function endVotingSession($billId)
    {
        try {
            $status = $this->billRepository->endVotingSession($billId);

            $updatedBill = $this->billRepository->getBillById($billId);

            // Create a success message based on the status
            switch ($status) {
                case 'Approved':
                    $message = "The bill has been approved successfully.";
                    break;
                case 'Rejected':
                    $message = "The bill has been rejected.";
                    break;
                case 'Under Review':
                default:
                    $message = "The voting session ended, and the bill is still under review.";
                    break;
            }


            $params = [
                "bill" => $updatedBill,
                "message" => $message,
                "votes" => $this->voteRepository->getVotes($billId),
            ];


            // Render the appropriate view with the message and updated bill data
            $this->render("Bill/BillAdmin", $params);
        } catch (Exception $e) {
            // Handle any exceptions and return an error message
            $params = [
                "error" => "Error ending the voting session: " . $e->getMessage(),
                "bill" => $this->billRepository->getBillById($billId),
            ];
            $this->render("Bill/BillPage", $params);
        }
    }
}
