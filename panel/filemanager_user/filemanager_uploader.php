<?php 
if (!isset($core))
{
	require_once '../filemanager_user_core.php';
	$core = new filemanager_user_core();
    $core->userInfo();
    require_once '../filemanager_language_user.php';
}
if ($core->isLogin())
{
	if($core->user_can_do_it($core->user_id, "upload_folders", $core->user_limitation))
    {
        if(isset($_POST["upload_dir"]))
        {
            if($_POST["upload_dir"] != '../')
                $_POST["upload_dir"] .= '/';


            if( $core->db_use ) {
                $allowedExts = $core->get_option("allow_uploads_".$core->user_id);
                $uploaderExts = implode("|", $allowedExts);
                $allowedExts = implode(", ", $allowedExts);
                $size = $core->get_option("user_upload_limit_".$core->user_id);
            }
            else {
                global $ALLOW_UPLOADER;
                $allowedExts = $ALLOW_UPLOADER;
                $uploaderExts = implode("|", $allowedExts);
                $allowedExts = implode(", ", $allowedExts);
                $size = 0;
            }

            $resizer_orientation = X3Config::$config["back"]["panel"]["upload_resize"]["orientation"];
?>
        <!-- NEW UPLOADER -->
        <div class="alert alert-info" style="text-align: center;"><?php language_filter("You can upload file with following extensions")?>: <br> <?php echo $allowedExts;?></div>

        <!-- The file upload form used as target for the file upload widget -->
        <form id="fileupload" action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="uploadDir" value="<?php echo htmlspecialchars($_POST["upload_dir"]);?>">
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript><input type="hidden" name="redirect" value="."></noscript>

            <div id="dropzone" class="fade well fileinput-button">
            	<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
            	<div class="tdef"><?php language_filter( "Dropzone" );?>&nbsp;</div>
            	<div class="tdrop"><?php language_filter( "Drop_files_here" );?>&nbsp;</div>
            	<div class="thover"><?php language_filter( "Add_Files" );?>&nbsp;</div>
            	<input type="file" name="datafile" multiple>
            </div>

            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="fileupload-buttonbar">

            	<!-- Resizer options -->
            	<div class="resize-options form-inline">

	            	<div class="btn-group resize-toggle" data-toggle="buttons">
								  <label class="btn btn-default btn-sm active">
								    <input type="checkbox" autocomplete="off" checked><?php language_filter( "Resize_Images" );?>
								  </label>
								</div>

								<div class="resize-inputs">
	            		<span class="input-sm"><?php language_filter( "Width" );?></span><div class="form-group">
	            			<input type="number" class="form-control input-sm" id="resize-width" value="1600" placeholder="1600" min="100" max="9999" maxlength="4" step="100" pattern="[0-9]{3,4}" title="Resized image max width">
								  </div>
								  <span class="input-sm"><?php language_filter( "Height" );?></span><div class="form-group">
								  	<input type="number" class="form-control input-sm" id="resize-height" value="1600" placeholder="1600" min="100" max="9999" maxlength="4" step="100" pattern="[0-9]{3,4}" title="Resized image max height">
								  </div>
								  <span class="input-sm>"<?php language_filter( "Quality" );?></span><div class="form-group">
								  	<input type="number" class="form-control input-sm" id="resize-quality" value="91" placeholder="91" min="1" max="100" maxlength="3" step="1" pattern="[0-9]{1,3}" title="Resized image quality (1-100)">
								  </div>
							  </div>
							</div>

                <div class="fileupload-buttons">

                	<div class="queue-text"></div>

	                <button type="submit" class="btn btn-primary start">
	                    <span><?php language_filter( "Start_Upload" );?></span>
	                </button>

	                <button type="reset" class="btn btn-warning btn-sm cancel">
	                    <i class="glyphicon glyphicon-trash"></i>
	                </button>

	                <button type="reset" class="btn btn-default view">
	                  <span><?php language_filter("Click_to_see_uploaded_files.");?></span>
	                </button>

                </div>

                <!-- The global file processing state -->
                <span class="fileupload-process"></span>

                <!-- The global progress state -->
                <div class="col-lg-12 fileupload-progress fade">
                		<!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                </div>
            </div>

            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files popup-parent"></tbody></table>
        </form>

        <!-- The template to display files available for upload -->
        <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-upload fade">
                    <td class="td-preview">
                        <span class="preview"></span>
                    </td>
                    <td class="td-data">
                        <div class="filename">{%=file.name%}</div>
                        <strong class="error text-danger"></strong>
                        <div class="size"><?php language_filter( "Processing" );?></div>
                    </td>
                    <td class="td-progress">
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                    </td>
                    <td class="td-cancel">
                    		{% if (!i && !o.options.autoUpload) { %}
                            <button class="btn btn-primary start hidden" disabled>
                                <i class="glyphicon glyphicon-upload"></i>
                                <span><?php language_filter( "Start" );?></span>
                            </button>
                        {% } %}
                        {% if (!i) { %}
                            <button class="btn btn-warning btn-sm cancel">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        {% } %}
                    </td>
                </tr>
            {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-download fade{% if (!file.width) { %} is_file{% } %}"{% if (file.width) { %} data-isimage="1"{% } %}>
                		<td class="td-preview">
                        <span class="preview">
                            {% if (file.thumbnailUrl) { %}
                                <a href="{%=file.url.replace('//content/','/content/')%}" target="_blank"{% if (file.width) { %} class="popup" data-width="{%=file.width%}" data-height="{%=file.height%}"{% } %} data-name="{%=file.name%}" data-filesize="{%=o.formatFileSize(file.size)%}" rel="up1">
                                	<img src="{%=file.thumbnailUrl.replace('//content/','/render/w'+thumbsize+'-c1:1-q90/')%}">
                                </a>
                            {% } %}
                        </span>
                    </td>

                    <td class="td-data">
                        <div class="filename"><a href="{%=file.url.replace('//content/','/content/')%}" target="_blank"{% if (file.width) { %} class="popup" data-width="{%=file.width%}" data-height="{%=file.height%}"{% } %} data-name="{%=file.name%}" data-filesize="{%=o.formatFileSize(file.size)%}" rel="up2">{%=file.name%}</a></div>
                        {% if (file.error) { %}
                            <div><span class="label label-danger"><?php language_filter( "Error" );?></span> {%=file.error%}</div>
                        {% } %}
                        <div class="size">{%=o.formatFileSize(file.size)%}{% if (file.width) { %} | {%=file.width%} x {%=file.height%}{% } %}</div>
                    </td>
                    <td class="td-ok"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
                    <td>
                        {% if (file.deleteUrl) { %}
                            <button class="btn btn-danger btn-sm delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        {% } else { %}
                            <button class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span><?php language_filter( "Cancel" );?></span>
                            </button>
                        {% } %}
                    </td>
                </tr>
            {% } %}
        </script>

        <script>
            $(function () {
            	x3Uploader({
            		"img_resize": <?php echo (IMG_RESIZE ? 'true' : 'false') ?>,
            		"img_resize_width": <?php echo IMG_RESIZE_WIDTH; ?>,
            		"img_resize_height": <?php echo IMG_RESIZE_HEIGHT; ?>,
            		"img_resize_quality": <?php echo IMG_RESIZE_QUALITY; ?>,
            		"path": 'filemanager_user/upload.php',
            		"acceptFileTypes": /(\.|\/)(<?php echo $uploaderExts; ?>)$/i,
            		"orientation": <?php echo ($resizer_orientation === true || $resizer_orientation === 'resizer' ? 'true' : 'false'); ?>
            	});
            });

        </script>

<?php
        }
	}
}
?>