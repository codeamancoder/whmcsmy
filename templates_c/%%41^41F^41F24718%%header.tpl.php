<?php /* Smarty version 2.6.28, created on 2017-03-27 13:03:33
         compiled from default/header.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo $this->_tpl_vars['charset']; ?>
" />
    <title><?php if ($this->_tpl_vars['kbarticle']['title']): ?><?php echo $this->_tpl_vars['kbarticle']['title']; ?>
 - <?php endif; ?><?php echo $this->_tpl_vars['pagetitle']; ?>
 - <?php echo $this->_tpl_vars['companyname']; ?>
</title>

    <?php if ($this->_tpl_vars['systemurl']): ?><base href="<?php echo $this->_tpl_vars['systemurl']; ?>
" />
    <?php endif; ?><script type="text/javascript" src="includes/jscript/jquery.js"></script>
    <?php if ($this->_tpl_vars['livehelpjs']): ?><?php echo $this->_tpl_vars['livehelpjs']; ?>

    <?php endif; ?>
    <link href="templates/<?php echo $this->_tpl_vars['template']; ?>
/css/bootstrap.css" rel="stylesheet">
    <link href="templates/<?php echo $this->_tpl_vars['template']; ?>
/css/whmcs.css" rel="stylesheet">

    <script src="templates/<?php echo $this->_tpl_vars['template']; ?>
/js/whmcs.js"></script>

    <?php echo $this->_tpl_vars['headoutput']; ?>


  </head>

  <body>

<?php echo $this->_tpl_vars['headeroutput']; ?>


<div id="whmcsheader">
    <div class="whmcscontainer">
        <div id="whmcstxtlogo"><a href="index.php"><?php echo $this->_tpl_vars['companyname']; ?>
</a></div>
        <div id="whmcsimglogo"><a href="index.php"><img src="templates/<?php echo $this->_tpl_vars['template']; ?>
/img/whmcslogo.png" alt="<?php echo $this->_tpl_vars['companyname']; ?>
" /></a></div>
    </div>
</div>

  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="nav-collapse">
        <ul class="nav">
            <li><a id="Menu-Home" href="<?php if ($this->_tpl_vars['loggedin']): ?>clientarea<?php else: ?>index<?php endif; ?>.php"><?php echo $this->_tpl_vars['LANG']['hometitle']; ?>
</a></li>
        </ul>
<?php if ($this->_tpl_vars['loggedin']): ?>
    <ul class="nav">
        <li class="dropdown"><a id="Menu-Services" class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->_tpl_vars['LANG']['navservices']; ?>
&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a id="Menu-Services-My_Services" href="clientarea.php?action=products"><?php echo $this->_tpl_vars['LANG']['clientareanavservices']; ?>
</a></li>
            <?php if ($this->_tpl_vars['condlinks']['pmaddon']): ?><li><a id="Menu-Services-My_Projects" href="index.php?m=project_management"><?php echo $this->_tpl_vars['LANG']['clientareaprojects']; ?>
</a></li><?php endif; ?>
            <li class="divider"></li>
            <li><a id="Menu-Services-Order_New_Services" href="cart.php"><?php echo $this->_tpl_vars['LANG']['navservicesorder']; ?>
</a></li>
            <li><a id="Menu-Services-View_Available_Addons" href="cart.php?gid=addons"><?php echo $this->_tpl_vars['LANG']['clientareaviewaddons']; ?>
</a></li>
          </ul>
        </li>
      </ul>


          <?php if ($this->_tpl_vars['condlinks']['domainreg'] || $this->_tpl_vars['condlinks']['domaintrans']): ?><ul class="nav">
            <li class="dropdown"><a id="Menu-Domains" class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->_tpl_vars['LANG']['navdomains']; ?>
&nbsp;<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a id="Menu-Domains-My_Domains" href="clientarea.php?action=domains"><?php echo $this->_tpl_vars['LANG']['clientareanavdomains']; ?>
</a></li>
                <li class="divider"></li>
                <li><a id="Menu-Domains-Renew_Domains" href="cart.php?gid=renewals"><?php echo $this->_tpl_vars['LANG']['navrenewdomains']; ?>
</a></li>
                <?php if ($this->_tpl_vars['condlinks']['domainreg']): ?><li><a id="Menu-Domains-Register_a_New_Domain" href="cart.php?a=add&domain=register"><?php echo $this->_tpl_vars['LANG']['navregisterdomain']; ?>
</a></li><?php endif; ?>
                <?php if ($this->_tpl_vars['condlinks']['domaintrans']): ?><li><a id="Menu-Domains-Transfer_Domains_to_Us" href="cart.php?a=add&domain=transfer"><?php echo $this->_tpl_vars['LANG']['navtransferdomain']; ?>
</a></li><?php endif; ?>
                <?php if ($this->_tpl_vars['enomnewtldsenabled']): ?><li><a id="Menu-Domains-Preregister_New_TLDs" href="<?php echo $this->_tpl_vars['enomnewtldslink']; ?>
">Preregister New TLDs</a></li><?php endif; ?>
                <li class="divider"></li>
                <li><a id="Menu-Domains-Whois_Lookup" href="domainchecker.php"><?php echo $this->_tpl_vars['LANG']['navwhoislookup']; ?>
</a></li>
              </ul>
            </li>
          </ul><?php endif; ?>

          <ul class="nav">
            <li class="dropdown"><a id="Menu-Billing" class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->_tpl_vars['LANG']['navbilling']; ?>
&nbsp;<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a id="Menu-Billing-My_Invoices" href="clientarea.php?action=invoices"><?php echo $this->_tpl_vars['LANG']['invoices']; ?>
</a></li>
                <li><a id="Menu-Billing-My_Quotes" href="clientarea.php?action=quotes"><?php echo $this->_tpl_vars['LANG']['quotestitle']; ?>
</a></li>
                <li class="divider"></li>
                <?php if ($this->_tpl_vars['condlinks']['addfunds']): ?><li><a id="Menu-Billing-Add_Funds" href="clientarea.php?action=addfunds"><?php echo $this->_tpl_vars['LANG']['addfunds']; ?>
</a></li><?php endif; ?>
                <?php if ($this->_tpl_vars['condlinks']['masspay']): ?><li><a id="Menu-Billing-Mass_Payment" href="clientarea.php?action=masspay&all=true"><?php echo $this->_tpl_vars['LANG']['masspaytitle']; ?>
</a></li><?php endif; ?>
                <?php if ($this->_tpl_vars['condlinks']['updatecc']): ?><li><a id="Menu-Billing-Manage_Credit_Card" href="clientarea.php?action=creditcard"><?php echo $this->_tpl_vars['LANG']['navmanagecc']; ?>
</a></li><?php endif; ?>
              </ul>
            </li>
          </ul>

          <ul class="nav">
            <li class="dropdown"><a id="Menu-Support" class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->_tpl_vars['LANG']['navsupport']; ?>
&nbsp;<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a id="Menu-Support-Tickets" href="supporttickets.php"><?php echo $this->_tpl_vars['LANG']['navtickets']; ?>
</a></li>
                <li><a id="Menu-Support-Knowledgebase" href="knowledgebase.php"><?php echo $this->_tpl_vars['LANG']['knowledgebasetitle']; ?>
</a></li>
                <li><a id="Menu-Support-Downloads" href="downloads.php"><?php echo $this->_tpl_vars['LANG']['downloadstitle']; ?>
</a></li>
                <li><a id="Menu-Support-Network_Status" href="serverstatus.php"><?php echo $this->_tpl_vars['LANG']['networkstatustitle']; ?>
</a></li>
              </ul>
            </li>
          </ul>

          <ul class="nav">
            <li><a id="Menu-Open_Ticket" href="submitticket.php"><?php echo $this->_tpl_vars['LANG']['navopenticket']; ?>
</a></li>
          </ul>

          <?php if ($this->_tpl_vars['condlinks']['affiliates']): ?><ul class="nav">
            <li><a id="Menu-Affiliates" href="affiliates.php"><?php echo $this->_tpl_vars['LANG']['affiliatestitle']; ?>
</a></li>
          </ul><?php endif; ?>

<?php if ($this->_tpl_vars['livehelp']): ?>
          <ul class="nav">
            <li><a id="Menu-Live_Chat" href="#" class="LiveHelpButton">Live Chat - <span class="LiveHelpTextStatus">Offline</span></a></li>
          </ul>
<?php endif; ?>

          <ul class="nav pull-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="Menu-Hello_User"><?php echo $this->_tpl_vars['LANG']['hello']; ?>
, <?php echo $this->_tpl_vars['loggedinuser']['firstname']; ?>
!&nbsp;<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a id="Menu-Hello_User-Edit_Account_Details" href="clientarea.php?action=details"><?php echo $this->_tpl_vars['LANG']['editaccountdetails']; ?>
</a></li>
                <?php if ($this->_tpl_vars['condlinks']['updatecc']): ?><li><a id="Menu-Hello_User-Contacts_Sub-Accounts" href="clientarea.php?action=creditcard"><?php echo $this->_tpl_vars['LANG']['navmanagecc']; ?>
</a></li><?php endif; ?>
                <li><a href="clientarea.php?action=contacts"><?php echo $this->_tpl_vars['LANG']['clientareanavcontacts']; ?>
</a></li>
                <?php if ($this->_tpl_vars['condlinks']['addfunds']): ?><li><a id="Menu-Hello_User-Add_Funds" href="clientarea.php?action=addfunds"><?php echo $this->_tpl_vars['LANG']['addfunds']; ?>
</a></li><?php endif; ?>
                <li><a id="Menu-Hello_User-Email_History" href="clientarea.php?action=emails"><?php echo $this->_tpl_vars['LANG']['navemailssent']; ?>
</a></li>
                <li><a id="Menu-Hello_User-Change_Password" href="clientarea.php?action=changepw"><?php echo $this->_tpl_vars['LANG']['clientareanavchangepw']; ?>
</a></li>
                <li class="divider"></li>
                <li><a id="Menu-Hello_User-Logout" href="logout.php"><?php echo $this->_tpl_vars['LANG']['logouttitle']; ?>
</a></li>
              </ul>
            </li>
          </ul>
<?php else: ?>
          <ul class="nav">
            <li><a id="Menu-Annoucements" href="announcements.php"><?php echo $this->_tpl_vars['LANG']['announcementstitle']; ?>
</a></li>
          </ul>
          
          <ul class="nav">
            <li><a id="Menu-Knowledgebase" href="knowledgebase.php"><?php echo $this->_tpl_vars['LANG']['knowledgebasetitle']; ?>
</a></li>
          </ul>
          
          <ul class="nav">
            <li><a id="Menu-Network_Status" href="serverstatus.php"><?php echo $this->_tpl_vars['LANG']['networkstatustitle']; ?>
</a></li>
          </ul>
          
          <ul class="nav">
            <li><a id="Menu-Affiliates" href="affiliates.php"><?php echo $this->_tpl_vars['LANG']['affiliatestitle']; ?>
</a></li>
          </ul>
          
          <ul class="nav">
            <li><a id="Menu-Contact_Us" href="contact.php"><?php echo $this->_tpl_vars['LANG']['contactus']; ?>
</a></li>
          </ul>

<?php if ($this->_tpl_vars['livehelp']): ?>
          <ul class="nav">
            <li><a id="Menu-Live_Chat" href="#" class="LiveHelpButton">Live Chat - <span class="LiveHelpTextStatus">Offline</span></a></li>
          </ul>
<?php endif; ?>

          <ul class="nav pull-right">
            <li class="dropdown"><a id="Menu-Account" class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->_tpl_vars['LANG']['account']; ?>
&nbsp;<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a id="Menu-Account-Login" href="clientarea.php"><?php echo $this->_tpl_vars['LANG']['login']; ?>
</a></li>
                <li><a id="Menu-Account-Register" href="register.php"><?php echo $this->_tpl_vars['LANG']['register']; ?>
</a></li>
                <li class="divider"></li>
                <li><a id="Menu-Account-Forgot_Password" href="pwreset.php"><?php echo $this->_tpl_vars['LANG']['forgotpw']; ?>
</a></li>
              </ul>
            </li>
          </ul>
<?php endif; ?>

        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div><!-- /navbar -->


<div class="whmcscontainer">
    <div class="contentpadded">

<?php if ($this->_tpl_vars['pagetitle'] == $this->_tpl_vars['LANG']['carttitle']): ?><div id="whmcsorderfrm"><?php endif; ?>
