<section class="content content-custom">
    <div class="container-fluid">
        <div class="block-header relative">
            <h2 class="text-uppercase">
              Admin     
            </h2>  
            <?php   
			echo $this->Html->link('Add Admin',array('controller'=>'admins','action'=>'add'),array('class' => 'btn bg-orange waves-effect pull-right btn-right-position','escape'=>false)) ; 
            ?>         
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
                                        <?php echo $this->Form->text('Search.name',array('class' => 'form-control', 'placeholder' => 'Name','id'=>'name')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.email',array('class' => 'form-control', 'placeholder' => 'Email','id'=>'email')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-sm-3">
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


	var url = adminUrl+'admins/users_data';
	loadPiece(url,'#empdata',changeStatus);	

    $("#search_button").click(function() {
	    var search_string = $("#search_string").val();
	       $('#loading_image').show();
	    var search_value = $('#serachForm').serialize();
	  	
	    var url = "<?php echo $this->Html->url(array('controller'=>'admins','action'=>'users_data'));?>"+'?q='+search_value;
     	loadPiece(url,"#empdata");    
    });

	$(".reset_data").click(function(){
		$( '#serachForm' ).each(function(){
			this.reset();
		});
		var url = adminUrl+'admins/users_data';
		loadPiece(url+'/reset',"#empdata");      
    });

	$('#viewSwitch').click(function(){
		var switchTo = $(this).attr('switchTo');
		if(switchTo == 'grid'){
			$(this).attr('switchTo','list').parent().find('i').removeClass('fa fa-th').addClass('fa fa-bars');	
			var url = adminUrl+'admins/users_data';
		}else{
			$(this).attr('switchTo','grid').parent().find('i').removeClass('fa fa-bars').addClass('fa fa-th');

			var url = adminUrl+'admins/users_data';	
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
	            url: adminUrl+'admins/change_status/',
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

