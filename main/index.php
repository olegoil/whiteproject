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

  <title>Main | White Standard</title>

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

        <br />
        <div class="">

          <div class="val top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-krw"></i>
                </div>
                <div class="count wcrestricted"><?php echo round($sql->getBalance(0)['amount'], 8); ?></div>

                <h3>WC Restricted</h3>
                <p>Internal wallet.</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-krw"></i>
                </div>
                <div class="count wcunrestricted"><?php echo round($sql->getBalance(1)['amount'], 8); ?></div>

                <h3>WC Unrestricted</h3>
                <p>External wallet.</p>
              </div>
            </div>
            <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-bitcoin"></i>
                </div>
                <div class="count bitcoin"><?php echo round($sql->getBalance(2)['amount'], 8); ?></div>

                <h3>Bitcoin</h3>
                <p>Bitcoin wallet.</p>
              </div>
            </div> -->
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-inr"></i>
                </div>
                <div class="count ethereum"><?php echo round($sql->getBalance(3)['amount'], 8); ?></div>

                <h3>Ethereum</h3>
                <p>Ethereum wallet.</p>
              </div>
            </div>
          </div>

          <div class="val">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Transaction Summary <small>Monthly progress</small></h2>
                  <!-- <div class="filter">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>January 30, <?php echo date('Y'); ?> - Juni 28, <?php echo date('Y'); ?></span> <b class="caret"></b>
                    </div>
                  </div> -->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="demo-container" style="height:280px">
                      <div id="placeholder33x" class="demo-placeholder"></div>
                    </div>
                    <div class="tiles">
                      <div class="col-md-4 tile">
                        <span>Incoming Us. Dollar Transactions</span>
                        <h2>$<?php echo $sql->getIncomeTransactions() * $sql->getExchangeRate('USD', 'WCR')['amount1']; ?></h2>
                        <span class="sparkline11 graph" style="height: 160px;">
                          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
                      </div>
                      <div class="col-md-4 tile">
                        <span>Total Balance in USD Value</span>
                        <h2>$<?php echo $sql->getBalance(0)['amount'] * $sql->getExchangeRate('USD', 'WCR')['amount1']; ?></h2>
                        <span class="sparkline22 graph" style="height: 160px;">
                          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
                      </div>
                      <div class="col-md-4 tile">
                        <span>Outgoing Transactions</span>
                        <h2>$<?php echo $sql->getOutTransactions() * $sql->getExchangeRate('USD', 'WCR')['amount1']; ?></h2>
                        <span class="sparkline11 graph" style="height: 160px;">
                          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-3 col-sm-12 col-xs-12">
                    <div>
                      <div class="x_title">
                        <h2>Transactions</h2>
                        <div class="clearfix"></div>
                      </div>
                      <ul class="list-unstyled top_profiles scroll-view">
                        <?php
                          $tg = json_decode($sql->getTransactionsGraph(), true);
                          foreach($tg as $val) {
                            // COIN BUY
                            if($val['wallet_from'] == $sql->getBank()['recid'] && $val['wallet_to'] == $sql->getUser()['user_id'] && $val['userid'] == $sql->getUser()['user_id']) {
                              $handleBtn = 'Pending';
                              $backcolor = 'aero';
                              if($val['acception'] == 0) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'aero';
                              }
                              else if($val['acception'] == 1) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              else if($val['acception'] == 2) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 3) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 4) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'blue';
                              }
                              else if($val['acception'] == 6) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 7) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              echo '<li class="media event">
                                <a class="pull-left border-'.$backcolor.' profile_thumb">
                                  <i class="fa fa-user '.$backcolor.'"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">White Standard Purchase</a>
                                  <p><strong>$'.$val['amount_from'].'. </strong>'.$handleBtn.'</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // COIN SELL
                            else if($val['wallet_from'] == $sql->getUser()['user_id'] && $val['wallet_to'] == $sql->getBank()['recid'] && $val['userid'] == $sql->getUser()['user_id']) {
                              $handleBtn = 'Pending';
                              $backcolor = 'aero';
                              if($val['acception'] == 0) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'aero';
                              }
                              else if($val['acception'] == 1) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              else if($val['acception'] == 2) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 3) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 4) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'blue';
                              }
                              else if($val['acception'] == 6) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 7) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              echo '<li class="media event">
                                <a class="pull-left border-'.$backcolor.' profile_thumb">
                                  <i class="fa fa-user '.$backcolor.'"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">White Standard Sale</a>
                                  <p><strong>₩'.$val['amount_from'].'. </strong>'.$handleBtn.'</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // COIN SEND
                            else if(($val['wallet_from'] == $sql->getBalance(0)['recid'] && $val['wallet_to'] != $sql->getBalance(0)['recid']) || ($val['wallet_from'] == $sql->getBalance(1)['recid'] && $val['wallet_to'] != $sql->getBalance(1)['recid']) || ($val['wallet_from'] == $sql->getBalance(2)['recid'] && $val['wallet_to'] != $sql->getBalance(2)['recid']) || ($val['wallet_from'] == $sql->getBalance(3)['recid'] && $val['wallet_to'] != $sql->getBalance(3)['recid']) && $val['userid'] == $sql->getUser()['user_id']) {
                              echo '<li class="media event">
                                <a class="pull-left border-green profile_thumb">
                                  <i class="fa fa-user green"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">White Standard Send</a>
                                  <p><strong>₩'.$val['amount_from'].'. </strong>Sent to other user</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // COIN RECEIVE
                            else if(($val['wallet_from'] != $sql->getBalance(0)['recid'] && $val['wallet_to'] == $sql->getBalance(0)['recid']) || ($val['wallet_from'] != $sql->getBalance(1)['recid'] && $val['wallet_to'] == $sql->getBalance(1)['recid']) || ($val['wallet_from'] != $sql->getBalance(2)['recid'] && $val['wallet_to'] == $sql->getBalance(2)['recid']) || ($val['wallet_from'] != $sql->getBalance(3)['recid'] && $val['wallet_to'] == $sql->getBalance(3)['recid']) && $val['userid'] != $sql->getUser()['user_id']) {
                              echo '<li class="media event">
                                <a class="pull-left border-green profile_thumb">
                                  <i class="fa fa-user green"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">White Standard Receive</a>
                                  <p><strong>₩'.$val['amount_from'].'. </strong>Received from other user</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // BANK WIRE
                            // else if($val['wallet_from'] == $sql->getUser()['user_id'] && $val['wallet_to'] == $sql->getBank()['recid'] && $val['userid'] == $sql->getUser()['user_id']) {
                              
                            // }
                          }
                        ?>
                        <!-- <li class="media event">
                          <a class="pull-left border-green profile_thumb">
                            <i class="fa fa-user green"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#">Restricted Wallet Credit</a>
                            <p><strong>₩ 19,600.00 </strong>Clearing Pending</p>
                            <p> <small>03/25/2018</small>
                            </p>
                          </div>
                        </li>
                        <li class="media event">
                          <a class="pull-left border-blue profile_thumb">
                            <i class="fa fa-user blue"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#">White Standard Sale</a>
                            <p><strong>₩ 40,000.00 </strong>Smart Contract Sent </p>
                            <p> <small>03/21/2018</small>
                            </p>
                          </div>
                        </li>
                        <li class="media event">
                          <a class="pull-left border-aero profile_thumb">
                            <i class="fa fa-user aero"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#">Bank Wire #2667899178991</a>
                            <p><strong>$39,200.00 </strong> Agent Avarage Sales </p>
                            <p> <small>03/21/2018</small>
                            </p>
                          </div>
                        </li>
                        <li class="media event">
                          <a class="pull-left border-green profile_thumb">
                            <i class="fa fa-user green"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#">Restricted to Unrestricted Wallet transfer</a>
                            <p><strong>₩ 12,375.00. </strong> Agent Avarage Sales </p>
                            <p> <small>03/21/2018</small>
                            </p>
                          </div>
                        </li> -->
                      </ul>
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
  <script src="../js/nicescroll/jquery.nicescroll.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
  <!-- icheck -->
  <script src="../js/icheck/icheck.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="../js/moment/moment.min.js"></script>
  <script type="text/javascript" src="../js/datepicker/daterangepicker.js"></script>
  <!-- chart js -->
  <script src="../js/chartjs/chart.min.js"></script>
  <!-- sparkline -->
  <script src="../js/sparkline/jquery.sparkline.min.js"></script>

  <script src="../js/custom.js"></script>

  <!-- flot js -->
  <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
  <script type="text/javascript" src="../js/flot/jquery.flot.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.pie.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.orderBars.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.time.min.js"></script>
  <script type="text/javascript" src="../js/flot/date.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.spline.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.stack.js"></script>
  <script type="text/javascript" src="../js/flot/curvedLines.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.resize.js"></script>
  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>
  <!-- PNotify -->
  <script type="text/javascript" src="../js/notify/pnotify.core.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.buttons.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.nonblock.js"></script>
  <!-- flot -->
  <script type="text/javascript" src="../js/app.js"></script>
  <script type="text/javascript">
    //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
    var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

    //generate random number for charts
    randNum = function() {
      return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
    }

    var transarr = <?php echo $sql->getTransactionsGraph(); ?>;
    var today = new Date();
        today = (today.getTime() / 1000).toFixed(0);
        today = parseInt(today)+86400;
    var firstday = parseInt(today) - (30*24*60*60);

    $(function() {
      var d1 = [];
      //var d2 = [];
      
      //here we generate data for chart
      for (var i = firstday; i < today; i+=86400) {
        var toshow = 0;
        var nexti = parseInt(i)+86400;
        var newint = parseInt(i)*1000;
        if(transarr.length > 0) {
          Object.keys(transarr).map(function(objectKey, index) {
            var value = transarr[objectKey];
            if(value.changed) {
              if(value.changed >= parseInt(i) && value.changed < nexti) {
                if(value.userid == '<?php echo $_COOKIE['u']; ?>') {
                  newint = parseInt(i) * 1000;
                  // console.log(new Date(newint) + ' | ' + new Date(nexti*1000));
                  toshow += parseFloat(value.amount_from);
                }
              }
            }
          });
          d1.push([newint, toshow]);
        }
        else {
          var newint = parseInt(i) * 10000;
          d1.push([newint, toshow]);
        }
        // d2.push([new Date(Date.today().add(i).days()).getTime(), randNum()]);
      }
      // console.log(d1.length + ' | ' + JSON.stringify(d1));

      var chartMinDate = d1[0][0]; //first day
      var chartMaxDate = d1[29][0]; //last day

      var tickSize = [1, "day"];
      var tformat = "%m/%d/%y";

      //graph options
      var options = {
        grid: {
          show: true,
          aboveData: true,
          color: "#3f3f3f",
          labelMargin: 10,
          axisMargin: 0,
          borderWidth: 0,
          borderColor: null,
          minBorderMargin: 5,
          clickable: true,
          hoverable: true,
          autoHighlight: true,
          mouseActiveRadius: 100
        },
        series: {
          lines: {
            show: true,
            fill: true,
            lineWidth: 2,
            steps: false
          },
          points: {
            show: true,
            radius: 4.5,
            symbol: "circle",
            lineWidth: 3.0
          }
        },
        legend: {
          position: "ne",
          margin: [0, -25],
          noColumns: 0,
          labelBoxBorderColor: null,
          labelFormatter: function(label, series) {
            // just add some space to labes
            return label + '&nbsp;&nbsp;';
          },
          width: 40,
          height: 1
        },
        colors: chartColours,
        shadowSize: 0,
        tooltip: true, //activate tooltip
        tooltipOpts: {
          content: "%s: %y.0",
          xDateFormat: "%m/%d",
          shifts: {
            x: -30,
            y: -50
          },
          defaultTheme: false
        },
        yaxis: {
          min: 0
        },
        xaxis: {
          mode: "time",
          minTickSize: tickSize,
          timeformat: tformat,
          min: chartMinDate,
          max: chartMaxDate
        }
      };
      var plot = $.plot($("#placeholder33x"), [{
        label: "My transfers",
        data: d1,
        lines: {
          fillColor: "rgba(150, 202, 89, 0.12)"
        }, //#96CA59 rgba(150, 202, 89, 0.42)
        points: {
          fillColor: "#fff"
        }
      }], options);
    });
  </script>
  <!-- /flot -->
  <!--  -->
  <script>
    $('document').ready(function() {
      $(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
        type: 'bar',
        height: '125',
        barWidth: 13,
        colorMap: {
          '7': '#a1a1a1'
        },
        barSpacing: 2,
        barColor: '#26B99A'
      });

      $(".sparkline11").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
        type: 'bar',
        height: '40',
        barWidth: 8,
        colorMap: {
          '7': '#a1a1a1'
        },
        barSpacing: 2,
        barColor: '#26B99A'
      });

      $(".sparkline22").sparkline([2, 4, 3, 4, 7, 5, 4, 3, 5, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6], {
        type: 'line',
        height: '40',
        width: '200',
        lineColor: '#26B99A',
        fillColor: '#ffffff',
        lineWidth: 3,
        spotColor: '#34495E',
        minSpotColor: '#34495E'
      });

    });
  </script>
  <!-- -->
  <!-- datepicker -->
  <script type="text/javascript">
    $(document).ready(function() {
      var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }
      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: moment().subtract(29, 'days'),
        maxDate: moment(),
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
    });
  </script>
  <!-- /datepicker -->
  <script>
    $(function() {
      setTimeout(function() {
        if(contractAddress != '0' && contractAddress != '') {
          
        }
        else {

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
      }, 5000);
      setTimeout(function() {
        App.getEtherBalance();
        App.getBalance();
      }, 2000);
    })
  </script>
</body>

</html>
