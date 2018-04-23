<?php 
  $sql->checkLogin();
?>
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">

    <div class="navbar nav_title" style="border: 0;">
      <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>White Standard</span></a>
    </div>
    
    <div class="clearfix"></div>

    <!-- menu prile quick info -->
    <div class="profile">
      <div class="profile_pic">
        <img src="<?php if($sql->getUser()['user_pic']) {echo $sql->getUser()['user_pic'];} else {echo '../images/user.png';}; ?>" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php if($sql->getUser()['user_name']) {echo $sql->getUser()['user_name'];} else {echo 'friend';}; ?></h2>
      </div>
    </div>

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

      <div class="menu_section">
        <h3><?php echo $sql->levelName($sql->checkLevel()); ?></h3>
        <ul class="nav side-menu">
          <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="../main/">Main</a>
              </li>
              <!-- <li><a href="../market/">Market</a>
              </li> -->
              <li><a href="../profile/">Profile</a>
              </li>
              <?php if($sql->checkLevel() == 1 || $sql->checkLevel() == 2) { ?>
                <li><a href="../users/">Users</a>
                </li>
              <?php } ?>
              <?php if($sql->checkLevel() == 1) { ?>
                <li><a href="../minters/">Minters</a>
                </li>
              <?php } ?>
              <?php if($sql->checkLevel() == 1) { ?>
                <li><a href="../mintrequests/">Mint requests</a>
                </li>
              <?php } ?>
              <?php if($sql->checkLevel() == 2) { ?>
                <li><a href="../wallets/">Bank</a>
                </li>
                <li><a href="../documents/">Documents</a>
                </li>
              <?php } ?>
              <?php if($sql->checkLevel() == 3) { ?>
                <li><a href="../userskyc/">Users</a>
                </li>
                <li><a href="../documents/">Documents</a>
                </li>
              <?php } ?>
            </ul>
          </li>
          <?php if($sql->checkLevel() == 0) { ?>
            <li><a><i class="fa fa-edit"></i> Wallet operations <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu" style="display: none">
                <li><a href="../fillbalance/">My balance</a>
                </li>
                <li><a href="../sendmoney/">Send money</a>
                </li>
              <?php if($sql->checkLevel() == 0) { ?>
                <li><a href="../transactions/">Transactions</a>
                </li>
              <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <li><a><i class="fa fa-desktop"></i> Support <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="../faq/">FAQ</a>
              </li>
              <!-- <li><a href="../tickets/">Tickets</a>
              </li> -->
            </ul>
          </li>
        </ul>
      </div>
      
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <!-- <div class="sidebar-footer hidden-small">
      <a href="../profile/" data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a href="../coms/logout.php" data-toggle="tooltip" data-placement="top" title="Logout">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div> -->
    <!-- /menu footer buttons -->
  </div>
</div>

<!-- top navigation -->
<div class="top_nav">

  <div class="nav_menu">
    <nav class="" role="navigation">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="../images/user.png" alt=""><?php echo $sql->getUser()['user_name'] . ' ' . $sql->getUser()['user_lastname']; ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
            <li><a href="/profile/">Profile</a>
            </li>
            <!-- <li>
              <a href="/settings/">
                <span class="badge bg-red pull-right">50%</span>
                <span>Settings</span>
              </a>
            </li> -->
            <li>
              <a href="/faq/">Help</a>
            </li>
            <li><a href="/coms/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
            </li>
          </ul>
        </li>

        <!-- <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope-o"></i>
            <span class="badge bg-green">6</span>
          </a>
          <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
            <li>
              <a>
                <span class="image">
                  <img src="../images/user.png" alt="Profile Image" />
                </span>
                <span>
                  <span><?php echo $sql->getUser()['user_name'] . ' ' . $sql->getUser()['user_lastname']; ?></span>
                  <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                    Lorem ipsum...
                </span>
              </a>
            </li>
            <li>
              <a>
                <span class="image">
                  <img src="../images/user.png" alt="Profile Image" />
                </span>
                <span>
                  <span><?php echo $sql->getUser()['user_name'] . ' ' . $sql->getUser()['user_lastname']; ?></span>
                  <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                  Lorem ipsum..
                </span>
              </a>
            </li>
            <li>
              <a>
                <span class="image">
                  <img src="../images/user.png" alt="Profile Image" />
                </span>
                <span>
                  <span><?php echo $sql->getUser()['user_name'] . ' ' . $sql->getUser()['user_lastname']; ?></span>
                  <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                  Lorem ipsum..
                </span>
              </a>
            </li>
            <li>
              <a>
                <span class="image">
                  <img src="../images/user.png" alt="Profile Image" />
                </span>
                <span>
                  <span><?php echo $sql->getUser()['user_name'] . ' ' . $sql->getUser()['user_lastname']; ?></span>
                  <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                  Lorem ipsum..
                </span>
              </a>
            </li>
            <li>
              <div class="text-center">
                <a href="inbox.html">
                  <strong>See All Messages</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </li>
          </ul>
        </li> -->

        <li>
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-krw"></i>
            <span id="wcrestricted" class="badge bg-green wcrestricted"><?php echo round($sql->getBalance(0)['amount'], 3); ?></span>
          </a>
        </li>
        <li>
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-krw"></i>
            <span id="wcunrestricted" class="badge bg-blue wcunrestricted"><?php echo round($sql->getBalance(1)['amount'], 3); ?></span>
          </a>
        </li>
        <!-- <li>
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bitcoin"></i>
            <span id="bitcoin" class="badge bg-gold bitcoin"><?php echo round($sql->getBalance(2)['amount'], 3); ?></span>
          </a>
        </li> -->
        <li>
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-inr"></i>
            <span id="ethereum" class="badge bg-white ethereum"><?php echo round($sql->getBalance(3)['amount'], 3); ?></span>
          </a>
        </li>

      </ul>
    </nav>
  </div>

</div>
<!-- /top navigation -->