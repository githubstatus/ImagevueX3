<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    require_once 'option_class.php';
    require_once '../filemanager_assets/tickets_class.php';
    $core = new filemanager_user_core();
    $option = new option_class();
    $tickets_class = new tickets_class();
    require_once '../filemanager_language_user.php';
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if (isset($_POST["showTickets"]))
        {
            $core->userInfo();
            if ($_POST["showTickets"] == $core->user_id)
            {
                $show = $_POST["show_what"];
                $page = $_POST["ticket_page"];
                $settings = $option->get_option("settings");
                if($show == "new") $tickets = "";
                else $tickets = $tickets_class->get_tickets($show, $core->user_id);
?>
            <div class="container">
                <div class="row">
                    <?php
                    if($settings->ticket == "off")
                    {
                        echo '<div class="alert alert-info" style="text-align: center; font-weight: bold;">'.language_filter("Ticket_system_is_off", true).'</div>';
                        exit();
                    }
                    ?>
                    <div class="col-md-3">
                        <ul class="nav nav-pills nav-stacked well">
                            <li  <?php if($show == "all") echo 'class="active"';?>><a href="javascript:;" onclick="show_what = 'all'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-th-list"></i> <?php language_filter("All");?></a></li>
                            <li <?php if($show == "open") echo 'class="active"';?>><a href="javascript:;" onclick="show_what = 'open'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("Open")?></a></li>
                            <li <?php if($show == "close") echo 'class="active"';?>><a href="javascript:;" onclick="show_what = 'close'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("Closed")?></a></li>
                            <li <?php if($show == "reply") echo 'class="active"';?>><a href="javascript:;" onclick="show_what = 'reply'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("Replayed")?></a></li>
                            <li <?php if($show == "progress") echo 'class="active"';?>><a href="javascript:;" onclick="show_what = 'progress'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("In_progress")?></a></li>
                            <li <?php if($show == "new") echo 'class="active"';?>><a href="javascript:;" onclick="show_what = 'new'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-comment"></i> <?php language_filter("Create_new_ticket")?></a></li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php if($show != "new") language_filter("Tickets"); else language_filter("Create_new_ticket")?></h3>
                            </div>
                            <?php
                            if($tickets == "" and $show != "new")
                            {
                                echo '<div class="panel-body"><div class="alert alert-info" style="text-align: center; font-weight: bold;">'.language_filter("NO_TICKETS", true).'</div></div>';
                            }
                            else
                            {
                                if($show != "new")
                                {
                            ?>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#task-table" placeholder="<?php language_filter("Filter_task", false, true)?>" />
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="task-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php language_filter("Task");?></th>
                                        <th><?php language_filter("Assignee");?></th>
                                        <th><?php language_filter("Status");?></th>
                                        <th><?php language_filter("Date_added");?></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = count($tickets["id"]);
                                    $core->page($page, $count, 10);
                                    for($i = $core->start; $i < $core->end; $i++)
                                    {
                                    ?>
                                    <tr>
                                        <td><?php echo $tickets["id"][$i];?></td>
                                        <td><?php echo $tickets["subject"][$i]?></td>
                                        <td><?php echo $tickets["user"][$i]?></td>
                                        <td>
                                            <?php
                                            switch($tickets["status"][$i])
                                            {
                                                case "open":
                                                    echo '<span class="label label-primary">'.language_filter("Open", true).'</span>';
                                                break;

                                                case "close":
                                                    echo '<span class="label label-danger">'.language_filter("Closed", true).'</span>';
                                                break;

                                                case "reply":
                                                    echo '<span class="label label-success" style="border-radius: 2px;">'.language_filter("Replayed", true).'</span>';
                                                break;

                                                case "progress":
                                                    echo '<span class="label label-info">'.language_filter("In_progress", true).'</span>';
                                                break;

                                                default :
                                                    echo '<span class="label label-default">ERROR</span>';
                                                break;
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $tickets["dateAdded"][$i]?></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs" onclick="show_ticket('<?php echo $tickets["id"][$i]?>')"><span class="glyphicon glyphicon-eye-open"></span></button>
                                            <button type="button" class="btn btn-warning btn-xs" onclick="change_status_of_ticket('<?php echo $tickets["status"][$i];?>', '<?php echo $tickets["id"][$i]?>', 'first')"><span class="glyphicon glyphicon-cog"></span></button>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="remove_ticket('<?php echo $tickets["id"][$i]?>', 'first')"><span class="glyphicon glyphicon-trash"></span></button>
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
                            <center>
                                <ul class="pagination pagination-sm">
                                    <?php
                                        for ($i = 1; $i <= $core->pageCount; $i++)
                                        {
                                    ?>
                                    <li <?php if ($i == $page) echo "active"?>><a href="javascript:;" onclick="ticket_page = <?php echo $i;?>; showTickets();"><?php echo $i;?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </center>
                            <?php
                                    }
                                }
                            }

                            if($show == "new")
                            {
                                $users = $tickets_class->get_users_id();
                            ?>
                                <br />
                                <div class="col-md-12">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="ticket_subject"><?php language_filter("subject")?></label>
                                                    <input type="text" class="form-control" id="ticket_subject" placeholder="" required="required" />
                                                </div>
                                                <div class="form-group" style="display: none;">
                                                    <select id="ticket_user" name="ticket_user" class="form-control" required="required">
                                                        <option value="na"><?php language_filter("Choose_One");?></option>
                                                        <?php
                                                        echo '<option value="'.$core->user_id.'" selected="selected">'.$core->user_id.'</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">
                                                        <?php language_filter("Message");?>
                                                    </label>
                                                    <textarea name="ticket_message" id="ticket_message" class="form-control" rows="5" cols="25" required="required" placeholder="<?php language_filter("Message", false, true);?>"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" onclick="add_new_ticket();" class="btn btn-primary pull-right" id="btnContactUs">
                                                    <?php language_filter("Send Message")?>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <br />
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="ticket_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4><?php language_filter("Change_status_of_ticket");?></h4>
                        </div>
                        <div class="modal-body">
                            <p id="change_status_msg"></p>
                            <p>
                                <div class="form-group" id="reopen_message_box" style="display: none;">
                                    <label for="reopen_message"><?php language_filter("Message");?></label>
                                    <textarea class="form-control" rows="3" id="reopen_message"></textarea>
                                </div>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Close");?></button>
                            <button type="button" class="btn btn-primary" id="apply_change_status"><?php language_filter("Apply");?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="ticket_remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4><?php language_filter("ticket_remove_title");?></h4>
                        </div>
                        <div class="modal-body">
                            <p><?php language_filter("ticket_remove_msg");?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Close");?></button>
                            <button type="button" class="btn btn-primary" id="remove_ticket_btn"><?php language_filter("Apply");?></button>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript" src="../filemanager_js/filemanager.js"></script>
            <script>
                $(function () {
                    $('#myTab a:last').tab('show')
                });
                function remove_ticket(id, method)
                {
                    if(method == "first")
                    {
                        $("#remove_ticket_btn").attr("onclick", "remove_ticket('"+id+"', 'remove')");
                        $("#ticket_remove").modal('show');
                    }
                    else
                    {
                        $("#ticket_remove").modal('hide');
                        show_preloader();
                        setTimeout(function(){
                            $.post(
                            "ajax_manage_tickets.php",
                            {
                                method:"remove_ticket",
                                ticketId:id
                            },
                            function (data, status)
                            {
                                if(status == "success")
                                {
                                    if(data == "true")
                                    {
                                        show_errors_on_nav("<?php language_filter("ticket_remove_done", false, true);?>", "green");
                                        setTimeout(function(){showTickets();}, 1000);
                                        return true;
                                    }
                                    else
                                    {
                                        show_errors_on_nav("<?php language_filter("ticket_remove_error", false, true);?>", "red");
                                        return false;
                                    }
                                }
                                else
                                {
                                    alert("Server error");
                                    hide_preloader();
                                    return false;
                                }
                            }
                            );
                        }, 1000);
                    }
                }
                function change_status_of_ticket(status, id, method)
                {
                    if(method == 'first')
                    {
                        if(status == "close")
                        {
                            $("#change_status_msg").html('<?php language_filter("Do_you_want_to_reopen_this_ticket", false, true);?>');
                            $("#apply_change_status").attr("onclick", "change_status_of_ticket('"+status+"', '"+id+"', 'open')");
                            $("#reopen_message_box").show();
                            $("#reopen_message").val('');
                        }
                        else
                        {
                            $("#reopen_message_box").hide();
                            $("#change_status_msg").html('<?php language_filter("Do_you_want_to_close_this_ticket", false, true);?>');
                            $("#apply_change_status").attr("onclick", "change_status_of_ticket('"+status+"', '"+id+"', 'close')");
                        }
                        $("#ticket_status").modal('show');
                    }
                    else
                    {
                        var message = "";
                        if(method == "open")
                        {
                            message = $("#reopen_message").val();
                            if(message == "")
                            {
                                alert("<?php language_filter("Please_fill_the_fields.", false, true)?>");
                                return false;
                            }
                        }
                        $("#ticket_status").modal('hide');
                        $("#reopen_message_box").hide();
                        show_preloader();
                        setTimeout(function(){
                            $.post(
                                "ajax_manage_tickets.php",
                                {
                                    method:"change_status_of_ticket",
                                    ticketId:id,
                                    newStatus:method,
                                    userId:"<?php echo $core->user_id;?>",
                                    message:message
                                },
                                function (data, status)
                                {
                                    if(status == "success")
                                    {
                                        if(data == "true")
                                        {
                                            show_errors_on_nav("<?php language_filter("change_status_done", false, true);?>", "green");
                                            setTimeout(function(){showTickets();}, 1000);
                                            return true;
                                        }
                                        else
                                        {
                                            show_errors_on_nav("<?php language_filter("change_status_error", false, true);?>", "red");
                                            return false;
                                        }
                                    }
                                    else
                                    {
                                        alert("Server error");
                                        hide_preloader();
                                        return false;
                                    }
                                }
                            );
                        }, 1000);
                    }
                }
                function add_new_ticket()
                {
                    var subject = $("#ticket_subject").val();
                    var message = $("#ticket_message").val();
                    var user = $("#ticket_user").val();
                    console.log(user);
                    if(subject == '' || message == '')
                    {
                        alert("<?php language_filter("Please_fill_the_fields.", false, true);?>");
                        return false;
                    }
                    show_preloader();
                    setTimeout(function(){
                        $.post(
                            'ajax_manage_tickets.php',
                            {
                                subject:subject,
                                message:message,
                                user:user,
                                method:"user_create_ticket"
                            },
                            function (data, status)
                            {
                                if(status == "success")
                                {
                                    if(data == "email")
                                    {
                                        show_errors_on_nav("<?php language_filter("ticket_sent_error1", false, true);?>", "blue");
                                        return false;
                                    }
                                    else if(data == "true")
                                    {
                                        show_errors_on_nav("<?php language_filter("ticket_sent_done", false, true);?>", "green");
                                        return false;
                                    }
                                    else
                                    {
                                        show_errors_on_nav("<?php language_filter("ticket_sent_error2", false, true);?>", "red");
                                        return false;
                                    }
                                }
                                else
                                {
                                    alert("server error");
                                    hide_preloader();
                                    return false;
                                }
                            }
                        );
                    }, 1000);
                }
            </script>
<?php
            }
        }
    }
}
?>