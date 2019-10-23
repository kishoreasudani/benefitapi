<section class="content content-custom">
    <div class="container-fluid">
        <div class="block-header relative rows">
            <h2 class="text-uppercase">
				Push Notifications
			<?php   
			echo $this->Html->link('Send Notification',array('controller'=>'notifications','action'=>'send_notifications'),array('class' => 'btn bg-orange waves-effect pull-right margin-left15','escape'=>false)) ; 
            ?>
			<?php   
			echo $this->Html->link('Add Notification',array('controller'=>'notifications','action'=>'add_notification'),array('class' => 'btn bg-orange waves-effect pull-right ','escape'=>false)) ; 
            ?>         
            </h2>  
        </div>   
        <?php echo $this->element('flash_message'); ?>  	
	   	<div class="row">
	   		<div class="col-sm-12">
	   			<div class="card no-margin-b">
		   			<div class="header">
	                    <div class="row clearfix">
	                     	<?php echo $this->Form->create('Search', array('url'=>'javascript:void(0)','id' => 'serachForm'));  ?>
                                <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('title',array('class' => 'form-control', 'placeholder' => 'Message')); ?>                                            
                                        </div>
                                    </div>
                                </div>

								<div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.sender',array('class' => 'form-control', 'placeholder' => 'Sender Name','id'=>'budget')); ?>                                            
                                        </div>
                                    </div>
                                </div>
								
                                <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.receiver',array('class' => 'form-control', 'placeholder' => 'Receiver Name','id'=>'budget')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                                             
                                <div class="col-sm-3 m-t-10">
                                    <button type="button" class="btn bg-green waves-effect" id="search_button">Search</button>
                                    <button type="button" class="btn btn-primary waves-effect reset_data">Reset</button>                                    
                                </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
	                </div>
	            </div>
	   		</div>
	   	</div>

	   	
		<div class="row">
			<div class="col-sm-12">				 	
				<div class="table-light" id="empdata">
		  		</div>
		  		<div class="page-loader-wrapper position-abs" id="loading_image">
			        <div class="loader">
			            <div class="preloader">
			                <div class="spinner-layer pl-teal">
			                    <div class="circle-clipper left">
			                        <div class="circle"></div>
			                    </div>
			                    <div class="circle-clipper right">
			                        <div class="circle"></div>
			                    </div>
			                </div>
			            </div>
			            <p>Please wait...</p>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</section>

<script> 
$(document).ready(function(){

	var url = adminUrl+'notifications/notification_data';
	loadPiece(url,'#empdata');	

    $("#search_button").click(function() {
	    var search_string = $("#search_string").val();
	       $('#loading_image').show();
	    var search_value = $('#serachForm').serialize();
	  	
	    var url = "<?php echo $this->Html->url(array('controller'=>'notifications','action'=>'notification_data'));?>"+'?q='+search_value;
     	loadPiece(url,"#empdata");    
    });

	$(".reset_data").click(function(){
		$( '#serachForm' ).each(function(){
			this.reset();
		});
		var url = switchViewUrl();
		loadPiece(url+'/reset',"#empdata");      
    });

	$('#viewSwitch').click(function(){
		var switchTo = $(this).attr('switchTo');
		if(switchTo == 'grid'){
			$(this).attr('switchTo','list').parent().find('i').removeClass('fa fa-th').addClass('fa fa-bars');	
			var url = adminUrl+'notifications/notification_data';
		}else{
			$(this).attr('switchTo','grid').parent().find('i').removeClass('fa fa-bars').addClass('fa fa-th');

			var url = adminUrl+'notifications/notification_data';	
		}
		loadPiece(url,'#empdata',changeStatus);		
	});

	function switchViewUrl(){
	
		return url = adminUrl+'notifications/notification_data';	
		
	}

});
</script>

