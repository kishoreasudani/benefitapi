<section class="content content-custom">
    <div class="container-fluid">
        <div class="block-header relative">
            <h2 class="text-uppercase">
               Users      
            </h2> 
			<?php   
				echo $this->Html->link('Export User',array('controller'=>'users','action'=>'download_sheet'),array('class' => 'btn bg-green waves-effect pull-right btn-right-position','escape'=>false)) ; 
			?>   
        </div>   
        <?php echo $this->element('flash_message'); ?>  	
	   	<div class="row">
	   		<div class="col-sm-12">
	   			<div class="card no-margin-b">
		   			<div class="header">
	                    <div class="row clearfix">
	                     	<?php echo $this->Form->create('Search', array('url'=>'javascript:void(0)','id' => 'serachForm'));  ?>
                                <div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.name',array('class' => 'form-control', 'placeholder' => 'Name','id'=>'name')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.email',array('class' => 'form-control', 'placeholder' => 'Email','id'=>'email')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.mobile',array('class' => 'form-control', 'placeholder' => 'Mobile Number','id'=>'mobile')); ?>                                            
                                        </div>
                                    </div>
								</div>
								<div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.total_coins',array('class' => 'form-control', 'placeholder' => 'Total Coins','id'=>'mobile')); ?>                                            
                                        </div>
                                    </div>
								</div>
								<div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.total_used',array('class' => 'form-control', 'placeholder' => 'Total Used Coins','id'=>'mobile')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">                                        
                                        <?php echo $this->Form->select('Search.status',Configure::read('General.status'),array('empty'=>'Select Status',  'class'=>'form-control SearchValStatus'));  ?>                                           
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


	var url = adminUrl+'users/users_data';
	loadPiece(url,'#empdata',changeStatus);	

    $("#search_button").click(function() {
	    var search_string = $("#search_string").val();
	       $('#loading_image').show();
	    var search_value = $('#serachForm').serialize();
	  	
	    var url = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'users_data'));?>"+'?q='+search_value;
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
			var url = adminUrl+'users/users_data';
		}else{
			$(this).attr('switchTo','grid').parent().find('i').removeClass('fa fa-bars').addClass('fa fa-th');

			var url = adminUrl+'users/users_data';	
		}
		loadPiece(url,'#empdata',changeStatus);		
	});

	function changeStatus(){
	    $('.change-status').on('change',function(){
	    	  $("#loading_image").show();
	    	var status = $(this).val();
	    	var userId = $(this).attr('emp-id');
	    	$.ajax({
	    		type: "POST",
	            url: adminUrl+'users/change_status/',
	            data: {'data[User]':{'status':status,'id':userId}},
	            dataType: 'json',
		        error:function(a,b,c) {
	        	  	$("#loading_image").hide();
	             	bootbox.alert({
						message: 'Unable to process request. - ' + a,
						className: "bootbox-m"
					});	
		        },             
	           	success: function (data) {
	           		  $("#loading_image").hide();
	           		  if(data.success == true){
           		  			showMsg('success',data.msg);
	           		  }else{
           		  			showMsg('error',data.msg);
	           		  }
	       		}
	        });
	    });
	}

	function switchViewUrl(){
	
		return url = adminUrl+'users/users_data';	
		
	}

});
</script>

