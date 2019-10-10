<?php if($this->Session->check('Message.success')){ ?>
	<div id="successBox" class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<span id="msgbox"><?php echo $this->Session->flash('success');?></span>
	</div>	
<?php } ?>

<?php if($this->Session->check('Message.error')){ ?>
	<div id="successBox" class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<span id="msgbox"><?php echo $this->Session->flash('error');?></span>
	</div>	
<?php } ?>
<div class="alert alert-danger alert-dismissible error_box" style = "display:none;" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true"  >&times;</span>
	</button>
 <div class = "error_msg"></div>   
</div>
<div class="alert alert-success alert-dismissible success_box" style = "display:none;" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">&times;</span>
	</button>
	<div class="success_msg"></div>
</div>