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
        if (isset($_POST["showAddUser"]))
        {
            $result = "";
            $status = 0;
            if(isset($_POST["add_username"]) and isset($_POST["add_email"]))
            {
                $username = $_POST["add_username"];
                $email = $_POST["add_email"];
                $firstname = $_POST["add_firstname"];
                $lastname = $_POST["add_lastname"];
                $password = $_POST["add_password"];
                $send_pass = $_POST["add_send_pass"];
                $user_dir = $_POST["add_user_dir"];
                $limitation = $_POST["add_limitation"];
                $upload_limitation = $_POST["add_upload_limitation"];
                $deny_files = $_POST["add_deny_files"];
                $user_perm = array();
                if(isset($_POST["add_user_perm"]))
                    $user_perm = $_POST["add_user_perm"];
                $user_ext = $_POST["add_user_ext"];
                $user_up = array();
                if(isset($_POST["add_user_up"]))
                    $user_up = $_POST["add_user_up"];
                $add = $core->add_new_user($username, $email, $firstname, $lastname, $password, $send_pass, $user_dir, $limitation, $upload_limitation, $deny_files, $user_perm, $user_ext, $user_up);
                if($add == true)
                {
                    $result = language_filter("User has been added.", true);
                    $status = 1;
                }
                else if($add == null)
                {
                    $result = language_filter("User has been added but can not send email to user.", true);
                    $status = 1;
                }
                else
                {
                    $result = language_filter("User has not been added.", true);
                }
            }
            $core->adminInfo();
            if ($_POST["showAddUser"] == $core->admin_id)
            {
                $allow_ext_filemanager = $option->get_option("allow_extensions");
                $allow_ext_uploader = $option->get_option("allow_uploads");
?>
            <div class="row">

                <div class="col-md-4">
                <div class="panel panel-danger">
                    <div class="panel-body">
                    <p class="text-success"><?php language_filter("Account Setting")?></p>
                    <form action="javascript:;" method="post" name="add_user_form">

                        <div class="form-group">
                            <label for="firstname_user"><?php language_filter("First Name");?></label>
                            <input type="text" id="firstname_user" name="firstname" class="form-control" required="required">
                        </div>

                        <div class="form-group">
                            <label for="lastname_user"><?php language_filter("Last Name");?></label>
                            <input type="text" name="lastname" id="lastname_user" class="form-control" required="required">
                        </div>

                        <div class="form-group">
                            <label for="email_user"><?php language_filter("Email Address")?></label>
                            <input type="email" id="email_user" name="email" class="form-control" required="required">
                        </div>

                        <div class="form-group">
                            <label for="username_user"><?php language_filter("Username")?></label>
                            <input type="text" id="username_user" name="username" class="form-control" required="required">
                        </div>

                        <div class="form-group">
                            <label for="password_user"><?php language_filter("Password")?></label>
                            <input type="password" id="password_user" name="password" class="form-control" required="required">
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="send_pass" value="off" onclick="if(this.checked == true) this.value = 'send'; else this.value = 'off';"> <small><?php language_filter("Send username / password for user via email:")?></small>
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="user_dir"><?php language_filter("Select User Folder")?> <button type="button" class="btn btn-default" onclick="showTree()"><?php language_filter("Site Map")?></button></label>
                            <input type="text" name="user_dir" class="form-control" id="user_dir" required="required">
                        </div>

                        <div class="form-group">
                            <label for="limitation"><?php language_filter("Set Size Limitation (MB)")?></label>
                            <input type="text" name="limitation" id="limitation" class="form-control" required="required">
                        </div>

                        <div class="form-group">
                            <label for="upload_limitation"><?php language_filter("Set Upload Size Limitation (MB)")?></label>
                            <input type="text" name="upload_limitation" id="upload_limitation" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="deny_name_user"><?php language_filter("Deny Folders Or Files With Name")?></label>
                            <textarea rows="5" id="deny_name_user" name="deny_name" class="form-control" placeholder="<?php language_filter("folder, folder2, file.txt, file2.txt")?>"></textarea>
                        </div>

                        <div class="form-group">
                            <label><?php language_filter("Set User Permissions")?></label>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default" onclick="set_user_permissions('public');">
                                    <input type="radio" name="options" id="option1"><?php language_filter("Public")?>
                                </label>
                                <label class="btn btn-default" onclick="set_user_permissions('full');">
                                    <input type="radio" name="options" id="option2"><?php language_filter("Full")?>
                                </label>
                                <label class="btn btn-default" onclick="$('#Permissions').modal('show')">
                                    <input type="radio" name="options" id="option3" ><?php language_filter("Customization")?>
                                </label>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="col-md-4">
                <div class="panel panel-danger">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <p class="text-success"><?php language_filter("Allowed extensions for user in file manager")?></p>
                                <tr>
                                    <th style="text-align: center"><?php language_filter("Format")?></th>
                                    <th style="text-align: center">
                                        <button type="button" class="btn btn-default btn-xs select-btn-filemanager" id="select_manager" onclick="select_all_ext('manager_')"><?php language_filter("Select All")?></button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i = 0; $i < count($allow_ext_filemanager); $i++)
                                    {
                                        ?>
                                            <tr>
                                                <td style="text-align: center"><?php echo $allow_ext_filemanager[$i];?></td>
                                                <td style="text-align: center">
                                                    <input type="checkbox" id="manager_<?php echo $allow_ext_filemanager[$i];?>" onclick="set_filemanager_ext('<?php echo $allow_ext_filemanager[$i];?>')">
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>

                <div class="col-md-4" >
                <div class="panel panel-danger">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <p class="text-success"><?php language_filter("Allowed extensions for user in uploader");?></p>
                                <tr>
                                    <th style="text-align: center"><?php language_filter("Format")?></th>
                                    <th style="text-align: center">
                                        <button type="button" class="btn btn-default btn-xs select-btn-filemanager" id="select_uploader" onclick="select_all_ext('uploader_')"><?php language_filter("Select All")?></button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i = 0; $i < count($allow_ext_uploader); $i++)
                                    {
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $allow_ext_uploader[$i];?></td>
                                        <td style="text-align: center">
                                            <input type="checkbox" id="uploader_<?php echo $allow_ext_uploader[$i];?>" onclick="set_uploader_ext('<?php echo $allow_ext_uploader[$i];?>');">
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                    <input type="button" value="<?php language_filter("Add")?>" class="btn btn-primary pull-right" onclick="check_and_send_user_info();">
                    </form>
                </div>
            </div>

            <div class="modal fade" id="Permissions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><?php language_filter("Choose User Permission")?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <td><?php language_filter("Edit Profile User")?></td>
                                        <td>
                                            <input type="checkbox" id="edit_profile" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Create Folder")?></td>
                                        <td>
                                            <input type="checkbox" id="create_folder" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Rename Files And Folders")?></td>
                                        <td>
                                            <input type="checkbox" id="rename_folder" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Copy Files And Folders");?></td>
                                        <td>
                                            <input type="checkbox" id="copy_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Move Files And Folders")?></td>
                                        <td>
                                            <input type="checkbox" id="move_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Remove Files And Folders")?></td>
                                        <td>
                                            <input type="checkbox" id="remove_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Create Zip From Files And Folders")?></td>
                                        <td>
                                            <input type="checkbox" id="zip_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Upload Files")?></td>
                                        <td>
                                            <input type="checkbox" id="upload_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Create Backup User")?></td>
                                        <td>
                                            <input type="checkbox" id="backup_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Edit Text Files")?></td>
                                        <td>
                                            <input type="checkbox" id="edit_files" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Edit Images")?></td>
                                        <td>
                                            <input type="checkbox" id="edit_img" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php language_filter("Unzip Zip Files")?></td>
                                        <td>
                                            <input type="checkbox" id="unzip_files" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reset_perms()"><?php language_filter("Reset")?></button>
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
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#user_dir').val('');"><?php language_filter("Cancel")?></button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><?php language_filter("Select")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                userPermission = new Array(); // send
                userExtensions = new Array(); // send
                userUploader = new Array(); // send
                selected_perms = new Array();
                permissions = new Array(
                        "edit_profile",
                        "create_folder",
                        "rename_folder",
                        "copy_folders",
                        "move_folders",
                        "remove_folders",
                        "zip_folders",
                        "upload_folders",
                        "backup_folders",
                        "edit_files",
                        "edit_img",
                        "unzip_files"
                );
                all_uploader = new Array(<?php for($i = 0; $i < count($allow_ext_uploader); $i++){if($i == (count($allow_ext_uploader) - 1)) echo "'".$allow_ext_uploader[$i]."'"; else echo "'".$allow_ext_uploader[$i]."', "; }?>);
                all_filemanager = new Array(<?php for($i = 0; $i < count($allow_ext_filemanager); $i++){if($i == (count($allow_ext_filemanager) - 1)) echo "'".$allow_ext_filemanager[$i]."'"; else echo "'".$allow_ext_filemanager[$i]."', "; }?>);
                function showTree()
                {
                    $('#container_id').fileTree({
                        root: '../',
                        script: 'jqueryFileTree.php',
                        expandSpeed: 500,
                        collapseSpeed: 500,
                        multiFolder: false
                    }, function(file) {
                        if(file == "..") file = "../";
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
                function set_filemanager_ext(ext)
                {
                    if(!in_array(userExtensions, ext))
                    {
                        userExtensions.push(ext);
                    }
                    else
                    {
                        removeItem(userExtensions, ext);
                    }
                }
                function set_uploader_ext(ext)
                {
                    if(!in_array(userUploader, ext))
                    {
                        userUploader.push(ext);
                    }
                    else
                    {
                        removeItem(userUploader, ext);
                    }
                }
                function select_all_ext(method)
                {
                    if(method == "uploader_")
                    {
                        var select_method = $("#select_uploader").html();
                        if(select_method == "<?php language_filter("Select All")?>")
                        {
                            for(var i in all_uploader)
                            {
                                document.getElementById(method+all_uploader[i]).checked = true;
                            }
                            userUploader = all_uploader;
                            $("#select_uploader").html("<?php language_filter("Unselect All")?>");
                        }
                        else
                        {
                            for(var i in all_uploader)
                            {
                                document.getElementById(method+all_uploader[i]).checked = false;
                            }
                            userUploader = new Array();
                            $("#select_uploader").html("<?php language_filter("Select All")?>");
                        }
                    }
                    else
                    {
                        var select_method = $("#select_manager").html();
                        if(select_method == "<?php language_filter("Select All")?>")
                        {
                            for(var i in all_filemanager)
                            {
                                document.getElementById(method+all_filemanager[i]).checked = true;
                            }
                            userExtensions = all_filemanager;
                            $("#select_manager").html("<?php language_filter("Unselect All")?>");
                        }
                        else
                        {
                            for(var i in all_filemanager)
                            {
                                document.getElementById(method+all_filemanager[i]).checked = false;
                            }
                            userExtensions = new Array();
                            $("#select_manager").html("<?php language_filter("Select All")?>");
                        }
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
                    if(password == "" || password == null)
                    {
                        alert("<?php language_filter("Please write user password.", false, true)?>");
                        return false;
                    }
                    if(user_dir == "" || user_dir == null)
                    {
                        alert("<?php language_filter("Please select a directory for user.", false, true)?>");
                        return false;
                    }
                    if(limitation == "" || limitation == null || limitation <= 0)
                    {
                        alert("<?php language_filter("Please write limitation size.", false, true)?>");
                        return false;
                    }
                    if(userExtensions.length <= 0)
                    {
                        alert("<?php language_filter("Please select file manager extensions for user.", false, true)?>");
                        return false;
                    }
                    if(in_array(userPermission, "upload_folders"))
                    {
                        if(userUploader.length <= 0)
                        {
                            alert("<?php language_filter("Please select uploader extensions for user.", false, true)?>");
                            return false;
                        }

                        if(upload_limitation == '' || upload_limitation == null || upload_limitation <= 0)
                        {
                            alert("<?php language_filter("Please write upload limitation size", false, true)?>");
                            return false;
                        }
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
                            dir_check:user_dir
                        },
                        function(data,status)
                        {
                            if(status == "success")
                            {
                                if(data == "done")
                                {
                                    $.post("ajax_add_user.php",
                                    {
                                        showAddUser:'<?php echo $core->admin_id;?>',
                                        add_username:username,
                                        add_email:email,
                                        add_firstname:firstname,
                                        add_lastname:lastname,
                                        add_password:password,
                                        add_send_pass:send_pass,
                                        add_user_dir:user_dir,
                                        add_deny_files:deny_files_folders,
                                        add_user_perm:userPermission,
                                        add_user_ext:userExtensions,
                                        add_user_up:userUploader,
                                        add_limitation:limitation,
                                        add_upload_limitation:upload_limitation
                                    },
                                    function(data,status)
                                    {
                                        if(status == "success")
                                        {
                                            $('#content_show').html('');
                                            $('.bar').addClass('bar-success');
                                            //$('li').removeClass();
                                            $('#addUser').addClass('active');
                                            //hide_preloader();
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