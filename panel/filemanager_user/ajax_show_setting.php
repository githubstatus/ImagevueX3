<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    $core = new filemanager_user_core();
    $core->userInfo();
    require_once '../filemanager_language_user.php';
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if (isset($_POST["showSetting"]) and $core->role == "user")
        {
            if ($_POST["showSetting"] == $core->user_id)
            {
            ?>
            <div class="x3-panel-section x3-settings">
                    <h3><?php language_filter("General_Setting")?></h3>
                    <div class="filter-buttons invisible">
                    	<div class="btn-group btn-group-sm" data-toggle="buttons">
                    		<label class="btn btn-primary"><input type="radio" name="options" id="optionx" autocomplete="off" checked="">placeholder</label>
                    	</div>
                    </div>

                    <form id=json-form></form>
                    <!--<div id="res" class="alert"></div>-->
            </div>

            <script type="text/javascript">
                get_x3_settings();
            </script>

            <?php
            }
        }
    }
}
?>