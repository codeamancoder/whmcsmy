<?php /* Smarty version 2.6.28, created on 2017-03-27 13:03:33
         compiled from default/footer.tpl */ ?>


<?php if ($this->_tpl_vars['pagetitle'] == $this->_tpl_vars['LANG']['carttitle']): ?></div><?php endif; ?>

    </div>
</div>

<div class="footerdivider">
    <div class="fill"></div>
</div>

<div class="whmcscontainer">
    <div class="footer">
        <div id="copyright"><?php echo $this->_tpl_vars['LANG']['copyright']; ?>
 &copy; <?php echo $this->_tpl_vars['date_year']; ?>
 <?php echo $this->_tpl_vars['companyname']; ?>
. <?php echo $this->_tpl_vars['LANG']['allrightsreserved']; ?>
.</div>
        <?php if ($this->_tpl_vars['langchange']): ?><div id="languagechooser"><?php echo $this->_tpl_vars['setlanguage']; ?>
</div><?php endif; ?>
        <div class="clear"></div>
    </div>
</div>

<?php echo $this->_tpl_vars['footeroutput']; ?>


<script type="text/javascript" src="includes/jscript/anonymize.php"></script>
</body>
</html>