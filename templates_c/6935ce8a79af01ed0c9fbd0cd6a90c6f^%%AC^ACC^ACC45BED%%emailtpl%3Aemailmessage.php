<?php /* Smarty version 2.6.28, created on 2017-04-08 09:11:50
         compiled from emailtpl:emailmessage */ ?>
<p><a href="<?php echo $this->_tpl_vars['company_domain']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['company_logo_url']; ?>
" alt="<?php echo $this->_tpl_vars['company_name']; ?>
" border="0" /></a></p>
<p>
Dear <?php echo $this->_tpl_vars['client_name']; ?>
,
</p>
<p>
This is a billing reminder that your invoice no. <?php echo $this->_tpl_vars['invoice_num']; ?>
 which was generated on <?php echo $this->_tpl_vars['invoice_date_created']; ?>
 is due on <?php echo $this->_tpl_vars['invoice_date_due']; ?>
.
</p>
<p>
Your payment method is: <?php echo $this->_tpl_vars['invoice_payment_method']; ?>

</p>
<p>
Invoice: <?php echo $this->_tpl_vars['invoice_num']; ?>
<br />
Balance Due: <?php echo $this->_tpl_vars['invoice_balance']; ?>
<br />
Due Date: <?php echo $this->_tpl_vars['invoice_date_due']; ?>

</p>
<p>
You can login to your client area to view and pay the invoice at <?php echo $this->_tpl_vars['invoice_link']; ?>

</p>
<p>
<?php echo $this->_tpl_vars['signature']; ?>

</p>