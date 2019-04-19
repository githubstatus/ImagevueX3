<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    $core = new filemanager_user_core();
    $core->userInfo();
    $core->create_user_panel($core->user_id);
    require_once '../filemanager_language_user.php';
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin() and $core->is_block == 0)
    {
        if(isset($_POST["showFilemanager"]))
        {
            if ($_POST["showFilemanager"] == $core->user_id)
            {
                $show_root = true;
                $path = $core->user_dir;
                $post_path = $_POST["my_dir_path"];
                if($_POST["root"] == 0 && file_exists($post_path))
                {
                    $show_root = false;
                    $path = $_POST["my_dir_path"];
                }
                if(isset($_POST["sort_type"]))
                {
                    $sort_with = $_POST["sort_type"];
                }
                else
                {
                    $sort_with = 'date';
                }
                $page = 1;
                $countShow = "all";
                $search = '';
                if(isset($_POST["search"]))
                {
                    $search = $_POST["search"];
                }

                $path = $core->name_filter( $path, true );
                $root = new filemanager_show_from_root_user($show_root, $path, $sort_with, $core->user_id, $search);
                $navigation_url = str_replace("ajax_show_filemanager.php", "navigate.php", $root->curPageURL());
                $fullCount = count($root->root_files_folders);
                $core->page($page, $fullCount, $countShow);
                if( $core->db_use ) {
                    $settings = $core->get_option("settings");
                }
                else {
                    $settings = new stdClass();
                    $settings->share = "off";
                }
                $have_action = $_POST["have_action"];
                $page_id = str_replace(array('"', '/', '.', '..'), '_', str_replace('../', '', $path));
?>


                <div class="x3-manager" id="page_<?php if($search != "") { echo 'search'; } else { echo $page_id; } ?>">
                    <div>

                    <ol class="breadcrumb">
                    <?php
                    $exp = explode("/", $path);
                    $key = array_search($core->user_folder_name, $exp);
                    $count = count($exp);
                    for($j = 0; $j < $count; $j++)
                    {
                        if($exp[$j] == "")
                        {
                            unset($exp[$j]);
                        }
                        else if($j < $key)
                        {
                            unset($exp[$j]);
                        }
                    }
                    $exp = array_values($exp);

                    $back_link = '';
                    $exp_count = count($exp);
                    for($j = 0; $j < $exp_count; $j++)
                    {
                        if($exp[$j] != "")
                        {
                            $back[] = $exp[$j];
                            for($k = 0; $k < count($back); $k++)
                            {
                                $back_link .= $back[$k].'/';
                            }
                            $new_back_link = $back_link;
                            $new_back_link = $core->user_root_folder.$new_back_link;
                            unset($back);
                            if($j == ($exp_count - 1))
                            {
                                if($exp[$j] == $core->user_folder_name and $j == 0)
                                    echo '<li class="active">'.language_filter("Your Directory", true).'</li>';
                                else
                                    echo '<li class="active">'.$exp[$j].'</li>';
                            }
                            else
                            {
                                if($exp[$j] == $core->user_folder_name and $j == 0)
                                {
                                    echo '<li><a href="javascript:;" onclick="loading_from_file = false; showFileManager(\'\')">'.language_filter("Your Directory", true).'</a></li>';
                                }
                                else
                                {
                                    echo '<li><a href="#" data-link="' . htmlspecialchars($back_link). '" onclick="loading_from_file = false; showFileManager(this.getAttribute(\'data-link\'))">'.$exp[$j].'</a> </li>';
                                }
                            }
                        }
                    }
                        $folder_title = $exp[$exp_count - 1];
                        if($folder_title == ROOT_DIR_NAME) $folder_title = "Content";
                        $folder_name = $folder_title;
                        if($search != "") $folder_title = language_filter("Search results for", true)." ".$search;
                    ?>
                    </ol>

                    <div class="alert alert-warning" id="limit" style="<?php if($core->user_limitation <= 100) echo 'display: none;';?>">
                        <button type="button" class="close" onclick="$('#limit').slideUp(500);">&times;</button>
                        <br />
                        <p><?php language_filter("Used Size")?> (<?php if($core->user_limitation < 100) echo intval($core->user_limitation)."%"; else echo '100%';?>)</p>
                        <div class="progress progress-striped">
                            <div class="progress-bar <?php if($core->user_limitation < 50) echo 'progress-bar-success'; elseif($core->user_limitation > 50 and $core->user_limitation < 90) echo 'progress-bar-warning'; else{ echo 'progress-bar-danger'; }?>" style="width: <?php echo $core->user_limitation;?>%">
                                <span></span>
                            </div>
                        </div>
                        <?php
                        if($core->user_limitation > 100)
                        {
                            language_filter("USER LIMITATION ERROR");
                        }
                        ?>
                    </div>

                    <div class="manage_box_show">
                        <div class="col-md-3">
                        <div id="menu-container">
                            <h3><?php language_filter( "Folder_Menu" );?> </h3><hr />
                            <div id="show_left_sidebar"></div>
                            <hr>
                            <button type="button" class="btn btn-info btn-sm new-root-page"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php language_filter("New Folder");?></button>
                        </div>
                        </div>

                        <div class="col-md-9">
                        		<h3 class="page-title"><?php echo $folder_title;?></h3>
                            <a class="title-url" href="#" target="_blank"><span></span><span class="glyphicon glyphicon-new-window"></span></a>
                            <div class="current-folder-btns" <?php if( $search != "" ){ ?> style="display: none" <?php }?>>
                                <div class="btn-group btn-group-sm">
                                    <?php if( isset($core->global_user_can["rename_folder"] ) ):?><button type="button" class="btn btn-default btn-group-filemanager" <?php if( $show_root or $folder_name == "" ) { echo 'disabled="disabled"'; } else {?>data-action="rename_dir"<?php }?>><?php language_filter("Rename");?></button><?php endif;?>
                                    <?php if( isset($core->global_user_can["move_folders"] ) ):?><button type="button" class="btn btn-default btn-group-filemanager" <?php if( $show_root or $folder_name == "" ) { echo 'disabled="disabled"'; } else {?>data-action="rename_dir" data-time="move"<?php }?>><?php language_filter("Move");?></button><?php endif;?>
                                    <?php if( isset($core->global_user_can["copy_folders"] ) ):?><button type="button" class="btn btn-default btn-group-filemanager" <?php if( $show_root or $folder_name == "" ) { echo 'disabled="disabled"'; } else {?>data-action="copy_dir"<?php }?>><?php language_filter("Copy");?></button><?php endif;?>
                                    <?php if( isset($core->global_user_can["remove_folders"] ) ):?><button type="button" class="btn btn-default  btn-group-filemanager" <?php if( $show_root or $folder_name == "" ) { echo 'disabled="disabled"'; } else {?>data-action="remove_dir"<?php }?>><?php language_filter("Delete");?></button><?php endif;?>
                                </div>
                                <?php if( isset($core->global_user_can["upload_folders"] ) ):?><button type="button" class="btn btn-info btn-group-filemanager btn-sm btn-uploader" onclick="showUploader()"><span class="glyphicon glyphicon-chevron-up"></span> &nbsp;<?php language_filter("Upload");?></button><?php endif;?>
                                <?php if( isset($core->global_user_can["create_folder"] ) ):?><button type="button" class="btn btn-info btn-group-filemanager btn-sm btn-new"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php language_filter("New Folder");?></button><?php endif;?>
                            </div>
                            <hr />
                            <ul class="nav nav-tabs" id="myTab">
                                <?php if($search == "") {?><li class="active"><a href="#page" data-toggle="tab"><?php language_filter("Page");?></a></li><?php }?>
                                <li <?php if($search != "") {echo 'class="active"';}?>><a href="#gallery" data-toggle="tab"><?php language_filter("Gallery");?></a></li>
                            </ul>

                            <div class="tab-content">
                                <?php if($search == "") {?><div class="tab-pane active" id="page">
                                 	<div>
                                            <div class="row x3-page-settings">
																                <div class="x3-page-settings-container"></div>
																            </div>

                                        </div>
                                <?php }?>
                                </div>
                                <div class="tab-pane" id="gallery">

                                    <div <?php if($fullCount == '') { echo 'style="display: none;"';};?> class="manage-list-buttons">

                                    	<div class="col-sm-5 list-actions">

                                				<button class="btn btn-default btn-sm" id="select_all" onclick="select_all();" data-title="<?php language_filter("Select All");?>" data-select="<?php language_filter("Select All");?>" data-unselect="<?php language_filter("Unselect All")?>"><span class="glyphicon glyphicon-check"></span></button>

                                        <button type="button" class="btn btn-default btn-sm btn-view" data-title="<?php language_filter("Change_List_View");?>"><span class="glyphicon glyphicon-list"></span></button>

                                        <button type="button" class="btn btn-default btn-sm btn-sort" data-sortby="<?php language_filter("Sort by");?>" data-date="<?php language_filter("Sort date");?>" data-sort="<?php language_filter("Sort name");?>" data-filesize="<?php language_filter("Sort size");?>" data-custom="Custom"><span class="glyphicon glyphicon-sort-by-alphabet"></span></button>

                                        <button class="btn btn-primary btn-sm reset-sort disabled hidden">Reset folders sort</button>

                                        <span class="button-helper"></span>

                                			</div>

                                        <div class="col-sm-7 text-right selected-actions">
                                        				<span class=selected-text data-lang="<?php language_filter("selected_Folders_Files")?>">0 <?php language_filter("selected_Folders_Files")?></span>
                                                <div class="btn-group btn-group-sm">
                                                        <?php echo $core->user_can;?>
                                                    <?php
                                                    if(!empty($core->user_permissions) and ($core->user_no_limit != 0 and $core->user_no_limit != 1000000000))
                                                    {
                                                        ?>
                                                        <button type="button" class="btn btn-default btn-group-filemanager" id="show_limit" onclick="$('#limit').slideDown(500);"><?php language_filter("Used Size")?></button>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="view-small manage-container">
                                    <div class="fixed-save"><button type="button" class="btn btn-primary save-page btn-lg"><?php language_filter("Save");?></button></div>
                                    <table class="table manage-table">
                                    <tbody class="popup-parent">
                                        <?php
                                        //$count = count($root->root_files_folders);
                                        if($fullCount == '')
                                        {
                                            echo '<div class="alert alert-info" style="text-align: center; font-weight: bold;">'.language_filter("NO FILES AND FOLDERS", true).'</div>';
                                        }
                                        else
                                        {
                                            /*echo '<tr>
                                                    <th style="text-align: center;"><button class="btn btn-default btn-xs" onclick="select_all()" id="select_all">'.language_filter("Select All", true).'</button></th>
                                                    <th style="">'.language_filter("Open / Download / View", true).'</th>
                                                    <th style="text-align: center;">'.language_filter("Size", true).'</th>
                                                    <th style="text-align: center;">'.language_filter("Setting", true).'</th>
                                                 </tr>';*/
                                            for ($i = $core->start; $i < $core->end; $i++)
                                            {
                                                $is_zip = 0;
                                                $reference_date = false;
                                                $iptc_data = false;
                                                if($show_root)
                                                    $fileAddress[$i] = $path.'/'. $root->root_files_folders[$i];
                                                else
                                                {
                                                    $fileAddress[$i] = $path.'/'.$root->root_files_folders[$i];
                                                    $fileAddress[$i] = str_replace($path.'/'.$path.'/', $path.'/', $fileAddress[$i]); // debug search
                                                }

                                                if( $search != '' ) {
                                                    $fileAddress[$i] = $root->root_files_folders[$i];
                                                }

                                                // fix double slash
                                                $fileAddress[$i] = preg_replace('#/+#', '/', $fileAddress[$i]);

                                                $fileSize[$i] = $root->formatBytes($fileAddress[$i]);

                                                //
                                                //$filePerm[$i] = substr(sprintf('%o', fileperms($fileAddress[$i])), -4);
                                                $navigate = "";
                                                if(is_dir($fileAddress[$i]))
                                                {
                                                    $is_file = 0;
                                                    $is_editable_file = 0;
                                                    $is_img = 0;
                                                    $ext = '';
                                                    $navigate = $navigation_url."?redirect=".base64_encode(utf8_encode($fileAddress[$i]));
                                                }
                                                else
                                                {
                                                    $is_file = 1;
                                                    $is_editable_file = 0;
                                                    $is_img = 0;
                                                    $ext = pathinfo($fileAddress[$i], PATHINFO_EXTENSION);
                                                    $ext = strtolower($ext);
                                                    if($ext == "zip")
                                                    {
                                                        $is_zip = 1;
                                                    }

                                                    if($ext == "txt")
                                                    {
                                                        if(is_writable($fileAddress[$i]))
                                                        {
                                                            $is_editable_file = 1;
                                                        }
                                                    }

                                                    if($ext == "jpg" or $ext == "png" or $ext == "gif" or $ext == "jpeg" or $ext == "webp")
                                                    {
                                                        $is_img = 1;
                                                        list($image_width, $image_height) = getimagesize($fileAddress[$i], $file_info);

                                                        // IPTC
                                                        if(isset($file_info["APP13"])){
                                                        	$iptc = iptcparse($file_info["APP13"]);
                                                        	$iptc_data = X3::get_iptc_data($iptc);

                                                        	// reference_date 047
                                                        	if(isset($iptc["2#047"][0]) && is_numeric($iptc["2#047"][0])) $reference_date = $iptc["2#047"][0];
                                                        }
                                                    }
                                                }

                                                // image date
                                                $exif_time = false;
                                                if($is_img && function_exists('exif_read_data')){
                                                	$dataEXIF = @exif_read_data($fileAddress[$i], 'ANY_TAG', 0);
                                                	if(!empty($dataEXIF) && @array_key_exists('DateTimeOriginal', $dataEXIF)) $exif_time = @strtotime($dataEXIF['DateTimeOriginal']);
                                                }
                                                //$fileTime[$i] = date('Y/m/d H:i:s', (empty($exif_time) ? ($reference_date ? $reference_date : filemtime($fileAddress[$i])) : $exif_time));
                                                $fileTime[$i] = empty($exif_time) ? ($reference_date ? $reference_date : filemtime($fileAddress[$i])) : $exif_time;

                                                //
                                                $exploded = explode("/", $root->root_files_folders[$i]);
                                                $filename = (($search != '') ? end($exploded) : $root->root_files_folders[$i]);

                                                ?>
                                                <tr id="row<?php echo $i;?>" class="manual_border_top"<?php if(!empty($iptc_data)) echo $iptc_data;?> data-name="<?php if($search != '') { $_root_files_folders = explode("/", $root->root_files_folders[$i]); echo end( $_root_files_folders ); } else echo $root->root_files_folders[$i];?>" data-path="<?php echo $fileAddress[$i] ?>" data-encoded="<?php echo $fileAddress[$i] ?>" data-ext="<?php echo $ext ?>" data-isfile="<?php echo $is_file ?>" data-isimage="<?php echo $is_img ?>" data-filesize="<?php echo $fileSize[$i] ?>" data-date="<?php echo $fileTime[$i] ?>" data-sort="<?php echo $i; ?>">

                                                		<td class="td-checkbox"><input type="checkbox" id="check_<?php echo $i;?>" value="<?php echo htmlspecialchars($root->root_files_folders[$i]); ?>" onclick="set_selected(this.value, <?php echo $i;?>, this.checked);"></td>

                                                    <td class="td-name">
                                                    <a href="<?php echo htmlspecialchars($fileAddress[$i]); ?>" target="_blank" <?php if($is_img == 1) echo 'class="popup" data-width="'.$image_width.'" data-height="'.$image_height.'" data-name="'.htmlspecialchars($filename).'" data-filesize="'.$fileSize[$i].'" rel="group1"';?>><?php if($search != '') { $_root_files_folders = explode("/", $root->root_files_folders[$i]); echo end( $_root_files_folders ); } else echo $root->root_files_folders[$i];?></a></td>
                                                    <td class="td-button">
                                                        <?php
                                                        if($search != '')
                                                        {
                                                            $navigate_dir =  $root->root_files_folders[$i];
                                                            if(is_file($navigate_dir)) {
                                                                $nav_path = '';
                                                                if(strpos($navigate_dir, "../") === FALSE)
                                                                {
                                                                    $nav_path = "../";
                                                                }
                                                                $navigate_dir = explode("/", $navigate_dir);
                                                                $nav_count = count($navigate_dir);
                                                                for($k = 0; $k < $nav_count; $k++)
                                                                {
                                                                    if($k == $nav_count - 1)
                                                                    {
                                                                        unset($navigate_dir[$k]);
                                                                    }
                                                                }
                                                                $navigate_dir = array_values($navigate_dir);

                                                                $navigate_dir = $nav_path.implode("/", $navigate_dir);
                                                            }
                                                            else {
                                                                $navigate_dir = $fileAddress[$i];
                                                            }
                                                            echo '<button type="button" class="btn btn-primary btn-xs" onclick="have_action = \'yes\'; navigate_to_path(\''.addslashes($navigate_dir).'\'); " >'.language_filter("Go to directory", true).'</button>';
                                                        }
                                                        else
                                                        {
                                                        ?>


<!-- X3 filemanger dropdown button -->
<?php if($search != '') { $myname = end( $_root_files_folders ); } else { $myname = $root->root_files_folders[$i]; } ?>
<div class="btn-group">
  <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <span class="glyphicon glyphicon-wrench"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right pull-right text-left" role="menu">
  <li role="presentation" class="dropdown-header"><?php echo $myname;?></li>
<?php if($is_file): ?>
    <li><a href="#" data-action="remove_file"><?php language_filter("Remove");?></a></li>
    <li><a href="#" data-action="rename_file"><?php language_filter("Rename");?></a></li>
    <li><a href="#" data-action="rename_file" data-time="move"><?php language_filter("Move");?></a></li>
    <li><a href="#" data-action="copy_file"><?php language_filter("Copy");?></a></li>
<?php else: ?>
    <li><a href="#" data-action="remove_dir"><?php language_filter("Remove");?></a></li>
    <li><a href="#" data-action="rename_dir"><?php language_filter("Rename");?></a></li>
    <li><a href="#" data-action="rename_dir" data-time="move"><?php language_filter("Move");?></a></li>
    <li><a href="#" data-action="copy_dir"><?php language_filter("Copy");?></a></li>
<?php endif; ?>
	</ul>
</div>





                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="td-filesize"><?php echo $fileSize[$i];?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
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

                    </div>
                </div>


            <div class="modal" id="showConf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="confLable"></h4>
                        </div>
                        <div class="modal-body" id="container_id_tree">

                        </div>
                        <div class="modal-footer" id="confButton" style="text-align: left;">

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="siteMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel_map"><?php language_filter("Site Map")?></h4>
                        </div>
                        <div class="modal-body" id="container_id">

                        </div>
                        <div class="modal-footer">
                            <div class="col-xs-5">
                                <input type="text" disabled="disabled" id="navigate_input" class="form-control">
                            </div>
                            <div class="col-xs-7">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel")?></button>
                                <button type="button" class="btn btn-primary" onclick="navigate_to_path(navigate_to); navigate_to = '';" data-dismiss="modal"><?php language_filter("Navigate_to")?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="uploader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel_upload"><?php language_filter("Upload")?></h4>
                        </div>
                        <div class="modal-body" id="show_uploader">
                            <?php language_filter("Loading...")?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="show_preloader(); setTimeout(function(){loading_from_file = false; hide_preloader(); have_action = 'yes'; showFileManager('<?php if($show_root == false) echo 'here';?>', '#gallery')}, 1000);"><?php language_filter("Click to see uploaded files.")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="newFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel_folder"><?php language_filter("Create New Folder");?></h4>
                        </div>
                        <div class="modal-body">
                        		<i class="panel-help fa fa-question-circle" data-help=new_folder></i>
                        		<label for="new_folder">Create New folder in <span class='path'></span></label>
                            <input type="text" class="form-control input-folder" id="new_folder" placeholder="foldername" style="margin-top: 3px;" spellcheck="false" />
                            <span class="label label-warning url-info">&nbsp;</span><br>
                            <span class="label label-default url-helper">&nbsp;</span>

														<div class="panel panel-default">

															<div class="panel-body" style="padding-bottom: 15px;">

																<div class="text-center"><a role="button" data-toggle="collapse" href=".new-folder-options"></a></div>

																<div class="collapse new-folder-options">

																  <div class="form-group">
																  	<a href="#" class="show-help" data-help="page_title"></a>
																  	<label for="new_folder_title">Page Title</label>
																    <input type="text" class="form-control" id="new_folder_title">
																  </div>

																  <div class="form-group">
																  	<a href="#" class="show-help" data-help="menu_label"></a>
																    <label for="new_folder_label">Menu Label</label>
																    <input type="text" class="form-control" id="new_folder_label">
																  </div>

																  <div class="form-group">
																  	<a href="#" class="show-help" data-help="page_link"></a>
																    <label for="new_folder_link">Link</label>
																    <input type="text" class="form-control" id="new_folder_link">
																  </div>

																  <div class="form-group new-folder-target-container hidden">
																  	<a href="#" class="show-help" data-help="page_link_target"></a>
																    <label for="new_folder_target">Link target</label>
															      <select id="new_folder_target" class="form-control">
														        	<option value="auto">auto</option>
														        	<option value="_self">_self</option>
														        	<option value="_blank">_blank</option>
														        	<option value="popup">Popup Window</option>
														        	<option value="x3_popup">X3 Popup</option>
														        	<option value="x3_modal">X3 Modal</option>
														        </select>
																  </div>

																  <div class="form-group" style="margin-bottom:0;">
																	  <a href="#" class="show-help" data-help="page_hidden"></a>
																    <label>
																      <input type="checkbox" id="new_folder_hidden"> &nbsp;<?php language_filter("Hide")?>
																    </label>
															    </div>

																</div>
															</div>
														</div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel")?></button>
                            <button type="button" class="btn btn-primary btn-key"><?php language_filter("Create")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="newzipFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel_zip"><?php language_filter("Create Zip File")?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info" style="text-align: center; font-weight: bold;"><?php language_filter("Please write zip file name without extension.")?></div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="new_zip" placeholder="<?php language_filter("Zip File Name")?>" onchange="set_new_zipFile_name(this.value);"/>
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel")?></button>
                            <button type="button" class="btn btn-primary btn-key" onclick="create_zip();"><?php language_filter("Create")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="removeSelected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel_folders"><?php language_filter("Remove Selected Files And Folders")?></h4>
                        </div>
                        <div class="modal-body">
                            <?php language_filter("Do you want to remove selected files and folders")?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel")?></button>
                            <button type="button" class="btn btn-primary" onclick="remove_selected();"><?php language_filter("Delete")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="moveSelected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel_move"><?php language_filter("Move Selected Files And Folders")?></h4>
                        </div>
                        <div class="modal-body" id="container_id_tree2">

                        </div>
                        <div class="modal-footer">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="selected_move" placeholder="<?php language_filter("New Folder Path")?>" onchange="/*set_new_name(this.value);*/" disabled="disabled"/>
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel")?></button>
                            <button class="btn btn-info" type="button" onclick="showInlineTree();"><?php language_filter("Browse")?></button>
                            <button type="button" class="btn btn-primary" onclick="move_selected();"><?php language_filter("Move")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="copySelected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel_copy"><?php language_filter("Copy Selected Files And Folders")?></h4>
                        </div>
                        <div class="modal-body" id="container_id_tree3">
                        </div>
                        <div class="modal-footer">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="selected_copy" placeholder="<?php language_filter("New Folder Path")?>" onchange="/*set_new_name(this.value);*/" disabled="disabled"/>
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Cancel")?></button>
                            <button class="btn btn-info" type="button" onclick="showInlineTree();"><?php language_filter("Browse")?></button>
                            <button type="button" class="btn btn-primary" onclick="copy_selected();"><?php language_filter("Copy")?></button>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">

            new_name = "";
            filext = "";
            is_root = '<?php if($show_root) echo "true"; else echo "false";?>';
            this_dir_path = "";
            this_file_path = "";
            here = "<?php echo addslashes($path); ?>";
            is_rename = false;
            is_move = false;
            new_folder_path = "";
            selected = new Array();
            zip_file_name = "";
            this_dir_selected = "";
            old_name = "";
            new_file_per = "";
            navigate_to = "";
            send_to_counter = 1;
            is_user = true;
            core_user_dir = '<?php echo addslashes($core->user_dir);?>';
            map_path = '<?php echo addslashes($core->user_dir)."/";?>';
            user_folder_name = '<?php echo $core->user_folder_name;?>';


            <?php
            if( $search == "" ):
            ?>

            // Get page.json
            <?php
              if(file_exists($path.'/page.json')) {
								$c = trim(file_get_contents($path.'/page.json'));
								$page_json = $c ? $c : '{}';
							} else {
								$page_json = '{}';
							}
						?>

            // get x3 page settings
           var page_json = <?php echo $page_json; ?>;
           mtreeActive();
           get_x3_page_settings(page_json, '<?php echo addslashes($path) . '/page.json'; ?>');


            <?php
            endif;
            ?>

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
else
{
	header("Status: 404 Not Found");
}
?>