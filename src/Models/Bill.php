<?php

class Bill
{

    private $id;
    private $title;
    private $description;
    private $author_id;
    private $draft_content;
    private $status;
    private $created_time;
    private $updated_time;
    private $userName;

    // Constructor
    public function __construct($id, $title, $description, $author_id, $draft_content, $status, $created_time, $updated_time, $userName = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->author_id = $author_id;
        $this->draft_content = $draft_content;
        $this->status = $status;
        $this->created_time = $created_time;
        $this->updated_time = $updated_time;
        $this->userName = $userName;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function getDraftContent()
    {
        return $this->draft_content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCreatedTime()
    {
        return $this->created_time;
    }

    public function getUpdatedTime()
    {
        return $this->updated_time;
    }

    public function getUsername()
    {
        return $this->userName;
    }

    // Setters
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }

    public function setDraftContent($draft_content)
    {
        $this->draft_content = $draft_content;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setUpdatedTime($updated_time)
    {
        $this->updated_time = $updated_time;
    }

    // Static method to generate a Bill object from an associative array
    public static function GenerateBill(array $data)
    {
        return new self(
            $data['id'],
            $data['title'],
            $data['description'],
            $data['author_id'],
            $data['draft_content'],
            $data['status'],
            $data['created_time'],
            $data['updated_time'],
            $data["username"]
        );
    }
}
