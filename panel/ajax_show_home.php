<?php
if (!isset($core))
{
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
	$backup = new filemanager_backups();
    require_once 'filemanager_language.php';
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if (isset($_POST["showHome"]))
        {
            $core->adminInfo();
            if ($_POST["showHome"] == $core->admin_id)
            {
    ?>
    <div class="row">
        <div class="col-md-12">
            <h2><?php language_filter("Backup_Files_Page_Title");?></h2>
            <p>
                <?php language_filter("Backup_Files_Page_Text");?>
                <p id="show_top_message">
                    <?php
                    if ($backup->backup_dir_files == NULL)
                    {
                        $viewAll = '<div class="alert alert-info"><center><b>'.language_filter("THERE IS NO BACKUPS", true).'</b></center></div>';
                    }
                    else
                    {
                        $viewAll = '<a class="btn" href="javascript:;" onclick="showAllBackups();" id="Viewbackupfiles">'.language_filter("View_Backups", true).'</a>';
                    }
                    ?>
                </p>
            </p>
            <?php echo $viewAll;?>
        </div>



        <div class="col-md-12" id="backups" style="display: none;">
            <hr>
            <h2><?php language_filter("Backup Files");?></h2>
            <div class="alert alert-info" id="remove_error" style="display: none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th style="text-align: center;"><?php language_filter("Download")?></th>
                    <th style="text-align: center;"><?php language_filter("Size");?></th>
                    <th style="text-align: center;"><?php language_filter("Date");?></th>
                    <th></th>
                    </tr>
                    <?php
                    if ($viewAll != "")
                    {
                        $count = count($backup->backup_dir_files);
                        for ($i = 0; $i < $count; $i++)
                        {
                            $fileAddress[$i] = "../filemanager_backups/". $backup->backup_dir_files[$i];
                            $fileSize[$i] = $backup->formatBytes($fileAddress[$i]);
                            $fileTime[$i] = date ("Y/m/d H:i:s", filemtime($fileAddress[$i]));
                    ?>
                    <tr id="row<?php echo $i;?>">
                        <td><span class="glyphicon glyphicon-download-alt" style="margin-right: 5px;"></span><a href="../filemanager_backups/backups.php?file_name=<?php echo $backup->backup_dir_files[$i];?>" target="_blank"><?php echo $backup->backup_dir_files[$i];?></a></td>
                        <td style="text-align: center;"><?php echo $fileSize[$i];?></td>
                        <td style="text-align: center;"><?php echo $fileTime[$i];?></td>
                        <td style="text-align: center;"><button class="btn btn-mini btn-danger" type="button" onclick="removeBackupAlert('<?php echo addslashes($backup->backup_dir_files[$i]);?>', 'row<?php echo $i;?>')"><?php language_filter("Remove");?></button></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>

                </table>
            </div>

                <!-- Modal -->
                <div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php language_filter("Remove Back Up File");?></h4>
                            </div>
                            <div class="modal-body">
                                <p><?php language_filter("Do you want to delete this file");?></p>
                            </div>
                            <div class="modal-footer" id="remove_footer">
                            </div>
                        </div>
                    </div>
                </div>

        </div>

    </div>


                <script>
                    end = <?php echo $count;?>;
                    function showAllBackups()
                    {
                        $("#backups").fadeIn(1000);
                        $('html, body').animate({
                             scrollTop: $("#backups").offset().top
                         }, 500);
                    }
                    function removeBackupAlert(name, id)
                    {
                        name = addslashes(name);
                        $("#remove_footer").html('<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php language_filter("Close", false, true);?></button><button class="btn btn-danger" onclick="removeBackup(\''+name+'\', \''+id+'\');"><?php language_filter("Delete", false, true);?></button>');
                        $("#remove_modal").modal();
                    }

                    function removeBackup(name, id)
                    {
                        $("#remove_modal").modal('hide');
                        $('#preloader').modal();
                        $.post("ajax_remove_file.php",
                        {
                            filename:name
                        },
                        function(data,status)
                        {
                            var error = "";
                            if(status == "success")
                            {
                                switch(data)
                                {
                                    case "T":
                                        $('#preloader').modal('hide');
                                        error = "<?php language_filter("File has been deleted.", false, true);?>";
                                        end--;

                                        if(end == 0)
                                        {
                                            $("#"+id).fadeOut(1000);
                                            $("#Viewbackupfiles").hide();
                                            $("#backups").hide();
                                            $("#show_top_message").html('<div class="alert alert-info"><center><b><?php language_filter("THERE IS NO BACKUPS", false, true);?></b></center></div>');
                                        }
                                        else
                                        {
                                            $("#"+id).fadeOut(1000);
                                        }
                                    break;

                                    case "F1":
                                        error = "<?php  language_filter("Can not remove file.", false, true);?>";
                                    break;

                                    case "F2":
                                        error = "<?php language_filter("This file not exists.", false, true);?>";
                                    break;

                                    default:
                                        error = "<?php language_filter("Undefined error!", false, true);?>";
                                    break;
                                }
                                /*$("#remove_error").html('<center>' + error + '</center>');
                                $('html, body').animate({
                                     scrollTop: $("#backups").offset().top
                                 }, 500);
                                $("#remove_error").fadeIn(1000).delay(2000).fadeOut(2000);*/
                                show_errors_on_nav(error, "blue");
                            }
                            else
                            {
                                alert("Error: " + status);
                            }

                        });
                        $('#preloader').modal('hide');
                    }
                    function addslashes(string)
                    {
                        return string.replace(/\\/g, '\\\\').
                                replace(/\u0008/g, '\\b').
                                replace(/\t/g, '\\t').
                                replace(/\n/g, '\\n').
                                replace(/\f/g, '\\f').
                                replace(/\r/g, '\\r').
                                replace(/'/g, '\\\'').
                                replace(/"/g, '\\"');
                    }
                </script>
    <?php
            }
        }

    }
    else
    {
        header("Status: 404 Not Found");
    }
}