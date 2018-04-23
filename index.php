<?php
  include 'conns/whiteauth.php';
  $sql = new sql();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <title>Authorization</title>

  <?php
    include 'incs/cssload.php';
  ?>
  <style>
    h1, h2, h3, h4, h5, h6, h7, p, a {
      color: #000;
    }
    .separator {
      border-top: 1px solid #000;
    }
    .login_content h1:before {
      background: rgb(0, 0, 0);
      background: -moz-linear-gradient(right, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
      background: -webkit-linear-gradient(right, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
      background: -o-linear-gradient(right, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
      background: -ms-linear-gradient(right, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
      background: linear-gradient(right, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
      left: 0;
    }
    .login_content h1:after {
      background: rgb(0, 0, 0);
      background: -moz-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0,0, 1) 100%);
      background: -webkit-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
      background: -o-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
      background: -ms-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
      background: linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
      right: 0;
  }
  </style>
  <script src="js/jquery.min.js"></script>

</head>

<body style="background:#4D8F85;">

  <div class="">

    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
      <?php if(isset($_COOKIE['h']) && isset($_COOKIE['u'])) { ?>
        <div id="logout" class="animate form">
          <section class="login_content">
            <a href="coms/logout.php" class="btn btn-danger">Logout</a>
            <a href="/main/" class="btn btn-danger">Main</a>
          </section>
        </div>
      <?php } else { ?> 
        <div id="login" class="animate form">
          <section class="login_content">
            <form action="coms/login.php" method="post" accept-charset="UTF-8" role="form">
              <h1>Login</h1>
              <?php if(isset($_GET['failed']) && $_GET['failed'] == '1') { ?>
                <div class="alert alert-danger">Wrong login or password.</div>
              <?php } else if(isset($_GET['failed']) && $_GET['failed'] == '2') { ?>
                <div class="alert alert-danger">You have to confirm Your email.</div>
              <?php } ?>
              <div>
                <input name="email" type="email" class="form-control" placeholder="Login" <?php if(isset($_GET['failed']) && isset($_GET['email'])) { echo 'value="'.$_GET['email'].'"';} ?> required="" />
              </div>
              <div>
                <input name="password" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <input type="submit" class="btn btn-default submit" value="Enter">
                <a href="#" class="reset_pass" data-dismiss="modal" data-toggle="modal" data-target="#forgotPwd" onclick="return false;">Forgot password?</a>
              </div>
              <div class="clearfix"></div>
              <div class="separator">

                <p class="change_link">Not registered?
                  <a href="#toregister" class="to_register"> CREATE ACCOUNT </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1>
                    <div class="profile_pic" style="width:20%;">
                      <img src="images/logo.png" alt="..." class="img-circle" style="width:90%;border-radius:0;">
                    </div>
                    WHITE STANDARD
                  </h1>

                  <p>&copy;<?php echo date('Y'); ?> All rights reserved. Terms of use.</p>
                </div>
              </div>
            </form>
            <!-- form -->
          </section>
          <!-- content -->
        </div>
        <div id="register" class="animate form">
          <section class="login_content">
            <div class="alert alert-success" style="display:none;" id="signUpSuccess">Registration was successfull! We sent you a confirmation Email.</div>
            <div class="alert alert-danger" style="display:none;" id="unknownError">An unknown Error occured.</div>
            <form id="signUpForm" onsubmit="submForm(); return false;" novalidate>
              <h1>Create account</h1>
              <div>
                <div class="alert alert-danger" style="display:none;" id="invalidEmail">Please fill a valid Email.</div>
                <div class="alert alert-danger" style="display:none;" id="takenEmail">Email already taken.</div>
                <input id="email" name="email" type="email" class="form-control" placeholder="Email" required pattern="[^ @]*@[^ @]*" />
              </div>
              <div>
              <div class="alert alert-danger" style="display:none;" id="signUpPassErr">Passwords do not match.</div>
              <div class="alert alert-danger" style="display:none;" id="pwdStrength">Password must be at least 8 characters in length and contain letters, numbers and special characters.</div>
                <input id="password1" name="password" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <input id="password2" name="password2" type="password" class="form-control" placeholder="Password again" required="" />
              </div>
              <br/>
              <div>
                <div class="alert alert-info" style="display:none;" id="checking">Checking.. Please keep waiting.</div>
                <input type="submit" class="btn btn-default submit" id="sbmtbtn" onclick="submForm(); return false;" value="Create">
              </div>
              <div class="clearfix"></div>
              <div class="separator">

                <p class="change_link">Already registered?
                  <a href="#tologin" class="to_register"> ENTER </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1>
                    <div class="profile_pic" style="width:20%;">
                      <img src="images/logo.png" alt="..." class="img-circle" style="width:90%;border-radius:0;">
                    </div>
                    WHITE STANDARD
                  </h1>

                  <p>&copy;<?php echo date('Y'); ?> All rights reserved. Terms of use.</p>
                </div>
              </div>
            </form>
            <!-- form -->
          </section>
          <!-- content -->
        </div>
      <?php } ?>

    </div>

  </div>

  <!-- BY OLEGTRONICS -->
  <div class="modal fade" id="forgotPwd" tabindex="-1" role="dialog" aria-labelledby="forgotPwdLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <h4 class="text-center">Forgot your password?</h4>
          <div class="alert alert-danger" style="display:none;" id="invalidEmail">Invalid Email.</div>
          <div class="alert alert-danger" style="display:none;" id="forgotEmailNoSuchErr">There is no registration with such an email.</div>
          <div class="alert alert-danger" style="display:none;" id="forgotEmailErr">Please fill a valid Email.</div>
          <div class="alert alert-success" style="display:none;" id="proofEmailTxt">We sent recover instructions to Your email.</div>
          <form id="forgotEmailForm" onsubmit="forgotEmailSubmit(); return false;" novalidate>
            <div class="form-group" id="proofEmailGroup">
              <!-- <label for="forgotEmail">Email</label> -->
              <input type="text" class="form-control" id="forgotEmail" name="forgotEmail" placeholder="Enter your email" required pattern="[^ @]*@[^ @]*">
            </div>
            <div class="alert alert-info" style="display:none;" id="checking2">Checking.. Please keep waiting.</div>
            <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="forgotEmailSubmit(); return false;" id="proofEmailSbmt" style="padding:5px 16px;margin:auto;width:auto;text-decoration:none;">RESET PASSWORD</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.min.js"></script>
  <!-- form validation -->
  <script src="js/validator/validator.js"></script>
  <script>

    jQuery(document).ready(function() {
      
      // if ( jQuery.browser.msie ) {
      //   if(jQuery.browser.version > 9) {
      //       jQuery('.modal').removeClass('fade');
      //   }
      // }

      jQuery('#forgotPwd').on('hidden.bs.modal', function () {
          jQuery('#forgotEmailForm').show();
          jQuery('#proofEmailSbmt').show();
          jQuery('#proofEmailGroup').show();
          jQuery('#proofEmailTxt').hide();
      });

    });

    function validateEmail(email) {
      var valmail = 0;
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
				valmail = 1;
			}
      return valmail;
		}

    function forgotEmailSubmit() {
			jQuery('#waitForForgot').show();
			jQuery('#invalidEmail').hide();
			jQuery('#proofEmailSbmt').hide();
			jQuery('#forgotEmailErr').hide();
			jQuery('#forgotEmailNoSuchErr').hide();
      jQuery('#checking2').show();
      if (jQuery('#forgotEmail').val() != '') {
        if(validateEmail(jQuery('#forgotEmail').val()) == 1) {
          var jsonstr = {
            forgotEmail: jQuery('#forgotEmail').val(),
            resetPwd: 1
          };
          jQuery.ajax({
            dataType: 'json',
            type: 'post',
            url: 'coms/forgotpwd.php',
            data: jsonstr,
            success: function(ress) {
              if (ress[0].emailReset === 1) {
                jQuery('#waitForForgot').hide();
                jQuery('#proofEmailTxt').show();
                jQuery('#forgotEmailErr').hide();
                jQuery('#forgotEmailNoSuchErr').hide();
                jQuery('#proofEmailSbmt').hide();
                jQuery('#proofEmailGroup').hide();
                jQuery('#forgotEmailForm')[0].reset();
                jQuery('#forgotEmailForm').hide();
			          jQuery('#invalidEmail').hide();
                jQuery('#checking2').hide();
              }
              else {
                jQuery('#proofEmailSbmt').show();
                jQuery('#checking2').hide();
                jQuery('#waitForForgot').hide();
                jQuery('#forgotEmailNoSuchErr').show();
              }
            },
            error: function(err) {
              jQuery('#checking2').hide();
              jQuery('#waitForForgot').hide();
              console.log('ERR ' + JSON.stringify(err));
            }
          });
        }
        else {
		    	jQuery('#proofEmailSbmt').show();
          jQuery('#checking2').hide();
          jQuery('#waitForForgot').hide();
			    jQuery('#invalidEmail').show();
        }
      } else {
        jQuery('#waitForForgot').hide();
        jQuery('#forgotEmailErr').show();
        jQuery('#proofEmailSbmt').show();
        jQuery('#checking2').hide();
        jQuery('#forgotEmailNoSuchErr').hide();
			  jQuery('#invalidEmail').hide();
      }
		}

    var strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})');

    function submForm() {
      jQuery('div#signUpPassErr').hide();
      jQuery('div#pwdStrength').hide();
      jQuery('div#invalidEmail').hide();
      jQuery('div#checking').show();
      jQuery('input#sbmtbtn').hide();
      if(jQuery('input#email').val() != '') {
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(jQuery('input#email').val())) {
          if(jQuery('input#password1').val() != '') {
            if (strongRegex.test(jQuery('input#password1').val())) {
              if(jQuery('input#password1').val() == jQuery('input#password2').val()) {
                var jsonstr = {
                  email: jQuery('input#email').val(),
                  password: jQuery('input#password1').val()
                };
                jQuery.ajax({
                  dataType: 'json',
                  type: 'post',
                  url: 'coms/regin.php',
                  data: jsonstr,
                  success: function(ress) {
                    if (ress[0].success === 1) {
                      jQuery('#signUpForm')[0].reset();
                      jQuery('div#signUpPassErr').hide();
                      jQuery('div#pwdStrength').hide();
                      jQuery('div#invalidEmail').hide();
                      jQuery('div#takenEmail').hide();
                      jQuery('div#signUpSuccess').show();
                      jQuery('input#email').hide();
                      jQuery('input#password1').hide();
                      jQuery('input#password2').hide();
                      jQuery('div#checking').hide();
                    }
                    else if(ress[0].success === 0) {
                      jQuery('div#signUpPassErr').hide();
                      jQuery('div#pwdStrength').hide();
                      jQuery('div#invalidEmail').hide();
                      jQuery('div#takenEmail').show();
                      jQuery('div#checking').hide();
                      jQuery('input#sbmtbtn').show();
                    }
                    else {
                      jQuery('div#signUpPassErr').hide();
                      jQuery('div#pwdStrength').hide();
                      jQuery('div#invalidEmail').hide();
                      jQuery('div#unknownError').show();
                      jQuery('div#checking').hide();
                      jQuery('input#sbmtbtn').show();
                    }
                  },
                  error: function(err) {
                    jQuery('#waitForForgot').hide();
                    jQuery('div#checking').hide();
                    jQuery('input#sbmtbtn').show();
                    console.log('ERR ' + JSON.stringify(err));
                  }
                });
              }
              else {
                jQuery('div#checking').hide();
                jQuery('input#sbmtbtn').show();
                jQuery('div#signUpPassErr').show();
              }
            }
            else {
              jQuery('div#checking').hide();
              jQuery('input#sbmtbtn').show();
              jQuery('div#pwdStrength').show();
            }
          }
          else {
            jQuery('div#checking').hide();
            jQuery('input#sbmtbtn').show();
            jQuery('div#pwdStrength').show();
          }
        }
        else {
          jQuery('div#checking').hide();
          jQuery('input#sbmtbtn').show();
          jQuery('#invalidEmail').show();
        }
      }
      else {
        jQuery('div#checking').hide();
        jQuery('input#sbmtbtn').show();
        jQuery('#invalidEmail').show();
      }
    }

  </script>

</body>
</html>
