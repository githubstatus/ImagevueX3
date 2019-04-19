<?php
if (!isset($core))
{
    require_once 'filemanager_core.php';
    $core = new filemanager_core();
    require_once 'filemanager_language.php';
}
if ($core->isLogin()){
    if($core->role == "admin"){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        {
            if($core->is_guest()) exit('false');
            $core->touchme();
            if(isset($_POST["filename"]))
            {
                $oldName = $core->dir_file_clear_str( $_POST["filename"] );
                $newName = $core->dir_file_clear_str( $_POST["newName"] );
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
                        echo "false";
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
                        echo "false";
                    }
                }
            }

            if(isset($_POST["dirname"]))
            {
                $oldName = $core->dir_file_clear_str( $_POST["dirname"] );
                $newName = $core->dir_file_clear_str( $_POST["newName"] );
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

            if(isset($_POST["removeDirName"]))
            {
                $name = $core->dir_file_clear_str( $_POST["removeDirName"] );
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

            if(isset($_POST["removeFileName"]))
            {
                $name = $core->dir_file_clear_str( $_POST["removeFileName"] );
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

            if(isset($_POST["mkdir_path"]))
            {
                $slash = "/";
                if($_POST["this_place"] == "../")
                {
                    $slash = "";
                }
                $pathname = $_POST["this_place"].$slash.$_POST["mkdir_path"];
                $pathname = $core->dir_file_clear_str( $pathname );
                if($core->check_base_root($pathname)){
                    if(file_exists($pathname)){
                        echo 'already';
                    } else if(mkdir($pathname, 0755, true)){
                    $core->create_json_file($pathname);
                    echo 'true';
                  } else {
                    echo 'false';
                  }
                }
                else
                {
                    echo "false";
                }
            }

            if(isset($_POST["create_zip"]))
            {
                $dir = $_POST["this_place"];
                if($dir != "../")
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
                $files_folders = $_POST["create_zip"];
                $dir = $core->dir_file_clear_str( $dir );
                $zip_name = $core->dir_file_clear_str( $zip_name );
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
                                $new_zip_name .= '.zip';
                                $new_zip_name = end(explode("/", $new_zip_name));
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
                    echo "false";
                }
            }

            if(isset($_POST["un_zip"]))
            {
                $path_location = $core->dir_file_clear_str( $_POST["path_location"] );
                if($core->check_base_root( $path_location ))
                {
                    $un_zip = $core->dir_file_clear_str( $_POST["un_zip"] );
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

            if(isset($_POST["remove_selected"]))
            {
                $files_and_folders = $_POST["remove_selected"];
                $dir = $_POST["this_path"];
                if($dir != "../")
                    $dir .= "/";

                $flag = true;
                $errors = array();
                $dir = $core->dir_file_clear_str( $dir );
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
                    language_filter("Can_not_remove_files_folders");
                }
            }

            if(isset($_POST["move_selected"]))
            {
                $files_and_folders = $_POST["move_selected"];
                $dir = $_POST["this_path"];
                $newName = $_POST["move_path"]."/";
                if($dir != "../")
                    $dir .= "/";
                $flag = true;
                $errors = array();
                $dir = $core->dir_file_clear_str( $dir );
                $newName = $core->dir_file_clear_str( $newName );
                $dirs_old = array();
                $dirs_new = array();
                if($core->check_base_root($dir.$newName))
                {
                    foreach ($files_and_folders as $value)
                    {
                        if(is_dir($dir.$value))
                        {
                            if(!$core->rename_directory($dir.$value, $dir.$newName.$value))
                            {
                                $flag = false;
                                $errors[] = $value;
                            } else {
                                $dirs_old[] = $dir.$value;
                                $dirs_new[] = realpath($dir.$newName.$value);
                            }
                        }

                        if(is_file($dir.$value))
                        {
                            if(!rename($dir.$value, $dir.$newName.$value))
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
                if($dir != "../")
                    $dir .= "/";
                $dir = $core->dir_file_clear_str( $dir );
                $newName = $core->dir_file_clear_str( $newName );
                $flag = true;
                $errors = array();
                $dirs_old = array();
                $dirs_new = array();
                if($core->check_base_root($dir.$newName))
                {
                    foreach ($files_and_folders as $value)
                    {
                        if(is_dir($dir.$value))
                        {
                            @$core->copy_directory($dir.$value, $dir.$newName.$value);
                            $dirs_old[] = $dir.$value;
                            $dirs_new[] = realpath($dir.$newName.$value);
                        }

                        if(is_file($dir.$value))
                        {
                            if(@!copy($dir.$value, $dir.$newName.$value))
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
        }
    }
}
else
{
    header("Status: 404 Not Found");
}
?>