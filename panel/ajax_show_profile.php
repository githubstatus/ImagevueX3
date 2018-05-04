<?php
if (!isset($core))
{
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
    require_once 'filemanager_language.php';
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if (isset($_POST["showProfile"]) and $core->role == "admin")
        {
            $core->adminInfo();
            if ($_POST["showProfile"] == $core->admin_id)
            {
    ?>
    					<div class="x3-profile x3-panel-section">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab"><?php language_filter("Profile")?></a></li>
                    <li><a href="#profile" data-toggle="tab"><?php language_filter("Password")?></a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="home">
                        <br/>
                        <form id="tab" name="editProfile">
                            <div class="form-group">
                                <label for="username_form"><?php language_filter("Username")?></label>
                                <input type="text" id="username_form" name="username" value="<?php echo $core->admin_username;?>" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="firstname_form"><?php language_filter("First Name")?></label>
                                <input type="text" id="firstname_form" name="firstname" value="<?php echo $core->admin_firstname;?>" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="lastname_form"><?php language_filter("Last Name")?></label>
                                <input type="text" id="lastname_form" name="lastname" value="<?php echo $core->admin_lastname;?>" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="email_form"><?php language_filter("Email")?></label>
                                <input type="email" id="email_form" name="email" value="<?php echo $core->admin_email;?>" class="form-control" required="required">
                            </div>

                            <input type="hidden" name="id" value="<?php echo $core->admin_id;?>" class="form-control" required="required">
                            <div>
                                <button type="button" class="btn btn-primary" onclick="updateProfile();"><?php language_filter("Update")?></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile">
                        <br />
                        <form id="tab2" name="editPassword">
                            <div class="form-group">
                                <label for="password_form"><?php language_filter("New Password")?></label>
                                <input type="password" id="password_form" name="newPass" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="newPassform"><?php language_filter("Repeat New Password")?></label>
                                <input type="password" id="newPassform" name="newPassRepeat" class="form-control" required="required">
                            </div>

                            <input type="hidden" name="id" value="<?php echo $core->admin_id;?>" class="form-control" required="required">
                            <div>
                                <button type="button" class="btn btn-primary" onclick="updatePassword();"><?php language_filter("Update")?></button>
                            </div>
                        </form>
                    </div>
                </div>
               </div>



              <script>
              reload = false;
              function updateProfile()
              {
                    var username = document.forms["editProfile"]["username"].value;
                    var firstname = document.forms["editProfile"]["firstname"].value;
                    var lastname = document.forms["editProfile"]["lastname"].value;
                    var email = document.forms["editProfile"]["email"].value;
                    var id = document.forms["editProfile"]["id"].value;
                    $("#show_status").html('');
                    if(username == "" || firstname == "" || lastname == "" || email == "")
                    {
                        show_errors_on_nav("<?php language_filter("Please fill the fields", false, true);?>", "red");
                        return false;
                    }

                    if(validateEmail(email) == false)
                    {
                        show_errors_on_nav("<?php language_filter("Please write a valid email", false, true)?>", "red");
                        return false;
                    }
                    show_preloader();
                    setTimeout(function(){
                        $.post("ajax_update_profile.php",
                        {
                            admin_id:id,
                            admin_username:username,
                            admin_firstname:firstname,
                            admin_lastname:lastname,
                            admin_email:email
                        },
                        function(data,status)
                        {
                            if(status == "success")
                            {
                                if(data == "true")
                                {
                                    show_errors_on_nav("<?php language_filter("Your profile has been edited", false, true)?>", "green");
                                    $("#welcome").html("<?php language_filter("Welcome", false, true)?> " + firstname + " " + lastname);
                                }
                                else
                                {
                                    if(data == 'null')
                                    {
                                        show_errors_on_nav("<?php language_filter("Your username or email already exists", false, true)?>", "red");
                                    }
                                    else
                                    {
                                        show_errors_on_nav("<?php language_filter("Your profile has not been edited", false, true)?>", "green");
                                    }
                                }
                                showEditProfile();
                            }
                            else
                            {
                                $('.bar').width("30%");
                                $('.bar').width("50%");
                                $('.bar').width("80%");
                                $('.bar').width("100%");
                                $('.bar').addClass('bar-danger');
                                $('.bar').html("<center>Can not load page, click to exit. SERVER STATUS: "+status+"</center>");
                            }

                        });
                    }, 1000);

              }


              function updatePassword()
              {
                  var id = document.forms["editPassword"]["id"].value;
                  var newPass = document.forms["editPassword"]["newPass"].value;
                  var PassRepeat = document.forms["editPassword"]["newPassRepeat"].value;
                  $("#show_status").html('');
                  if(newPass == "" || PassRepeat == "")
                  {
                        show_errors_on_nav("<?php language_filter("Please fill the fields", false, true)?>", "red");
                        return false;
                  }


                  if(newPass != PassRepeat)
                  {
                      show_errors_on_nav("<?php language_filter("Your password is not match", false, true)?>", "red");
                      return false;
                  }

                  show_preloader();
                  setTimeout(function(){
                      $.post("ajax_update_profile.php",
                      {
                          admin_change_pass_id:id,
                          admin_newPass:newPass
                      },
                      function(data,status)
                      {
                          if(status == "success")
                          {
                              $('#preloader').modal('hide');
                              if(data == "true")
                              {
                                  show_errors_on_nav("<?php language_filter("Your password has been changed. please wait, reloading...", false, true)?>", "green");
                                  reload = true;
                                  setTimeout(function() {
                                      if(reload == true)
                                          window.location.href = ".";
                                  }, 3000);
                              }
                              else
                              {
                                  show_errors_on_nav("<?php language_filter("Your password has not been changed", false, true)?>", "red");
                                  reload = false;
                              }
                          }
                          else
                          {
                              $('.bar').width("30%");
                              $('.bar').width("50%");
                              $('.bar').width("80%");
                              $('.bar').width("100%");
                              $('.bar').addClass('bar-danger');
                              $('.bar').html("<center>Can not load page, click to exit. SERVER STATUS: "+status+"</center>");
                          }

                      });
                  }, 1000);


              }

              function validateEmail(email)
              {
                  var atpos = email.indexOf("@");
                  var dotpos = email.lastIndexOf(".");
                  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
                  {
                       return false;
                  }
                  else
                  {
                       return true;
                  }
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
else
{
    header("Status: 404 Not Found");
}