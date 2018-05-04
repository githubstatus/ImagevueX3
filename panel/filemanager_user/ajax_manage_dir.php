<?php
if (!isset($core))
{
	require_once '../filemanager_user_core.php';
	$core = new filemanager_user_core();
    $core->userInfo();
    require_once '../filemanager_language_user.php';
}
if ($core->isLogin())
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    {
    	$core->touchme();
        if(isset($_POST["filename"]))
        {
            if($core->user_can_do_it($core->user_id, "rename_folder", $core->user_limitation) or $core->user_can_do_it($core->user_id, "copy_folders", $core->user_limitation) or $core->user_can_do_it($core->user_id, "move_folders", $core->user_limitation))
            {
                $oldName = $_POST["filename"];
                $newName = $_POST["newName"];
                $newName = $core->name_filter($newName);
                $oldName = $core->name_filter($oldName);
                if(isset($_POST["copy_this"]))
                {
                    if($core->check_base_root($newName))
                    {
                        if(copy($oldName, $newName))
                        {
                            echo 'true';
                        }
                        else
                        {
                            echo 'false';
                        }
                    }
                    else
                    {
                        echo 'false';
                    }
                }
                else
                {
                    if($core->check_base_root($newName))
                    {
                        if(rename($oldName, $newName))
                        {
                            echo 'true';
                        }
                        else
                        {
                            echo 'false';
                        }
                    }
                    else
                    {
                        echo 'false';
                    }
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["dirname"]))
        {
            if($core->user_can_do_it($core->user_id, "rename_folder", $core->user_limitation) or $core->user_can_do_it($core->user_id, "copy_folders", $core->user_limitation) or $core->user_can_do_it($core->user_id, "move_folders", $core->user_limitation))
            {
                $oldName = $core->name_filter($_POST["dirname"]);
                $newName = $core->name_filter($_POST["newName"]);
                if(isset($_POST["copy_this"]))
                {
                    if($core->check_base_root($newName))
                    {
                        $core->copy_directory($oldName, $newName);
                        X3::update_folders_key($oldName, $newName, true);
                        echo 'true';
                    }
                    else
                    {
                        echo 'false';
                    }
                }
                else
                {
                    if($core->check_base_root($newName))
                    {
                        if($core->rename_directory($oldName, $newName))
                        {
                        		X3::update_folders_key($oldName, $newName);
                            echo 'true';
                        }
                        else
                        {
                            echo 'false';
                        }
                    }
                    else
                    {
                        echo 'false';
                    }
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["removeDirName"])) // done
        {
            if($core->user_can_do_it($core->user_id, "remove_folders"))
            {
                $name = $_POST["removeDirName"];
                $name = $core->name_filter($name);
                if($core->check_base_root($name))
                {
                    if($core->recursiveDelete($name))
                    {
                    		X3::remove_folders_key($name);
                        echo 'true';
                    }
                    else
                    {
                        echo 'false';
                    }
                }
                else
                {
                    echo 'false';
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["removeFileName"])) // done
        {
            if($core->user_can_do_it($core->user_id, "remove_folders"))
            {
                $name = $_POST["removeFileName"];
                $name = $core->name_filter($name);
                if($core->check_base_root($name))
                {
                    if(@unlink($name))
                    {
                        echo 'true';
                    }
                    else
                    {
                        echo 'false';
                    }
                }
                else
                {
                    echo 'false';
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["mkdir_path"])) // done
        {
            if($core->user_can_do_it($core->user_id, "create_folder", $core->user_limitation))
            {
                $str_pos = strpos($_POST["mkdir_path"], "../");
                if($str_pos !== false)
                {
                    echo 'false';
                    exit;
                }
                $pathname = $_POST["this_place"]."/".$_POST["mkdir_path"];
                $pathname = $core->name_filter($pathname);
                if($core->check_base_root($pathname))
                {
                		if(file_exists($pathname)){
	                		echo 'already';
	                	} else if(mkdir($pathname, 0755, true))
                    {
                    		$core->create_json_file($pathname);
                        echo 'true';
                    }
                    else
                    {
                        echo 'false';
                    }
                }
                else
                {
                    echo 'false';
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["create_zip"])) // done
        {
            if($core->user_can_do_it($core->user_id, "zip_folders", $core->user_limitation) or $core->user_can_do_it($core->user_id, "backup_folders", $core->user_limitation))
            {
                $dir = $_POST["this_place"];
                if($dir != "../".ROOT_DIR_NAME."/")
                    $dir .= "/";
                $zip_name = $_POST["zip_name"];
                $realName = $zip_name; // for check backup name

                if(is_file($dir.$zip_name.".zip"))
                {
                    $zip_name = $zip_name."_".rand();
                }
                if(is_dir($dir.$zip_name))
                {
                    $zip_name = $zip_name."_".rand();
                }

                $zip_name = $dir.$zip_name;
                $zip_name = $core->name_filter( $zip_name );
                $dir = $core->name_filter( $dir );
                $files_folders = $_POST["create_zip"];
                if($core->check_base_root($zip_name))
                {
                    if(mkdir($zip_name, 0755))
                    {
                        foreach ($files_folders as $value)
                        {
                            if(is_dir($dir.$value))
                            {
                                $core->copy_directory($dir.$value, $zip_name."/".$value);
                            }
                            else
                            {
                                copy($dir.$value, $zip_name."/".$value);
                            }
                        }
                        if($core->create_zip($zip_name, $zip_name))
                        {
                            $core->recursiveDelete($zip_name);
                            if(isset($_POST["create_back_up"]))
                            {
                                $backup_dir = "../filemanager_backups/";
                                $new_zip_name = $zip_name;
                                $new_zip_name = str_replace("../", "", $new_zip_name);

                                if(is_file($backup_dir.$new_zip_name.".zip"))
                                {
                                    $new_zip_name = $new_zip_name.'_'.rand();
                                }
                                $username = $core->user_username;
                                $new_zip_name .= '.zip';
                                $new_zip_name = end(explode("/", $new_zip_name));
                                $new_zip_name = $username."_".$new_zip_name;
                                if (rename($zip_name.'.zip', $backup_dir.$new_zip_name))
                                    echo 'true';
                                else
                                    echo 'false';
                            }
                            else
                            {
                                echo "true";
                            }
                        }
                        else
                        {
                            $core->recursiveDelete($zip_name);
                            echo "false";
                        }
                    }
                    else
                    {
                        echo 'false';
                    }
                }
                else
                {
                    echo 'false';
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["un_zip"])) // done
        {
            if($core->user_can_do_it($core->user_id, "unzip_files", $core->user_limitation))
            {
                $path_location = $core->name_filter( $_POST["path_location"] );
                if($core->check_base_root( $path_location ))
                {
                    $un_zip = $core->name_filter( $_POST["un_zip"] );
                    if($core->extract_zip($un_zip, $path_location))
                    {
                        echo 'true';
                    }
                    else
                    {
                        echo 'false';
                    }
                }
                else
                {
                    echo 'false';
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["remove_selected"])) // done
        {
            if($core->user_can_do_it($core->user_id, "remove_folders"))
            {
                $files_and_folders = $_POST["remove_selected"];
                $dir = $_POST["this_path"];
                if($dir != "../".ROOT_DIR_NAME."/")
                    $dir .= "/";

                $flag = true;
                $errors = array();
                $dir = $core->name_filter( $dir );
                $dirs = array();
                if($core->check_base_root($dir))
                {
                    foreach ($files_and_folders as $value)
                    {
                        if(is_dir($dir.$value))
                        {
                            if(!$core->recursiveDelete($dir.$value))
                            {
                                $flag = false;
                                $errors[] = $value;
                            } else {
                            	$dirs[] = $dir.$value;
                            }
                        }

                        if(is_file($dir.$value))
                        {
                            if(!@unlink($dir.$value))
                            {
                                $flag = false;
                                $errors[] = $value;
                            }
                        }
                    }

                    if(count($dirs)) X3::remove_folders_key($dirs);

                    if($flag)
                        echo 'true';
                    else
                        echo implode(", ", $errors);
                }
                else
                {
                    echo 'false';
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["move_selected"]))
        {
            $files_and_folders = $_POST["move_selected"];
            $dir = $_POST["this_path"];
            $newName = $_POST["move_path"]."/";
            if($dir != "../".ROOT_DIR_NAME."/")
                $dir .= "/";
            $flag = true;
            $errors = array();
            $newName = $core->name_filter($newName);
            $dir = $core->name_filter( $dir );
            $dirs_old = array();
            $dirs_new = array();
            if($core->check_base_root($newName))
            {
                foreach ($files_and_folders as $value)
                {
                    if(is_dir($dir.$value))
                    {
                        if(!$core->rename_directory($dir.$value, $newName.$value))
                        {
                            $flag = false;
                            $errors[] = $value;
                        } else {
                        	$dirs_old[] = $dir.$value;
                        	$dirs_new[] = realpath($newName.$value);
                        }
                    }

                    if(is_file($dir.$value))
                    {
                        if(!rename($dir.$value, $newName.$value))
                        {
                            $flag = false;
                            $errors[] = $value;
                        }
                    }
                }

                // folders.json
                if(count($dirs_old)) X3::update_folders_key($dirs_old, $dirs_new);

                if($flag)
                {
                    echo 'true';
                }
                else
                {
                    echo implode(", ", $errors);
                }
            }
            else
            {
                language_filter("Can_not_move_files_folders");
            }
        }

        if(isset($_POST["copy_selected"]))
        {
            $files_and_folders = $_POST["copy_selected"];
            $dir = $_POST["this_path"];
            $newName = $_POST["copy_path"]."/";
            if($dir != "../".ROOT_DIR_NAME."/")
                $dir .= "/";
            $flag = true;
            $errors = array();
            $newName = $core->name_filter($newName);
            $dir = $core->name_filter( $dir );
            $dirs_old = array();
            $dirs_new = array();
            if($core->check_base_root($newName))
            {
                foreach ($files_and_folders as $value)
                {
                    if(is_dir($dir.$value))
                    {
                        $core->copy_directory($dir.$value, $newName.$value);
                        $dirs_old[] = $dir.$value;
                        $dirs_new[] = realpath($newName.$value);
                    }

                    if(is_file($dir.$value))
                    {
                        if(!copy($dir.$value, $newName.$value))
                        {
                            $flag = false;
                            $errors[] = $value;
                        }
                    }
                }

                // folders.json
                if(count($dirs_old)) X3::update_folders_key($dirs_old, $dirs_new, true);

                if($flag)
                {
                    echo 'true';
                }
                else
                {
                    echo implode(", ", $errors);
                }
            }
            else
            {
                language_filter("Can_not_copy_files_folders");
            }
        }

        if(isset($_POST["download_selected"]))
        {
            $dir = $_POST["this_path"];
            if($dir != "../".ROOT_DIR_NAME."/")
                $dir .= "/";
            $zip_name = date("YmdHis");
            $realName = $zip_name;
            $temp_dir = "../".ROOT_DIR_NAME."/";
            $dir = $core->name_filter($dir);
            if(is_file($temp_dir.$zip_name.".zip"))
            {
                $zip_name = $zip_name."_".rand();
            }

            $zip_name = $temp_dir.$zip_name;
            $zip_name = $core->name_filter( $zip_name );
            $files_folders = $_POST["download_selected"];
            if($core->check_base_root($dir))
            {
                if(mkdir($zip_name, 0755))
                {
                    foreach ($files_folders as $value)
                    {
                        if(is_dir($dir.$value))
                        {
                            $core->copy_directory($dir.$value, $zip_name."/".$value);
                        }
                        else
                        {
                            copy($dir.$value, $zip_name."/".$value);
                        }
                    }
                    if($core->create_zip($zip_name, $zip_name))
                    {
                        $core->recursiveDelete($zip_name);
                        $file = $zip_name.".zip";
                        $file = $core->name_filter($file);
                        echo "download.php?filename=".base64_encode(utf8_encode($file))."&dir=".base64_encode(utf8_encode($dir));
                        exit;
                    }
                    else
                    {
                        $core->recursiveDelete($zip_name);
                        echo "false";
                    }
                }
                else
                {
                    echo "false";
                }
            }
            else
            {
                echo 'false';
            }
        }

        if(isset($_POST["share_selected"]))
        {
            $settings = $core->get_option("settings");
            if($settings->share == "on")
            {
                $dir = $_POST["this_path"];
                if($dir != "../")
                    $dir .= "/";
                $zip_name = date("YmdHis");
                $realName = $zip_name;

                $temp_dir = "../";

                if(is_file($temp_dir.$zip_name.".zip"))
                {
                    $zip_name = $zip_name."_".rand();
                }

                $zip_name = $temp_dir.$zip_name;
                $zip_name = $core->name_filter( $zip_name );
                $dir = $core->name_filter( $dir );
                $files_folders = $_POST["share_selected"];
                if($core->check_base_root($dir))
                {
                    $send_to = $_POST["send_to"];
                    $from = $_POST["from"];
                    $subject = $_POST["subject"];
                    $message = $_POST["message"];
                    $emails = $_POST["emails"];
                    if(mkdir($zip_name, 0755))
                    {
                        foreach ($files_folders as $value)
                        {
                            if(is_dir($dir.$value))
                            {
                                $core->copy_directory($dir.$value, $zip_name."/".$value);
                            }
                            else
                            {
                                copy($dir.$value, $zip_name."/".$value);
                            }
                        }
                        if($core->create_zip($zip_name, $zip_name))
                        {
                            $core->recursiveDelete($zip_name);
                            $file = $zip_name.".zip";
                            $core->share_files($send_to, $emails, $subject, $from, $message, $file);
                            sleep(1);
                            @unlink($file);
                            exit;
                        }
                        else
                        {
                            $core->recursiveDelete($zip_name);
                            echo "false";
                        }
                    }
                    else
                    {
                        echo "false";
                    }
                }
                else
                {
                    echo "false";
                }
            }
            else
            {
                echo "false";
            }
        }

    }
}
else
{
	header("Status: 404 Not Found");
}
?>