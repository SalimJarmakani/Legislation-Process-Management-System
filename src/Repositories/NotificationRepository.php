<?php

require_once "./DB/DB.php";
require_once "./Models/Notification.php";

class NotificationRepository
{
    private DB $dbContext;

    public function __construct()
    {
        $this->dbContext = DB::getInstance();
    }

    public function getAllNotificationsForUser($userId)
    {
        $sqlQuery = "SELECT * FROM notification ORDER BY created_time DESC Limit 5";

        $notificationsData = $this->dbContext->query($sqlQuery, [], true);

        $notifications = [];
        foreach ($notificationsData as $notificationData) {
            $notification = new Notification(
                $notificationData['id'],
                $notificationData['user_id'],
                $notificationData['message'],
                $notificationData['is_read'],
                $notificationData['created_time']
            );
            $notifications[] = $notification;
        }

        return $notifications;
    }

    public function markAsRead($notificationId)
    {
        $sqlQuery = "UPDATE notification SET is_read = 1 WHERE id = :notificationId";
        $params = ['notificationId' => $notificationId];
        return $this->dbContext->query($sqlQuery, $params, false);
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

        return $this->dbContext->query($sqlQuery, $params, false);
    }
}
