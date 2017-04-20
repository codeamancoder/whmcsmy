<?php /* Smarty version 2.6.28, created on 2017-04-03 13:59:45
         compiled from original/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'original/header.tpl', 73, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['charset']; ?>
" />
<title>WHMCS - <?php echo $this->_tpl_vars['pagetitle']; ?>
</title>
<link href="templates/original/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/jscript/css/ui.all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jscript/jquery.js"></script>
<script type="text/javascript" src="../includes/jscript/jqueryui.js"></script>
<script type="text/javascript" src="../includes/jscript/adminsearchbox.js"></script>
<?php echo '<script>
  $(document).ready(function(){
     $("#intellisearchval").keyup(function () {
        var intellisearchlength = $("#intellisearchval").val().length;
        if (intellisearchlength>2) {
        $.post("search.php", { intellisearch: "true", value: $("#intellisearchval").val(), token: "'; ?>
<?php echo $this->_tpl_vars['csrfToken']; ?>
<?php echo '" },
          function(data){
            $("#searchresults").html(data);
            $("#searchresults").slideDown("slow");
          });
        }
    });
    $("#intellisearchcancel").click(function () {
        $("#intellisearchval").val("");
        $("#searchresults").slideUp("slow");
    });
    $(".datepick").datepicker({
        dateFormat: "'; ?>
<?php echo $this->_tpl_vars['datepickerformat']; ?>
<?php echo '",
        showOn: "button",
        buttonImage: "images/showcalendar.gif",
        buttonImageOnly: true,
        showButtonPanel: true
    });
    '; ?>
<?php echo $this->_tpl_vars['jquerycode']; ?>
<?php echo '
  });'; ?>

  <?php echo $this->_tpl_vars['jscode']; ?>

</script>
<?php echo $this->_tpl_vars['headoutput']; ?>

</head>
<body>
<?php echo $this->_tpl_vars['headeroutput']; ?>

<div id="searchbox" style="visibility: hidden;">
  <form method="get" action="search.php">
    &nbsp;<b><?php echo $this->_tpl_vars['_ADMINLANG']['global']['advancedsearch']; ?>
</b>
    <select name="type" id="searchtype" onchange="populate(this)">
      <option value="clients">Clients </option>
      <option value="orders">Orders </option>
      <option value="services">Services </option>
      <option value="domains">Domains </option>
      <option value="invoices">Invoices </option>
      <option value="tickets">Tickets </option>
    </select>
    <select name="field" id="searchfield">
      <option>Client ID</option>
      <option selected="selected">Client Name</option>
      <option>Company Name</option>
      <option>Email Address</option>
      <option>Address 1</option>
      <option>Address 2</option>
      <option>City</option>
      <option>State</option>
      <option>Postcode</option>
      <option>Country</option>
      <option>Phone Number</option>
      <option>CC Last Four</option>
    </select>
    <input type="text" name="q" size="25" />
    <input type="submit" value="<?php echo $this->_tpl_vars['_ADMINLANG']['global']['search']; ?>
" class="button" />
  </form>
</div>
<div id="topnav">
  <div id="welcome"><?php echo $this->_tpl_vars['_ADMINLANG']['global']['welcomeback']; ?>
 <strong><?php echo $this->_tpl_vars['admin_username']; ?>
</strong>&nbsp;&nbsp;[ <a href="#" onclick="toggleadvsearch();return false"><strong><?php echo $this->_tpl_vars['_ADMINLANG']['global']['advancedsearch']; ?>
</strong></a> | <a href="myaccount.php"><strong><?php echo $this->_tpl_vars['_ADMINLANG']['global']['myaccount']; ?>
</strong></a> | <a href="logout.php"><strong><?php echo $this->_tpl_vars['_ADMINLANG']['global']['logout']; ?>
</strong></a> ]</div>
  <div id="date"><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A <strong>|</strong> %d %B %Y <strong>|</strong> %H:%M %p") : smarty_modifier_date_format($_tmp, "%A <strong>|</strong> %d %B %Y <strong>|</strong> %H:%M %p")); ?>
</div>
  <div class="clear"></div>
</div>
<div id="logo_container">
<div class="logo"><img src="templates/original/images/toplogo.gif" alt="WHMCS" width="300" height="90" border="0" /></div>
<?php if ($this->_tpl_vars['helplink']): ?><div class="contexthelp"><a href="http://nullrefer.com/?http://docs.whmcs.com/<?php echo $this->_tpl_vars['helplink']; ?>
" target="_blank"><img src="images/icons/help.png" border="0" align="absmiddle" /> <?php echo $this->_tpl_vars['_ADMINLANG']['help']['contextlink']; ?>
</a></div><?php endif; ?>
</div>
<div class="navigation">
  <ul id="menu">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "original/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </ul>
</div>
<div id="content_container">
  <div id="left_side">

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "original/sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  </div>
  <div id="content">
    <div class="header_container">
      <h1><img src="images/icons/<?php echo $this->_tpl_vars['pageicon']; ?>
.png" alt="Hosting Clients" width="16" height="16" class="absmiddle" /> <?php echo $this->_tpl_vars['pagetitle']; ?>
</h1>
      <div id="intellisearch"><img src="images/icons/search.png" alt="Search" width="16" height="16" class="absmiddle" /> <strong><?php echo $this->_tpl_vars['_ADMINLANG']['global']['intellisearch']; ?>
</strong>
        <input type="text" id="intellisearchval" />
        <img src="images/delete.gif" alt="Cancel" width="16" height="16" class="absmiddle" id="intellisearchcancel" />
        <div align="left" id="searchresults"></div>
        <div class="clear"></div>
      </div>
    </div>
    <div id="content_padded">
      <br />