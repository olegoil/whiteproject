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

  <title>FAQ | White Standard</title>

  <?php
    include '../incs/cssload.php';
  ?>
  <script src="../js/jquery.min.js"></script>

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
              <h3>FAQ</h3>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-align-left"></i> Questions and Answers</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <!-- start accordion -->
                  <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                    <?php if($sql->checkLevel() == '1') { ?>
                      <div class="panel">
                        <a class="panel-heading" role="tab" id="headingBtns" data-toggle="collapse" data-parent="#accordion" href="#collapseBtns" aria-expanded="true" aria-controls="collapseBtns">
                          <h4 class="panel-title">Manager actions</h4>
                        </a>
                        <div id="collapseBtns" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingBtns">
                          <div class="panel-body">
                              <button class="btn btn-default" onclick=""></button>
                          </div>
                        </div>
                      </div>
                    <?php } ?>

                    <div class="panel">
                      <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="panel-title">How to get WC?</h4>
                      </a>
                      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <p><strong>Give us Ether</strong></p>
                          Ipsum lorem ...
                        </div>
                      </div>
                    </div>
                    <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title">How to send WC?</h4>
                      </a>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          <p><strong>Simple send</strong>
                          </p>
                          Lorem ipsum..
                        </div>
                      </div>
                    </div>
                    <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="panel-title">Money not received?</h4>
                      </a>
                      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                          <p><strong>Why I don't received money yet?</strong>
                          </p>
                          Lorem Ipsum..
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end of accordion -->


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

  <script>
    $(function() {
      var cnt = 10; //$("#custom_notifications ul.notifications li").length + 1;
      TabbedNotification = function(options) {
        var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
          "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

        if (document.getElementById('custom_notifications') == null) {
          alert('doesnt exists');
        } else {
          $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
          $('#custom_notifications #notif-group').append(message);
          cnt++;
          CustomTabs(options);
        }
      }

      CustomTabs = function(options) {
        $('.tabbed_notifications > div').hide();
        $('.tabbed_notifications > div:first-of-type').show();
        $('#custom_notifications').removeClass('dsp_none');
        $('.notifications a').click(function(e) {
          e.preventDefault();
          var $this = $(this),
            tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
            others = $this.closest('li').siblings().children('a'),
            target = $this.attr('href');
          others.removeClass('active');
          $this.addClass('active');
          $(tabbed_notifications).children('div').hide();
          $(target).show();
        });
      }

      CustomTabs();

      var tabid = idname = '';
      $(document).on('click', '.notification_close', function(e) {
        idname = $(this).parent().parent().attr("id");
        tabid = idname.substr(-2);
        $('#ntf' + tabid).remove();
        $('#ntlink' + tabid).parent().remove();
        $('.notifications a').first().addClass('active');
        $('#notif-group div').first().css('display', 'block');
      });
    })
  </script>
  <script type="text/javascript">
    var permanotice, tooltip, _alert;
    $(function() {
      // new PNotify({
      //   title: "PNotify",
      //   type: "dark",
      //   text: "Welcome. Try hovering over me. You can click things behind me, because I'm non-blocking.",
      //   nonblock: {
      //     nonblock: true
      //   },
      //   before_close: function(PNotify) {
      //     // You can access the notice's options with this. It is read only.
      //     //PNotify.options.text;

      //     // You can change the notice's options after the timer like this:
      //     PNotify.update({
      //       title: PNotify.options.title + " - Enjoy your Stay",
      //       before_close: null
      //     });
      //     PNotify.queueRemove();
      //     return false;
      //   }
      // });

    });
  </script>
  <script>
    $(document).ready(function() {
      $('.progress .bar').progressbar(); // bootstrap 2
      $('.progress .progress-bar').progressbar(); // bootstrap 3
    });
  </script>

</body>

</html>
