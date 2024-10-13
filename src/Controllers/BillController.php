<?php

require_once './BaseController.php';
require_once './repositories/BillRepository.php';
class BillController extends BaseController
{
    private $billRepository;
    public function __construct()
    {

        $this->billRepository = new BillRepository();
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
}
