<div id="successBox" class="alert alert-success message-fix" <?php if(!$this->Session->check('Message.success')){ ?> style="display:none;" <?php }else{ ?> style="position:relative !important;" <?php } ?>>
	<button type="button" class="close" data-dismiss="alert">×</button>
	<span id="msgbox"><?php echo $this->Session->flash('success'); ?></span>
</div>

<div id="errorBox" class="alert alert-danger message-fix" <?php if(!$this->Session->check('Message.error')){ ?> style="display:none;" <?php }else{ ?>style="position:relative !important;"<?php } ?>>
	<button type="button" class="close" data-dismiss="alert">×</button>
	<span id="errorMsgbox"><?php echo $this->Session->flash('error'); ?></span>
</div>