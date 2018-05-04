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
        if (isset($_POST["showTicket"]))
        {
            $core->userInfo();
            if ($_POST["showTicket"] == $core->user_id)
            {
                $settings = $option->get_option("settings");
                $ticketId = $_POST["ticketId"];
                $show = $_POST["show_what"];
                $page = $_POST["ticket_page"];
                $ticket_info = $tickets_class->get_ticket($ticketId);
                $tickets_class->user_role_info = $core->user_firstname." ".$core->user_lastname;
                $tickets_class->user_gravatar = $tickets_class->get_gravatar_src($core->user_email);

?>
<div class="container">
    <div class="row">
        <?php
        if($settings->ticket == "off" or $tickets_class->ticket_user_id != $core->user_id)
        {
            echo '<div class="alert alert-info" style="text-align: center; font-weight: bold;">'.language_filter("Ticket_system_is_off", true).'</div>';
            exit();
        }
        ?>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php language_filter("subject");?>: <b><?php echo $ticket_info["base"]["subject"];?></b><br /><br />
                        <?php language_filter("Status");?>: <b>
                        <?php
                        switch($ticket_info["base"]["status"])
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
                        </b>
                    </h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="javascript:;" onclick="$('#ticket_reply').modal('show');"><i class="glyphicon glyphicon-comment"></i> <?php language_filter("Reply");?></a></li>
                        <li><a href="javascript:;" onclick="change_status_of_ticket('<?php echo $ticket_info["base"]["status"];?>', '<?php echo $ticketId?>', 'first')"><i class="glyphicon glyphicon-pencil" style="margin-right: 3px;"></i><?php language_filter("Change_status_of_ticket");?></a></li>
                        <li><a href="javascript:;" onclick="remove_ticket('<?php echo $ticketId;?>', 'first')"><i class="glyphicon glyphicon-trash" style="margin-right: 3px;"></i><?php language_filter("ticket_remove_title");?></a></li>
                        <li><a href="javascript:;" onclick="showTickets();"><i class="glyphicon glyphicon-chevron-left"></i> <?php language_filter("Back");?></a></li>
                        <hr />
                        <li><a href="javascript:;" onclick="show_what = 'all'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-th-list"></i> <?php language_filter("All");?></a></li>
                        <li><a href="javascript:;" onclick="show_what = 'open'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("Open")?></a></li>
                        <li><a href="javascript:;" onclick="show_what = 'close'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("Closed")?></a></li>
                        <li><a href="javascript:;" onclick="show_what = 'reply'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("Replayed")?></a></li>
                        <li><a href="javascript:;" onclick="show_what = 'process'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-filter"></i> <?php language_filter("In_progress")?></a></li>
                        <li><a href="javascript:;" onclick="show_what = 'new'; ticket_page = 1; showTickets();"><i class="glyphicon glyphicon-comment"></i> <?php language_filter("Create_new_ticket")?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <ul class="timeline">
                <li>
                    <div class="timeline-badge">
                        <?php
                        if($ticket_info["base"]["adminTicket"] == 1)
                        {
                            if($tickets_class->admin_gravatar == "http://www.gravatar.com/avatar/")
                            {
                                $tickets_class->set_admin_role_info();
                            }
                            echo '<img class="img-circle" style="margin-top: -5px;" src="'.$tickets_class->admin_gravatar.'" />';
                        }
                        else
                        {
                            echo '<img class="img-circle" style="margin-top: -5px;" src="'.$tickets_class->user_gravatar.'" />';
                        }
                        ?>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">
                            <?php
                            if($ticket_info["base"]["adminTicket"] == 1)
                            {
                                if($tickets_class->admin_role_info == "")
                                {
                                    $tickets_class->set_admin_role_info();
                                }
                                echo $tickets_class->admin_role_info;
                            }
                            else
                            {
                                echo $tickets_class->user_role_info;
                            }
                            ?>
                            </h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo $ticket_info["base"]["dateAdded"];?></small></p>
                        </div>
                        <div class="timeline-body">
                            <p>
                                <?php echo $ticket_info["base"]["message"]; ?>
                            </p>
                        </div>
                    </div>
                </li>
                <?php
                if($ticket_info["answers"] != "")
                {
                    for($i = 0; $i < count($ticket_info["answers"]["role"]); $i++)
                    {
                ?>
                <li>
                    <div class="timeline-badge danger">
                        <?php
                        if($ticket_info["answers"]["role"][$i] == "admin")
                        {
                            echo '<img class="img-circle" style="margin-top: -5px;" src="'.$tickets_class->admin_gravatar.'" />';
                        }
                        else
                        {
                            echo '<img class="img-circle" style="margin-top: -5px;" src="'.$tickets_class->user_gravatar.'" />';
                        }
                        ?>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">
                                <?php
                                if($ticket_info["answers"]["role"][$i] == "admin")
                                {
                                    echo $tickets_class->admin_role_info;
                                }
                                else
                                {
                                    echo $tickets_class->user_role_info;
                                }
                                ?>
                            </h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo $ticket_info["answers"]["dateAdded"][$i];?></small></p>
                        </div>
                        <div class="timeline-body">
                            <p>
                                <?php echo $ticket_info["answers"]["message"][$i];?>
                            </p>
                        </div>
                    </div>
                </li>

                <?php
                    }
                }
                ?>
            </ul>
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

<div class="modal fade" id="ticket_reply" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php language_filter("Reply");?></h4>
            </div>
            <div class="modal-body">
                <p>
                <div class="form-group">
                    <label for="reopen_message"><?php language_filter("Message");?></label>
                    <textarea class="form-control" rows="5" id="reply_message"></textarea>
                </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Close");?></button>
                <button type="button" class="btn btn-primary" onclick="reply_message('<?php echo $ticketId;?>', '<?php echo $core->user_id;?>');"><?php language_filter("Send_Message");?></button>
            </div>
        </div>
    </div>
</div>

<script>

    function reply_message(id, userId)
    {
        var message = $("#reply_message").val();
        if(message == "")
        {
            alert("<?php language_filter("Please_fill_the_fields.", false, true)?>");
            return false;
        }
        $("#ticket_reply").modal('hide');
        show_preloader();
        setTimeout(function(){
            $.post(
            "ajax_manage_tickets.php",
            {
                method:"reply_ticket",
                ticketId:id,
                userId:userId,
                adminId:0,
                role:"user",
                message:message
            },
            function (data, status)
            {
                if(status == "success")
                {
                    if(data == "true")
                    {
                        show_errors_on_nav("<?php language_filter("reply_ticket_done", false, true);?>", "green");
                        setTimeout(function(){show_ticket('<?php echo $ticketId;?>');}, 1000);
                        return true;
                    }
                    else if(data == "email")
                    {
                        show_errors_on_nav("<?php language_filter("reply_ticket_error1", false, true);?>", "blue");
                        setTimeout(function(){show_ticket('<?php echo $ticketId;?>');}, 1000);
                        return false;
                    }
                    else
                    {
                        show_errors_on_nav("<?php language_filter("reply_ticket_error2", false, true);?>", "red");
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
                            setTimeout(function(){show_ticket('<?php echo $ticketId;?>');}, 1000);
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
</script>

<?php
            }
        }
    }
}