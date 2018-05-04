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
                    Minters
                    <small>
                        
                    </small>
					<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#minterModal">Create Minter</button>
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

	<!-- Modal create Minter -->
	<div class="modal fade" id="minterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content sentrequest">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Create new Minter</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">

					<div class="alert alert-success" style="display:none;" id="signUpSuccess">Registration was successfull!</div>
					<div class="alert alert-danger" style="display:none;" id="unknownError">An unknown Error occured.</div>

					<form id="signUpForm" onsubmit="submForm(); return false;" novalidate>
						<div class="form-group">
							<label for="firstname">Firstname</label>
							<input type="text" id="firstname" name="firstname" class="form-control col-md-7 col-xs-12" value="">
						</div>
						<div class="form-group">
							<label for="lastname">Lastname</label>
							<input type="text" id="lastname" name="lastname" class="form-control col-md-7 col-xs-12" value="">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" value="">
						</div>

						<div class="alert alert-danger" style="display:none;" id="invalidEmail">Please fill a valid Email.</div>
						<div class="alert alert-danger" style="display:none;" id="takenEmail">Email already taken.</div>

						<div class="form-group">
							<label for="pwd">Password</label>
							<input type="password" id="pwd" name="pwd" class="form-control col-md-7 col-xs-12" value="" required pattern="[^ @]*@[^ @]*">
						</div>
						<div class="form-group">
							<label for="pwd2">Password confirmation</label>
							<input type="password" id="pwd2" name="pwd2" class="form-control col-md-7 col-xs-12" value="" required pattern="[^ @]*@[^ @]*">
						</div>

						<div class="alert alert-danger" style="display:none;" id="signUpPassErr">Passwords do not match.</div>
						<div class="alert alert-danger" style="display:none;" id="pwdStrength">Password must be at least 8 characters in length and contain letters, numbers and special characters.</div>
						<div class="alert alert-info" style="display:none;" id="checking">Checking.. Please keep waiting.</div>

						<div class="clearfix"></div>

						<br/>

						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id="sbmtbtn" class="btn btn-success submit" onclick="submForm(); return false;">Create</button>

					</form>
				</div>
			</div>
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
		
	var strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})');

	function validateEmail(email) {
		var valmail = 0;
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
			valmail = 1;
		}
		return valmail;
	}

	function chngState(state) {
		$('input#state').val(state);
	}
	
	function submForm() {
		if(jQuery('input#firstname').val() != '' && jQuery('input#lastname').val() != '') {
			jQuery('div#signUpPassErr').hide();
			jQuery('div#pwdStrength').hide();
			jQuery('div#invalidEmail').hide();
			jQuery('div#checking').show();
			jQuery('input#sbmtbtn').hide();
			if(jQuery('input#email').val() != '') {
				if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(jQuery('input#email').val())) {
					if(jQuery('input#pwd').val() != '') {
						if (strongRegex.test(jQuery('input#pwd').val())) {
							if(jQuery('input#pwd').val() == jQuery('input#pwd2').val()) {
								var jsonstr = {
									email: jQuery('input#email').val(),
									password: jQuery('input#pwd').val(),
									firstname: jQuery('input#firstname').val(),
									lastname: jQuery('input#lastname').val()
								};
								jQuery.ajax({
									dataType: 'json',
									type: 'post',
									url: '/coms/regin_minter.php',
									data: jsonstr,
									success: function(ress) {
										console.log(JSON.stringify(ress))
										// var ress = JSON.parse(ress);
										if (ress[0].success === 1) {
											$('#usersTable').DataTable().ajax.reload();
											jQuery('#signUpForm')[0].reset();
											jQuery('div#signUpPassErr').hide();
											jQuery('div#pwdStrength').hide();
											jQuery('div#invalidEmail').hide();
											jQuery('div#takenEmail').hide();
											jQuery('div#signUpSuccess').show();
											jQuery('button.close').click();
											// jQuery('input#email').hide();
											// jQuery('input#pwd').hide();
											// jQuery('input#pwd2').hide();
											// jQuery('div#checking').hide();
											new PNotify({
												title: "Minter created!",
												type: "success",
												text: "New restricted Minter was created!",
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
										// console.log('ERR ' + JSON.stringify(err));
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
		else {
			new PNotify({
				title: "Fill all fields",
				type: "error",
				text: "Need to fill Firstname and Lastname!",
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
	
	function remminter(val1, val2) {
		if(confirm("Delete this Minter "+val1)) {
			if(val2 != '0' && val2 != '') {
				if(contractAddress) {
					App.removeMinterDel(val1, val2);
				}
			}
		}
	}
		
	function mkunrestricted(val1, val2) {
		// console.log(val2 + ' ' + contractAddress)
		if(val2 != '0' && val2 != '' && val2 != null && val2 != 'null' && contractAddress) {
			if(confirm("Make this Minter unrestricted?")) {
				App.addMinter(val1, val2);
			}
		}
		else {
			new PNotify({
				title: "White Standard + Metamask",
				type: "error",
				text: "Be sure this Minter had logged in with Metamask and also you are logged in now.",
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
	
	function mkrestricted(val1, val2) {
		// console.log(val2 + ' ' + contractAddress)
		if(val2 != '0' && val2 != '' && val2 != null && val2 != 'null' && contractAddress) {
			if(confirm("Make this Minter restricted?")) {
				App.removeMinterRest(val1, val2);
			}
		}
		else {
			new PNotify({
				title: "White Standard + Metamask",
				type: "error",
				text: "Be sure this Minter had logged in with Metamask and also you are logged in now.",
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
		
    $(function() {

		setTimeout(function() {
			App.getBalance();
			App.getEtherBalance();
		}, 2000);
		
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
					"name" : "req", "value" : "minters"
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
						var usrtype = '';
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
					title: 'Ethereum address', 
					"mData": 6,
					"mRender": function(data, type, full) {
						return full[22];
					}
				},
				{
					title: 'Status', 
					"mData": 7,
					"mRender": function(data, type, full) {
						var btns = '';
						if(full[0] != null) {
							btns += '<button class="btn btn-danger btn-xs" style="height:25px;" onclick="remminter(\''+full[0]+'\', \''+full[22]+'\'); return false;">Remove Minter</button>';
							if(full[21] == full[22]) {
								if(full[21] != null && full[22] != null) {
									btns += '<button class="btn btn-warning btn-xs" style="height:25px;" onclick="mkrestricted(\''+full[0]+'\', \''+full[22]+'\'); return false;">Revoke Privilege</button>';
								}
								else {
									btns += '<button class="btn btn-success btn-xs" style="height:25px;" onclick="mkunrestricted(\''+full[0]+'\', \''+full[22]+'\'); return false;">Deploy Privilege</button>';
								}
							}
							else {
								btns += '<button class="btn btn-success btn-xs" style="height:25px;" onclick="mkunrestricted(\''+full[0]+'\', \''+full[22]+'\'); return false;">Make Unrestricted</button>';
							}
						}
						return btns;
					}
				}
			]
		});

    });
		
  </script>

</body>

</html>
