<?php

class Amendment
{
    // Attributes
    private $id;
    private $bill_id;
    private $author_id;
    private $amendment_content;
    private $comment;
    private $created_time;
    private $updated_time;
    private $billName;
    private $authorName;


    // Constructor
    public function __construct($id, $bill_id, $author_id, $amendment_content, $comment, $created_time, $updated_time, $billName = null, $authorName = null)
    {
        $this->id = $id;
        $this->bill_id = $bill_id;
        $this->author_id = $author_id;
        $this->amendment_content = $amendment_content;
        $this->comment = $comment;
        $this->created_time = $created_time;
        $this->updated_time = $updated_time;
        $this->billName = $billName;
        $this->authorName = $authorName;
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

    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function getAmendmentContent()
    {
        return $this->amendment_content;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getCreatedTime()
    {
        return $this->created_time;
    }

    public function getUpdatedTime()
    {
        return $this->updated_time;
    }
    public function getAuthorName()
    {
        return $this->authorName;
    }

    public function getBillName()
    {
        return $this->billName;
    }

    // Setters
    public function setBillId($bill_id)
    {
        $this->bill_id = $bill_id;
    }

    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }

    public function setAmendmentContent($amendment_content)
    {
        $this->amendment_content = $amendment_content;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setUpdatedTime($updated_time)
    {
        $this->updated_time = $updated_time;
    }

    // Static function to generate Amendment from array
    public static function generateAmendment($data)
    {
        return new Amendment(
            $data['id'],
            $data['bill_id'],
            $data['author_id'],
            $data['amendment_content'],
            $data['comment'],
            $data['created_time'],
            $data['updated_time'],
            $data["billName"],
            $data["authorName"]
        );
    }
}
