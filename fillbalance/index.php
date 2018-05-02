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

  <title>Purchase White Standard</title>

  <?php
    include '../incs/cssload.php';
  ?>
  <script src="../js/jquery.min.js"></script>
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
              <h3>Purchase White Standard</h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search"></div>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-bars"></i> Choose your wallet</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"> <i class="fa fa-krw"></i> WCR</a>
                      </li>
                      <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"> <i class="fa fa-krw"></i> WCUR</a>
                      </li>
                      <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-bar-chart"></i> Fees</a>
                      </li>
                      <!-- <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-ethereum"></i> Ethereum</a>
                      </li> -->
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        <h3>Account: <span class="wcrestricted2"><?php echo $sql->getBalance(0)['recid']; ?></span></h3>
                        <h3>Balance: <span class="wcrestricted"><?php echo $sql->getBalance(0)['amount']; ?></span> <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#redeemModal" onclick="chngState('USD', '<?php echo $sql->getFee('WCR', 'USD')['fee']; ?>', 'redeemModal')">Redeem</button></h3>
                        <div class="row">
                          <div class="col-md-10 col-sm-10 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Order options</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th></th>
                                      <th>From</th>
                                      <th>Comissions %</th>
                                      <!-- <th>Comissions</th> -->
                                      <th>Enrollment time</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <th scope="row"><i class="fa fa-bank"></i></th>
                                      <td>BANK WIRE</td>
                                      <td><?php echo $sql->getFee('BA', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'BA\', \''.$sql->getFee('BA', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-bank"></i></th>
                                      <td>ACH</td>
                                      <td><?php echo $sql->getFee('CA', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CA\', \''.$sql->getFee('CA', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-cc-visa"></i></th>
                                      <td>VISA</td>
                                      <td><?php echo $sql->getFee('CC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CC\', \''.$sql->getFee('CC', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-cc-mastercard"></i></th>
                                      <td>Mastercard</td>
                                      <td><?php echo $sql->getFee('CC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CC\', \''.$sql->getFee('CC', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-cc-amex"></i></th>
                                      <td>American Express</td>
                                      <td><?php echo $sql->getFee('CC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CC\', \''.$sql->getFee('CC', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-bitcoin"></i></th>
                                      <td>Bitcoin</td>
                                      <td><?php echo $sql->getFee('BTC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenBTCModal" onclick="chngState(\'BTC\', \''.$sql->getFee('BTC', 'WCR')['fee'].'\', \'tokenBTCModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <!-- <tr>
                                      <th scope="row"><i class="fa fa-cc-paypal"></i></th>
                                      <td>PayPal</td>
                                      <td>2,95%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            // if($sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                            //   echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal">Purchase White Standard</button>';
                                            // }
                                            // else {
                                            //   echo '<a href="/profile/" class="btn btn-success">Verification</a>';
                                            // }
                                        ?>
                                      </td>
                                    </tr> -->
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <h3>Account: <span class="wcunrestricted2">loading..</span></h3>
                        <h3>Balance: <span class="wcunrestricted"><?php echo $sql->getBalance(1)['amount']; ?></span> <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#redeemEthModal" onclick="chngState('ETH', '<?php echo $sql->getFee('ETH', 'WCUR')['fee']; ?>', 'redeemEthModal')">Redeem</button></h3>
                          <table class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>From</th>
                                <th>Comissions %</th>
                                <!-- <th>Comissions</th> -->
                                <th>Enrollment time</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row"><i class="fa fa-bank"></i></th>
                                <td>Ether</td>
                                <td><?php echo $sql->getFee('ETH', 'WCUR')['fee']; ?>%</td>
                                <td>3-5 Days</td>
                                <td>
                                  <button class="btn btn-success" data-toggle="modal" data-target="#tokenEthModal">Purchase White Standard</button>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row"><i class="fa fa-bank"></i></th>
                                <td>Wite Standart Restricted</td>
                                <td><?php echo $sql->getFee('WCR', 'WCUR')['fee']; ?>%</td>
                                <td>3-5 Days</td>
                                <td>
                                  <button class="btn btn-success" data-toggle="modal" data-target="#tokenChngModal">Transfer balance from Restricted to Unrestricted</button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        <p>Use your balance number or scan the qrcode below to fill wallet.</p>
                        <div id="qrcodewc"><i class="fa fa-spin fa-spinner" style="font-size:46px;"></i></div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>From</th>
                              <th>To</th>
                              <th>Comissions %</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $sql->listFee(); ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                        <h3>Account: <span class="ethereum2">loading..</span></h3>
                        <h3>Balance: <span class="ethereum"><?php echo $sql->getBalance(3)['amount']; ?></span></h3>
                        <p>Use your balance number or scan the qrcode below to fill wallet.</p>
                        <div id="qrcodeet"><i class="fa fa-spin fa-spinner" style="font-size:46px;"></i></div>
                      </div> -->
                    </div>
                  </div>

                </div>
              </div>
            </div>

        </div>
        <div class="clearfix"></div>

        <?php include '../incs/footer.php'; ?>

      </div>
      <!-- /page content -->
    </div>

  </div>

  <!-- Modal USD Purchase -->
  <div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequest">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="moneysell">Spend USD</label>
          <div class="input-group">
            <input type="text" id="moneysell" name="moneysell" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">USD</button>
            </span>
          </div>
          <label for="wcbuy">Buy WCR</label>
          <div class="input-group">
            <input type="text" id="wcbuy" name="wcbuy" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsP">Commission
              <span id="commissionsP">0</span> USD
            </label>
          </div>
          <div class="checkbox">
            <label>
              <input id="conditionsbuy" name="conditionsbuy" type="checkbox" class="flat"> I'm not a citizen of NY, nor Washington state.
              <input id="state" name="state" type="hidden" value="BA">
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendreq" onclick="sendreq(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal USD Redeem -->
  <div class="modal fade" id="redeemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentredeem">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel2">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="wcsell">Sell WCR</label>
          <div class="input-group">
            <input type="text" id="wcsell" name="wcsell" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <label for="moneyrec">Receive USD</label>
          <div class="input-group">
            <input type="text" id="moneyrec" name="moneyrec" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">USD</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsR">Commission
              <span id="commissionsR">0</span> USD
            </label>
          </div>
          <div class="checkbox">
            <label>
              <input id="conditionssell" name="conditionssell" type="checkbox" class="flat"> I'm not a citizen of NY, nor Washington state.
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendredeem" onclick="sendredeem(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal ETH Purchase -->
  <div class="modal fade" id="tokenEthModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequestEth">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label>Send Ether to get White Standard to the address below</label>
          <div class="input-group">
            <input type="text" class="form-control col-md-7 col-xs-12" value="0x838C133dA3C493D728d49FA94f4f9B1930651e2a" disabled>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">Contract</button>
            </span>
          </div>
          <!-- <div class="input-group">
            <input type="text" id="moneysellEth" name="moneysellEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">ETH</button>
            </span>
          </div>
          <label for="wcbuyEth">Buy WCUR</label>
          <div class="input-group">
            <input type="text" id="wcbuyEth" name="wcbuyEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div> -->
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary sendreqEth" onclick="sendreqEth(); return false;">Send request</button> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Modal ETH Redeem -->
  <div class="modal fade" id="redeemEthModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentredeemEth">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel2">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="wcsellEth">Sell WCUR</label>
          <div class="input-group">
            <input type="text" id="wcsellEth" name="wcsellEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div>
          <label for="moneyrecEth">Receive Ether</label>
          <div class="input-group">
            <input type="text" id="moneyrecEth" name="moneyrecEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">ETH</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsER">Commission
              <span id="commissionsER">0</span> WC
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendredeemEth" onclick="sendredeemEth(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal BTC Purchase -->
  <div class="modal fade" id="tokenBTCModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequestBTC">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="moneysellBTC">Sell BTC</label>
          <div class="input-group">
            <input type="text" id="moneysellBTC" name="moneysellBTC" class="form-control col-md-7 col-xs-12" value="0">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">BTC</button>
            </span>
          </div>
          <label for="wcbuyBTC">Buy WCR</label>
          <div class="input-group">
            <input type="text" id="wcbuyBTC" name="wcbuyBTC" class="form-control col-md-7 col-xs-12" value="1">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsB">Commission
              <span id="commissionsB">0</span> BTC
            </label>
          </div>
          <label for="myBTC">My Bitcoin wallet (for comparison)</label>
          <div class="form-group">
            <input type="text" id="myBTC" name="myBTC" class="form-control col-md-7 col-xs-12" value="">
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendreqBTC" onclick="sendreqBTC(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal BTC Redeem -->
  <div class="modal fade" id="redeemBTCModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentredeemBTC">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel2">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="wcsellBTC">Sell WCUR</label>
          <div class="input-group">
            <input type="text" id="wcsellBTC" name="wcsellBTC" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div>
          <label for="moneyrecBTC">Receive BTC</label>
          <div class="input-group">
            <input type="text" id="moneyrecBTC" name="moneyrecBTC" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">ETH</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsBR">Commission
              <span id="commissionsBR">0</span> WC
            </label>
          </div>
          <label for="myBTCrec">My Bitcoin wallet (for comparison)</label>
          <div class="form-group">
            <input type="text" id="myBTCrec" name="myBTCrec" class="form-control col-md-7 col-xs-12" value="">
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendredeemBTC" onclick="sendredeemBTC(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Restricted to Unrestricted -->
  <div class="modal fade" id="tokenChngModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequestChng">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="moneysellWCR">Spend WCR</label>
          <div class="input-group">
            <input type="text" id="moneysellWCR" name="moneysellWCR" class="form-control col-md-7 col-xs-12" value="1">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <label for="wcbuyWCUR">Buy WCUR</label>
          <div class="input-group">
            <input type="text" id="wcbuyWCUR" name="wcbuyWCUR" class="form-control col-md-7 col-xs-12" value="1">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsUR">Commission
              <span id="commissionsUR">0</span> WC
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendreqWCUR" onclick="sendreqWCUR(); return false;">Send request</button>
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

    var percentage = 0;
    var bitcoincost = 0;
    var ethercost = 0;

    function chngState(state, percent, modal) {
      $('input#state').val(state);
      percentage = percent.replace(',', '.');
      if(modal) {
        $('#'+modal+' .modal-dialog .modal-content .modal-body .input-group input').keyup();
      }
    }

    function sendreq() {
      if(document.getElementsByName('conditionsbuy')[0].checked) {
        if($('#moneysell').val() > 0) {
          $('.sendreq').hide();
          $.ajax({
            type: 'post',
            data: 'amnt='+$('#moneysell').val()+'&state='+$('#state').val()+'&act=reqwc',
            url: '/coms/mktransaction.php',
            success: function(suc) {
              var succ = JSON.parse(suc);
              // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
              if(succ.success == 1) {
                $('.sentrequest').html('<h2 style="padding:6px 12px;">Request for White Standard sent!</h2>');
              }
              else {
                $('.sentrequest').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
              }
            },
            error: function(err) {
              alert('An unknown error occurred!')
              console.log(JSON.stringify(err));
              $('.sendreq').show();
            }
          });
        }
      }
      else {
        new PNotify({
          title: "Accept conditions",
          type: "error",
          text: "Please accept the conditions by checking the checkbox.",
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

    function sendredeem() {
      if(document.getElementsByName('conditionssell')[0].checked) {
        if($('#wcsell').val() > 0) {
          $('.sendredeem').hide();
          $.ajax({
            type: 'post',
            data: 'amnt='+$('#wcsell').val()+'&act=sellwc',
            url: '/coms/mktransaction.php',
            success: function(suc) {
              var succ = JSON.parse(suc);
              // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
              if(succ.success == 1) {
                $('.sentredeem').html('<h2 style="padding:6px 12px;">Request for USD sent!</h2>');
              }
              else {
                $('.sentredeem').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
              }
            },
            error: function(err) {
              alert('An unknown error occurred!')
              console.log(JSON.stringify(err));
              $('.sendredeem').show();
            }
          });
        }
      }
      else {
        new PNotify({
          title: "Accept conditions",
          type: "error",
          text: "Please accept the conditions by checking the checkbox.",
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

    function sendreqEth() {
      if($('#moneysellEth').val() > 0) {
        if(contractAddress != '0' && contractAddress != '') {
          if(parseFloat(document.getElementsByClassName('ethereum')[0].innerHTML) > parseFloat($('#moneysellEth').val())) {
            App.transferReqWCUR(contractAddress, parseFloat($('#moneysellEth').val()));
          }
          else {
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
    }

    function sendredeemEth() {
      if($('#wcsellEth').val() > 0) {
        if(contractAddress != '0' && contractAddress != '') {
          if(parseFloat(document.getElementsByClassName('wcunrestricted')[0].innerHTML) > parseFloat($('#wcsellEth').val())) {
            App.transferRedeemWCUR(contractAddress, parseFloat($('#wcsellEth').val()));
          }
          else {
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
    }

    function sendreqWCUR() {
      if($('#moneysellWCR').val() > 0) {
        if(contractAddress != '0' && contractAddress != '') {
          if(parseFloat($('#moneysellWCR').val()) <= parseFloat(<?php echo $sql->getBalance(0)['amount']; ?>)) {
            $('.sendreqWCUR').hide();
            $.ajax({
              type: 'post',
              data: 'amnt='+$('#moneysellWCR').val()+'&act=wcrtowcur',
              url: '/coms/mktransaction.php',
              success: function(suc) {
                // console.log(JSON.stringify(suc));
                var succ = JSON.parse(suc);
                // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
                if(succ.success == 1) {
                  $('.sentrequestChng').html('<h2 style="padding:6px 12px;">Request for WCUR sent!</h2>');
                }
                else {
                  $('.sentrequestChng').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
                }
              },
              error: function(err) {
                alert('An unknown error occurred!')
                console.log(JSON.stringify(err));
                $('.sendreqWCUR').show();
              }
            });
          }
          else {
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
    }

    function sendreqBTC() {
      if($('#myBTC').val() != '' && $('#myBTC').val() != '0') {
        if($('#moneysellBTC').val() > 0) {
          $('.sendreqBTC').hide();
          $.ajax({
            type: 'post',
            data: 'amnt='+$('#moneysellBTC').val()+'&state='+$('#state').val()+'&fromadr='+$('#myBTC').val()+'&act=btcreqwc',
            url: '/coms/mktransaction.php',
            success: function(suc) {
              var succ = JSON.parse(suc);
              // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
              if(succ.success == 1) {
                $('.sentrequestBTC').html('<h2 style="padding:6px 12px;">Request for White Standard sent!</h2>');
              }
              else {
                $('.sentrequestBTC').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
              }
            },
            error: function(err) {
              alert('An unknown error occurred!')
              console.log(JSON.stringify(err));
              $('.sendreqBTC').show();
            }
          });
        }
      }
      else {
        new PNotify({
          title: "Valid Bitcoin wallet",
          type: "error",
          text: "Please specify a valid bitcoin wallet from that you'll buy White Standard. This is just for comparison reasons.",
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

    function sendredeemBTC() {
      if($('#myBTCrec').val() != '' && $('#myBTCrec').val() != '0') {
        if($('#wcsellBTC').val() > 0) {
          $('.sendredeemBTC').hide();
          $.ajax({
            type: 'post',
            data: 'amnt='+$('#wcsellBTC').val()+'&act=btcsellwc',
            url: '/coms/mktransaction.php',
            success: function(suc) {
              var succ = JSON.parse(suc);
              // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
              if(succ.success == 1) {
                $('.sentredeem').html('<h2 style="padding:6px 12px;">Request for USD sent!</h2>');
              }
              else {
                $('.sentredeem').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
              }
            },
            error: function(err) {
              alert('An unknown error occurred!')
              console.log(JSON.stringify(err));
              $('.sendredeemBTC').show();
            }
          });
        }
      }
      else {
        new PNotify({
          title: "Valid Bitcoin wallet",
          type: "error",
          text: "Please specify a valid bitcoin wallet from that you'll buy White Standard. This is just for comparison reasons.",
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

      var exchangeusd = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
      var exchangewcr = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount2']; ?>;
      var exchangeeth = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
      var exchangewcur = <?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>;
      var exchangebtc = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;

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
              $('#moneysellBTC').val(exchangebtc);
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

      $('#moneysell').keyup(function() {
        var recalcres = ($('#moneysell').val() / exchangeusd).toFixed(8);
        $('#wcbuy').val(recalcres);
        $('#commissionsP').html(($('#moneysell').val()/100*percentage).toFixed(2));
      });

      $('#wcbuy').keyup(function() {
        var recalcres = ($('#wcbuy').val() * exchangeusd).toFixed(8);
        $('#moneysell').val(recalcres);
        $('#commissionsP').html((recalcres/100*percentage).toFixed(2));
      });

      $('#moneyrec').keyup(function() {
        var recalcres = ($('#moneyrec').val() / exchangeusd).toFixed(8);
        $('#wcsell').val(recalcres);
        $('#commissionsR').html(($('#moneyrec').val()/100*percentage).toFixed(2));
      });

      $('#wcsell').keyup(function() {
        var recalcres = ($('#wcsell').val() * exchangeusd).toFixed(8);
        $('#moneyrec').val(recalcres);
        $('#commissionsR').html((recalcres/100*percentage).toFixed(2));
      });


      $('#moneysellEth').keyup(function() {
        var recalcres = ($('#moneysellEth').val() / exchangeeth).toFixed(8);
        $('#wcbuyEth').val(recalcres);
        $('#commissionsR').html(($('#moneysellEth').val()/100*percentage).toFixed(2));
      });

      $('#wcbuyEth').keyup(function() {
        var recalcres = ($('#wcbuyEth').val() * exchangeeth).toFixed(18);
        $('#moneysellEth').val(recalcres);
        $('#commissionsR').html((recalcres/100*percentage).toFixed(18));
      });

      $('#moneyrecEth').keyup(function() {
        var recalcres = ($('#moneyrecEth').val() / exchangeeth).toFixed(8);
        $('#wcsellEth').val(recalcres);
        $('#commissionsER').html(($('#moneyrecEth').val()/100*percentage).toFixed(18));
      });

      $('#wcsellEth').keyup(function() {
        var recalcres = ($('#wcsellEth').val() * exchangeeth).toFixed(8);
        $('#moneyrecEth').val(recalcres);
        $('#commissionsER').html((recalcres/100*percentage).toFixed(18));
      });

      $('#moneysellBTC').keyup(function() {
        var recalcres = ($('#moneysellBTC').val() / exchangebtc).toFixed(8);
        $('#wcbuyBTC').val(recalcres);
        $('#commissionsB').html(($('#moneysellBTC').val()/100*percentage).toFixed(18));
      });

      $('#wcbuyBTC').keyup(function() {
        var recalcres = ($('#wcbuyBTC').val() * exchangebtc).toFixed(8);
        $('#moneysellBTC').val(recalcres);
        $('#commissionsB').html((recalcres/100*percentage).toFixed(18));
      });

      $('#moneysellWCR').keyup(function() {
        $('#wcbuyWCUR').val($('#moneysellWCR').val());
      });

      $('#wcbuyWCUR').keyup(function() {
        $('#moneysellWCR').val($('#wcbuyWCUR').val());
      });

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

      setTimeout(function() {
        if(contractAddress != '0' && contractAddress != '') {
          jQuery('#qrcodewc').html('').qrcode("ethereum:"+contractAddress);
          // jQuery('#qrcodebc').qrcode("this plugin is great for BTC");
          jQuery('#qrcodeet').html('').qrcode("ethereum:"+contractAddress);
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

    });

  </script>

</body>

</html>
