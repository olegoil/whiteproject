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

  <title>Transactions | White Standard</title>

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
                <h3>
                    Transactions
                    <small>
                        A list of made transactions
                    </small>
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">

                  <table id="transTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>

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

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display:none;">
    Launch modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <div class="modal-body">
              <p id="detailsbody"></p>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
      </div>
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

  <!-- Datatables-->
  <script src="../js/datatables/jquery.dataTables.min.js"></script>
  <script src="../js/datatables/dataTables.bootstrap.js"></script>
  <script src="../js/datatables/dataTables.buttons.min.js"></script>
  <script src="../js/datatables/buttons.bootstrap.min.js"></script>
  <script src="../js/datatables/jszip.min.js"></script>
  <script src="../js/datatables/pdfmake.min.js"></script>
  <script src="../js/datatables/vfs_fonts.js"></script>
  <script src="../js/datatables/buttons.html5.min.js"></script>
  <script src="../js/datatables/buttons.print.min.js"></script>
  <script src="../js/datatables/dataTables.fixedHeader.min.js"></script>
  <script src="../js/datatables/dataTables.keyTable.min.js"></script>
  <script src="../js/datatables/dataTables.responsive.min.js"></script>
  <script src="../js/datatables/responsive.bootstrap.min.js"></script>
  <script src="../js/datatables/dataTables.scroller.min.js"></script>
  <script src="../js/datatables/dataTables.select.min.js"></script>
  <script src="../js/datatables/buttons.colVis.min.js"></script>
  
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

      var transtbl = $('#transTable').DataTable({
        // order: [[ 9, "asc" ], [ 0, "desc" ]],
        "displayLength": 15,
        "lengthMenu": [[15, 50, 100, 500, 1000,  -1], [15, 50, 100, 500, 1000, "All"]],
          select: true,
          responsive: true,
          // "bStateSave": true,
          dom: "Bfrtipl",
          buttons: [{
          extend: "copy",
          exportOptions: {
            rows: { filter: 'applied', order: 'current', selected: true }
          },
          className: "btn-sm"
          }, {
          extend: "csv",
          exportOptions: {
            rows: { filter: 'applied', order: 'current', selected: true }
          },
          className: "btn-sm"
          }, {
          extend: "excel",
          exportOptions: {
            rows: { filter: 'applied', order: 'current', selected: true }
          },
          className: "btn-sm"
          }, {
          extend: "pdf",
          exportOptions: {
            rows: { filter: 'applied', order: 'current', selected: true }
          },
          className: "btn-sm"
          }, {
          extend: "print",
          exportOptions: {
            rows: { filter: 'applied', order: 'current', selected: true }
          },
          className: "btn-sm"
          },
          {
            extend: "colvis",
            className: "btn-sm",
            text: "Filter"
          }],
        // "sScrollY": "500px",
        "sAjaxSource": "/coms/getwalletsdata.php",
        "bProcessing": true,
        "bServerSide": true,
        // "sDom": "frtiS",
        "fnServerData": function ( sSource, aoData, fnCallback ) {
          aoData.push({
            "name" : "bankId", "value" : <?php echo '"'.$sql->adminGetBank()['recid'].'"'; ?>
          });
          aoData.push({
            "name" : "req", "value" : "transactions"
          });
          aoData.push({
            "name" : "utype", "value" : <?php echo '"'.$sql->checkLevel().'"'; ?>
          });
          aoData.push({
            "name" : "userid", "value" : <?php echo '"'.$sql->getUser()['user_id'].'"'; ?>
          });
          
          $.ajax({
            "dataType": 'json', 
            "type": "POST", 
            "url": sSource, 
            "data": aoData,
            "success": fnCallback,
            "error": function(data) {console.log('ERROR: '+JSON.stringify(data))}
          });
        },
        // "oScroller": {
          // "loadingIndicator": true
        // },
        language: {
          "processing": '<span style="color:#00ff00;"><i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>Loading..</span>'
        },
        columns: [
          {
            title: 'ID', 
            "mData": 0,
            "mRender": function(data, type, full) {
              // var id = full[0];
              // if(full[11]) {
              //   id = 'Wire: '+full[11];
              // }
              // return id;
              return full[13];
            }
          },
          {
            title: 'Sent', 
            "mData": 1,
            "mRender": function(data, type, full) {
              return full[2];
            }
          },
          {
            title: 'Received', 
            "mData": 2,
            "mRender": function(data, type, full) {
              return full[3];
            }
          },
          {
            title: 'Date',
            "mData": 3,
            "mRender": function(data, type, full) {
              return full[8];
            }
          },
          { 
            title: 'Options', 
            "mData": 4,
            "mRender": function(data, type, full) {

              var handleBtn = '&nbsp;';
              if(full[9] == 7 && (full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR')) {
                  handleBtn = '<span class="text-success" style="height:25px;">Aprofed Exchange</span>';
              }
              else if((full[9] == 3 && (full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR')) || (full[9] == 6 && (full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR'))) {
                  handleBtn = '<span class="text-danger" style="height:25px;">Denied Exchange</span>';
              }
              else if(full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR') {
                handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\'); return false;">Details</button><button class="btn btn-danger btn-xs" style="height:25px;" onclick="transdel(\''+full[0]+'\', \'0\'); return false;">Abort</button><span class="text-warning" style="height:25px;">Pending Exchange</span>';
              }
              else if(full[5] != 'Request WCR' || full[5] != 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR') {
                var transtype = '<span class="text-success" style="height:25px;">Received transaction</span>';
                if(full[1] == '<?php echo $sql->getUser()['user_id'] ?>') {
                  transtype = '<span class="text-success" style="height:25px;">Sent transaction</span>';
                }
                handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\'); return false;">Details</button>'+transtype;
              }
						  return handleBtn;

            }
          }
        ]
      });

    });

    function transdel(val1, val2) {
      if(confirm("Delete this transaction "+val1)) {
          ajaxSend(val1, val2);
      }
    }

    function showdetails(val1, val2, val3, val4, val5, val6, val7, val8, val9, val10, val11, val12) {
      var handleBtn = '&nbsp;';
      if(val10 == 7 && (val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR')) {
        handleBtn = '<span class="text-success" style="height:25px;">Aprofed</span>';
      }
      else if((val10 == 3 && (val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR')) || (val10 == 6 && (val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR'))) {
        handleBtn = '<span class="text-danger" style="height:25px;">Denied</span>';
      }
      else if(val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR') {
        handleBtn = '<span class="text-warning" style="height:25px;">Pending</span>';
      }
      else if(val6 != 'Request WCR' || val6 != 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR') {
        handleBtn = '<span class="text-success" style="height:25px;">Received transaction</span>';
        if(val2 == '<?php echo $sql->getUser()['user_id'] ?>') {
          handleBtn = '<span class="text-success" style="height:25px;">Sent transaction</span>';
        }
      }
      $('#myModalLabel').html('Details of Transfer: <b>'+val1+'</b>');
      var detailsbody = '<table><tr><td><strong>ID</strong></td><td>'+val1+'</td></tr>';
      if(val12 != 'null') {
        detailsbody += '<tr><td><strong>Wire ID</strong></td><td>'+val12+'</td></tr><tr><td><strong>Wire Type</strong></td><td>'+val11+'</td></tr>';
      }
      detailsbody += '<tr><td><strong>Amount from</strong></td><td>'+val3+'</td></tr><tr><td><strong>Amount to</strong></td><td>'+val4+'</td></tr><tr><td><strong>Comissions</strong></td><td>'+val5+'</td></tr><tr><td><strong>Notes</strong></td><td>'+val6+'</td></tr><tr><td><strong>Wallet From</strong></td><td>'+val7+'</td></tr><tr><td><strong>Wallet To</strong></td><td>'+val8+'</td></tr><tr><td><strong>Date</strong></td><td>'+val9+'</td></tr><tr><td><strong>Acception</strong></td><td>'+handleBtn+'</td></tr></table>';
      $('#detailsbody').html(detailsbody);
      $('#myModal').modal('show');
    }

    function ajaxSend(val1, val2) {
      var datastr = 'act=userproof&adr='+val1+'&amnt='+val2;
      $.ajax({
        type: 'post',
        url: '/coms/mktransaction.php',
        data: datastr,
        success: function(suc) {
            console.log(JSON.stringify(suc));
            $('#transTable').DataTable().ajax.reload();
        },
        error: function(err) {
            alert('Some error occured!')
        }
      })
    }
      
  </script>

</body>

</html>