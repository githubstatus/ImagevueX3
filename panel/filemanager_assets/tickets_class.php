<?php
class tickets_class
{
    private $db;
    public $user_role_info = "";
    public $admin_role_info = "";
    public $ticket_admin_id = 0;
    public $ticket_user_id = 0;
    public $user_gravatar = "http://www.gravatar.com/avatar/";
    public $admin_gravatar = "http://www.gravatar.com/avatar/";
    function __construct()
    {
        $this->db = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST, DB_USER, DB_PASS));
        ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_NAME')));
    }

    private function encode_me($txt)
    {
        $txt = strip_tags($txt);
        $txt = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $txt) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $txt = urlencode($txt);
        return $txt;
    }

    private function decode_me($txt)
    {
        $txt = urldecode($txt);
        $txt = stripslashes($txt);
        return $txt;
    }

    public function get_tickets($status, $user = 0)
    {
        $tickets = "";
        $status = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $status) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $user = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $user) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $select = "SELECT * FROM filemanager_tickets WHERE parentId=0 ";
        if($status != "all")
        {
            $select .= " AND status='".$status."' ";
        }
        if($user != 0)
        {
            $select .= " AND userId='$user' ";
        }
        $select .= " ORDER BY dateadded DESC";
        $select = mysqli_query($GLOBALS["___mysqli_ston"], $select);
        $num = mysqli_num_rows($select);
        if($num <= 0)
        {
            return $tickets;
        }

        while($row = mysqli_fetch_array($select))
        {
            $tickets["id"][] = $row["id"];
            $tickets["user"][] = $this->get_user_of_ticket($row["userId"], $row["role"]);
            $tickets["subject"][] = $this->decode_me($row["subject"]);
            $tickets["adminTicket"][] = $row["adminTicket"];
            $tickets["status"][] = $row["status"];
            $tickets["dateAdded"][] = $row["dateadded"];
        }
        return $tickets;
    }

    public function get_users_id()
    {
        $users = "";
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, firstname, lastname, username FROM filemanager_users");
        while($row = mysqli_fetch_array($select))
        {
            $users["id"][] = $row["id"];
            $users["name"][] = $this->decode_me($row["firstname"]." ".$row["lastname"]." ( ".$row["username"]." )");
        }
        return $users;
    }


    public function get_ticket($id)
    {
        $id = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $id) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $ticket["base"] = "";
        $ticket["answers"] = "";
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM filemanager_tickets WHERE id='$id' OR parentId='$id'");
        $flag = true;
        while($row = mysqli_fetch_array($select))
        {
            if($row["id"] == $id)
            {
                $this->get_user_of_ticket($row["userId"], $row["role"], false);
                $this->ticket_user_id = $row["userId"];
                $ticket["base"]["adminTicket"] = $row["adminTicket"];
                $ticket["base"]["subject"] = $this->decode_me($row["subject"]);
                $ticket["base"]["message"] = $this->decode_me($row["message"]);
                $ticket["base"]["status"] = $row["status"];
                $ticket["base"]["dateAdded"] = $row["dateadded"];
            }
            else
            {
                $ticket["answers"]["role"][] = $row["role"];
                if($row["role"] == "admin" and $flag)
                {
                    $this->get_user_of_ticket($row["userId"], $row["role"], false);
                    $flag = false;
                }
                $ticket["answers"]["message"][] = $this->decode_me($row["message"]);
                $ticket["answers"]["dateAdded"][] = $this->decode_me($row["dateadded"]);
            }
        }
        return $ticket;
    }

    public function reply_ticket($ticketId, $userId, $adminId, $role, $message)
    {
        $ticketId = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $ticketId) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $userId = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $userId) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $adminId = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $adminId) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $message = $this->encode_me($message);
        if($role == "admin")
        {
            $status = "reply";
        }
        else
        {
            $status = "progress";
        }
        $dateAdded = date("YmdHis");
        if($role == "admin")
        {
            $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO filemanager_tickets (parentId, userId, role, message, adminTicket, dateadded) VALUES ('$ticketId', '$adminId', '$role', '$message', 0, '$dateAdded')");
        }
        else
        {
            $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO filemanager_tickets (parentId, userId, role, message, adminTicket, dateadded) VALUES ('$ticketId', '$userId', '$role', '$message', 0, '$dateAdded')");
        }
        $insert_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        if($insert)
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_tickets SET status='$status' WHERE id='$ticketId' AND parentId=0");
            if($update)
            {
                if($role == "admin")
                {
                    if($this->send_email_to_user($ticketId, $userId, $status, "", $message))
                    {
                        return true;
                    }
                    else
                    {
                        return null;
                    }
                }
                else
                {
                    if($this->send_email_to_admin($ticketId, $status, "", $message))
                    {
                        return true;
                    }
                    else
                    {
                        return null;
                    }
                }
            }
            else
            {
                mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM filemanager_tickets WHERE id='$insert_id' AND parentId='$ticketId'");
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    private function get_user_of_ticket($userId, $role, $username = true)
    {
        $userId = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $userId) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $userId = (int) $userId;
        $from = "filemanager_users";
        if($role == "admin")
        {
            $from = "filemanager_db";
        }
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT firstname, lastname, username, email FROM ".$from." WHERE id='$userId' LIMIT 1");
        $user = "";
        $num = mysqli_num_rows($select);
        if($num <= 0) return $user;
        $row = mysqli_fetch_array($select,  MYSQLI_ASSOC);
        if($username)
        {
            $user = $this->decode_me($row["firstname"]." ".$row["lastname"]." ( ".$row["username"]." ) ");
        }
        else
        {
            $user = $this->decode_me($row["firstname"]." ".$row["lastname"]);
            if($role == "admin")
            {
                $this->admin_gravatar = $this->get_gravatar_src($this->decode_me($row["email"]));
                $this->admin_role_info = $user;
            }
            else
            {
                $this->user_gravatar = $this->get_gravatar_src($this->decode_me($row["email"]));
                $this->user_role_info = $user;
            }
        }
        return $user;
    }

    public function set_admin_role_info()
    {
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT firstname, lastname, username, email FROM filemanager_db LIMIT 1");
        $user = "";
        $num = mysqli_num_rows($select);
        if($num <= 0) return $user;
        $row = mysqli_fetch_array($select,  MYSQLI_ASSOC);
        $user = $this->decode_me($row["firstname"]." ".$row["lastname"]);
        $this->admin_gravatar = $this->get_gravatar_src($this->decode_me($row["email"]));
        $this->admin_role_info = $user;
    }

    public function add_new_ticket($subject, $message, $userId, $parentId, $role, $status, $adminTicket, $dateAdded)
    {
        $subject = $this->encode_me($subject);
        $message = $this->encode_me($message);
        $userId = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $userId) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $parentId = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $parentId) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $role = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $role) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $status = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $status) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $adminTicket = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $adminTicket) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $dateAdded = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $dateAdded) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO filemanager_tickets (parentId, userId, role, subject, message, status, adminTicket, dateadded) VALUES ('$parentId', '$userId', '$role', '$subject', '$message', '$status', '$adminTicket', '$dateAdded')");
        $ticketId = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        if($insert)
        {
            if($adminTicket == 1)
            {
                if($this->send_email_to_user($ticketId, $userId, $status, $subject, $message))
                {
                    return true;
                }
                else
                {
                    return null;
                }
            }
            else
            {
                if($this->send_email_to_admin($ticketId, $status, $subject, $message))
                {
                    return true;
                }
                else
                {
                    return null;
                }
            }
        }
        else
        {
            return false;
        }
    }

    public function change_status_of_ticket($id, $status, $userId, $message = "", $is_admin = true)
    {
        $id = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $id) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $status = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $status) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        if($status != "open")
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_tickets SET status='$status' WHERE id='$id' AND parentId=0");
        }
        else
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_tickets SET status='$status' WHERE id='$id' AND parentId=0");
        }
        if($update)
        {
            if($status == "open")
            {
                $role = "user";
                if($is_admin) $role = "admin";
                $dateAdded = date("YmdHis");
                $message = $this->encode_me($message);
                if(mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO filemanager_tickets (parentId, userId, role, message, dateadded) VALUES ('$id', '$userId', '$role', '$message', '$dateAdded')"))
                {
                    $this->change_status_email($id, $message, $is_admin);
                    return true;
                }
                else
                {
                    $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_tickets SET status='close' WHERE id='$id' AND parentId=0");
                    return false;
                }
            }
            else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    public function remove_ticket($id)
    {
        $id = (int) ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $id) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $delete = mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM filemanager_tickets WHERE id='$id' OR parentId='$id'");
        if($delete)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function send_email_to_user($ticketId, $id, $status, $subject, $message)
    {
        $message = $this->decode_me($message);
        $message = strip_tags($message);
        $subject = $this->decode_me($subject);
        $subject = strip_tags($subject);
        $new_message = "Ticket ID: ".$ticketId." <br/><br /> Message: <br/><br/>".$message;
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
        preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
            $_SERVER['SERVER_NAME'], $matches);
        $host = $matches[2];
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        $host = "noreply@".$host;
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT email FROM filemanager_users WHERE id='$id' LIMIT 1");
        $row = mysqli_fetch_array($select,  MYSQLI_ASSOC);
        $send_to = $this->decode_me($row["email"]);
        if($status == "open")
        {
            $new_subject = "New ticket ( ".$subject." )";
        }
        else
        {
            $new_subject = "Ticket reply ( ".$host." )";
        }
        require_once 'PHPMailer/class.phpmailer.php';
        $phpMailer = new PHPMailer();

        if( defined( "IS_SMTP_USE" ) )
        {
            if( IS_SMTP_USE )
            {
                $phpMailer->SMTPAuth = SMTPAuth;
                $phpMailer->SMTPSecure = SMTPSecure;
                $phpMailer->Host = SMTPHost;
                $phpMailer->Mailer = "smtp";
                $phpMailer->Port = SMTPPort;
                $phpMailer->Username = SMTPUsername;
                $phpMailer->Password = SMTPPassword;
                if( SMTPFromSMTPUsername == true ) {
                    $host = SMTPUsername;
                }
            }
        }

        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->From = $host;
        $phpMailer->FromName = $host;
        $phpMailer->AddAddress($send_to);
        $phpMailer->Subject = $new_subject;
        $phpMailer->IsHTML(true);
        $phpMailer->Body = $new_message;
        if(!$phpMailer->Send())
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    private function send_email_to_admin($ticketId, $status, $subject, $message)
    {
        $message = $this->decode_me($message);
        $message = strip_tags($message);
        $subject = $this->decode_me($subject);
        $subject = strip_tags($subject);
        $new_message = "Ticket ID: ".$ticketId." <br/><br /> Message: <br/><br/>".$message;
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
        preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
            $_SERVER['SERVER_NAME'], $matches);
        $host = $matches[2];
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        $host = "noreply@".$host;
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT email FROM filemanager_db LIMIT 1");
        $row = mysqli_fetch_array($select,  MYSQLI_ASSOC);
        $send_to = $this->decode_me($row["email"]);
        if($status == "open")
        {
            $new_subject = "New ticket ( ".$subject." )";
        }
        else
        {
            $new_subject = "Ticket reply ( ".$host." )";
        }
        require_once 'PHPMailer/class.phpmailer.php';
        $phpMailer = new PHPMailer();

        if( defined( "IS_SMTP_USE" ) )
        {
            if( IS_SMTP_USE )
            {
                $phpMailer->SMTPAuth = SMTPAuth;
                $phpMailer->SMTPSecure = SMTPSecure;
                $phpMailer->Host = SMTPHost;
                $phpMailer->Mailer = "smtp";
                $phpMailer->Port = SMTPPort;
                $phpMailer->Username = SMTPUsername;
                $phpMailer->Password = SMTPPassword;
                if( SMTPFromSMTPUsername == true ) {
                    $host = SMTPUsername;
                }
            }
        }

        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->From = $host;
        $phpMailer->FromName = $host;
        $phpMailer->AddAddress($send_to);
        $phpMailer->Subject = $new_subject;
        $phpMailer->IsHTML(true);
        $phpMailer->Body = $new_message;
        if(!$phpMailer->Send())
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    private function change_status_email($ticketId, $message, $is_admin)
    {
        $message = $this->decode_me($message);
        $message = strip_tags($message);
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
        preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
            $_SERVER['SERVER_NAME'], $matches);
        $host = $matches[2];
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        $host = "noreply@".$host;

        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filemanager_tickets.subject, filemanager_users.email, filemanager_users.firstname, filemanager_users.lastname, filemanager_db.email AS adminEmail, filemanager_db.firstname AS adminFirstname, filemanager_db.lastname AS adminLastname FROM filemanager_tickets, filemanager_users, filemanager_db WHERE filemanager_tickets.userId=filemanager_users.id AND filemanager_tickets.parentId=0 LIMIT 1");
        $row = mysqli_fetch_array($select,  MYSQLI_ASSOC);
        if($is_admin)
        {
            $new_subject = "Ticket has been reopened by admin ( ".$this->decode_me($row["subject"])." )";
            $new_message = "Hi ".$this->decode_me($row["firstname"]." ".$row["lastname"])."; <br/><br/> Ticket ID: ".$ticketId." <br/><br /> Message: ".$message."<br/><br/>";
            $send_to = $this->decode_me($row["email"]);
        }
        else
        {
            $new_subject = "Ticket has been reopened by user ( ".$this->decode_me($row["subject"])." )";
            $new_message = "Hi ".$this->decode_me($row["adminFirstname"]." ".$row["adminLastname"])."; <br/><br/> Ticket ID: ".$ticketId." <br/><br /> Message: ".$message."<br/><br/>";
            $send_to = $this->decode_me($row["adminEmail"]);
        }
        require_once 'PHPMailer/class.phpmailer.php';
        $phpMailer = new PHPMailer();

        if( defined( "IS_SMTP_USE" ) )
        {
            if( IS_SMTP_USE )
            {
                $phpMailer->SMTPAuth = SMTPAuth;
                $phpMailer->SMTPSecure = SMTPSecure;
                $phpMailer->Host = SMTPHost;
                $phpMailer->Mailer = "smtp";
                $phpMailer->Port = SMTPPort;
                $phpMailer->Username = SMTPUsername;
                $phpMailer->Password = SMTPPassword;
                if( SMTPFromSMTPUsername == true ) {
                    $host = SMTPUsername;
                }
            }
        }

        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->From = $host;
        $phpMailer->FromName = $host;
        $phpMailer->AddAddress($send_to);
        $phpMailer->Subject = $new_subject;
        $phpMailer->IsHTML(true);
        $phpMailer->Body = $new_message;
        if(!$phpMailer->Send())
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function get_gravatar_src($email, $size = 55)
    {
        $email = trim($email);
        $email = strtolower($email);
        $email_hash = md5($email);
        return "http://www.gravatar.com/avatar/".$email_hash."?s=".$size;
    }

}