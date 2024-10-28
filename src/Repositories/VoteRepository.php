<?php

require_once __DIR__ . "/../DB/DB.php";
require_once __DIR__ . "/../Models/Vote.php";


class VoteRepository
{

    private DB $dbContext;


    public function __construct()
    {

        $this->dbContext = DB::getInstance();
    }

    public function checkIfAlreadyVoted($mpId, $billId)
    {

        //we check if Member of parliment already voted on this bill
        $sql = "SELECT count(id) as voteCount from vote where 
        mp_id = :mpId AND bill_id = :billId";

        $params = ["mpId" => $mpId, "billId" => $billId];

        //if the voteCount is bigger than 0 then the member already voted 
        $voteCountResult = $this->dbContext->query($sql, $params, true);

        //get vote count from query result
        $voteCount = $voteCountResult[0]["voteCount"];

        $alreadyVoted = $voteCount > 0;
        return  $alreadyVoted;
    }
    public function addVote(Vote $vote)
    {

        $alreadyVoted = $this->checkIfAlreadyVoted($vote->getMpId(), $vote->getBillId());

        if ($alreadyVoted) return false;

        $sql = "INSERT INTO vote (bill_id,mp_id,vote_value,created_time)
                VALUES (:billId,:mpId,:vote,:currentTime)";

        $params = [
            "billId" => $vote->getBillId(),
            "mpId" => $vote->getMpId(),
            "vote" => $vote->getVoteValue(),
            "currentTime" => $vote->getCreatedTime()
        ];

        $result = $this->dbContext->query($sql, $params, false);

        return $result;
    }

    public function getVotes($billId)
    {

        $sql = "SELECT v.*,u.username as mpName from vote as v 
                Left Join user u on u.id = v.mp_id
                WHERE v.bill_id = :billId";


        $params = ["billId" => $billId];

        $billVotes = $this->dbContext->query($sql, $params, true);

        $votes = [];

        foreach ($billVotes as $voteData) {

            $votes[] = Vote::GenerateVote($voteData);
        }


        return $votes;
    }

    public function getAllVote($billId)
    {
        //TODO add finish this method that gets all votes on bill without needing mpId
    }
}
