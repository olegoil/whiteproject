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

  <title>Documents | White Standard</title>

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
                    Documents
                    <small>
                        A list of uploaded documents
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
            "name" : "req", "value" : "documents"
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
            title: 'Upload',
            "mData": 0,
            "mRender": function(data, type, full) {
              return '<a href="../profile/?usr='+full[6]+'">'+full[0]+'</a>';
            }
          },
          {
            title: 'Type', 
            "mData": 1,
            "mRender": function(data, type, full) {
              return full[1];
            }
          },
          {
            title: 'User', 
            "mData": 2,
            "mRender": function(data, type, full) {
              return '<a href="javascript:;" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[6]+'\', \''+full[8]+'\', \''+full[9]+'\'); return false;">'+full[8]+' '+full[9]+'</a>';
            }
          },
          {
            title: 'Uploaded', 
            "mData": 3,
            "mRender": function(data, type, full) {
              return full[2];
            }
          },
          {
            title: 'Options', 
            "mData": 4,
            "mRender": function(data, type, full) {
                var handleBtn = '&nbsp;';
                if(full[4] == 1) {
                    handleBtn = '<div class="btn-group"><a href="/uploads/'+full[7]+'" target="_blank" class="btn btn-primary btn-xs">view</a></div> <b class="text-success">Approved</b>';
                }
                else if(full[4] == 2) {
                    handleBtn = '<div class="btn-group"><a href="/uploads/'+full[7]+'" target="_blank" class="btn btn-primary btn-xs">view</a></div> <b class="text-danger">failed</b>';
                }
                else if(full[4] != '') {
                    handleBtn = '<div class="btn-group"><a href="/uploads/'+full[7]+'" target="_blank" class="btn btn-primary btn-xs">view</a><a href="javascript:;" class="btn btn-success btn-xs" onclick="antoconfirm(\''+full[0]+'\', 1);">confirm</a><a href="javascript:;" class="btn btn-danger btn-xs" onclick="antodeny(\''+full[0]+'\', 2);">deny</a></div>';
                }
                return handleBtn;
            }
          }
        ]
      });

    });

    function ajaxSend(val1, val2) {
      var datastr = 'act=docproof&adr='+val1+'&amnt='+val2;
      $.ajax({
          type: 'post',
          url: '/coms/mktransaction.php',
          data: datastr,
          success: function(suc) {
            var suc = JSON.parse(suc);
            if(suc.success == 'no doc') {
              pnotealert('document');
            }
            else if(suc.success == 'no handler') {
              pnotealert('handler');
            }
            else if(suc.success == 'no user') {
              pnotealert('user');
            }
            else if(suc.success == 'no doctype') {
              pnotealert('doctype');
            }
            else if(suc.success == '1') {
              $('#transTable').DataTable().ajax.reload();
            }
          },
          error: function(err) {
              alert('Some error occured!')
          }
      })
    }

    function antoconfirm(val1, val2) {
        if(confirm("Approve this Document "+val1)) {
            ajaxSend(val1, val2);
        }
    }

    function antodeny(val1, val2) {
        if(confirm("Deny this document "+val1)) {
            ajaxSend(val1, val2);
        }
    }

    function showdetails(val0, val6, val8, val9) {
      $('#myModalLabel').html('Details of Document: <b>'+val0+'</b>');
      var detailsbody = '<tr><td><strong>User ID</strong></td><td>'+val6+'</td></tr><tr><td><strong>Name</strong></td><td>'+val8+'</td></tr><tr><td><strong>Lastname</strong></td><td>'+val9+'</td></tr><tr><td>Details</td><td><a href="../profile/?usr='+val6+'">Go to Profile</a></td></tr></table>';
      $('#detailsbody').html(detailsbody);
      $('#myModal').modal('show');
    }

  </script>

</body>

</html>