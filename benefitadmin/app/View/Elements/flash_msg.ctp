<?php if($this->Session->check('Message.success')) { ?>

	<div id="successBox" class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<span id="msgbox"><?php echo $this->Session->flash('success'); ?></span>
	</div>	
<?php }
if($this->Session->check('Message.error')) { ?>

	<div id="successBox" class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<span id="msgbox"><?php echo $this->Session->flash('error'); ?></span>
	</div>	
<?php } ?>