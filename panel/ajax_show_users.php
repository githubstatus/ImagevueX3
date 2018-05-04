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
        if (isset($_POST["showUser"]) and $core->role == "admin")
        {
            $result = "";
            $status = 0;
            $core->adminInfo();
            if ($_POST["showUser"] == $core->admin_id)
            {

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

                if(isset($_POST["block_user"]))
                {
                    if($core->block_user($_POST["block_user"], $_POST["block_method"]))
                    {
                        if($_POST["block_method"] == 0)
                        {
                            $status = 1;
                            $result = language_filter("User has been blocked.", true);
                        }
                        else
                        {
                            $status = 1;
                            $result = language_filter("User has been unblocked.", true);
                        }
                    }
                    else
                    {
                        if($_POST["block_method"] == 0)
                        {
                            $result = language_filter("User has not been blocked.", true);
                        }
                        else
                        {
                            $result = language_filter("User has not been unblocked.", true);
                        }
                    }
                }
                if(isset($_POST["remove_user"]))
                {
                    if($core->delete_user($_POST["remove_user"]))
                    {
                        $status = 1;
                        $result = language_filter("User has been removed.", true);
                    }
                    else
                    {
                        $result = language_filter("User has not been removed.", true);
                    }
                }


                $users = $core->get_users();
                if($users == "")
                {
                    $page = 1;
                    echo '<div class="alert alert-info" style="text-align: center">'.language_filter("NO USERS", true).' | <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addNewUser">'.language_filter("Add User", true).'</button></div>';
                    if(isset($_POST["remove_user"]))
                    {
                        ?>
                             <script>
                                 function show_status_ext_end(msg, status)
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
                             </script>
                        <?php
                        echo "<script>show_status_ext_end('".addslashes($result)."', ".$status.");</script>";
                    }
                }
                else
                {
                    $count = isset($users["id"]) ? count($users["id"]) : 0;
                    if(isset($_POST["page"]))
                    {
                        $page = $_POST["page"];
                    }
                    else
                    {
                        $page = 1;
                    }
                    $core->page($page, $count, 10);
?>
                    <div class="container-fluid x3-users">
                        <div class="row">
                            <div class="col-md-6">
                                <h3><?php language_filter("Users")?></h3>
                            </div>
                            <div class="col-md-6">
                                <button style="margin-top: 20px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addNewUser"><?php language_filter("Add User")?></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="margin-top: 10px;">
                                <thead>
                                <tr>
                                    <th><?php language_filter("Full_Name");?></th>
                                    <th><?php language_filter("Username");?></th>
                                    <th><?php language_filter("Email");?></th>
                                    <th><?php language_filter("Used Size");?></th>
                                    <th><?php language_filter("Extra");?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = $core->start; $i < $core->end; $i++)
                                    {
                                        ?>
                                    <tr <?php if($users["is_block"][$i] == 1) echo 'class="danger"';?>>
                                        <td><?php echo $users["firstname"][$i]." ".$users["lastname"][$i];?></td>
                                        <td><?php echo $users["username"][$i];?></td>
                                        <td><?php echo $users["email"][$i];?></td>
                                        <td style="width: 30%">
                                            <?php
                                            if($users["user_limit"][$i] == 0 or $users["user_limit"][$i] == 1000000000)
                                            {
                                            ?>
                                                NO LIMITS
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                <div class="progress progress-striped">
                                                    <div class="progress-bar <?php if($users["limitation"][$i] < 50) echo 'progress-bar-success'; elseif($users["limitation"][$i] > 50 and $users["limitation"][$i] < 90) echo 'progress-bar-warning'; else{ echo 'progress-bar-danger'; }?>" role="progressbar" aria-valuenow="<?php echo $users["limitation"][$i];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $users["limitation"][$i];?>%">
                                                        <span class="" style="color: #000;"><?php if($users["limitation"][$i] < 100) echo intval($users["limitation"][$i])."%"; else echo '100%';?></span>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center">
                                            <div class="tn-group btn-group-xs">
                                                <button type="button" onclick="edit_user('<?php echo $users["id"][$i]?>');" class="btn btn-default tip" data-toggle="tooltip" data-placement="top" title="<?php language_filter("Edit");?>"><span class="glyphicon glyphicon-edit"></span></button>
                                                <button type="button" onclick="block_user('<?php echo $users["id"][$i];?>', '<?php echo $users["is_block"][$i];?>','alert');" class="btn btn-default tip" data-toggle="tooltip" data-placement="top" title="<?php if($users["is_block"][$i] == 0) language_filter("Block"); else language_filter("Unblock");?>"><span class="glyphicon <?php if($users["is_block"][$i] == 0) echo 'glyphicon-ban-circle'; else echo 'glyphicon-retweet';?>"></span></button>
                                                <button type="button" onclick="remove_user('<?php echo $users["id"][$i];?>', 'alert');" class="btn btn-default tip" data-toggle="tooltip" data-placement="top" title="<?php language_filter("Remove");?>"><span class="glyphicon glyphicon-remove-circle"></span></button>
                                                <button type="button" onclick="showTree('<?php echo addslashes($users["dir_path"][$i]);?>')" class="btn btn-default tip" data-toggle="tooltip" data-placement="top" title="<?php language_filter("User Folder");?>"><span class="glyphicon glyphicon-folder-open"></span></button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-xs"><?php language_filter("More_info");?></button>
                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="javascript:;" onclick="show_user_profile('<?php echo addslashes($users["firstname"][$i]." ".$users["lastname"][$i]);?>', '<?php echo addslashes($users["username"][$i]);?>', '<?php echo addslashes($users["email"][$i]);?>', '<?php echo addslashes($users["dir_path"][$i])?>' , '<?php echo addslashes($users["date_added"][$i])?>');"><?php language_filter("User Profile")?></a></li>
                                                    <li><a href="javascript:;" onclick="show_user_permissions('<?php echo implode(", ", $users["permissions"][$i]);?>');"><?php language_filter("User Permissions")?></a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                        <?php
                        if($core->pageCount != 1)
                        {
                            ?>
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-xs">
                                    <?php
                                    for ($i = 1; $i <= $core->pageCount; $i++)
                                    {
                                        ?>
                                        <button type="button" class="btn btn-default <?php if ($i == $page) echo "active"?>" onclick="change_page('<?php echo $i?>');"><?php echo $i;?></button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
<?php
                }
                global $ALLOW_EXTENSIONS;
                global $ALLOW_UPLOADER;
                $allow_ext_filemanager = $ALLOW_EXTENSIONS;
                $allow_ext_uploader = $ALLOW_UPLOADER;
?>

            <!-- Add User -->
            <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><?php language_filter("Add User");?></h4>
                        </div>
                        <div class="modal-body">
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
                                    <label for="user_dir"><?php language_filter("Select User Folder")?> <button type="button" class="btn btn-default" onclick="showTree_2()"><?php language_filter("Site Map")?></button></label>
                                    <input type="text" name="user_dir" class="form-control" id="user_dir" value="../" required="required">
                                </div>

                                <div class="form-group">
                                    <label for="limitation"><?php language_filter("Set Size Limitation (MB)")?></label>
                                    <input type="text" name="limitation" id="limitation" value="0" class="form-control" required="required">
                                </div>

                                <!--<div class="form-group">
                            <label for="upload_limitation"><?php /*language_filter("Set Upload Size Limitation (MB)")*/?></label>-->
                                <input type="hidden" name="upload_limitation" id="upload_limitation" value="0" class="form-control">
                                <!--</div>-->

                                <div class="form-group" style="display: none;">
                                    <label for="deny_name_user"><?php language_filter("Deny Folders Or Files With Name")?></label>
                                    <textarea rows="5" id="deny_name_user" name="deny_name" class="form-control" placeholder="<?php language_filter("folder, folder2, file.txt, file2.txt")?>"></textarea>
                                </div>

                                <div class="form-group">
                                    <label><?php language_filter("Set User Permissions")?></label> <br />
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel")?></button>
                            <input type="button" value="<?php language_filter("Add")?>" class="btn btn-primary pull-right" onclick="check_and_send_user_info();">
                        </div>
                    </div>
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
                                        <td>Edit Settings</td>
                                        <td>
                                            <input type="checkbox" id="edit_settings" onclick="set_user_permissions(this.id)">
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

                                    <!--<tr>
                                        <td><?php /*language_filter("Create Zip From Files And Folders")*/?></td>
                                        <td>
                                            <input type="checkbox" id="zip_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>-->

                                    <tr>
                                        <td><?php language_filter("Upload Files")?></td>
                                        <td>
                                            <input type="checkbox" id="upload_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <!--<tr>
                                        <td><?php /*language_filter("Create Backup User")*/?></td>
                                        <td>
                                            <input type="checkbox" id="backup_folders" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>-->

                                    <tr>
                                        <td><?php language_filter("Edit Text Files")?></td>
                                        <td>
                                            <input type="checkbox" id="edit_files" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>

                                    <!--<tr>
                                        <td><?php /*language_filter("Edit Images")*/?></td>
                                        <td>
                                            <input type="checkbox" id="edit_img" onclick="set_user_permissions(this.id)">
                                        </td>
                                    </tr>-->

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

            <div class="modal fade" id="siteMap_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><?php language_filter("Choose a specific folder for user")?></h4>
                        </div>
                        <div class="modal-body">
                            <p id="container_id_2"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#user_dir').val('../');"><?php language_filter("Cancel")?></button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><?php language_filter("Select")?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Add User -->

            <div class="modal fade" id="siteMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><?php language_filter("User Files And Folders")?></h4>
                        </div>
                        <div class="modal-body">
                            <p id="container_id"></p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php language_filter("Cancel")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="alerts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="alert_head"></h4>
                        </div>
                        <div class="modal-body">
                            <p id="alert_body"></p>
                        </div>
                        <div class="modal-footer" id="alert_footer">
                        </div>
                    </div>
                </div>
            </div>

                <script type="text/javascript">
                    $('.tip').tooltip();
                    function showTree(path)
                    {
                        $('#container_id').fileTree({
                            root: path,
                            script: 'jqueryFileTree.php',
                            expandSpeed: 500,
                            collapseSpeed: 500,
                            multiFolder: false
                        }, function(file) {
                            // NOTHING
                        });
                        $("#siteMap").modal('show');
                    }
                    function change_page(page_go)
                    {
                        $('#preloader').modal('show');
                        $.post("ajax_show_users.php",
                        {
                            showUser:'<?php echo $core->admin_id;?>',
                            page:page_go
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
                    function block_user(user_id, method, time)
                    {
                        if(time == "alert")
                        {
                            if(method == 0)
                            {
                                $("#alert_head").html('<?php language_filter("Block User", false, true);?>');
                                $("#alert_body").html('<?php language_filter("Do you want to block this user", false, true);?>');
                                $("#alert_footer").html('<button class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel", false, true)?></button>');
                                $("#alert_footer").html($("#alert_footer").html()+'<button class="btn btn-warning" onclick="block_user(\''+user_id+'\', \''+method+'\', \'go\')"><?php language_filter("Block", false, true)?></button>');
                            }
                            else
                            {
                                $("#alert_head").html('<?php language_filter("Unblock User", false, true)?>');
                                $("#alert_body").html('<?php language_filter("Do you want to unblock this user", false, true)?>');
                                $("#alert_footer").html('<button class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel", false, true)?></button>');
                                $("#alert_footer").html($("#alert_footer").html()+'<button class="btn btn-warning" onclick="block_user(\''+user_id+'\', \''+method+'\', \'go\')"><?php language_filter("Unblock", false, true)?></button>');
                            }
                            $("#alerts").modal('show');
                        }
                        else
                        {
                            $("#alerts").modal('hide');
                            show_preloader();
                            setTimeout(function(){
                                $.post("ajax_show_users.php",
                                {
                                    showUser:'<?php echo $core->admin_id;?>',
                                    page:'<?php echo $page?>',
                                    block_user:user_id,
                                    block_method:method
                                },
                                function(data,status)
                                {
                                    if(status == "success")
                                    {
                                        $('#content_show').html('');
                                        $('.bar').addClass('bar-success');
                                        //$('li').removeClass();
                                        $('#users').addClass('active');
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
                            }, 1000);
                        }
                    }
                    function remove_user(user_id, time)
                    {
                        if(time == 'alert')
                        {
                            $("#alert_head").html('<?php language_filter("Remove User", false, true)?>');
                            $("#alert_body").html('<?php language_filter("Do you want to remove this user", false, true)?>');
                            $("#alert_footer").html('<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php language_filter("Cancel", false, true)?></button>');
                            $("#alert_footer").html($("#alert_footer").html()+'<button class="btn btn-danger" onclick="remove_user(\''+user_id+'\', \'go\')"><?php language_filter("Remove", false, true)?></button>');
                            $("#alerts").modal('show');
                        }
                        else
                        {
                            $("#alerts").modal('hide');
                            //$('#preloader').modal('show');
                            show_preloader();
                            setTimeout(function(){
                                $.post("ajax_show_users.php",
                                {
                                    showUser:'<?php echo $core->admin_id;?>',
                                    page:'<?php echo $page;?>',
                                    remove_user:user_id
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
                            }, 1000);
                        }
                    }

                    function show_user_permissions(value)
                    {
                        $("#alert_head").html('<?php language_filter("User Permissions", false, true)?>');
                        if(value != "")
                            $("#alert_body").html('<div class="alert alert-info">'+value+'</div>');
                        else
                            $("#alert_body").html('<div class="alert alert-info" style="text-align: center"><?php language_filter("Public User", false, true)?></div>');
                        $("#alert_footer").html('<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php language_filter("Cancel", false, true)?></button>');
                        $("#alerts").modal('show');
                    }
                    function show_user_profile(fullname, username, email, dir, date)
                    {
                        if(dir == "<?php echo ROOT_DIR_NAME."/";?>")
                        {
                            dir = "<?php echo language_filter("ROOT", false, true);?>";
                        }
                        else
                        {
                            dir = dir.replace("<?php echo ROOT_DIR_NAME?>/", "../");
                        }
                        $("#alert_head").html('<?php language_filter("User Profile", false, true)?>');
                        $("#alert_body").html('<p><b><?php language_filter("Full Name", false, true)?> </b>'+fullname+'</p> <p><b><?php language_filter("Username", false, true)?>: </b>'+username+'</p> <p><b><?php language_filter("Email", false, true)?>: </b>'+email+'</p> <p><b><?php language_filter("User Directory", false, true)?>: </b>'+dir+'</p> <p><b><?php language_filter("Date Registration", false, true)?>: </b>'+date+'</p>');
                        $("#alert_footer").html('<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php language_filter("Cancel", false, true)?></button>');
                        $("#alerts").modal('show');
                    }

                    function edit_user(user_id)
                    {
                        $('#preloader').modal('show');
                        $.post("ajax_edit_user.php",
                        {
                            editUser:'<?php echo $core->admin_id;?>',
                            backPage:'<?php echo $page;?>',
                            userId:user_id
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



                    /* Add User */

                    userPermission = new Array(); // send
                    selected_perms = new Array();
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
                    userUploader = all_uploader;
                    userExtensions = all_filemanager;
                    function showTree_2()
                    {
                        $('#container_id_2').fileTree({
                            root: '<?php echo ROOT_DIR_NAME?>/',
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
                        $("#siteMap_2").modal("show");
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
                        $("#Permissions").modal("hide");
                        $("#siteMap_2").modal("hide");
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
                        $("#addNewUser").modal('hide');
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
                                        $.post("ajax_show_users.php",
                                        {
                                            showUser:'<?php echo $core->admin_id;?>',
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
                                    else if(data == "username")
                                    {
                                        show_errors_on_nav("<?php language_filter("Username already exists.", false, true)?>", "red");
                                        setTimeout(function(){
                                            $("#addNewUser").modal('show');
                                        }, 1000);
                                        return false;
                                    }
                                    else if(data == "email")
                                    {
                                        show_errors_on_nav("<?php language_filter("Email already exists.", false, true)?>", "red");
                                        setTimeout(function(){
                                            $("#addNewUser").modal('show');
                                        }, 1000);
                                        return false;
                                    }
                                    else
                                    {
                                        show_errors_on_nav("<?php language_filter("User directory not exists.", false, true)?>", "red");
                                        setTimeout(function(){
                                            $("#addNewUser").modal('show');
                                        }, 1000);
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

                    /* End Add User */

                    here = "<?php echo ROOT_DIR_NAME."/";?>";
                </script>

<?php
                echo "<script>show_status_ext('".addslashes($result)."', ".$status.");</script>";
            }

        }

    }
}
