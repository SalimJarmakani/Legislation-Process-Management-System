    <?php

    require_once "./DB/DB.php";
    require_once "./Models/Bill.php";
    require_once "./Models/Amendment.php";


    class BillRepository
    {

        private DB $dbContext;


        public function __construct()
        {

            $this->dbContext = DB::getInstance();
        }


        public function CreateBill(Bill $bill)
        {

            // Get the author ID from the session
            if (!isset($_SESSION['Id'])) {
                throw new Exception('User is not logged in.');
            }

            $authorId = $_SESSION['Id'];

            // Prepare the SQL statement to insert a new bill
            $sqlQuery = "INSERT INTO bill (title, description, author_id, created_time, updated_time) 
                 VALUES (:title, :description, :author_id, :created_time, :updated_time)";

            // Current time for created and updated time
            $currentTime = date('Y-m-d H:i:s');

            // Execute the query
            $params = [
                'title' => $bill->getTitle(),
                'description' => $bill->getDescription(),
                'author_id' => $authorId,
                'created_time' => $currentTime,
                'updated_time' => $currentTime
            ];

            // Execute the query using dbContext
            $result = $this->dbContext->query($sqlQuery, $params, false);

            return $result;
        }

        public function getBillById($billId): Bill
        {

            $sql = "
        SELECT b.*, u.username 
        FROM bill b 
        JOIN user u ON b.author_id = u.id
        WHERE b.id = :billId";

            $params = ["billId" => $billId];

            $billData = $this->dbContext->query($sql, $params, true);


            $bill = null;


            if (!empty($billData)) $bill = Bill::GenerateBill($billData[0]); //get first element our Bill

            return $bill;
        }

        public function getAllBills()
        {
            // Prepare the SQL query to get all bills with associated usernames
            $sqlQuery = "
            SELECT b.*, u.username 
            FROM bill b 
            JOIN user u ON b.author_id = u.id
        ";

            // Execute the query
            $billsData = $this->dbContext->query($sqlQuery, [], true); // Get all results

            $bills = [];

            // Process each bill data row
            foreach ($billsData as $billData) {
                // Use GenerateBill to create a Bill object from the data
                $bill = Bill::GenerateBill($billData);
                // Add the username to the Bill object or store in an array
                $bills[] = $bill;
            }

            return $bills; // Return an array of bills with usernames
        }

        public function initiateBillVoting($billId)
        {

            $sql = "UPDATE bill SET status='Under Review' where id=:billId";

            $params = ["billId" => $billId];

            $result = $this->dbContext->query($sql, $params, false);

            return $result;
        }

        public function addAmendment(Amendment $amendment)
        {

            // Prepare the SQL statement to insert a new bill
            $sqlQuery = "INSERT INTO amendment (bill_id,author_id,amendment_content,comment,created_time,updated_time) 
                VALUES (:bill_id,:author_id,:amendment_content,:comment,:created_time,:updated_time)";

            // Current time for created and updated time
            $currentTime = date('Y-m-d H:i:s');

            // Execute the query
            $params = [
                'bill_id' => $amendment->getBillId(),
                'author_id' => $amendment->getAuthorId(),
                'amendment_content' => $amendment->getAmendmentContent(),
                'comment' => $amendment->getComment(),
                'created_time' => $currentTime,
                'updated_time' => $currentTime
            ];

            // Execute the query using dbContext
            $result = $this->dbContext->query($sqlQuery, $params, false);

            return $result;
        }
    }
