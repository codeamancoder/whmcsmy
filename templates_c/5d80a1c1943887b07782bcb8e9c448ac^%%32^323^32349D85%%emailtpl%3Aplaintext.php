<?php /* Smarty version 2.6.28, created on 2017-04-01 13:13:06
         compiled from emailtpl:plaintext */ ?>
<p>Dear <?php echo $this->_tpl_vars['client_name']; ?>
,</p>
<p>This is a payment receipt for Invoice <?php echo $this->_tpl_vars['invoice_num']; ?>
 sent on <?php echo $this->_tpl_vars['invoice_date_created']; ?>
</p>
<p><?php echo $this->_tpl_vars['invoice_html_contents']; ?>
</p>
<p>Amount: <?php echo $this->_tpl_vars['invoice_last_payment_amount']; ?>
<br />Transaction #: <?php echo $this->_tpl_vars['invoice_last_payment_transid']; ?>
<br />Total Paid: <?php echo $this->_tpl_vars['invoice_amount_paid']; ?>
<br />Remaining Balance: <?php echo $this->_tpl_vars['invoice_balance']; ?>
<br />Status: <?php echo $this->_tpl_vars['invoice_status']; ?>
</p>
<p>You may review your invoice history at any time by logging in to your client area.</p>
<p>Note: This email will serve as an official receipt for this payment.</p>
<p><?php echo $this->_tpl_vars['signature']; ?>
</p>