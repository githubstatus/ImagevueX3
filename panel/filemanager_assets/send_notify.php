<?php
class send_notifications extends filemanager_user_core
{
    public function send_mails($info)
    {
        $this_file_path = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $user_link = str_replace("upload.php", "", $this_file_path);
        $admin_link = str_replace("filemanager_user/upload.php", "filemanager_admin/", $this_file_path);
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
        preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
            $_SERVER['SERVER_NAME'], $matches);
        $host = $matches[2];
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        $info["host"] = "noreply@".$host;
        $info["user_link"] = "http://".$user_link."navigate.php?redirect=".base64_encode($info["folder"]);
        $admin_link = "http://".$admin_link."navigate.php?redirect=".base64_encode($info["folder"]);
        $settings = parent::get_option("settings");
        if($settings->admin_notification == "on")
        {
            $select_admins = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, firstname, lastname, email FROM filemanager_db  LIMIT 1");
            if($select_admins)
            {
                while($row = mysqli_fetch_array($select_admins))
                {
                    $admin_info["fullname"] = parent::decode_me($row["firstname"]) . " " .parent::decode_me($row["lastname"]);
                    $admin_info["email"] = parent::decode_me($row["email"]);
                    $admin_info["link"] = $admin_link;
                    $this->send_admin_email($info, $admin_info);
                    break;
                }
            }
        }
        if($settings->user_notification == "on")
        {
            $this->send_user_email($info);
        }
    }

    private function send_admin_email($base_info, $admin_info)
    {
        $to = $admin_info["email"];
        $listOfTheFiles = implode(", ", $base_info["list_of_files"]);
        $folderName = end(explode("/", trim($base_info["folder"], "/")));
        if($folderName == "..")
        {
            $folderName = "Root of Filemanager";
        }
        $subject = "Filemanager Notification";
        //$headers = "From: " . $base_info["host"] . "\r\n";
        //$headers .= "MIME-Version: 1.0\r\n";
        //$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = "Hi ".$admin_info["fullname"]."; <br>
        - Name of the user who uploaded file: <b>".$base_info["fullname"]."</b> (".$base_info["username"].") <br>
        - List of uploaded files: ".$listOfTheFiles."<br>
        - Name of the folder in which files are uploaded: ".$folderName."<br>
        - Date and time stamp: ".$base_info["date"]."<br>
        - <a href='".$admin_info["link"]."'>Click here</a> to go to the folder in which files are uploaded.
        ";

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
                    $base_info["host"] = SMTPUsername;
                }
            }
        }
        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->From = $base_info["host"];
        $phpMailer->FromName = $base_info["host"];
        $phpMailer->AddAddress($to);
        $phpMailer->Subject = $subject;
        $phpMailer->IsHTML(true);
        $phpMailer->Body = $message;
        $phpMailer->Send();

        //@mail($to, $subject, $message, $headers);
    }

    private function send_user_email($info)
    {
        $to = $info["email"];
        $listOfTheFiles = implode(", ", $info["list_of_files"]);
        $folderName = end(explode("/", trim($info["folder"], "/")));
        $subject = "Filemanager Notification";
        //$headers = "From: " . $info["host"] . "\r\n";
        //$headers .= "MIME-Version: 1.0\r\n";
        //$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = "Hi ".$info["fullname"]." (".$info["username"]."); <br>
        - List of uploaded files: ".$listOfTheFiles."<br>
        - Name of the folder in which files are uploaded: ".$folderName."<br>
        - Date and time stamp: ".$info["date"]."<br>
        - <a href='".$info["user_link"]."'>Click here</a> to go to the folder in which files are uploaded.
        ";

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
                    $info["host"] = SMTPUsername;
                }
            }
        }
        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->From = $info["host"];
        $phpMailer->FromName = $info["host"];
        $phpMailer->AddAddress($to);
        $phpMailer->Subject = $subject;
        $phpMailer->IsHTML(true);
        $phpMailer->Body = $message;
        $phpMailer->Send();

        //@mail($to, $subject, $message, $headers);
    }
}