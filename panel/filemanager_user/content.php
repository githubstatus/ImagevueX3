<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    $core = new filemanager_user_core();
    $core->userInfo();
    $core->create_user_panel($core->user_id);
    require_once '../filemanager_language_user.php';
}
if ($core->isLogin() and $core->is_block == 0)
{
?>
    <!-- Modal -->
    <div class="modal fade" id="preloader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <?php language_filter("Please Wait...");?>
                    <div class="progress progress-striped" style="margin-top: 25px;">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="show_status" style="display: none">

    </div>

    <div>
        <div>
            <div id="content_show" style="display: none;">

            </div>

            <div class="col-md-4" style="display: none;" id="left_sidebar">
                <div id="left_folder_menu_box">

                </div>
            </div>

        </div>
    </div>


<?php
}
else
{
    header("Location: .");
}
?>