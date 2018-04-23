<?php
  include '../conns/whiteauth.php';
  $sql = new sql();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Send money | White Standard</title>

  <?php
    include '../incs/cssload.php';
  ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery.qrcode.min.js"></script>
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
              <h3>Send Money</h3>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Send Money <small>from my wallet</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                <?php if($sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') { ?>
                  <div class="container">
                <form action="/coms/sendmoney.php" id="myForm" name="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                  <!-- Smart Wizard -->
                  <p>Select the wallet you want to send from and point the wallet you want to send money to.</p>
                  <div id="smartwizard">
                    <ul>
                      <li>
                        <a href="#step-1">
                            <span>1</span>
                            <span>
                                Select Wallet<br />
                                <small>Select your wallet</small>
                            </span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-2">
                            <span>2</span>
                            <span>
                              Payment confirmation<br/>
                              <small>Please check payment data</small>
                            </span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-3">
                            <span>3</span>
                            <span>
                              Conditions<br/>
                              <small>Accept our conditions</small>
                            </span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-4">
                          <span>4</span>
                          <span>
                              Payment Sent!<br />
                              <small>Your payment is awaiting confirmation!</small>
                          </span>
                        </a>
                      </li>
                    </ul>
                    <div>
                    <div id="step-1">
                      <!-- <h2>Select Wallet</h2> -->
                      <div id="form-step-0" role="form" data-toggle="validator">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label" for="walletSend">Wallet sender<span class="required">*</span>
                            </label>
                            <select id="walletSend" name="walletSend" required="required" class="form-control col-md-7 col-xs-12">
                              <?php
                                echo '<option value="'.$sql->getBalance(0)['recid'].'">WCR</option>';
                                // echo '<option value="'.$sql->getBalance(1)['recid'].'">WCUR</option>';
                                // echo '<option value="'.$sql->getBalance(2)['recid'].'">Bitcoin</option>';
                                // echo '<option value="'.$sql->getBalance(3)['recid'].'">Ethereum</option>';
                              ?>
                            </select>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label" for="sendAmount">Sending amount<span class="required">*</span>
                            </label>
                            <input type="text" id="sendAmount" name="sendAmount" required="required" class="form-control col-md-7 col-xs-12">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label" for="walletRec">Wallet receiver <span class="required">*</span>
                            </label>
                            <input type="text" id="walletRec" name="walletRec" required="required" class="form-control col-md-7 col-xs-12">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="recAmount" class="control-label">Receiving amount</label>
                            <input id="recAmount" class="form-control col-md-7 col-xs-12" type="text" name="recAmount">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="sendNotes" class="control-label col-md-3 col-sm-3 col-xs-12">Notes</label>
                            <textarea id="sendNotes" class="form-control col-md-7 col-xs-12" name="sendNotes"></textarea>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div id="step-2">
                      <!-- <h2>Check data</h2> -->
                      <div id="form-step-1" role="form" data-toggle="validator">
                        <h2>From wallet</h2>
                        <p id="fromWalletConf"></p>
                        <h2>To wallet</h2>
                        <p id="toWalletConf"></p>
                        <h2>Sending sum</h2>
                        <p id="sendSumConf"></p>
                        <h2>Commissions</h2>
                        <p id="commsConf"></p>
                        <h2>Receiving sum</h2>
                        <p id="amountRecConf"></p>
                        <h2>Notes</h2>
                        <p id="notesConf"></p>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div id="step-3">
                      <!-- <h2>Accept conditions</h2> -->
                      <div id="form-step-2" role="form" data-toggle="validator">
                        <h2 class="StepTitle">Transfer conditions</h2>
                        <p>
                          By proceeding the transfer you accept the following conditions:
                          <br/>
                          Lorem Ipsum ...
                        </p>
                        <!-- <div id="qrcode"></div> -->
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div id="step-4" class="">
                      <h2 id="finalShotTitle" class="StepTitle">Congratulations!</h2>
                      <p id="finalShotText">Your payment gone!</p>
                      <div class="clearfix"></div>
                    </div>
                    </div>
                  </div>
                  <!-- End SmartWizard Content -->

                </form>
                </div>
                <?php } else { ?>
                    <h2>Not verified user. Just verfificated user are able to send money. <a href="/profile/">Go to verification.</a></h2>
                <?php } ?>

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
  <!-- Include jQuery Validator plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
  <!-- form wizard -->
  <script type="text/javascript" src="../js/wizard/jquery.smartWizard.min.js"></script>
  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>
  <!-- PNotify -->
  <script type="text/javascript" src="../js/notify/pnotify.core.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.buttons.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.nonblock.js"></script>

  <script type="text/javascript" src="../js/app.js"></script>
  <script>
    $(function() {
      setTimeout(function() {
        App.getEtherBalance();
        App.getBalance();
      }, 2000);
    })
  </script>

  <script type="text/javascript">
    <?php if($sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') { ?>
  
      $(document).ready(function() {

          var fromWallet = $('select#walletSend').val();
          var toWallet = $('input#walletRec').val();
          var sendAmount = $('input#sendAmount').val();
          var sendNotes = $('textarea#sendNotes').val();

          $('select#walletSend').change(function() {
            if($('select#walletSend option:selected').text() == 'WCUR' || $('select#walletSend option:selected').text() == 'Ethereum') {
              if(contractAddress) {
                $('p#fromWalletConf').html(contractAddress);
              }
              else {
                new PNotify({
                  title: "WhiteCoin + Metamask",
                  type: "error",
                  text: "Please log in to Metamask extension!",
                  nonblock: {
                    nonblock: true
                  },
                  before_close: function(PNotify) {
                    PNotify.update({
                        title: PNotify.options.title + " - Enjoy your Stay",
                        before_close: null
                    });
                    PNotify.queueRemove();
                    return false;
                  }
                });
              }
            }
            else {
              $('p#fromWalletConf').html($('select#walletSend').val());
            }
          });

          $('input#sendAmount').keyup(function() {
            $('p#sendSumConf').html($('input#sendAmount').val());
            $('input#recAmount').val($('input#sendAmount').val()*0.95);
            $('p#commsConf').html($('input#sendAmount').val()*0.05);
            $('p#amountRecConf').html($('input#sendAmount').val()*0.95);
          });

          $('input#walletRec').keyup(function() {
            $('p#toWalletConf').html($('input#walletRec').val());
          });

          $('input#recAmount').keyup(function() {
            $('p#commsConf').html($('input#sendAmount').val()*0.05);
            $('p#amountRecConf').html($('input#sendAmount').val()*0.95);
            $('p#sendSumConf').html($('input#sendAmount').val());
            $('input#recAmount').val($('input#sendAmount').val()*0.95);
          });

          $('textarea#sendNotes').keyup(function() {
            $('p#notesConf').html($('textarea#sendNotes').val());
          });

          $('p#fromWalletConf').html($('select#walletSend').val());

          $('#smartwizard').smartWizard({
            selected: 0,  // Initial selected step, 0 = first step 
            keyNavigation:true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            autoAdjustHeight:true, // Automatically adjust content height
            cycleSteps: false, // Allows to cycle the navigation of steps
            backButtonSupport: true, // Enable the back button support
            useURLhash: false, // Enable selection of the step based on url hash
            lang: {  // Language variables
                next: 'Next', 
                previous: 'Previous'
            },
            toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true // show/hide a Previous button
                // toolbarExtraButtons: [btnFinish, btnCancel]
            }, 
            anchorSettings: {
                anchorClickable: true, // Enable/Disable anchor navigation
                enableAllAnchors: false, // Activates all anchors clickable all times
                markDoneStep: true, // add done css
                enableAnchorOnDoneStep: true, // Enable/Disable the done steps navigation
                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
            },            
            contentURL: null, // content url, Enables Ajax content loading. can set as data data-content-url on anchor
            disabledSteps: [],    // Array Steps disabled
            errorSteps: [],    // Highlight step with errors
            theme: 'arrows',
            transitionEffect: 'fade', // Effect on navigation, none/slide/fade
            transitionSpeed: '400'
          });

          $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
            var elmForm = $("#form-step-" + stepNumber);
            // stepDirection === 'forward' :- this condition allows to do the form validation
            // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
            if(stepDirection === 'forward' && elmForm) {
              elmForm.validator('validate');
              var elmErr = elmForm.children('.has-error');
              if(elmErr && elmErr.length > 0){
                  // Form validation failed
                  return false;
              }
            }
            return true;
          });

          $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
              // Enable finish button only on last step
              if(stepNumber == 3) {

                if($('select#walletSend option:selected').text() == "WCR") {
                  var notesenc = encodeURIComponent($('textarea#sendNotes').val());
                  var sendstr = 'amnt='+$('input#sendAmount').val()+'&adr='+$('input#walletRec').val()+'&notes='+notesenc+'&fromadr='+$('select#walletSend').val()+'&act=sendwc';
                  $.ajax({
                    type: 'post',
                    data: sendstr,
                    url: '/coms/mktransaction.php',
                    success: function(suc) {
                      var succ = JSON.parse(suc);
                      console.log(JSON.stringify(suc));
                      if(succ.success == 1) {
                        $('#finalShotTitle').html('Congratulations!');
                        $('#finalShotText').html('Your payment gone!');
                        new PNotify({
                          title: "Success!",
                          type: "success",
                          text: "Transaction gone.",
                          nonblock: {
                            nonblock: true
                          },
                          before_close: function(PNotify) {
                            // You can access the notice's options with this. It is read only.
                            //PNotify.options.text;

                            // You can change the notice's options after the timer like this:
                            PNotify.update({
                              title: PNotify.options.title + " - Enjoy your Stay",
                              before_close: null
                            });
                            PNotify.queueRemove();
                            return false;
                          }
                        });
                        $('button.sw-btn-next').hide();
                        $('button.sw-btn-prev').hide();
                        setTimeout(function() {
                          $('#smartwizard').smartWizard("reset");
                          $('#myForm').find("input, textarea").val("");
                          $('#myForm').find("select").val("WCR");
                          $('#fromWalletConf').html("");
                          $('#toWalletConf').html("");
                          $('#sendSumConf').html("");
                          $('#commsConf').html("");
                          $('#amountRecConf').html("");
                          $('#notesConf').html("");
                        }, 2000);
                      }
                      else if(succ.success == 0) {
                        $('#finalShotTitle').html('Error!');
                        $('#finalShotText').html('Not enough money in your wallet.');
                        new PNotify({
                          title: "Not enough money!",
                          type: "error",
                          text: "Not enough money in your wallet.",
                          nonblock: {
                            nonblock: true
                          },
                          before_close: function(PNotify) {
                            // You can access the notice's options with this. It is read only.
                            //PNotify.options.text;

                            // You can change the notice's options after the timer like this:
                            PNotify.update({
                              title: PNotify.options.title + " - Enjoy your Stay",
                              before_close: null
                            });
                            PNotify.queueRemove();
                            return false;
                          }
                        });
                      }
                      else if(succ.success == 2) {
                        $('#finalShotTitle').html('Error!');
                        $('#finalShotText').html('No receiver!');
                        new PNotify({
                          title: "No receiver!",
                          type: "error",
                          text: "There is no receiver with this wallet.",
                          nonblock: {
                            nonblock: true
                          },
                          before_close: function(PNotify) {
                            // You can access the notice's options with this. It is read only.
                            //PNotify.options.text;

                            // You can change the notice's options after the timer like this:
                            PNotify.update({
                              title: PNotify.options.title + " - Enjoy your Stay",
                              before_close: null
                            });
                            PNotify.queueRemove();
                            return false;
                          }
                        });
                      }
                    },
                    error: function(err) {
                      $('#finalShotTitle').html('Error!');
                      $('#finalShotText').html('An unknown error occurred!');
                      new PNotify({
                        title: "Error!",
                        type: "error",
                        text: "An unknown error occurred!",
                        nonblock: {
                          nonblock: true
                        },
                        before_close: function(PNotify) {
                          // You can access the notice's options with this. It is read only.
                          //PNotify.options.text;

                          // You can change the notice's options after the timer like this:
                          PNotify.update({
                            title: PNotify.options.title + " - Enjoy your Stay",
                            before_close: null
                          });
                          PNotify.queueRemove();
                          return false;
                        }
                      });
                      console.log(JSON.stringify(err));
                      $('.sendredeem').show();
                    }
                  });
                }
                else if($('select#walletSend option:selected').text() == 'WCUR' || $('select#walletSend option:selected').text() == 'Ethereum') {
                  if(parseInt($('input#sendAmount').val()) > 0) {
                    if(contractAddress != '0' && contractAddress != '') {
                      if(parseFloat(wcursum) >= parseFloat($('input#sendAmount').val())) {
                        App.transferPrivate($('input#walletRec').val(), $('input#sendAmount').val());
                      }
                      else {
                        $('#finalShotTitle').html('Error!');
                        $('#finalShotText').html('Not enough money in your wallet.');
                        new PNotify({
                          title: "Not enought money",
                          type: "error",
                          text: "There is not enought money on your account.",
                          nonblock: {
                            nonblock: true
                          },
                          before_close: function(PNotify) {
                            // You can access the notice's options with this. It is read only.
                            //PNotify.options.text;

                            // You can change the notice's options after the timer like this:
                            PNotify.update({
                              title: PNotify.options.title + " - Enjoy your Stay",
                              before_close: null
                            });
                            PNotify.queueRemove();
                            return false;
                          }
                        });
                      }
                    }
                    else {
                      $('#finalShotTitle').html('Error!');
                      $('#finalShotText').html('Please login into your Metamask and refresh this page.');
                      new PNotify({
                        title: "White Standard + Metamask",
                        type: "error",
                        text: "Please login into your Metamask and refresh this page.",
                        nonblock: {
                          nonblock: true
                        },
                        before_close: function(PNotify) {
                          // You can access the notice's options with this. It is read only.
                          //PNotify.options.text;

                          // You can change the notice's options after the timer like this:
                          PNotify.update({
                            title: PNotify.options.title + " - Enjoy your Stay",
                            before_close: null
                          });
                          PNotify.queueRemove();
                          return false;
                        }
                      });
                    }
                  }
                  else {
                    $('#finalShotTitle').html('Error!');
                    $('#finalShotText').html('There is no sum defined to send!');
                    new PNotify({
                      title: "No sum!",
                      type: "error",
                      text: "There is no sum defined to send!",
                      nonblock: {
                        nonblock: true
                      },
                      before_close: function(PNotify) {
                        // You can access the notice's options with this. It is read only.
                        //PNotify.options.text;

                        // You can change the notice's options after the timer like this:
                        PNotify.update({
                          title: PNotify.options.title + " - Enjoy your Stay",
                          before_close: null
                        });
                        PNotify.queueRemove();
                        return false;
                      }
                    });
                  }
                }

              }
              else if(stepNumber == 2) {
                $('button.sw-btn-next').text('Send').removeClass('btn-secondary').addClass('btn-success');
              }
              else {
                $('button.sw-btn-next').text('Next').show().removeClass('btn-success').addClass('btn-secondary');
              }
          });

          // $('#qrcode').qrcode("this plugin is great");

      });

    <?php } ?>
  </script>

</body>

</html>
