<?php
  include '../conns/whiteauth.php';
  $sql = new sql();

  $usr = $sql->protect($_COOKIE['u']);
  if(isset($_GET['usr'])) {
    $usr = $sql->protect($_GET['usr']);
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Profile | White Standard</title>

  <?php
    include '../incs/cssload.php';
  ?>
  <script src="../js/jquery.min.js"></script>

  
<style>
  .ui-ribbon-container .ui-ribbon {
      background-color: #00e660 !important;
  }
</style>

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <?php include '../incs/navigation.php'; ?>

      <!-- page content -->
      <div class="right_col" role="main">

        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Profile</h3>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?php echo $sql->levelName($sql->checkLevel()); ?></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <div class="profile_img">

                      <!-- end of image cropping -->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="Change the avatar">
                          <img src="../images/user.png" alt="Avatar">
                        </div>
                        <?php if(!isset($_GET['usr'])) { ?>
                          <!-- Cropping modal -->
                          <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
                                  <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                                    <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="avatar-body">

                                      <!-- Upload image and data -->
                                      <div class="avatar-upload">
                                        <input class="avatar-src" name="avatar_src" type="hidden">
                                        <input class="avatar-data" name="avatar_data" type="hidden">
                                        <label for="avatarInput">Local upload</label>
                                        <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                      </div>

                                      <!-- Crop and preview -->
                                      <div class="row">
                                        <div class="col-md-9">
                                          <div class="avatar-wrapper"></div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="avatar-preview preview-lg"></div>
                                          <div class="avatar-preview preview-md"></div>
                                          <div class="avatar-preview preview-sm"></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- <div class="modal-footer">
                                                    <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                  </div> -->
                                </form>
                              </div>
                            </div>
                          </div>
                          <!-- /.modal -->

                          <!-- Loading state -->
                          <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                        <?php } ?>
                      </div>
                      <!-- end of image cropping -->

                    </div>
                    <h3><?php echo $sql->getAdminUser($usr)['user_name'] . ' ' . $sql->getAdminUser($usr)['user_lastname']; ?></h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-map-marker user-profile-icon"></i><?php echo $sql->getAdminUser($usr)['user_city'] . ' ' . $sql->getAdminUser($usr)['user_country']; ?>
                      </li>

                      <li>
                        <i class="fa fa-briefcase user-profile-icon"></i> <?php echo 'Last visit: ' . date('l jS \of F Y h:i:s A', $sql->getAdminUser($usr)['user_log']); ?>
                      </li>

                      <li>
                        <i class="fa fa-external-link user-profile-icon"></i> <?php echo $sql->getAdminUser($usr)['user_ip']; ?>
                      </li>
                    </ul>

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Personal data</a>
                        </li>
                        <?php if(!isset($_GET['usr'])) { ?>
                          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Password change</a>
                          </li>
                        <?php } ?>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Verification</a>
                        </li>
                        <?php if(!isset($_GET['usr'])) { ?>
                          <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">API</a>
                          </li>
                        <?php } ?>
                        <?php if($sql->checkLevel() != '0') { ?>
                          <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Notes</a>
                          </li>
                        <?php } ?>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        <?php if(!isset($_GET['usr'])) { ?>
                          <form action="/coms/usrdata.php" id="userform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" novalidate>
                            <div class="alert alert-success" style="display:none;" id="saveSuccess">Saved successfully!.</div>
                            <div class="alert alert-danger" style="display:none;" id="saveUnknownError">An unknown Error occured.</div>
                        <?php } ?>
                            <div class="form-group">
                              <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name">Name
                                <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_name']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-6 col-sm-6 col-xs-12" for="lastname">Lastname
                                <input type="text" id="lastname" name="lastname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_lastname']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <div class="form-group">
                              <label for="mobile" class="control-label col-md-6 col-sm-6 col-xs-12">Mobile phone
                                <input type="mobile" id="mobile" name="mobile" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_mobile']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <!-- <div class="form-group">
                              <label for="email" class="control-label col-md-6 col-sm-6 col-xs-12">Email
                                <input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_email']; ?>">
                              </label>
                            </div> -->
                            <div class="form-group">
                              <label for="skype" class="control-label col-md-6 col-sm-6 col-xs-12">Skype
                                <input type="skype" id="skype" name="skype" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_skype']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <div class="form-group">
                              <label for="country" class="control-label col-md-6 col-sm-6 col-xs-12">Country
                                <input type="country" id="country" name="country" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_country']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <div class="form-group">
                              <label for="city" class="control-label col-md-6 col-sm-6 col-xs-12">City
                                <input type="city" id="city" name="city" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_city']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <div class="form-group">
                              <label for="plz" class="control-label col-md-6 col-sm-6 col-xs-12">Postalcode
                                <input type="plz" id="plz" name="plz" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_postal']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <div class="form-group">
                              <label for="address" class="control-label col-md-6 col-sm-6 col-xs-12">Address
                                <input type="address" id="address" name="address" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getAdminUser($usr)['user_adress']; ?>" <?php if(isset($_GET['usr'])) { echo 'disabled'; } ?>>
                              </label>
                            </div>
                            <div class="ln_solid"></div>
                            <?php if(!isset($_GET['usr'])) { ?>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <!-- <button type="submit" class="btn btn-primary">Cancel</button> -->
                                <div class="alert alert-info" style="display:none;" id="savingusr">Checking.. Please keep waiting.</div>
                                <button class="btn btn-success saveusr" onclick="saveUsr(); return false;">Save</button>
                              </div>
                            </div>
                          </form>
                            <?php } ?>
                        </div>
                        <?php if(!isset($_GET['usr'])) { ?>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <div class="alert alert-success" style="display:none;" id="pwdSuccess">Password changed successfully!.</div>
                            <div class="alert alert-danger" style="display:none;" id="unknownError">An unknown Error occured.</div>

                            <form action="/coms/usrdata.php" id="pwdform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" novalidate>
                              <div class="form-group">
                                <div class="alert alert-danger" style="display:none;" id="matchPassErr">Passwords do not match.</div>
                                <div class="alert alert-danger" style="display:none;" id="oldPassErr">Wrong current password.</div>
                                <div class="alert alert-danger" style="display:none;" id="pwdStrength">Password must be at least 8 characters in length and contain letters, numbers and special characters.</div>
                                <label class="control-label col-md-12 col-sm-12 col-xs-12" for="oldpwd">Current password <span class="required">*</span>
                                  <input type="password" id="oldpwd" name="oldpwd" required="required" class="form-control col-md-7 col-xs-12">
                                </label>
                                <label class="control-label col-md-12 col-sm-12 col-xs-12" for="newpwd">New password <span class="required">*</span>
                                  <input type="password" id="newpwd" name="newpwd" required="required" class="form-control col-md-7 col-xs-12">
                                </label>
                                <label class="control-label col-md-12 col-sm-12 col-xs-12" for="newpwdrep">Repeat new password
                                  <input type="password" id="newpwdrep" name="newpwdrep" required="required" class="form-control col-md-7 col-xs-12">
                                </label>
                              </div>
                            </form>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <div class="alert alert-info" style="display:none;" id="checkingpwd">Checking.. Please keep waiting.</div>
                                <button class="btn btn-success pwdchangebtn" onclick="chngPwd(); return false;">Submit</button>
                              </div>
                            </div>

                          </div>
                        <?php } ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          
                          <div class="col-md-3 col-xs-12 widget widget_tally_box">
                            <div class="x_panel ui-ribbon-container fixed_height_390">

                              <?php if($sql->getAdminUser($usr)['user_confirm'] == '1') { ?>
                                <div class="ui-ribbon-wrapper">
                                  <div class="ui-ribbon">
                                    Verified
                                  </div>
                                </div>
                              <?php } ?>

                              <div class="x_title">
                                <h2>Email</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <?php if(!isset($_GET['usr'])) { ?>
                                  <h3 class="name_title">Email</h3>
                                  <p>Confirm received Email</p>

                                  <div class="divider"></div>

                                  <p>You have to click on the link you'll get at registration to confirm your Email.</p>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3 col-xs-12 widget widget_tally_box">
                            <div class="x_panel ui-ribbon-container fixed_height_390">

                              <?php if($sql->getAdminUser($usr)['user_mobile_confirm'] == '1') { ?>
                                <div class="ui-ribbon-wrapper">
                                  <div class="ui-ribbon">
                                    Verified
                                  </div>
                                </div>
                              <?php } ?>

                              <div class="x_title">
                                <h2>Mobile</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <?php if(!isset($_GET['usr'])) { ?>
                                  <!-- <h3 class="name_title">Mobile phone</h3> -->
                                  <p>Confirm your mobile phone number</p>

                                  <div class="divider"></div>

                                  <p>You will receive a text sms with a code, that you have to enter in this form, to confirm your phonenumber.</p>

                                  <?php if($sql->getAdminUser($usr)['user_mobile_confirm'] != '1') { ?>

                                    <div class="input-group">
                                      <input id="phone" name="phone" type="text" class="form-control" <?php if($sql->getAdminUser($usr)['user_mobile']) {echo 'value="'.$sql->getAdminUser($usr)['user_mobile'].'" disabled';}; ?> >
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-success">Send</button>
                                      </span>
                                    </div>
                                    
                                    <div class="input-group">
                                      <input id="reccode" name="reccode" type="text" class="form-control" placeholder="Enter received code">
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">Accept</button>
                                      </span>
                                    </div>

                                  <?php } ?>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3 col-xs-12 widget widget_tally_box">
                            <div class="x_panel ui-ribbon-container fixed_height_390">

                              <?php if($sql->getAdminUser($usr)['user_passport_confirm'] == '1') { ?>
                                <div class="ui-ribbon-wrapper">
                                  <div class="ui-ribbon">
                                    Verified
                                  </div>
                                </div>
                              <?php } else if($sql->getDocsConfirmed('passport', $usr) == '2') { ?>
                                <div class="ui-ribbon-wrapper">
                                  <div class="ui-ribbon" style="background-color:#f11 !important;">
                                    Rejected
                                  </div>
                                </div>
                              <?php } ?>

                              <div class="x_title">
                                <h2>Passport</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <?php if(!isset($_GET['usr'])) { ?>
                                  <!-- <h3 class="name_title">Personal passport</h3> -->
                                  <p>Upload a scan of your documents</p>

                                  <div class="divider"></div>

                                  <p>Upload a high definition scan of your passport.</p>

                                  <?php if($sql->getAdminUser($usr)['user_passport_confirm'] != '1') { ?>

                                    <form enctype="multipart/form-data" action="/coms/upload.php?t=passport" class="dropzone" style="border: 1px solid #e5e5e5; min-height: 100px; height:100%;"></form>

                                  <?php } ?>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3 col-xs-12 widget widget_tally_box">
                            <div class="x_panel ui-ribbon-container fixed_height_390">

                              <?php if($sql->getAdminUser($usr)['user_adress_confirm'] == '1') { ?>
                                <div class="ui-ribbon-wrapper">
                                  <div class="ui-ribbon">
                                    Verified
                                  </div>
                                </div>
                              <?php } else if($sql->getDocsConfirmed('address', $usr) == '2') { ?>
                                <div class="ui-ribbon-wrapper">
                                  <div class="ui-ribbon" style="background-color:#f11 !important;">
                                    Rejected
                                  </div>
                                </div>
                              <?php } ?>

                              <div class="x_title">
                                <h2>Address</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <?php if(!isset($_GET['usr'])) { ?>
                                  <!-- <h3 class="name_title">Address</h3> -->
                                  <p>Confirm your address</p>

                                  <div class="divider"></div>

                                  <p>
                                    To verify the address, upload Receipt for utility bills (gas, water, electricity).
                                  </p>

                                  <?php if($sql->getAdminUser($usr)['user_adress_confirm'] != '1') { ?>

                                    <form enctype="multipart/form-data" action="/coms/upload.php?t=address" class="dropzone" style="border: 1px solid #e5e5e5; min-height: 100px; height:100%; "></form>

                                  <?php } ?>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                        </div>
                        <?php if(!isset($_GET['usr'])) { ?>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                            <p>Some API data </p>
                          </div>
                        <?php } ?>
                        <?php if($sql->checkLevel() != '0') { ?>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">

                            <form action="/coms/usrdata.php" id="notesform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" novalidate>
                              <div class="alert alert-success" style="display:none;" id="saveSuccessNote">Saved successfully!.</div>
                              <div class="alert alert-danger" style="display:none;" id="saveUnknownErrorNote">An unknown Error occured.</div>
                              <div class="form-group">
                                <label for="notes" class="control-label col-md-12 col-sm-12 col-xs-12">About user
                                  <textarea id="notes" name="notes" style="width:100%;height:300px;" ><?php echo $sql->getAdminUser($usr)['user_notes']; ?></textarea>
                                </label>
                              </div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <!-- <button type="submit" class="btn btn-primary">Cancel</button> -->
                                  <div class="alert alert-info" style="display:none;" id="savingnotes">Saving.. Please keep waiting.</div>
                                  <button class="btn btn-success savenotes" onclick="saveNotes(); return false;">Save</button>
                                </div>
                              </div>
                            </form>

                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php include '../incs/footer.php'; ?>

      </div>
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="../js/bootstrap.min.js"></script>
  
  <!-- bootstrap progress js -->
  <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="../js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="../js/icheck/icheck.min.js"></script>

  <script src="../js/custom.js"></script>

  <!-- image cropping -->
  <script src="../js/cropping/cropper.min.js"></script>
  <script src="../js/cropping/main.js"></script>

  <!-- daterangepicker -->
  <script type="text/javascript" src="../js/moment/moment.min.js"></script>
  <script type="text/javascript" src="../js/datepicker/daterangepicker.js"></script>

  <!-- chart js -->
  <script src="../js/chartjs/chart.min.js"></script>

  <!-- moris js -->
  <script src="../js/moris/raphael-min.js"></script>
  <script src="../js/moris/morris.min.js"></script>

  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>
  <!-- dropzone -->
  <script src="../js/dropzone/dropzone.js"></script>

  <script type="text/javascript" src="../js/app.js"></script>
  <script>
    $(function() {
      setTimeout(function() {
        App.getEtherBalance();
        App.getBalance();
      }, 2000);
    })
  </script>
  
  <!-- datepicker -->
  <script type="text/javascript">

    var strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})');

    function chngPwd() {
      jQuery('div#matchPassErr').hide();
      jQuery('div#pwdStrength').hide();
      jQuery('div#oldPassErr').hide();
      jQuery('div#unknownError').hide();
      jQuery('div#pwdSuccess').hide();
      jQuery('div#checkingpwd').show();
      jQuery('button.pwdchangebtn').hide();
      if(jQuery('input#oldpwd').val() != '') {
        if (strongRegex.test(jQuery('input#newpwd').val())) {
          if(jQuery('input#newpwd').val() == jQuery('input#newpwdrep').val()) {
            var jsonstr = {
              pwdold: jQuery('input#oldpwd').val(),
              pwdnew: jQuery('input#newpwd').val(),
              act: 'chngpwd'
            };
            // console.log(JSON.stringify(jsonstr));
            jQuery.ajax({
              dataType: 'json',
              type: 'post',
              url: '/coms/usrdata.php',
              data: jsonstr,
              success: function(ress) {
                // console.log(JSON.stringify(ress));
                if (ress.success === 1) {
                  jQuery('#pwdform')[0].reset();
                  jQuery('div#matchPassErr').hide();
                  jQuery('div#pwdStrength').hide();
                  jQuery('div#oldPassErr').hide();
                  // jQuery('div#takenEmail').hide();
                  jQuery('div#checkingpwd').hide();
                  jQuery('button.pwdchangebtn').show();
                  jQuery('div#pwdSuccess').show();
                }
                else if (ress.success === 2) {
                  jQuery('div#matchPassErr').hide();
                  jQuery('div#pwdStrength').hide();
                  jQuery('div#oldPassErr').show();
                  // jQuery('div#takenEmail').hide();
                  jQuery('div#checkingpwd').hide();
                  jQuery('button.pwdchangebtn').show();
                  jQuery('div#pwdSuccess').hide();
                }
                else {
                  jQuery('div#matchPassErr').hide();
                  jQuery('div#pwdStrength').hide();
                  jQuery('div#oldPassErr').hide();
                  // jQuery('div#takenEmail').hide();
                  jQuery('div#checkingpwd').hide();
                  jQuery('button.pwdchangebtn').show();
                  jQuery('div#pwdSuccess').hide();
                  jQuery('div#unknownError').show();
                }
              },
              error: function(err) {
                jQuery('div#matchPassErr').hide();
                jQuery('div#pwdStrength').hide();
                jQuery('div#oldPassErr').hide();
                // jQuery('div#takenEmail').hide();
                jQuery('div#checkingpwd').hide();
                jQuery('button.pwdchangebtn').show();
                jQuery('div#pwdSuccess').hide();
                jQuery('div#unknownError').show();
                // console.log('ERR ' + JSON.stringify(err));
              }
            });
          }
          else {
            jQuery('div#checkingpwd').hide();
            jQuery('button.pwdchangebtn').show();
            jQuery('div#matchPassErr').show();
          }
        }
        else {
          jQuery('div#checkingpwd').hide();
          jQuery('button.pwdchangebtn').show();
          jQuery('div#pwdStrength').show();
        }
      }
      else {
        jQuery('div#checkingpwd').hide();
        jQuery('button.pwdchangebtn').show();
        jQuery('div#pwdStrength').show();
      }
    }

    function saveUsr() {
      jQuery('div#checkingpwd').show();
      jQuery('button.saveusr').hide();
      jQuery('div#saveSuccess').hide();
      jQuery('div#saveUnknownError').hide();
      var jsonstr = $('form#userform').serialize()+'&act=updusr';
      // console.log(JSON.stringify(jsonstr));
      jQuery.ajax({
        dataType: 'json',
        type: 'post',
        url: '/coms/usrdata.php',
        data: jsonstr,
        success: function(res) {
          // console.log(JSON.stringify(res))
          if (res.success === 1) {
            jQuery('div#checkingpwd').hide();
            jQuery('button.saveusr').show();
            jQuery('div#saveSuccess').show();
            jQuery('div#saveUnknownError').hide();
          }
          else {
            jQuery('div#checkingpwd').hide();
            jQuery('button.saveusr').show();
            jQuery('div#saveSuccess').hide();
            jQuery('div#saveUnknownError').show();
          }
        },
        error: function(err) {
          jQuery('div#checkingpwd').hide();
          jQuery('button.saveusr').show();
          jQuery('div#saveSuccess').hide();
          jQuery('div#saveUnknownError').show();
          // console.log('ERR '+JSON.stringify(err))
        }
      });
    }

    <?php if($sql->getAdminUser($usr)['user_adress_confirm'] == '1' && isset($_GET['usr'])) { ?>

      function saveNotes() {
        jQuery('div#savingnotes').show();
        jQuery('button.saveusr').hide();
        jQuery('div#saveSuccessNote').hide();
        jQuery('div#saveUnknownErrorNote').hide();
        var jsonstr = $('form#notesform').serialize()+'&act=usrnotes&usr=<?php echo $_GET['usr']; ?>';
        // console.log(JSON.stringify(jsonstr));
        jQuery.ajax({
          dataType: 'json',
          type: 'post',
          url: '/coms/usrdata.php',
          data: jsonstr,
          success: function(res) {
            // console.log(JSON.stringify(res))
            if (res.success === 1) {
              jQuery('div#savingnotes').hide();
              jQuery('button.saveusr').show();
              jQuery('div#saveSuccessNote').show();
              jQuery('div#saveUnknownErrorNote').hide();
            }
            else {
              jQuery('div#savingnotes').hide();
              jQuery('button.saveusr').show();
              jQuery('div#saveSuccessNote').hide();
              jQuery('div#saveUnknownErrorNote').show();
            }
          },
          error: function(err) {
            jQuery('div#savingnotes').hide();
            jQuery('button.saveusr').show();
            jQuery('div#saveSuccessNote').hide();
            jQuery('div#saveUnknownErrorNote').show();
            // console.log('ERR '+JSON.stringify(err))
          }
        });
      }

    <?php } ?>

    $(document).ready(function() {

      var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
          days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
          applyLabel: 'Submit',
          cancelLabel: 'Clear',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          firstDay: 1
        }
      };
      $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
      });
      $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
      });
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
      });
      $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
      });
      $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
      });
      $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
      });

    });

  </script>
  <!-- /datepicker -->
</body>

</html>
