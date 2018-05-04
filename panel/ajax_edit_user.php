<?php
if (!isset($core))
{
    require_once 'filemanager_core.php';
    require_once 'option_class.php';
    $core = new filemanager_core();
    $option = new option_class();
    require_once 'filemanager_language.php';
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if (isset($_POST["editUser"]))
        {
            $result = "";
            $status = 0;
            $core->adminInfo();
            if ($_POST["editUser"] == $core->admin_id)
            {
                if(isset($_POST["edit_username"]) and isset($_POST["edit_email"]))
                {
                    $userId = $_POST["userId"];
                    $username = $_POST["edit_username"];
                    $email = $_POST["edit_email"];
                    $firstname = $_POST["edit_firstname"];
                    $lastname = $_POST["edit_lastname"];
                    $password = $_POST["edit_password"];
                    $send_pass = $_POST["edit_send_pass"];
                    $user_dir = $_POST["edit_user_dir"];
                    $limitation = $_POST["edit_limitation"];
                    $upload_limitation = $_POST["edit_upload_limitation"];
                    $deny_files = $_POST["edit_deny_files"];
                    $user_perm = array();
                    if(isset($_POST["edit_user_perm"]))
                        $user_perm = $_POST["edit_user_perm"];
                    $user_ext = $_POST["edit_user_ext"];
                    $user_up = array();
                    if(isset($_POST["edit_user_up"]))
                        $user_up = $_POST["edit_user_up"];
                    $edit = $core->edit_user($username, $email, $firstname, $lastname, $password, $send_pass, $user_dir, $limitation, $upload_limitation, $deny_files, $user_perm, $user_ext, $user_up, $userId);
                    if($edit == true)
                    {
                        $status = 1;
                        $result = language_filter("User has been edited", true);
                    }
                    else if($edit == null)
                    {
                        $status = 1;
                        $result = language_filter("User has been edited but can not send email to user", true);
                    }
                    else
                    {
                        $result = language_filter("User has not been edited", true);
                    }
                }
                $backPage = $_POST["backPage"];
                $userId = $_POST["userId"];
                global $ALLOW_EXTENSIONS;
                global $ALLOW_UPLOADER;
                $allow_ext_filemanager = $ALLOW_EXTENSIONS;
                $allow_ext_uploader = $ALLOW_UPLOADER;
                $user = $core->get_user($userId);
?>
                <div class=x3-edit-user>
                <div class="row">
                    <div class="col-md-12" style="">
                        <h3>Edit User</h3> <hr />
                        <form action="javascript:;" method="post" name="add_user_form">

                            <div class="form-group">
                                <label for="user_edit_firstname"><?php language_filter("First Name")?></label>
                                <input type="text" id="user_edit_firstname" name="firstname" class="form-control" required="required" value="<?php echo $user["firstname"];?>">
                            </div>

                            <div class="form-group">
                                <label for="user_edit_lastname"><?php language_filter("Last Name")?></label>
                                <input type="text" id="user_edit_lastname" name="lastname" class="form-control" required="required" value="<?php echo $user["lastname"];?>">
                            </div>

                            <div class="form-group">
                                <label for="user_edit_email"><?php language_filter("Email Address")?></label>
                                <input type="email" id="user_edit_email" name="email" class="form-control" required="required" value="<?php echo $user["email"];?>">
                            </div>

                            <div class="form-group">
                                <label for="user_edit_username"><?php language_filter("Username")?></label>
                                <input type="text" id="user_edit_username" name="username" class="form-control" required="required" value="<?php echo $user["username"];?>">
                            </div>

                            <div class="form-group">
                                <label><?php language_filter("New Password")?><small><?php language_filter("(Optional)")?></small></label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="send_pass" value="off" onclick="if(this.checked == true) this.value = 'send'; else this.value = 'off';"> <small><?php language_filter("Send username / password for user via email:")?></small>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="user_dir"><?php language_filter("Select User Folder")?> <button type="button" class="btn btn-default" onclick="showTree();"><?php language_filter("Site Map")?></button></label>
                                <input type="text" name="user_dir" class="form-control" id="user_dir" required="required" value="<?php echo $user["dir_path"];?>">
                            </div>

                            <div class="form-group">
                                <label for="user_edit_limit"><?php language_filter("Set Size Limitation (MB)")?></label>
                                <input type="text" id="user_edit_limit" name="limitation" id="limitation" class="form-control" required="required" value="<?php echo $user["limitation"];?>">
                            </div>

                            <div class="form-group" style="display: none;">
                                <label for="user_edit_upload"><?php language_filter("Set Upload Size Limitation (MB)")?></label>
                                <input type="text" id="user_edit_upload" name="upload_limitation" class="form-control" value="<?php echo $user["upload_limitation"];?>">
                            </div>

                            <div class="form-group" style="display: none;">
                                <label for="user_edit_deny"><?php language_filter("Deny Folders Or Files With Name")?></label>
                                <textarea rows="5" id="user_edit_deny" name="deny_name" class="form-control" placeholder="<?php language_filter("folder, folder2, file.txt, file2.txt")?>"><?php if(!empty($user["deny_folders"])) echo implode(", ", $user["deny_folders"]);?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php language_filter("Customize User Permissions")?></label><br />
                                <a href="#Permissions" role="button" class="btn btn-default" data-toggle="modal" style="text-decoration: none;"><?php language_filter("Select Permission")?></a>
                            </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                            <hr>
                            <input type="button" value="<?php language_filter("Save Changes")?>" class="btn btn-primary" onclick="check_and_send_user_info();">
                            <button class="btn btn-default" onclick="back_to_users()" style="margin-right: 20px;"><?php language_filter("Back")?></button>
                        </form>
                    </div>
                </div>
                </div>

                <div class="modal fade" id="Permissions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php language_filter("Choose User Permissions")?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table">

                                        <tr>
                                            <td><?php language_filter("Edit Profile")?></td>
                                            <td>
                                                <input type="checkbox" id="edit_profile" onclick="set_user_permissions(this.id)" <?php if(in_array("edit_profile", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Edit Settings</td>
                                            <td>
                                                <input type="checkbox" id="edit_settings" onclick="set_user_permissions(this.id)" onclick="set_user_permissions(this.id)" <?php if(in_array("edit_settings", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?php language_filter("Create Folder")?></td>
                                            <td>
                                                <input type="checkbox" id="create_folder" onclick="set_user_permissions(this.id)" <?php if(in_array("create_folder", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?php language_filter("Rename Files And Folders")?></td>
                                            <td>
                                                <input type="checkbox" id="rename_folder" onclick="set_user_permissions(this.id)" <?php if(in_array("rename_folder", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?php language_filter("Copy Files And Folders")?></td>
                                            <td>
                                                <input type="checkbox" id="copy_folders" onclick="set_user_permissions(this.id)" <?php if(in_array("copy_folders", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?php language_filter("Move Files And Folders")?></td>
                                            <td>
                                                <input type="checkbox" id="move_folders" onclick="set_user_permissions(this.id)" <?php if(in_array("move_folders", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?php language_filter("Remove Files And Folders")?></td>
                                            <td>
                                                <input type="checkbox" id="remove_folders" onclick="set_user_permissions(this.id)" <?php if(in_array("remove_folders", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <!--<tr>
                                            <td><?php /*language_filter("Create Zip From Files And Folders")*/?></td>
                                            <td>
                                                <input type="checkbox" id="zip_folders" onclick="set_user_permissions(this.id)" <?php /*if(in_array("zip_folders", $user["permissions"])) echo 'checked="checked"';*/?>>
                                            </td>
                                        </tr>-->

                                        <tr>
                                            <td><?php language_filter("Upload Files")?></td>
                                            <td>
                                                <input type="checkbox" id="upload_folders" onclick="set_user_permissions(this.id)" <?php if(in_array("upload_folders", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <!--<tr>
                                            <td><?php /*language_filter("Create Backup")*/?></td>
                                            <td>
                                                <input type="checkbox" id="backup_folders" onclick="set_user_permissions(this.id)" <?php /*if(in_array("backup_folders", $user["permissions"])) echo 'checked="checked"';*/?>>
                                            </td>
                                        </tr>-->

                                        <tr>
                                            <td><?php language_filter("Edit Text Files")?></td>
                                            <td>
                                                <input type="checkbox" id="edit_files" onclick="set_user_permissions(this.id)" <?php if(in_array("edit_files", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                        <!--<tr>
                                            <td><?php /*language_filter("Edit Images")*/?></td>
                                            <td>
                                                <input type="checkbox" id="edit_img" onclick="set_user_permissions(this.id)" <?php /*if(in_array("edit_img", $user["permissions"])) echo 'checked="checked"';*/?>>
                                            </td>
                                        </tr>-->

                                        <tr>
                                            <td><?php language_filter("Unzip Zip Files")?></td>
                                            <td>
                                                <input type="checkbox" id="unzip_files" onclick="set_user_permissions(this.id)" <?php if(in_array("unzip_files", $user["permissions"])) echo 'checked="checked"';?>>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" onclick="reset_perms()"><?php language_filter("Reset")?></button>
                                <button class="btn btn-primary" data-dismiss="modal"><?php language_filter("Apply")?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="siteMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php language_filter("Choose a specific folder for user")?></h4>
                            </div>
                            <div class="modal-body">
                                <p id="container_id"></p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" onclick="$('#user_dir').val('');"><?php language_filter("Cancel")?></button>
                                <button class="btn btn-primary" data-dismiss="modal"><?php language_filter("Select")?></button>
                            </div>
                        </div>
                    </div>
                </div>

            <script>
            userPermission = new Array(<?php if(!empty($user["permissions"])) {for($i = 0; $i < count($user["permissions"]); $i++){if($i == (count($user["permissions"]) - 1)) echo "'".$user["permissions"][$i]."'"; else echo "'".$user["permissions"][$i]."', "; } }?>); // send
            <?php
                if(count($user["permissions"]) == 1)
                {
                    echo 'userPermission = new Array(); userPermission.push(\''.$user["permissions"][0].'\');';
                }
            ?>
            userExtensions = new Array(<?php if(!empty($user["filemanager_ext"])) {for($i = 0; $i < count($user["filemanager_ext"]); $i++){if($i == (count($user["filemanager_ext"]) - 1)) echo "'".$user["filemanager_ext"][$i]."'"; else echo "'".$user["filemanager_ext"][$i]."', "; } }?>); // send
            <?php
            if(count($user["filemanager_ext"]) == 1)
            {
                echo 'userExtensions = new Array(); userExtensions.push(\''.$user["filemanager_ext"][0].'\');';
            }
            ?>
            userUploader = new Array(<?php if(!empty($user["uploader_ext"])) {for($i = 0; $i < count($user["uploader_ext"]); $i++){if($i == (count($user["uploader_ext"]) - 1)) echo "'".$user["uploader_ext"][$i]."'"; else echo "'".$user["uploader_ext"][$i]."', "; } }?>); // send
            <?php
            if(count($user["uploader_ext"]) == 1)
            {
                echo 'userUploader = new Array(); userUploader.push(\''.$user["uploader_ext"][0].'\');';
            }
            ?>
            selected_perms = userPermission;

            permissions = new Array(
                    "edit_profile",
                    "edit_settings",
                    "create_folder",
                    "rename_folder",
                    "copy_folders",
                    "move_folders",
                    "remove_folders",
                    "upload_folders",
                    "edit_files",
                    "unzip_files"
            );
            all_uploader = new Array(<?php for($i = 0; $i < count($allow_ext_uploader); $i++){if($i == (count($allow_ext_uploader) - 1)) echo "'".$allow_ext_uploader[$i]."'"; else echo "'".$allow_ext_uploader[$i]."', "; }?>);
            all_filemanager = new Array(<?php for($i = 0; $i < count($allow_ext_filemanager); $i++){if($i == (count($allow_ext_filemanager) - 1)) echo "'".$allow_ext_filemanager[$i]."'"; else echo "'".$allow_ext_filemanager[$i]."', "; }?>);
            function back_to_users()
            {
                $('#preloader').modal('show');
                $.post("ajax_show_users.php",
                {
                    showUser:'<?php echo $core->admin_id;?>',
                    page:'<?php echo $backPage?>'
                },
                function(data,status)
                {
                    if(status == "success")
                    {
                        $('#content_show').html('');
                        $('.bar').addClass('bar-success');
                        //$('li').removeClass();
                        $('#users').addClass('active');
                        $("#preloader").modal("hide");
                        $('#content_show').fadeIn(1000);
                        $('#content_show').html(data);
                    }
                    else
                    {
                        $('.bar').width("30%");
                        $('.bar').width("50%");
                        $('.bar').width("80%");
                        $('.bar').width("100%");
                        $('.bar').addClass('bar-danger');
                        $('.bar').html("<center>Can not load page, click to exit. SERVER STATUS: "+status+"</center>");
                    }
                });
            }
            function showTree()
            {
                $('#container_id').fileTree({
                    root: '<?php echo ROOT_DIR_NAME;?>/',
                    script: 'jqueryFileTree.php',
                    expandSpeed: 500,
                    collapseSpeed: 500,
                    multiFolder: false
                }, function(file) {
                    if(file == "..." || file == "..")
                    {
                        file = '../';
                    }
                    else
                    {
                        file = file.replace("<?php echo ROOT_DIR_NAME?>/", "../");
                    }
                    $("#user_dir").val(file);
                });
                $("#siteMap").modal("show");
            }
            function removeItem(array, item)
            {
                for(var i in array)
                {
                    if(array[i]==item)
                    {
                        array.splice(i,1);
                        break;
                    }
                }
            }
            function in_array(array, id)
            {
                for(var i=0;i<array.length;i++)
                {
                    if(array[i] === id)
                    {
                        return true;
                    }
                }
                return false;
            }
            function set_user_permissions(method)
            {
                if(method == "public")
                {
                    userPermission = new Array();
                }
                else if(method == "full")
                {
                    userPermission = permissions;
                }
                else
                {
                    if(!in_array(selected_perms, method))
                    {
                        selected_perms.push(method);
                    }
                    else
                    {
                        removeItem(selected_perms, method);
                    }
                    userPermission = selected_perms;
                }
            }
            function reset_perms()
            {
                userPermission = new Array();
                selected_perms = new Array();
                for(var i in permissions)
                {
                    document.getElementById(permissions[i]).checked = false;
                }
            }
            function check_and_send_user_info()
            {
                var firstname = document.forms["add_user_form"]["firstname"].value;
                var lastname = document.forms["add_user_form"]["lastname"].value;
                var email = document.forms["add_user_form"]["email"].value;
                var atpos = email.indexOf("@");
                var dotpos = email.lastIndexOf(".");
                var username = document.forms["add_user_form"]["username"].value;
                var password = document.forms["add_user_form"]["password"].value;
                var send_pass = document.forms["add_user_form"]["send_pass"].value;
                var user_dir = document.forms["add_user_form"]["user_dir"].value;
                var deny_files_folders = document.forms["add_user_form"]["deny_name"].value;
                var limitation = document.forms["add_user_form"]["limitation"].value;
                var upload_limitation = document.forms["add_user_form"]["upload_limitation"].value;
                if(firstname == "" || firstname == null)
                {
                    alert("<?php language_filter("Please write user first name.", false, true)?>");
                    return false;
                }
                if(lastname == "" || lastname == null)
                {
                    alert("<?php language_filter("Please write user last name.", false, true)?>");
                    return false;
                }
                if(email == "" || email == null)
                {
                    alert("<?php language_filter("Please write user email.", false, true)?>");
                    return false;
                }
                if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
                {
                    alert("<?php language_filter("Not a valid email address.", false, true)?>");
                    return false;
                }
                if(username == "" || username == null)
                {
                    alert("<?php language_filter("Please write username.", false, true)?>");
                    return false;
                }
                /*if(password == "" || password == null)
                {
                    alert("Please write user password.");
                    return false;
                }*/
                if(user_dir == "" || user_dir == null)
                {
                    user_dir = "../";
                }
                if(limitation == "" || limitation == null || limitation <= 0)
                {
                    limitation = 0;
                }

                check_user_email(username, email, firstname, lastname, password, send_pass, user_dir, limitation, upload_limitation, deny_files_folders);
            }
            function check_user_email(username, email, firstname, lastname, password, send_pass, user_dir, limitation, upload_limitation, deny_files_folders)
            {
                show_preloader();
                setTimeout(function(){
                    $.post("ajax_check_user.php",
                    {
                        username_check:username,
                        email_check:email,
                        dir_check:user_dir,
                        check_id:'<?php echo $userId?>'
                    },
                    function(data,status)
                    {
                        if(status == "success")
                        {
                            if(data == "done")
                            {
                                $.post("ajax_edit_user.php",
                                {
                                    editUser:'<?php echo $core->admin_id;?>',
                                    userId:'<?php echo $userId?>',
                                    backPage:'<?php echo $backPage?>',
                                    edit_username:username,
                                    edit_email:email,
                                    edit_firstname:firstname,
                                    edit_lastname:lastname,
                                    edit_password:password,
                                    edit_send_pass:send_pass,
                                    edit_user_dir:user_dir,
                                    edit_deny_files:deny_files_folders,
                                    edit_user_perm:userPermission,
                                    edit_user_ext:userExtensions,
                                    edit_user_up:userUploader,
                                    edit_limitation:limitation,
                                    edit_upload_limitation:upload_limitation
                                },
                                function(data,status)
                                {
                                    if(status == "success")
                                    {
                                        $('#content_show').html('');
                                        $('.bar').addClass('bar-success');
                                        //$('li').removeClass();
                                        $('#users').addClass('active');
                                        //$("#preloader").modal("hide");
                                        $('#content_show').fadeIn(1000);
                                        $('#content_show').html(data);
                                    }
                                    else
                                    {
                                        $('.bar').width("30%");
                                        $('.bar').width("50%");
                                        $('.bar').width("80%");
                                        $('.bar').width("100%");
                                        $('.bar').addClass('bar-danger');
                                        $('.bar').html("<center>Can not load page, click to exit. SERVER STATUS: "+status+"</center>");
                                    }
                                });
                            }
                            else if(data == "username")
                            {
                                show_errors_on_nav("<?php language_filter("Username already exists.", false, true)?>", "red");
                                return false;
                            }
                            else if(data == "email")
                            {
                                show_errors_on_nav("<?php language_filter("Email already exists.", false, true)?>", "red");
                                return false;
                            }
                            else
                            {
                                show_errors_on_nav("<?php language_filter("User directory not exists.", false, true)?>", "red");
                                return false;
                            }
                        }
                        else
                        {
                            $('.bar').width("30%");
                            $('.bar').width("50%");
                            $('.bar').width("80%");
                            $('.bar').width("100%");
                            $('.bar').addClass('bar-danger');
                            $('.bar').html("<center>Can not load page, click to exit. SERVER STATUS: "+status+"</center>");
                        }
                    });
                }, 1000);
            }
            function show_status_ext(msg, status)
            {
                if(msg != "")
                {
                    var color = "red";
                    if(status == 1)
                    {
                        color = "green";
                    }
                    show_errors_on_nav(msg, color);
                }
            }
            here = "../";
            </script>
<?php
                echo "<script>show_status_ext('".addslashes($result)."', ".$status.");</script>";
            }
        }
    }
}
?>