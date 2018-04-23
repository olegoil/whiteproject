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

  <title>Users | White Standard</title>

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
                    Users
                    <small>
                        A list of users
                    </small>
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">

                    <table id="usersTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>

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

			var userstbl = $('#usersTable').DataTable({
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
						"name" : "req", "value" : "users"
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
						title: 'UserId',
						"mData": 0,
						"mRender": function(data, type, full) {
							return '<a href="../profile/?usr='+full[0]+'">'+full[0]+'</a>';
						}
					},
					{
						title: 'Fullname',
						"mData": 1,
						"mRender": function(data, type, full) {
							return full[6] + ' ' + full[7];
						}
					},
					{
						title: 'Registration', 
						"mData": 2,
						"mRender": function(data, type, full) {
							return full[2];
						}
					},
					{
						title: 'Login', 
						"mData": 3,
						"mRender": function(data, type, full) {
							return full[3];
						}
					},
					{ 
						title: 'IP', 
						"mData": 4,
						"mRender": function(data, type, full) {
							return full[4];
						}
					},
					{
						title: 'Type', 
						"mData": 5,
						"mRender": function(data, type, full) {
							var usrtype = 'USER';
							if(full[5] == 0) {
								usrtype = 'USER';
							}
							else if(full[5] == 1) {
								usrtype = 'MANAGER';
							}
							else if(full[5] == 2) {
								usrtype = 'MINTER';
							}
							else if(full[5] == 3) {
								usrtype = 'KYCAML';
							}
							return usrtype;
						}
					},
					{ 
						title: 'Address/Phone', 
						"mData": 6,
						"mRender": function(data, type, full) {
							return full[12] + ' ' + full[13];
						}
					},
					{ 
						title: 'Status', 
						"mData": 7,
						"mRender": function(data, type, full) {
							$userconf = '<b class="text-danger">email not confirmed</b>';
							if(full[15]) {
								if(full[15] == 1) {
									$userconf = '<b class="text-success">email confirmed</b>';
								}
							}
							$mobileconf = '<b class="text-danger">mobile not confirmed</b>';
							if(full[16]) {
								if(full[16] == 1) {
									$mobileconf = '<b class="text-success">mobile confirmed</b>';
								}
							}
							$addressconf = '<b class="text-danger">address not confirmed</b>';
							if(full[17]) {
								if(full[17] == 1) {
									$addressconf = '<b class="text-success">address confirmed</b>';
								}
							}
							$passportconf = '<b class="text-danger">passport not confirmed</b>';
							if(full[18]) {
								if(full[18] == 1) {
									$passportconf = '<b class="text-success">passport confirmed</b>';
								}
							}
							return $userconf + ' / ' + $mobileconf + ' / ' + $addressconf + ' / ' + $passportconf;
						}
					}
				]
			});

    });
  </script>

</body>

</html>
