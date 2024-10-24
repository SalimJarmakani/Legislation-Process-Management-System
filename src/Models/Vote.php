<?php

class Vote
{
    // Attributes
    private $id;
    private $bill_id;
    private $mp_id;
    private $vote_value;
    private $created_time;
    private $mpName;
    // Constructor
    public function __construct($id, $bill_id, $mp_id, $vote_value, $created_time, $mpName = null)
    {
        $this->id = $id;
        $this->bill_id = $bill_id;
        $this->mp_id = $mp_id;
        $this->vote_value = $vote_value;
        $this->created_time = $created_time;
        $this->mpName = $mpName;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getBillId()
    {
        return $this->bill_id;
    }

    public function getMpId()
    {
        return $this->mp_id;
    }

    public function getVoteValue()
    {
        return $this->vote_value;
    }

    public function getCreatedTime()
    {
        return $this->created_time;
    }

    public function getMpName()
    {
        return $this->mpName;
    }

    // Setters
    public function setBillId($bill_id)
    {
        $this->bill_id = $bill_id;
    }

    public function setMpId($mp_id)
    {
        $this->mp_id = $mp_id;
    }

    public function setVoteValue($vote_value)
    {
        $this->vote_value = $vote_value;
    }

    public function setCreatedTime($created_time)
    {
        $this->created_time = $created_time;
    }


    public static function GenerateVote($data)
    {

        return new Vote(
            $data['id'] ?? null,
            $data['bill_id'],
            $data['mp_id'],
            $data['vote_value'],
            $data['created_time'],
            $data['mpName'] ?? null
        );
    }
}
