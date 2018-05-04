<?php
require_once '../filemanager_user_core.php';
$core = new filemanager_user_core();
require_once '../filemanager_language_user.php';
$core->userInfo();
if ($core->isLogin())
{
    if($core->user_can_do_it($core->user_id, "edit_img", $core->user_limitation))
    {
        if(isset($_GET["info"]))
        {
            $error_msg = "";
            if(!is_dir("../filemanager_temp/".$core->user_id))
            {
                mkdir("../filemanager_temp/".$core->user_id, 0755);
            }
            $user_dir = "../filemanager_temp/".$core->user_id."/";
            $img = utf8_decode(base64_decode($_GET["info"]));
            if($core->check_base_root($img))
            {
                if(is_file($img))
                {
                    $base_address = $img;
                    $real_extension = end(explode(".", $img));
                    $edited_address = "";
                    $temp_txt_file_name = "text_undo_".$core->user_username.".txt";

                    function edit()
                    {
                        global $edit;

                        if(!empty($_POST['width']) and !empty($_POST['height']))//resize
                        {
                            $edit->resize($_POST['width'],$_POST['height']);
                        }

                        if(isset($_POST['x']) and isset($_POST['y']) and !empty($_POST['widcrop']) and !empty($_POST['heicrop']))//crop
                        {
                            if($_POST['x'] == '') $_POST['x'] = 0;
                            if($_POST['y'] == '') $_POST['y'] = 0;

                            $edit->crop($_POST['x'],$_POST['y'],$_POST['widcrop'],$_POST['heicrop']);
                        }

                        if(!empty($_POST['filter']) and $_POST['filter'] != 'nofilter')//filter
                        {
                            $edit->filter($_POST['filter']);
                        }

                        if(!empty($_POST['alphacolorize']) and isset($_POST['redsiz']) and isset($_POST['greensiz']) and isset($_POST['bluesiz']))//coloriz
                        {
                            if($_POST['redsiz'] == '')   $_POST['redsiz'] = 0;
                            if($_POST['greensiz'] == '') $_POST['greensiz'] = 0;
                            if($_POST['bluesiz'] == '')  $_POST['bluesiz'] = 0;

                            $color = array($_POST['redsiz'],$_POST['greensiz'],$_POST['bluesiz']);
                            $edit->coloriz($color,$_POST['alphacolorize']);
                        }

                        if(!empty($_POST['rotat']) and isset($_POST['red']) and isset($_POST['green']) and isset($_POST['blue']))//rotation
                        {
                            if($_POST['red'] == '')   $_POST['red'] = 0;
                            if($_POST['green'] == '') $_POST['green'] = 0;
                            if($_POST['blue'] == '')  $_POST['blue'] = 0;

                            $colorR = array($_POST['red'],$_POST['green'],$_POST['blue']);
                            $edit->rotation($_POST['rotat'],$colorR);
                        }

                        if(!empty($_POST['text']) and !empty($_POST['font']) and isset($_POST['textx']) and isset($_POST['texty']) and
                            isset($_POST['alpha']) and isset($_POST['rottext']) and isset($_POST['fontsize']) and
                                isset($_POST['redtext']) and isset($_POST['greentext']) and isset($_POST['bluetext']))
                        {
                            if($_POST['textx'] == '')     $_POST['textx'] = 0;
                            if($_POST['texty'] == '')     $_POST['texty'] = 0;
                            if($_POST['alpha'] == '')     $_POST['alpha'] = 0;
                            if($_POST['rottext'] == '')   $_POST['rottext'] = 0;
                            if($_POST['fontsize'] == '')  $_POST['fontsize'] = 12;
                            if($_POST['redtext'] == '')   $_POST['redtext'] = 0;
                            if($_POST['greentext'] == '') $_POST['greentext'] = 0;
                            if($_POST['bluetext'] == '')  $_POST['bluetext'] = 0;

                            $colorT = array($_POST['redtext'],$_POST['greentext'],$_POST['bluetext']);
                            if(!empty($_POST['shadow']) and $_POST['shadow'] == 'shadow')
                            {
                                $edit->shadowText($_POST['textx'],$_POST['texty'],$_POST['text'],$colorT,$_POST['alpha'],$_POST['rottext'],$_POST['font'],$_POST['fontsize']);
                            }
                            else
                            {
                                $edit->addText($_POST['textx'],$_POST['texty'],$_POST['text'],$colorT,$_POST['alpha'],$_POST['rottext'],$_POST['font'],$_POST['fontsize']);
                            }
                        }
                    }


                    if(isset($_POST['edit']))
                    {
                        $pathinfo = pathinfo($_POST['source']);
                        $extension = $pathinfo['extension'];
                        $i = date('YmdHis');
                        $edit = new editImage();
                        $edit->initEdit($_POST['source'],$user_dir.$i.".".$extension);
                        edit();
                        $undo = fopen($user_dir.$temp_txt_file_name,'a');
                        fwrite($undo,$user_dir.$i.".".$extension.PHP_EOL);
                        fclose($undo);
                        $edited_address = $user_dir.$i.".".$extension;
                    }
                    elseif(isset($_POST['save']))
                    {
                        $path_save = $_POST['path_save'];
                        $img_name = $_POST["image_name"];
                        $new_img_extension = end(explode(".", $img_name));
                        if(strtolower($new_img_extension) != strtolower($real_extension))
                        {
                            $error_msg = "<div class='alert alert-danger' style='text-align: center'>".language_filter("Please write valid extension.", true)."</div>";
                        }
                        else
                        {
                            $path_save = $path_save.$img_name;
                            if($core->check_base_root($path_save) and strpos($path_save, "../") !== FALSE)
                            {
                                $content = file($user_dir.$temp_txt_file_name);
                                $endOfLine = trim($content[sizeof($content)-1]);
                                if(!is_dir($path_save))
                                {
                                    @mkdir(dirname($path_save), 0755);
                                }
                                if(@rename($endOfLine,$path_save))
                                {
                                    $results = scandir($user_dir);
                                    foreach($results as $result)
                                    {
                                        if($result == "." or $result == ".." or is_dir($user_dir.$result)) continue;
                                        unlink($user_dir.$result);
                                    }
                                    $error_msg = "<div class='alert alert-success' style='text-align: center'>".language_filter("New image has been saved.", true)."</div>";
                                }
                                else
                                {
                                    $error_msg = "<div class='alert alert-danger' style='text-align: center'>".language_filter("Can not save new image.", true)."</div>";
                                }
                            }
                            else
                            {
                                $error_msg = "<div class='alert alert-danger' style='text-align: center'>".language_filter("Can not save new image.", true)."</div>";
                            }
                        }
                    }
                    elseif(isset($_POST['undo']))
                    {
                        $back = file($user_dir.$temp_txt_file_name);
                        if(sizeof($back) > 1)
                        {
                            $edited_address = trim($back[sizeof($back) - 2]);

                            unset($back[sizeof($back)-1]);
                        }
                        else
                        {
                            $edited_address = $base_address ;
                        }
                        $undo = fopen($user_dir.$temp_txt_file_name,'w');
                        for($i = 0; $i < sizeof($back);++$i)
                        {
                            fwrite($undo,$back[$i]);
                        }
                        fclose($undo);
                    }

                    //if(isset($_GET['address']))
                    //{
                    $base_address = $img;
                    //}

                    if($edited_address == "")
                    {
                        $surce = $base_address;
                        // remove files in temp
                        $results = scandir($user_dir);
                        foreach($results as $result)
                        {
                            if($result == "." or $result == ".." or is_dir($user_dir.$result)) continue;
                            unlink($user_dir.$result);
                        }
                    }
                    else
                    {
                        $surce = $edited_address;
                    }
                    ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="<?php language_filter("charset")?>">
                    <meta name="robots" content="noindex">
                    <meta name="googlebot" content="noindex">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link href='https://cdn.jsdelivr.net/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' />
                    <link href="../filemanager_css/jqueryFileTree.css" rel="stylesheet">
                    <script src='https://cdn.jsdelivr.net/jquery/2.2.4/jquery.min.js'></script>
                    <script src="https://cdn.jsdelivr.net/bootstrap/3.0.0/js/bootstrap.min.js"></script>
                    <title><?php language_filter("Edit image")?></title>
                    <style>
                        body {
                            direction: <?php language_filter("direction")?>;
                        }
                    </style>

                </head>

                <body>
                <div class="container">
                <div class="row">
                <div class="well col-md-12">
                    <?php echo $error_msg;?>
                <ul class="thumbnails" style="text-decoration: none; list-style: none;">
                    <li class="col-md-6">
                        <p style="text-align: center"><b><?php language_filter("Your Image")?></b></p>
                        <a href="javascript:;" class="thumbnail" >
                            <img src="<?php echo "img.php?filename=".base64_encode(utf8_encode($base_address));?>" alt="">
                        </a>
                    </li>

                    <li class="col-md-6">
                        <p style="text-align: center"><b><?php language_filter("Image Preview")?></b></p>
                        <a href="javascript:;" class="thumbnail">
                            <img src="<?php if($edited_address == "" or isset($_POST['undo'])) echo "img.php?filename=".base64_encode(utf8_encode($base_address)); else echo "img.php?filename_img_editor=".base64_encode(utf8_encode($edited_address));?>" alt="" onclick="find_x_y_crop(event)" id="user_img" onmousemove="this.style.cursor = 'crosshair'">
                        </a>
                    </li>
                </ul>
                <p>&nbsp;</p>
                <hr>
                <br />
                <div class="" id="loginModal">
                <div class="modal-body">
                <div>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#resize" data-toggle="tab" onclick="set_method_type('#resize');"><?php language_filter("Resize")?></a></li>
                    <li><a href="#crop" data-toggle="tab" onclick="set_method_type('#crop');"><?php language_filter("Crop")?></a></li>
                    <li><a href="#filter" data-toggle="tab" onclick="set_method_type('#filter');"><?php language_filter("Filter")?></a></li>
                    <li><a href="#colorize" data-toggle="tab" onclick="set_method_type('#colorize');"><?php language_filter("Colorize")?></a></li>
                    <li><a href="#rotation" data-toggle="tab" onclick="set_method_type('#rotation');"><?php language_filter("Rotation")?></a></li>
                    <li><a href="#text" data-toggle="tab" onclick="set_method_type('#text');"><?php language_filter("Text")?></a></li>
                    <li><a href="#save" data-toggle="tab" onclick="set_method_type('#save');"><?php language_filter("Save")?></a></li>
                </ul>
                <form action="edit_img.php?info=<?php echo $_GET["info"]?>" method="post" name="info">
                <input type="hidden" name="source" value="<?php echo $surce;?>">
                <fieldset>
                <div id="myTabContent" class="tab-content">

                <div class="tab-pane active in" id="resize">
                    <br />
                    <div class="alert alert-info">
                        <?php language_filter("Enter your width and height (pixels).")?>
                    </div>
                    <div class="form-group">
                        <label for="resize_width" class="col-sm-2 control-label"><?php language_filter("Width")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="resize_width" class="form-control" name="width" size="4" maxlength="4">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="resize_height" class="col-sm-2 control-label"><?php language_filter("Height")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="resize_height" class="form-control" name="height" size="4" maxlength="4">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="crop">
                    <br />
                    <div class="alert alert-info">
                        <?php language_filter("CROP TEXT")?>
                    </div>

                    <div class="form-group">
                        <label for="crop_x" class="col-sm-2 control-label"><?php language_filter("X")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="x" size="4" maxlength="4" id="crop_x">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="crop_y" class="col-sm-2 control-label"><?php language_filter("Y")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="y" size="4" maxlength="4" id="crop_y">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="widcrop" class="col-sm-2 control-label"><?php language_filter("Width")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="widcrop" name="widcrop" size="4" maxlength="4">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="heicrop" class="col-sm-2 control-label"><?php language_filter("Height")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="heicrop" size="4" maxlength="4" id="heicrop">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="filter">
                    <br />
                    <div class="alert alert-info">
                        <?php language_filter("Choose your image filter.")?>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="filter" value="GRAYSCALE">
                            <?php language_filter("GRAYSCALE")?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="filter" value="NEGATIVE">
                            <?php language_filter("NEGATIVE")?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="filter" value="REMOVAL">
                            <?php language_filter("REMOVAL")?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="filter" value="EMBOSS">
                            <?php language_filter("EMBOSS")?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="filter" value="BLUR">
                            <?php language_filter("BLUR")?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="filter" value="nofilter">
                            <?php language_filter("No Filter")?>
                        </label>
                    </div>
                </div>

                <div class="tab-pane fade" id="colorize">
                    <br />
                    <div class="alert alert-info">
                        <?php language_filter("Colorize your image. Alpha ranges between 1 to 127.")?>
                    </div>
                    <div class="form-group">
                        <label for="alphacolorize" class="col-sm-2 control-label"><?php language_filter("Alpha")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="alphacolorize" class="form-control" name="alphacolorize" size="4" maxlength="3">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="redsiz" class="col-sm-2 control-label"><?php language_filter("Red")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="redsiz" class="form-control" name="redsiz" value="255" size="3" maxlength="3">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="greensiz" class="col-sm-2 control-label"><?php language_filter("Green")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="greensiz" class="form-control" name="greensiz" value="255" size="3" maxlength="3">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="bluesiz" class="col-sm-2 control-label"><?php language_filter("Blue")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="bluesiz" class="form-control" name="bluesiz" value="255" size="3" maxlength="3">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="rotation">
                    <br />
                    <div class="alert alert-info">
                        <?php language_filter("Rotation Text")?>
                    </div>
                    <div class="form-group">
                        <label for="rotat" class="col-sm-2 control-label"><?php language_filter("Rotation Angle")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="rotat" class="form-control" name="rotat" size="4" maxlength="3">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="red" class="col-sm-2 control-label"><?php language_filter("Red")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="red" class="form-control" name="red" value="255" size="3" maxlength="3">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="green" class="col-sm-2 control-label"><?php language_filter("Green")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="green" class="form-control" name="green" value="255" size="3" maxlength="3">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="blue" class="col-sm-2 control-label"><?php language_filter("Blue")?> :</label>
                        <div class="col-sm-10">
                            <input type="number" id="blue" class="form-control" name="blue" value="255" size="3" maxlength="3">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="text">
                    <br />
                    <div class="alert alert-info">
                        <?php language_filter("Add text to your image.")?>
                    </div>
                    <fieldset>
                        <legend><?php language_filter("Text Place")?></legend>
                        <div class="form-group">
                            <label for="text_x" class="col-sm-2 control-label"><?php language_filter("X")?> :</label>
                            <div class="col-sm-10">
                                <input id="text_x" class="form-control" type="number" name="textx" size="4" maxlength="4">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <label for="text_y" class="col-sm-2 control-label"><?php language_filter("Y")?> :</label>
                            <div class="col-sm-10">
                                <input id="text_y" class="form-control" type="number" name="texty" size="4" maxlength="4">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <label for="add_TXT" class="col-sm-2 control-label"><?php language_filter("Text")?> :</label>
                            <div class="col-sm-10">
                                <input type="text" id="add_TXT" class="form-control" name="text" size="20">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <label for="add_alpha" class="col-sm-2 control-label"><?php language_filter("Alpha")?> :</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="add_alpha" name="alpha" size="4" maxlength="3">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <label for="rottext" class="col-sm-2 control-label"><?php language_filter("Rotation")?> :</label>
                            <div class="col-sm-10">
                                <input type="number" id="rottext" class="form-control" name="rottext" size="4" maxlength="3">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <label for="fontsize" class="col-sm-2 control-label"><?php language_filter("FontSize")?> :</label>
                            <div class="col-sm-10">
                                <input type="number" id="fontsize" class="form-control" name="fontsize" size="4" maxlength="3">
                            </div>
                        </div>

                        <legend><?php language_filter("Font");?></legend>

                        <div class="radio">
                            <label>
                                <input type="radio" name="font" value="../filemanager_assets/arial.ttf">
                                <?php language_filter("Arial")?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="font" value="../filemanager_assets/tahoma.ttf">
                                <?php language_filter("Tahoma")?>
                            </label>
                        </div>

                        <legend><?php language_filter("Text Color")?></legend>
                        <div class="form-group">
                            <label for="redtext" class="col-sm-2 control-label"><?php language_filter("Red")?> :</label>
                            <div class="col-sm-10">
                                <input type="number" id="redtext" class="form-control" name="redtext" value="255" size="3" maxlength="3">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <label for="greentext" class="col-sm-2 control-label"><?php language_filter("Green")?> :</label>
                            <div class="col-sm-10">
                                <input type="number" id="greentext" class="form-control" name="greentext" value="255" size="3" maxlength="3">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <label for="bluetext" class="col-sm-2 control-label"><?php language_filter("Blue")?> :</label>
                            <div class="col-sm-10">
                                <input type="number" id="bluetext" class="form-control" name="bluetext" value="255" size="3" maxlength="3">
                            </div>
                        </div>

                        <legend><?php language_filter("Shadow")?></legend>
                        <div class="radio">
                            <label>
                                <input type="radio" name="shadow" value="shadow">
                                <?php language_filter("Shadow")?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="shadow" value="noshadow">
                                <?php language_filter("No Shadow")?>
                            </label>
                        </div>

                    </fieldset>
                </div>

                <div class="tab-pane fade" id="save">
                    <div class="form-group">
                        <label for="save_dir" class="col-sm-6 control-label"><?php language_filter("SAVE_TEXT")?></label>
                        <div class="col-sm-3">
                            <input type="text" name="path_save" id="save_dir_show" class="form-control" disabled="disabled">
                            <input type="hidden" name="path_save" id="save_dir" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="image_name" class="form-control" id="new_img_name" placeholder="Image Name" onchange="var check = this.value; check = check.indexOf('../'); if(check != -1 || this.value == '') {alert('Please write image name'); return false;}">
                        </div>
                    </div>
                </div>

                </div>
                </fieldset>
                <br><br><br><hr>
                <p style="text-align: center">
                    <input type="submit" name="edit" value="<?php language_filter("Edit")?>" class="btn btn-default" id="edit_btn">
                    <input type="submit" name="save" value="<?php language_filter("Save")?>" class="btn btn-default" <?php if($edited_address == "") echo 'disabled="disabled"';?> style="display: none;" id="save_btn">
                    <input type="submit" name="undo" value="<?php language_filter("Undo")?>" class="btn btn-default" <?php if($edited_address == "") echo 'disabled="disabled"';?> id="undo_btn">
                </p>
                </form>
                </div>
                </div>
                </div>

                <div class="modal fade" id="siteMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php language_filter("Select save image directory")?></h4>
                            </div>
                            <div class="modal-body">
                                <p id="container_id"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php language_filter("Select Directory")?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var method_type = "#resize";
                    function getOffset( el ) {
                        var _x = 0;
                        var _y = 0;
                        while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
                            _x += el.offsetLeft - el.scrollLeft;
                            _y += el.offsetTop - el.scrollTop;
                            el = el.offsetParent;
                        }
                        return { top: _y, left: _x };
                    }
                    var x = getOffset( document.getElementById('user_img') ).left;
                    var Y = getOffset( document.getElementById('user_img') ).top;
                    function find_x_y_crop(e)
                    {
                        if(!e) e = window.event;
                        var relativeX = e.clientX;
                        var relativeY = e.clientY;
                        var image_x = relativeX - x;
                        var image_y = relativeY - Y;
                        if(method_type == "#crop")
                        {
                            $("#crop_x").val(Math.abs(image_x));
                            $("#crop_y").val(Math.abs(image_y));
                        }

                        if(method_type == "#text")
                        {
                            $("#text_x").val(Math.abs(image_x));
                            $("#text_y").val(Math.abs(image_y));
                        }

                    }
                    function set_method_type(method)
                    {
                        method_type = method;
                        if(method == "#save")
                        {
                            var path = '<?php echo addslashes($core->user_dir)."/";?>';
                            showTree(path);
                            $("#save_btn").show();
                            $("#edit_btn").hide();
                            $("#undo_btn").hide();
                        }
                        else
                        {
                            $("#save_btn").hide();
                            $("#edit_btn").show();
                            $("#undo_btn").show();
                        }
                    }
                    function showTree(path)
                    {
                        $('#container_id').fileTree({
                            root: path,
                            script: 'jqueryFileTree.php',
                            expandSpeed: 500,
                            collapseSpeed: 500,
                            multiFolder: false
                        }, function(file) {
                            $("#save_dir").val(file);
                            var parse_user = file.split("/");
                            var user_folder = parse_user.indexOf('<?php echo $core->user_folder_name;?>');
                            for(var i = 0; i <= user_folder; i++)
                            {
                                delete parse_user[i];
                            }
                            var show_to_user = cleanArray(parse_user);
                            show_to_user = show_to_user.join("/");
                            $("#save_dir_show").val(show_to_user+"/");
                            $("#new_img_name").val("new_image_name."+'<?php echo addslashes($real_extension);?>');

                        });
                        $("#siteMap").modal("show");
                    }
                    function cleanArray(actual)
                    {
                        var newArray = new Array();
                        for(var i = 0; i<actual.length; i++){
                            if (actual[i]){
                                newArray.push(actual[i]);
                            }
                        }
                        return newArray;
                    }
                    here = "../";
                </script>

                </div>
                </div>
                </div>

                </body>
                </html>
                <?php
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
        }
        else
        {
            header("Status: 404 Not Found");
        }
    }
}
else
{
    header("Status: 404 Not Found");
}
?>