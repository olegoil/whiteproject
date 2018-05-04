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
                        A list of transactions
                    </small>
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">

                    <!-- start accordion -->
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">Bank transactions</h4>
                            </a>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <!-- <p><strong>Bank transactions</strong></p>
                                    <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">RecId </th>
                                            <th class="column-title">UserId </th>
                                            <th class="column-title">Sent </th>
                                            <th class="column-title">Received </th>
                                            <th class="column-title">Commissions </th>
                                            <th class="column-title">Notes </th>
                                            <th class="column-title">Wallet from </th>
                                            <th class="column-title">Wallet to </th>
                                            <th class="column-title">Date </th>
                                            <th class="bulk-actions" colspan="10">
                                            <a class="antoo" style="color:#fff; font-weight:500;">Selected records ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                            </tr>
                                        </thead>

                                        <?php
                                            // echo $sql->adminGetBankTransactions($sql->adminGetBank()['recid']);
                                        ?>
                                    </table> -->
                                    <table id="transTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 class="panel-title">User wallets</h4>
                            </a>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <!-- <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">RecId </th>
                                                <th class="column-title">UserId </th>
                                                <th class="column-title">Type </th>
                                                <th class="column-title">Amount </th>
                                                <th class="column-title">Date </th>
                                                <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Selected records ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                                </th>
                                            </tr>
                                        </thead>

                                        <?php
                                            // echo $sql->adminGetWallets();
                                        ?>
                                    </table> -->
                                    <table id="walletTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingZero" data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                <h4 class="panel-title">Restricted Bank account</h4>
                            </a>
                            <div id="collapseZero" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                                <div class="panel-body">
                                    <!-- <p><strong>Bank transactions</strong></p> -->

                                    <h3>Restricted balance: <?php echo $sql->adminGetBank()['recid']; ?></h3>
                                    <h3 id="bankbalance">Sum: <?php echo $sql->adminGetBank()['amount']; ?></h3>

                                    <form id="tknform" name="tknform">
                                        <div class="input-group">
                                            <input id="crtoken" name="crtoken" type="text" class="form-control" placeholder="Amount of Token to create">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success tkncreate">Create</button>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input id="dstoken" name="dstoken" type="text" class="form-control" placeholder="Amount of Token to destroy">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger tkndestroy">Destroy</button>
                                            </span>
                                        </div>
                                        <h3>Send restricted tokens to wallet</h3>
                                        <div class="form-group">
                                            <input id="sndtokenadr" name="sndtokenadr" type="text" class="form-control" placeholder="Wallet address">
                                        </div>
                                        <div class="form-group">
                                            <input id="sndnotes" name="sndnotes" type="text" class="form-control" placeholder="Notes">
                                        </div>
                                        <div class="input-group">
                                            <input id="sndtokenamount" name="sndtokenamount" type="text" class="form-control" placeholder="Amount">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary tknsend">Send</button>
                                            </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- <div class="panel">
                            <a class="panel-heading" role="tab" id="headingZero" data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                <h4 class="panel-title">Unrestricted Bank account</h4>
                            </a>
                            <div id="collapseZero" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                                <div class="panel-body">

                                    <h3>Unrestricted balance: <span class="unrestrictedwallet">0</span></h3>
                                    <h3>Sum: <span class="wcunrestricted2">0</span></h3>

                                    <form id="tknform2" name="tknform2">
                                        <div class="input-group">
                                            <input id="crtoken2" name="crtoken2" type="text" class="form-control" placeholder="Amount of Token to create">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success tkncreate2">Create</button>
                                            </span>
                                        </div>
                                        <h3>Send unrestricted tokens to wallet</h3>
                                        <div class="form-group">
                                            <input id="sndtokenadr2" name="sndtokenadr2" type="text" class="form-control" placeholder="Wallet address">
                                        </div>
                                        <div class="form-group">
                                            <input id="sndnotes2" name="sndnotes2" type="text" class="form-control" placeholder="Notes">
                                        </div>
                                        <div class="input-group">
                                            <input id="sndtokenamount2" name="sndtokenamount2" type="text" class="form-control" placeholder="Amount">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary tknsend2">Send</button>
                                            </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div> -->
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

  <script>
    function sendAjax(jsonstr) {
        jQuery.ajax({
            dataType: 'json',
            type: 'post',
            url: '/coms/mktransaction.php',
            data: jsonstr,
            success: function(res) {
                if(res.success == 'no money') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "Not enough money!",
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
                else if(res.success == 'no wallet') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "No such wallet!",
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
                else if(res.success >= '0') {
                    document.getElementById('bankbalance').innerHTML = 'Sum: '+res.success;
                    new PNotify({
                        title: "Success!",
                        type: "success",
                        text: "New balance: "+res.success,
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
                $('form#tknform')[0].reset();
            },
            error: function(err) {
                console.log('ERR '+JSON.stringify(err))
            }
        });
    }

    function sendAjax2(jsonstr) {
        jQuery.ajax({
            dataType: 'json',
            type: 'post',
            url: '/coms/mktransaction.php',
            data: jsonstr,
            success: function(res) {
                if(res.success == 'no money') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "Not enough money!",
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
                else if(res.success == 'no wallet') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "No such wallet!",
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
                else if(res.success >= '0') {
                    
                    document.getElementById('bankbalance').innerHTML = 'Sum: '+res.success;
                    new PNotify({
                        title: "Success!",
                        type: "success",
                        text: "New balance: "+res.success,
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
                $('form#tknform2')[0].reset();
            },
            error: function(err) {
                console.log('ERR '+JSON.stringify(err))
            }
        });
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    $(function() {
        $('.tknsend').on('click', function() {
            if($('#sndtokenadr').val() != '' && $('#sndnotes').val() != '' && $('#sndtokenamount').val() != '' && isNumber($('#sndtokenamount').val())) {
                var jsonstr = {
                    adr: $('#sndtokenadr').val(),
                    notes: $('#sndnotes').val(),
                    amnt: $('#sndtokenamount').val(),
                    act: 'send'
                };
                sendAjax(jsonstr);
            }
            else {
                new PNotify({
                    title: "All fields must be filled!",
                    type: "error",
                    text: "Check all fields and be sure number is filled in amount!",
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
        });
        $('.tkncreate').on('click', function() {
            if(isNumber($('#crtoken').val())) {
                var jsonstr = {
                    amnt: $('#crtoken').val(),
                    act: 'create'
                };
                sendAjax(jsonstr);
            }
            else {
                new PNotify({
                    title: "Amount of new tokens!",
                    type: "error",
                    text: "Be sure number is filled in amount!",
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
        });
        $('.tkndestroy').on('click', function() {
            if(isNumber($('#crtoken').val())) {
                var jsonstr = {
                    amnt: $('#dstoken').val(),
                    act: 'destroy'
                };
                sendAjax(jsonstr);
            }
            else {
                new PNotify({
                    title: "Amount of tokens!",
                    type: "error",
                    text: "Be sure number is filled in amount!",
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
        });
        $('.tknsend2').on('click', function() {
            if($('#sndtokenadr2').val() != '' && $('#sndnotes2').val() != '' && $('#sndtokenamount2').val() != '' && isNumber($('#sndtokenamount2').val())) {
                var jsonstr = {
                    adr: $('#sndtokenadr2').val(),
                    notes: $('#sndnotes2').val(),
                    amnt: $('#sndtokenamount2').val(),
                    act: 'send2'
                };
                sendAjax2(jsonstr);
            }
            else {
                new PNotify({
                    title: "All fields must be filled!",
                    type: "error",
                    text: "Check all fields and be sure number is filled in amount!",
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
        });
        $('.tkncreate2').on('click', function() {
            if(isNumber($('#crtoken2').val())) {
                var jsonstr = {
                    amnt: $('#crtoken2').val(),
                    act: 'create2'
                };
                sendAjax2(jsonstr);
            }
            else {
                new PNotify({
                    title: "Amount of new tokens!",
                    type: "error",
                    text: "Be sure number is filled in amount!",
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
        });
    });
  </script>

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

        // setTimeout(function() {
        //     App.getBalance();
        //     App.getTotalSupply();
        // }, 2000);

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
                        var ending = '<button class="btn btn-danger btn-xs" style="height:25px;" onclick="transdeny(\''+full[0]+'\', \'0\'); return false;">Deny</button>';
                        if(full[9] == 0) {
                            var btns = 'onclick="transallow(\''+full[0]+'\', \''+full[2]+'\');';
                            if(full[5] == 'WCR to WCUR' && (full[12] == 'null' || full[12] == null || full[12] == '' || full[12] == 0)) {
                                btns = 'onclick="transallow2(\''+full[0]+'\', \''+full[2]+'\', \''+full[7]+'\');';
                            }
                            else if(full[5] == 'WCR to WCUR' && full[12] != 'null' && full[12] != null && full[12] != '') {
                                btns = 'onclick="sendTokens(\''+full[0]+'\', \''+full[3]+'\', \''+full[7]+'\', \''+full[12]+'\');';
                                ending = '';
                            }
                            handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\', \''+full[12]+'\'); return false;">Details</button><button class="btn btn-success btn-xs" style="height:25px;" '+btns+' return false;">Allow</button>'+ending;
                        }
                        else if(full[9] == 1) {
                            handleBtn = '<button class="btn btn-success btn-xs" style="height:25px;">Aprofed</button>';
                        }
                        else if(full[9] == 2) {
                            handleBtn = '<button class="btn btn-danger btn-xs" style="height:25px;">Denied</button>';
                        }
						return handleBtn;
					}
				}
			]
		});

        var wallettbl = $('#walletTable').DataTable({
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
					"name" : "req", "value" : "wallets"
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
				{ title: 'WalletId', "mData": 0 },
				{
					title: 'UserId',
					"mData": 1,
					"mRender": function(data, type, full) {
						return '<a href="/profile/?usr='+full[1]+'" >'+full[1]+'</a>';
					}
				},
				{
					title: 'Type', 
					"mData": 2,
					"mRender": function(data, type, full) {
						return full[2];
					}
				},
				{
					title: 'Amount', 
					"mData": 3,
					"mRender": function(data, type, full) {
						return full[3];
					}
				},
				{
					title: 'Date', 
					"mData": 4,
					"mRender": function(data, type, full) {
						return full[4];
					}
				}
			]
		});

    });

    function ajaxSend(val1, val2) {
        var datastr = 'act=minterproof&adr='+val1+'&amnt='+val2;
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

    function transallow2(val1, val2, val3) {
        if(confirm("Allow this transaction "+val1)) {
            var val2 = val2.split(' ')[0];
            // console.log(val2)
            App.mintingRequest(val1, val2, val3);
        }
    }

    function transdeny(val1, val2) {
        if(confirm("Deny this transaction "+val1)) {
            ajaxSend(val1, val2);
        }
    }

    function sendTokens(full0, full3, full7, full12) {
        var full3 = full3.split(' ')[0];
        App.transferTrans(full7, full3, full0);
    }

    function showdetails(val1, val2, val3, val4, val5, val6, val7, val8, val9, val10, val11, val12, val13) {
        var val4var = val4;
        var val5var = val5;
        // console.log(val11 + ' ' + val12)
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
        detailsbody += '<tr><td><strong>User ID</strong></td><td>'+val2+'</td></tr></tr>'+mintreq+'<tr><tr><td><strong>Amount from</strong></td><td>'+val3+'</td></tr><tr><td><strong>Amount to</strong></td><td>'+val4var+'</td></tr><tr><td><strong>Comissions</strong></td><td>'+val5var+'</td></tr><tr><td><strong>Notes</strong></td><td>'+val6+'</td></tr><tr><td><strong>Wallet From</strong></td><td>'+val7+'</td></tr><tr><td><strong>Wallet To</strong></td><td>'+val8+'</td></tr><tr><td><strong>Date</strong></td><td>'+val9+'</td></tr><tr><td><strong>Acception</strong></td><td><span class="text-warning" style="height:25px;">Pending</span></td></tr></table>';
        $('#detailsbody').html(detailsbody);
        $('#myModal').modal('show');
    }
  </script>

</body>

</html>
