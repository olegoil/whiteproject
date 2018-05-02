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
                    <!-- <button class="btn btn-success" onclick="addManager()">Make me manager</button>
                    <button class="btn btn-success" onclick="addMinter()">Make me minter</button> -->
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">
                  <?php if($sql->checkLevel() == 1) { ?>

                    <table id="transTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>

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

  <!-- PNotify -->
  <script type="text/javascript" src="../js/notify/pnotify.core.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.buttons.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.nonblock.js"></script>

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

  var exchangeeth = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
  var exchangebtc = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
  var ethercost = 1;
  var bitcoincost = 1;

  $(function() {

      jQuery.ajax({
        dataType: 'json',
        type: 'get',
        url: 'https://api.coinmarketcap.com/v2/ticker/?limit=10',
        data: 1,
        success: function(res) {
          $.each(res.data, function(index, val) {
            if(val.name == 'Bitcoin') {
              bitcoincost = val.quotes.USD.price;
              // $('.bitcoin').html(val.quotes.USD.price);
              exchangebtc = exchangebtc/bitcoincost;
            }
            else if (val.name == 'Ethereum') {
              ethercost = val.quotes.USD.price;
              // $('.ether').html(val.quotes.USD.price);
              exchangeeth = exchangeeth/ethercost;
            }
            // console.log(val);
          });
        },
        error: function(err) {
          console.log('ERR '+JSON.stringify(err))
        }
      });

      setTimeout(function() {
        App.getEtherBalance();
        App.getBalance();
      }, 2000);

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
            title: 'MintId',
            "mData": 0,
            "mRender": function(data, type, full) {
              var id = '<a href="/profile/?usr='+full[1]+'" >'+full[0]+'</a>';
              if(full[11]) {
                id = 'Wire: '+'<a href="/profile/?usr='+full[1]+'" >'+full[11]+'</a>';
              }
              return id;
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
            title: 'Commissions', 
            "mData": 3,
            "mRender": function(data, type, full) {
              if(full[5] == 'Request BTC to WCR') {
                return full[4] + ' %';
              }
              else {
                return full[4];
              }
            }
          },
          { 
            title: 'Notes', 
            "mData": 4,
            "mRender": function(data, type, full) {
              return full[5];
            }
          },
          { 
            title: 'Date', 
            "mData": 5,
            "mRender": function(data, type, full) {
              return full[8];
            }
          },
          { 
            title: 'Options', 
            "mData": 6,
            "mRender": function(data, type, full) {
              var handleBtn = '&nbsp;';
              if(full[9] == 4) {
                  var clickaction = 'onclick="transallow(\''+full[0]+'\', \''+full[2]+'\'); return false;"';
                  var clickaction2 = 'onclick="transdeny(\''+full[0]+'\', \'0\'); return false;"';
                  if(full[5] == 'WCR to WCUR') {
                    clickaction = 'onclick="transallow2(\''+full[0]+'\', \''+full[2]+'\', \''+full[7]+'\', \''+full[3]+'\', \''+full[12]+'\'); return false;"';
                    clickaction2 = 'onclick="transdeny2(\''+full[0]+'\', \'0\', \''+full[12]+'\'); return false;"';
                  }
                  if(full[5] == 'Request BTC to WCR') {
                    clickaction = 'onclick="transallow3(\''+full[0]+'\', \''+full[3]+'\'); return false;"';
                  }
                  handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\', \''+full[12]+'\'); return false;">Details</button><button class="btn btn-success btn-xs" style="height:25px;" '+clickaction+'>Allow</button><button class="btn btn-danger btn-xs" style="height:25px;" '+clickaction2+'>Deny</button>';
              }
              else if(full[9] == 7) {
                  handleBtn = '<button class="btn btn-success btn-xs" style="height:25px;">Aprofed</button>';
              }
              else if(full[9] == 6) {
                  handleBtn = '<button class="btn btn-danger btn-xs" style="height:25px;">Denied</button>';
              }
              return handleBtn;
            }
          }
        ]
      });

  });

  function ajaxSend(val1, val2) {
    var datastr = 'act=adminproof&adr='+val1+'&amnt='+val2;
    $.ajax({
      type: 'post',
      url: '/coms/mktransaction.php',
      data: datastr,
      success: function(suc) {
        // console.log(JSON.stringify(suc));
        $('#transTable').DataTable().ajax.reload();
      },
      error: function(err) {
        alert('Some error occured!')
      }
    })
  }

  function transallow(val1, val2) {
    if(confirm("Allow this transaction "+val1)) {
        ajaxSend(val1, val2);
    }
  }

  function transdeny(val1, val2) {
    if(confirm("Deny this transaction "+val1)) {
        ajaxSend(val1, val2);
    }
  }

  function transallow2(val1, val2, val3, val4, val5) {
    // console.log("TEST "+val1+' | '+val2+' | '+val3);
    // decision - 1 - если запрос принят, 2 - если запрос отклоненен
    App.isManagerSend(val1, val2, val3, val4, val5);
  }

  function transdeny2(val1, val2, val3, val4, val5) {
    App.isManagerDeny(val1, val2, val3, val4, val5);
  }

  function transallow3(val1, val3) {
    var val3var = val3.split(' ');
    val3var = val3var[0] / exchangebtc;
    if(confirm("Allow this transaction "+val1)) {
        ajaxSend(val1, val3var);
    }
  }

  function showdetails(val1, val2, val3, val4, val5, val6, val7, val8, val9, val10, val11, val12, val13) {
      var val4var = val4;
      var val5var = val5;
      $('#myModalLabel').html('Details of MintId: <b>'+val1+'</b>');
      var detailsbody = '<table><tr><td><strong>Mint ID</strong></td><td>'+val1+'</td></tr>';
      var mintreq = '';
      if(val12 != 'null') {
        detailsbody += '<tr><td><strong>Wire ID</strong></td><td>'+val12+'</td></tr><tr><td><strong>Wire Type</strong></td><td>'+val11+'</td></tr>';
      }
      if(val13 != 'null') {
        mintreq = '<tr><td><strong>MintRequest ID</strong></td><td>'+val13+'</td></tr>';
      }
      if(val6 == 'Request BTC to WCR') {
        val4var = val4.split(' ');
        val4var = val4var[0] / exchangebtc;
        val4var = val4var + ' WCR';
        val5var = val5 + ' %';
      }
      detailsbody += '<tr><td><strong>User ID</strong></td><td>'+val2+'</td></tr>'+mintreq+'<tr><td><strong>Amount from</strong></td><td>'+val3+'</td></tr><tr><td><strong>Amount to</strong></td><td>'+val4var+'</td></tr><tr><td><strong>Comissions</strong></td><td>'+val5var+'</td></tr><tr><td><strong>Notes</strong></td><td>'+val6+'</td></tr><tr><td><strong>Wallet From</strong></td><td>'+val7+'</td></tr><tr><td><strong>Wallet To</strong></td><td>'+val8+'</td></tr><tr><td><strong>Date</strong></td><td>'+val9+'</td></tr><tr><td><strong>Acception</strong></td><td>Pending</td></tr></table>';
      $('#detailsbody').html(detailsbody);
      $('#myModal').modal('show');
  }

  </script>
  
</body>

</html>
