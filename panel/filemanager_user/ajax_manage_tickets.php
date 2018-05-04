<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    require_once '../filemanager_assets/tickets_class.php';
    require_once 'option_class.php';
    $core = new filemanager_user_core();
    $option = new option_class();
    $tickets_class = new tickets_class();
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if(isset($_POST["method"]))
        {
            $method = $_POST["method"];
            if($method == "user_create_ticket")
            {
                $subject = $_POST["subject"];
                $message = $_POST["message"];
                $userId = $_POST["user"];
                $parentId = 0;
                $role = "user";
                $status = "open";
                $adminTicket = 0;
                $dateAdded = date("YmdHis");
                $add = $tickets_class->add_new_ticket($subject, $message, $userId, $parentId, $role, $status, $adminTicket, $dateAdded);
                if($add == null)
                {
                    echo 'email';
                    exit;
                }
                else if($add == true)
                {
                    echo 'true';
                    exit;
                }
                else
                {
                    echo 'false';
                    exit;
                }
            }
            else if($method == "change_status_of_ticket")
            {
                $ticketId = $_POST["ticketId"];
                $new_status = $_POST["newStatus"];
                $message = $_POST["message"];
                $userId = $_POST["userId"];
                $change = $tickets_class->change_status_of_ticket($ticketId, $new_status, $userId, $message, false);
                if($change)
                {
                    echo "true";
                    exit();
                }
                else
                {
                    echo "false";
                    exit();
                }
            }
            else if($method == "remove_ticket")
            {
                $ticketId = $_POST["ticketId"];
                $remove = $tickets_class->remove_ticket($ticketId);
                if($remove)
                {
                    echo "true";
                    exit;
                }
                else
                {
                    echo "false";
                    exit;
                }
            }
            else if($method == "reply_ticket")
            {
                $ticketId = $_POST["ticketId"];
                $userId = $_POST["userId"];
                $adminId = $_POST["adminId"];
                $role = $_POST["role"];
                $message = $_POST["message"];
                $reply = $tickets_class->reply_ticket($ticketId, $userId, $adminId, $role, $message);
                if($reply)
                {
                    echo "true";
                    exit;
                }
                else if($reply == null)
                {
                    echo "email";
                    exit;
                }
                else
                {
                    echo "false";
                    exit;
                }
            }
            else
            {
                echo 'false';
            }
        }
    }
}