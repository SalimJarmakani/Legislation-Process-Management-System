<?php

class Notification
{
    // Attributes
    private $id;
    private $user_id;
    private $message;
    private $is_read;
    private $created_time;

    // Constructor
    public function __construct($id, $user_id, $message, $is_read, $created_time)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->message = $message;
        $this->is_read = $is_read;
        $this->created_time = $created_time;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getIsRead()
    {
        return $this->is_read;
    }

    public function getCreatedTime()
    {
        return $this->created_time;
    }

    // Setters
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setIsRead($is_read)
    {
        $this->is_read = $is_read;
    }

    public function setCreatedTime($created_time)
    {
        $this->created_time = $created_time;
    }
}
