<?php

include '../conns/whiteauth.php';
$sql = new sql();

$gotdata = array();

if(isset($_POST['req']) && $_POST['req'] == 'transactions') {

	// FOR SEARCHING
	$aColumns = array( 'recid', 'userid', 'notes', 'wallet_from', 'wallet_to' );

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".$sql->protect( $_POST['iDisplayStart'] ).", ".
        $sql->protect( $_POST['iDisplayLength'] );
	}

	/*
	 * Ordering
	 */
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
				 	".$sql->protect( $_POST['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "ORDER BY datetime DESC";
		}

		$sOrder = "ORDER BY datetime DESC";

	}
	
	/* 
	 * Filtering
	 */
	if(isset($_POST['utype'])) {
		if($_POST['utype'] == 2) {
			$sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='0' AND transdel='0'";
			if ( $_POST['sSearch'] != "" )
			{
				$sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='0' AND transdel='0' AND (";
			}
		}
		else if($_POST['utype'] == 1) {
			$sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='4' AND transdel='0'";
			if ( $_POST['sSearch'] != "" )
			{
				$sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='4' AND transdel='0' AND (";
			}
		}
		else if($_POST['utype'] == 0) {
			$sWhere = "WHERE userid='".$_POST['userid']."' OR wallet_to='".$sql->getBalance(0)['recid']."' OR wallet_to='".$sql->getBalance(1)['recid']."' OR wallet_to='".$sql->getBalance(2)['recid']."' OR wallet_to='".$sql->getBalance(3)['recid']."'";
			if ( $_POST['sSearch'] != "" )
			{
				$sWhere = "WHERE userid='".$_POST['userid']."' OR wallet_to='".$sql->getBalance(0)['recid']."' OR wallet_to='".$sql->getBalance(1)['recid']."' OR wallet_to='".$sql->getBalance(2)['recid']."' OR wallet_to='".$sql->getBalance(3)['recid']."') AND (";
			}
		}
	}
	if ( $_POST['sSearch'] != "" )
	{
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect( $_POST['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect($_POST['sSearch_'.$i])."%' ";
		}
	}
	
	$query_getData = "SELECT * FROM transactions $sWhere $sOrder";
	$getData = $sql->dbquery($query_getData);
	$row_getData = odbc_fetch_array($getData);
	$getDataRows  = odbc_num_rows($getData);
	
	$query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM transactions WHERE wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."'";
	$getDataLength = $sql->dbquery($query_getDataLength);
	$row_getDataLength = odbc_fetch_array($getDataLength);
	$getDataLengthRows  = odbc_num_rows($getDataLength);

	if($getDataRows > 0) {
		
		do {

			$amountfrom = $row_getData['amount_from'].' '.$sql->getCurrency($row_getData['currency_from']);
			$amountto = $row_getData['amount_to'].' '.$sql->getCurrency($row_getData['currency_to']);

			$walletTo = $row_getData['wallet_to'];
			if($row_getData['notes'] == 'Request BTC to WCR') {

				$query_getWalletId = "SELECT * FROM wallets WHERE userid = '".$row_getData['wallet_to']."' AND type = '0'";
				$getWalletId = $sql->dbquery($query_getWalletId);
				$row_getWalletId = odbc_fetch_array($getWalletId);
				$getWalletIdRows  = odbc_num_rows($getWalletId);
				
				if($getWalletIdRows > 0) {
					$walletTo = $row_getWalletId['recid'];
				}

			}
			
			$gotdata['aaData'][] = array($row_getData['recid'], $row_getData['userid'], $amountfrom, $amountto, $row_getData['commissions'], $row_getData['notes'], $row_getData['wallet_from'], $walletTo, date('m/d/Y h:i A', $row_getData['datetime']), $row_getData['acception'], $row_getData['state'], $row_getData['transid'], $row_getData['mintreq']);
		
		} while ($row_getData = odbc_fetch_array($getData));
	
	}
	else {
		$gotdata['aaData'][] = array(null, null, null, null, null, null, null, null, null, null, null, null);
	}
	
	$gotdata['sEcho'] = intval($_POST['sEcho']);
	$gotdata['iTotalRecords'] = $getDataRows;
	$gotdata['iTotalDisplayRecords'] = $getDataRows;

	echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);

}
else if(isset($_POST['req']) && $_POST['req'] == 'wallets') {

    // FOR SEARCHING
	$aColumns = array( 'recid', 'userid', 'type', 'amount', 'date' );

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".$sql->protect( $_POST['iDisplayStart'] ).", ".
        $sql->protect( $_POST['iDisplayLength'] );
	}

	/*
	 * Ordering
	 */
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
				 	".$sql->protect( $_POST['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "ORDER BY datetime DESC";
		}
	}
	
	/* 
	 * Filtering
	 */
	$sWhere = "WHERE type='0' ";
	if ( $_POST['sSearch'] != "" )
	{
		$sWhere = "WHERE type='0' AND ";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect( $_POST['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect($_POST['sSearch_'.$i])."%' ";
		}
	}
	

  $query_getData = "SELECT * FROM wallets $sWhere $sOrder";
  $getData = $sql->dbquery($query_getData);
  $row_getData = odbc_fetch_array($getData);
  $getDataRows  = odbc_num_rows($getData);
  
  $query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM wallets WHERE type = '0'";
  $getDataLength = $sql->dbquery($query_getDataLength);
  $row_getDataLength = odbc_fetch_array($getDataLength);
  $getDataLengthRows  = odbc_num_rows($getDataLength);

  if($getDataRows > 0) {
	
	do {
        
        $gotdata['aaData'][] = array($row_getData['recid'], $row_getData['userid'], $sql->getCurrency($row_getData['type']), $row_getData['amount'], date('m/d/Y h:i A', $row_getData['datetime']));
	  
	} while ($row_getData = odbc_fetch_array($getData));
  
  }
  else {
	  $gotdata['aaData'][] = array(null, null, null, null, null);
  }
  
  $gotdata['sEcho'] = intval($_POST['sEcho']);
  $gotdata['iTotalRecords'] = $getDataRows;
  $gotdata['iTotalDisplayRecords'] = $getDataRows;

  echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);

}
else if(isset($_POST['req']) && $_POST['req'] == 'users') {

    // FOR SEARCHING
	$aColumns = array( 'user_id', 'user_email', 'user_name', 'user_lastname', 'user_postal', 'user_adress', 'user_mobile' );

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".$sql->protect( $_POST['iDisplayStart'] ).", ".
        $sql->protect( $_POST['iDisplayLength'] );
	}

	/*
	 * Ordering
	 */
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
				 	".$sql->protect( $_POST['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "ORDER BY user_when DESC";
		}
	}
	
	/* 
	 * Filtering
	 */
	$sWhere = "WHERE ";
	if ( $_POST['sSearch'] != "" )
	{
		$sWhere = "WHERE ";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect( $_POST['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect($_POST['sSearch_'.$i])."%' ";
		}
	}
	

  $query_getData = "SELECT * FROM users WHERE user_type='0' ORDER BY user_when DESC";
  $getData = $sql->dbquery($query_getData);
  $row_getData = odbc_fetch_array($getData);
  $getDataRows  = odbc_num_rows($getData);
  
  $query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM users WHERE user_type='0'";
  $getDataLength = $sql->dbquery($query_getDataLength);
  $row_getDataLength = odbc_fetch_array($getDataLength);
  $getDataLengthRows  = odbc_num_rows($getDataLength);

  if($getDataRows > 0) {
	
	do {

		$adress_confirm = $row_getData['user_adress_confirm'];
		$passport_confirm = $row_getData['user_passport_confirm'];
		$adressid = 0;
		$passid = 0;

		$query_getDocs = "SELECT * FROM documents WHERE userid='".$row_getData['user_id']."' ORDER BY datetime DESC";
		$getDocs = $sql->dbquery($query_getDocs);
		$row_getDocs = odbc_fetch_array($getDocs);
		$getRowsDocs  = odbc_num_rows($getDocs);

		if($getRowsDocs > 0) {
			do {
				if($row_getDocs['confirmed'] == '2' && $row_getDocs['doctype'] == 'address') {
					$adress_confirm = $row_getDocs['confirmed'];
					$adressid = $row_getDocs['recid'];
				}
				else if($row_getDocs['confirmed'] == '2' && $row_getDocs['doctype'] == 'passport') {
					$passport_confirm = $row_getDocs['confirmed'];
					$passid = $row_getDocs['recid'];
				}
				else if($row_getDocs['confirmed'] != '1' && $row_getDocs['doctype'] == 'address') {
					$adress_confirm = $row_getDocs['docurl'];
					$adressid = $row_getDocs['recid'];
				}
				else if($row_getDocs['confirmed'] != '1' && $row_getDocs['doctype'] == 'passport') {
					$passport_confirm = $row_getDocs['docurl'];
					$passid = $row_getDocs['recid'];
				}
			} while ($row_getDocs = odbc_fetch_array($getDocs));
		}
        
        $gotdata['aaData'][] = array($row_getData['user_id'], $row_getData['user_email'], date('m/d/Y h:i A', $row_getData['user_when']), date('m/d/Y h:i A', $row_getData['user_log']), $row_getData['user_ip'], $row_getData['user_type'], $row_getData['user_name'], $row_getData['user_lastname'], $row_getData['user_skype'], $row_getData['user_country'], $row_getData['user_city'], $row_getData['user_postal'], $row_getData['user_adress'], $row_getData['user_mobile'], $row_getData['user_pic'], $row_getData['user_confirm'], $row_getData['user_mobile_confirm'], $adress_confirm, $passport_confirm, $adressid, $passid);
	  
	} while ($row_getData = odbc_fetch_array($getData));
  
  }
  else {
	  $gotdata['aaData'][] = array(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
  }
  
  $gotdata['sEcho'] = intval($_POST['sEcho']);
  $gotdata['iTotalRecords'] = $getDataRows;
  $gotdata['iTotalDisplayRecords'] = $getDataRows;

  echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);

}
else if(isset($_POST['req']) && $_POST['req'] == 'minters') {

    // FOR SEARCHING
	$aColumns = array( 'user_id', 'user_email', 'user_name', 'user_lastname', 'user_postal', 'user_adress', 'user_mobile' );

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".$sql->protect( $_POST['iDisplayStart'] ).", ".
        $sql->protect( $_POST['iDisplayLength'] );
	}

	/*
	 * Ordering
	 */
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
				 	".$sql->protect( $_POST['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "ORDER BY user_when DESC";
		}
	}
	
	/* 
	 * Filtering
	 */
	$sWhere = "WHERE ";
	if ( $_POST['sSearch'] != "" )
	{
		$sWhere = "WHERE ";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect( $_POST['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect($_POST['sSearch_'.$i])."%' ";
		}
	}
	
	$query_getData = "SELECT * FROM users WHERE user_type='2' ORDER BY user_when DESC";
	$getData = $sql->dbquery($query_getData);
	$row_getData = odbc_fetch_array($getData);
	$getDataRows = odbc_num_rows($getData);
	
	$query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM users WHERE user_type='2'";
	$getDataLength = $sql->dbquery($query_getDataLength);
	$row_getDataLength = odbc_fetch_array($getDataLength);
	$getDataLengthRows  = odbc_num_rows($getDataLength);

	if($getDataRows > 0) {
		
		do {

			$adress_confirm = $row_getData['user_adress_confirm'];
			$passport_confirm = $row_getData['user_passport_confirm'];
			$adressid = 0;
			$passid = 0;

			$query_getDocs = "SELECT * FROM documents WHERE userid='".$row_getData['user_id']."' ORDER BY datetime DESC";
			$getDocs = $sql->dbquery($query_getDocs);
			$row_getDocs = odbc_fetch_array($getDocs);
			$getRowsDocs  = odbc_num_rows($getDocs);

			if($getRowsDocs > 0) {
				do {
					if($row_getDocs['confirmed'] == '2' && $row_getDocs['doctype'] == 'address') {
						$adress_confirm = $row_getDocs['confirmed'];
						$adressid = $row_getDocs['recid'];
					}
					else if($row_getDocs['confirmed'] == '2' && $row_getDocs['doctype'] == 'passport') {
						$passport_confirm = $row_getDocs['confirmed'];
						$passid = $row_getDocs['recid'];
					}
					else if($row_getDocs['confirmed'] != '1' && $row_getDocs['doctype'] == 'address') {
						$adress_confirm = $row_getDocs['docurl'];
						$adressid = $row_getDocs['recid'];
					}
					else if($row_getDocs['confirmed'] != '1' && $row_getDocs['doctype'] == 'passport') {
						$passport_confirm = $row_getDocs['docurl'];
						$passid = $row_getDocs['recid'];
					}
				} while ($row_getDocs = odbc_fetch_array($getDocs));
			}

			$queryWallet = "SELECT * FROM wallets WHERE type='3' AND userid='".$row_getData['user_id']."'";
			$checkWallet = $sql->dbquery($queryWallet);
			$rowWallet = odbc_fetch_array($checkWallet);
			$rowsWallet = odbc_num_rows($checkWallet);
			
			$gotdata['aaData'][] = array($row_getData['user_id'], $row_getData['user_email'], date('m/d/Y h:i A', $row_getData['user_when']), date('m/d/Y h:i A', $row_getData['user_log']), $row_getData['user_ip'], $row_getData['user_type'], $row_getData['user_name'], $row_getData['user_lastname'], $row_getData['user_skype'], $row_getData['user_country'], $row_getData['user_city'], $row_getData['user_postal'], $row_getData['user_adress'], $row_getData['user_mobile'], $row_getData['user_pic'], $row_getData['user_confirm'], $row_getData['user_mobile_confirm'], $adress_confirm, $passport_confirm, $adressid, $passid, $row_getData['user_minter'], $rowWallet['wallet_minter']);
		
		} while ($row_getData = odbc_fetch_array($getData));
	
	}
	else {
		$gotdata['aaData'][] = array(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
	}
	
	$gotdata['sEcho'] = intval($_POST['sEcho']);
	$gotdata['iTotalRecords'] = $getDataRows;
	$gotdata['iTotalDisplayRecords'] = $getDataRows;

	echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);

}
else if(isset($_POST['req']) && $_POST['req'] == 'documents') {

    // FOR SEARCHING
	$aColumns = array( 'recid', 'doctype', 'datetime', 'confirmed', 'userid' );

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".$sql->protect( $_POST['iDisplayStart'] ).", ".
        $sql->protect( $_POST['iDisplayLength'] );
	}

	/*
	 * Ordering
	 */
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
				 	".$sql->protect( $_POST['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "ORDER BY datetime DESC";
		}
	}
	
	/* 
	 * Filtering
	 */
	$sWhere = "WHERE docdel != '1' ";
	if ( $_POST['sSearch'] != "" )
	{
		$sWhere = "WHERE docdel != '1' AND (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect( $_POST['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".$sql->protect($_POST['sSearch_'.$i])."%' ";
		}
	}
	

  $query_getData = "SELECT * FROM documents $sWhere $sOrder";
  $getData = $sql->dbquery($query_getData);
  $row_getData = odbc_fetch_array($getData);
  $getDataRows  = odbc_num_rows($getData);
  
  $query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM documents";
  $getDataLength = $sql->dbquery($query_getDataLength);
  $row_getDataLength = odbc_fetch_array($getDataLength);
  $getDataLengthRows  = odbc_num_rows($getDataLength);

  if($getDataRows > 0) {
	
	do {
        
        $gotdata['aaData'][] = array($row_getData['recid'], $row_getData['doctype'], date('m/d/Y h:i A', $row_getData['datetime']), $row_getData['docdel'], $row_getData['confirmed'], date('m/d/Y h:i A', $row_getData['confdatetime']), $row_getData['userid'], $row_getData['docurl']);
	  
	} while ($row_getData = odbc_fetch_array($getData));
  
  }
  else {
	  $gotdata['aaData'][] = array(null, null, null, null, null, null, null, null);
  }
  
  $gotdata['sEcho'] = intval($_POST['sEcho']);
  $gotdata['iTotalRecords'] = $getDataRows;
  $gotdata['iTotalDisplayRecords'] = $getDataRows;

  echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);

}

?>