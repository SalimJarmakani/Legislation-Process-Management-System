<?php

require_once "./DB/DB.php";
require_once "./Models/Bill.php";
require_once "./Models/Amendment.php";


class AmendmentRepository
{

    private DB $dbContext;


    public function __construct()
    {

        $this->dbContext = DB::getInstance();
    }

    public function getUserAmendments($authorId)
    {

        $sql = "SELECT a.*,u.username as authorName,b.title as billName FROM amendment a
        LEFT JOIN user u on u.id = a.author_id
        LEFT JOIN bill b on b.id = a.bill_id 
         WHERE a.author_id = :authorId";

        $params = ["authorId" => $authorId];

        $data = $this->dbContext->query($sql, $params, true);


        $amendments = [];
        foreach ($data as $amendmentArray) {
            $amendment = Amendment::generateAmendment($amendmentArray);

            $amendments[] = $amendment;
        }

        return $amendments;
    }

    public function getBillAmendments($billId)
    {
        $sql = "SELECT a.*,u.username as authorName,b.title as billName FROM amendment a
        LEFT JOIN user u on u.id = a.author_id
        LEFT JOIN bill b on b.id = a.bill_id 
         WHERE a.bill_id = :billId";

        $params = ["billId" => $billId];

        $data = $this->dbContext->query($sql, $params, true);


        $amendments = [];
        foreach ($data as $amendmentArray) {
            $amendment = Amendment::generateAmendment($amendmentArray);

            $amendments[] = $amendment;
        }

        return $amendments;
    }
}
