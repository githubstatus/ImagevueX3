<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    $core = new filemanager_user_core();
    $core->userInfo();
    $core->create_user_panel($core->user_id);
    require_once '../filemanager_language_user.php';
}
if ($core->isLogin())
{
    if($core->is_block == 1)
    {
        echo '<div class="alert alert-info" style="text-align: center"><b>'.language_filter("You are blocked.", true).' <a href="logout.php">'.language_filter("Logout", true).'</a></b></div>';
        exit;
    }
?>
<body class=user>
    <div class="container x3-panel-container">
        <!-- Static navbar -->
        <div class="navbar navbar-inverse" role="navigation" style="z-index: 0;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand<?php if( $core->db_use ): ?> editProfile<?php endif;?>" href="javascript:;" id="welcome" data-html="true" data-title="" data-delay="0" data-container="body" data-toggle="popover" data-placement="bottom" data-content="" data-trigger="manual"><?php language_filter("Welcome")?> <?php echo $core->user_firstname." ".$core->user_lastname;?></a>
                </div>

                <form class="navbar-form navbar-right" action="javascript:;" onsubmit="return false;" role="search">
                    <div class="top_search_input">
                        <span class="input-group-addon top_search_btn hidden" onclick="search = x3_search_input.val(); if(search == '') {alert('<?php language_filter("Please write a file name", false, true)?>'); return false;} page = 1; loading_from_file = false; countShow = 'all'; if( typeof (here) == 'undefined' ) here='../<?php echo ROOT_DIR_NAME;?>'; showFileManager(here); x3_search_input.val('');"><i class="glyphicon glyphicon-search"></i></span>
                        <div class="inner-addon">
			    								<span class="glyphicon glyphicon-search"></span>
			   									<input type="text" class="form-control" placeholder="<?php language_filter("Search");?> …" id="searchInput">
												</div>
                    </div>
                </form>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php echo $core->user_menu;?>
                        <?php $refresh = X3Config::$config["settings"]["menu_manual"] ? '' : ' class=hidden' ?>
                    		<li id="refresh"<?php echo $refresh; ?>><a href="javascript:;" class="btn btn-primary">Refresh Menu<i class="fa fa-question-circle panel-help" data-help="refresh"></i></a></li>
                    		<li id="website-link"><a href="../" target="_blank" title="<?php language_filter("View_Page");?>"><span class="glyphicon glyphicon-new-window"></span></a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </div>
<?php
}
else
{
    header("Location: .");
}
?>
