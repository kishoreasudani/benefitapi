<div class="alert alert-danger alert-dismissible error_box" style = "display:none;" role="alert">
	<button type="button" class="close close_box"  aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class = "error_msg"></div>
</div>
<div class="alert alert-success alert-dismissible success_box" style = "display:none;" role="alert">
	<button type="button" class="close close_box"  aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class="success_msg"></div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		/*setTimeout(function() {
			$('#successBox').fadeOut('fast');
		}, 5000);*/ 
		$('.close_box').click(function() {
			$('.error_box').remove();
		});
	});
</script>