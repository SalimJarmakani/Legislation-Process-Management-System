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

    public function createNotification($userId, $message)
    {
        $sqlQuery = "INSERT INTO notification (user_id, message, is_read, created_time) 
                     VALUES (:user_id, :message, :is_read, :created_time)";

        $params = [
            'user_id' => $userId,
            'message' => $message,
            'is_read' => 0,
            'created_time' => date('Y-m-d H:i:s')
        ];

        $result = $this->dbContext->query($sqlQuery, $params, false);
        return $result;
    }

    public function CreateBill(Bill $bill)
    {
        if (!isset($_SESSION['Id'])) {
            throw new Exception('User is not logged in.');
        }

        $authorId = $_SESSION['Id'];

        $sqlQuery = "INSERT INTO bill (title, description, author_id, created_time, updated_time,draft_content) 
                     VALUES (:title, :description, :author_id, :created_time, :updated_time, :draft_content)";

        $currentTime = date('Y-m-d H:i:s');

        $params = [
            'title' => $bill->getTitle(),
            'description' => $bill->getDescription(),
            'author_id' => $authorId,
            'created_time' => $currentTime,
            'updated_time' => $currentTime,
            'draft_content' => $bill->getDraftContent()
        ];

        $result = $this->dbContext->query($sqlQuery, $params, false);

        if ($result) {
            $this->createNotification($authorId, "bill titled '{$bill->getTitle()}' has been created successfully.");
        }

        return $result;
    }

    public function updateBill(Bill $bill)
    {
        $sqlQuery = "
            UPDATE bill 
            SET title = :title, 
                description = :description, 
                draft_content = :draft_content, 
                updated_time = :updated_time 
            WHERE id = :id";

        $currentTime = date('Y-m-d H:i:s');

        $params = [
            'id' => $bill->getId(),
            'title' => $bill->getTitle(),
            'description' => $bill->getDescription(),
            'draft_content' => $bill->getDraftContent(),
            'updated_time' => $currentTime
        ];

        $result = $this->dbContext->query($sqlQuery, $params, false);

        if ($result) {
            $this->createNotification($bill->getAuthorId(), "Your bill titled '{$bill->getTitle()}' has been updated.");
        }

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
        if (!empty($billData)) {
            $bill = Bill::GenerateBill($billData[0]);
        }

        return $bill;
    }

    public function getAllBills()
    {
        $sqlQuery = "
            SELECT b.*, u.username 
            FROM bill b 
            JOIN user u ON b.author_id = u.id";

        $billsData = $this->dbContext->query($sqlQuery, [], true);

        $bills = [];
        foreach ($billsData as $billData) {
            $bill = Bill::GenerateBill($billData);
            $bills[] = $bill;
        }

        return $bills;
    }

    public function initiateBillVoting($billId)
    {
        $sql = "UPDATE bill SET status='Under Review' WHERE id=:billId";
        $params = ["billId" => $billId];
        $result = $this->dbContext->query($sql, $params, false);

        if ($result) {
            $bill = $this->getBillById($billId);
            $this->createNotification($bill->getAuthorId(), "Voting has been initiated for bill titled '{$bill->getTitle()}'.");
        }

        return $result;
    }

    public function addAmendment(Amendment $amendment)
    {
        $sqlQuery = "INSERT INTO amendment (bill_id, author_id, amendment_content, comment, created_time, updated_time) 
                     VALUES (:bill_id, :author_id, :amendment_content, :comment, :created_time, :updated_time)";

        $currentTime = date('Y-m-d H:i:s');

        $params = [
            'bill_id' => $amendment->getBillId(),
            'author_id' => $amendment->getAuthorId(),
            'amendment_content' => $amendment->getAmendmentContent(),
            'comment' => $amendment->getComment(),
            'created_time' => $currentTime,
            'updated_time' => $currentTime
        ];

        $result = $this->dbContext->query($sqlQuery, $params, false);

        if ($result) {
            $this->createNotification($amendment->getAuthorId(), "An amendment has been added to the bill with ID {$amendment->getBillId()}.");
        }

        return $result;
    }

    public function endVotingSession($billId)
    {
        $sql = "SELECT vote_value FROM vote WHERE bill_id = :billId";
        $params = ['billId' => $billId];
        $votes = $this->dbContext->query($sql, $params, true);

        $countFor = 0;
        $countAgainst = 0;
        $countAbstain = 0;

        foreach ($votes as $vote) {
            switch ($vote['vote_value']) {
                case 'For':
                    $countFor++;
                    break;
                case 'Against':
                    $countAgainst++;
                    break;
                case 'Abstain':
                    $countAbstain++;
                    break;
            }
        }

        if ($countFor > $countAgainst) {
            $status = 'Approved';
        } elseif ($countAgainst > $countFor) {
            $status = 'Rejected';
        } else {
            $status = 'Under Review';
        }

        $sqlUpdate = "UPDATE bill SET status = :status WHERE id = :billId";
        $updateParams = [
            'status' => $status,
            'billId' => $billId
        ];
        $this->dbContext->query($sqlUpdate, $updateParams, false);

        $bill = $this->getBillById($billId);
        $this->createNotification($bill->getAuthorId(), "The voting session for bill titled '{$bill->getTitle()}' has ended with the result: $status.");

        return $status;
    }
}
