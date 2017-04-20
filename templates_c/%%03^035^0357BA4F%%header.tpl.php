<?php /* Smarty version 2.6.28, created on 2017-04-03 13:59:36
         compiled from v4/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'v4/header.tpl', 31, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['charset']; ?>
" />
<title>WHMCS - <?php echo $this->_tpl_vars['pagetitle']; ?>
</title>
<link href="templates/v4/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/jscript/css/ui.all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jscript/jquery.js"></script>
<script type="text/javascript" src="../includes/jscript/jqueryui.js"></script>
<script type="text/javascript" src="../includes/jscript/textext.js"></script>
<script type="text/javascript">
var datepickerformat = "<?php echo $this->_tpl_vars['datepickerformat']; ?>
";
<?php if ($this->_tpl_vars['jquerycode']): ?>$(document).ready(function(){
    <?php echo $this->_tpl_vars['jquerycode']; ?>

});
<?php endif; ?>
<?php if ($this->_tpl_vars['jscode']): ?><?php echo $this->_tpl_vars['jscode']; ?>

<?php endif; ?>
</script>
<script type="text/javascript" src="templates/<?php echo $this->_tpl_vars['template']; ?>
/head.js"></script>
<script type="text/javascript" src="../includes/jscript/adminsearchbox.js"></script>
<?php echo $this->_tpl_vars['headoutput']; ?>

</head>
<body>
<?php echo $this->_tpl_vars['headeroutput']; ?>

  <div id="headerWrapper" align="center">
    <div id="bodyContentWrapper" align="left">
      <div id="mynotes"><form id="frmmynotes"><input type="hidden" name="action" value="savenotes" /><input type="hidden" name="token" value="<?php echo $this->_tpl_vars['csrfToken']; ?>
" /><textarea id="mynotesbox" name="notes" rows="15" cols="80"><?php echo $this->_tpl_vars['admin_notes']; ?>
</textarea><br /><input type="button" value="Save" id="savenotes" /></form></div>
      <div id="topnav">
        <div id="welcome"><?php echo $this->_tpl_vars['_ADMINLANG']['global']['welcomeback']; ?>
 <strong><?php echo $this->_tpl_vars['admin_username']; ?>
</strong>&nbsp;&nbsp;- <a href="../" title="Client Area"><?php echo $this->_tpl_vars['_ADMINLANG']['global']['clientarea']; ?>
</a> | <a href="#" id="shownotes" title="My Notes"><?php echo $this->_tpl_vars['_ADMINLANG']['global']['mynotes']; ?>
</a> | <a href="myaccount.php" title="My Account"><?php echo $this->_tpl_vars['_ADMINLANG']['global']['myaccount']; ?>
</a> | <a href="logout.php" title="Logout"><?php echo $this->_tpl_vars['_ADMINLANG']['global']['logout']; ?>
</a></div>
        <div id="date"><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A | %d %B %Y | %H:%M %p") : smarty_modifier_date_format($_tmp, "%A | %d %B %Y | %H:%M %p")); ?>
</div>
        <div class="clear"></div>
      </div>
      <div id="intellisearch"><strong><?php echo $this->_tpl_vars['_ADMINLANG']['global']['intellisearch']; ?>
</strong><br />
        <div style="padding-top: 5px;" align="center">
          <form id="frmintellisearch">
            <input type="hidden" name="intellisearch" value="1" />
            <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['csrfToken']; ?>
" />
            <input type="text" id="intellisearchval" name="value" />
            <img src="images/icons/delete.png" alt="Cancel" width="16" height="16" class="absmiddle" id="intellisearchcancel" />
          </form>
          </div>
        <div align="left" id="searchresults"></div>
      </div>
      <a title="WHMCS Home" href="./" id="logo"></a>
      <div class="navigation">
        <ul id="menu">
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "v4/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </ul>
      </div>
    </div>
  </div>
  <div id="content_container">
    <div id="left_side">

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "v4/sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    </div>
    <div id="content">
      <?php if ($this->_tpl_vars['helplink']): ?><div class="contexthelp"><a href="http://nullrefer.com/?http://docs.whmcs.com/<?php echo $this->_tpl_vars['helplink']; ?>
" target="_blank"><img src="images/icons/help.png" border="0" align="absmiddle" /> <?php echo $this->_tpl_vars['_ADMINLANG']['help']['contextlink']; ?>
</a></div><?php endif; ?>
      <h1><?php echo $this->_tpl_vars['pagetitle']; ?>
</h1>
      <div id="content_padded">