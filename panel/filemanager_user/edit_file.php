<?php
require_once '../filemanager_user_core.php';
$core = new filemanager_user_core();
require_once '../filemanager_language_user.php';
$core->userInfo();
if ($core->isLogin())
{
    if($core->user_can_do_it($core->user_id, "edit_files", $core->user_limitation))
    {
        if(isset($_GET["info"]))
        {
            $file = utf8_decode(base64_decode($_GET["info"]));
            if($core->check_base_root($file))
            {
                if(is_file($file))
                {
                    $result = "";
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    $name = end(explode("/", $file));
                    if($ext == "txt")
                    {
                        $post = "save_".md5($file);
                        if(isset($_POST[$post]))
                        {
                            $new = $_POST["new_value"];
                            $fp = fopen($file, "w");
                            fwrite($fp, $new);
                            fclose($fp);
                            $result = '<div class="alert alert-success" style="text-align: center"><b>'.language_filter("Your file has been saved.", true).'</b></div>';
                        }
                        $input = file_get_contents($file);
                        ?>
                    <html>
                    <head>
                        <meta charset="<?php echo $language["charset"];?>">
                        <link href='https://cdn.jsdelivr.net/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' />
                        <title><?php echo $language["title"];?></title>
                        <style type="text/css">
                            body {
                                padding-top: 20px;
                                padding-bottom: 20px;
                                direction: <?php echo $language["direction"];?>;
                            }

                            .navbar {
                                margin-bottom: 20px;
                            }

                            .popover{
                                width:400px;
                            }
                        </style>
                    </head>
                    <body>

                    <div class="container">
                        <div class="row">
                            <?php echo $result;?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b><?php language_filter("Edit")?> "<?php echo $name;?>"</b>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="edit_file.php?info=<?php echo base64_encode(utf8_encode($file));?>">
                                        <textarea style="width: 100%; height: 400px;" class="form-control" name="new_value"><?php echo $input;?></textarea>
                                        <br />
                                        <button type="submit" name="save_<?php echo md5($file);?>" class="btn btn-success"><?php language_filter("Save")?></button>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="footer">
                                <p><?php language_filter("Footer Text")?></p>
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
?>