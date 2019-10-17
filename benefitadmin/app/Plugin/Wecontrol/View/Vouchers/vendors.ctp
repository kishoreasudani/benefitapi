<section class="content content-custom">
    <div class="container-fluid">
        <div class="block-header relative">
            <h2 class="text-uppercase">
				Vendors
            </h2> 
			<?php   
			echo $this->Html->link('Add Vendors','javascript:void(0)',array('class' => 'btn bg-orange waves-effect pull-right btn-right-position','id'=>'addvendorformbutton','escape'=>false)) ; 
            ?>          
        </div>   
        <?php echo $this->element('flash_message'); ?>  	
	   	<div class="row">

	   		<div class="col-sm-12" id="addvendorformdata" style="display: none;">
                <div class="row clearfix">
			        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			            <div class="card">
			                <div class="header">
			                    <h2>
			                        Add Vendor
			                    </h2>
			                </div>
			                <div class="body">
			                    <?php echo $this->Form->create('Vendor',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'VendorAddForm', 'enctype' => "multipart/form-data")) ;?>                        
			                    <div class="row">
			                        <div class="col-md-6">
			                            <label for="email_address">Vendor Name<span class="red_star">*</span></label>
			                            <div class="form-group">
			                                <div class="form-line">
			                                    <?php echo $this->Form->text('Vendor.name',array('placeholder' => 'Enter vendor Name','class' => 'form-control')); ?>
			                                    	
			                                  </div>
			                            </div>
			                        </div>
			                        <div class="col-md-6">
			                            
			                            <div class="form-group">
			                                <button type="submit" class="btn btn-primary m-t-15 waves-effect align-center jq_add_vendor">Submit</button>
			                            </div>
			                        </div>
			                    </div>
			               <?php echo $this->Form->end(); ?>
			           </div>
			           </div>
                    </div>
                 </div>
	   		</div>

	   		<div class="col-sm-12">
	   			<div class="card no-margin-b">
		   			<div class="header">
	                    <div class="row clearfix">
	                     	<?php echo $this->Form->create('Search', array('url'=>'javascript:void(0)','id' => 'serachForm'));  ?>
                                <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.name',array('class' => 'form-control', 'placeholder' => 'Name')); ?>                                            
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

	var url = adminUrl+'vouchers/vendors_data';
	loadPiece(url,'#empdata');	

    $("#search_button").click(function() {
	    var search_string = $("#search_string").val();
		$('#loading_image').show();
	    var search_value = $('#serachForm').serialize();
	    var url = "<?php echo $this->Html->url(array('controller'=>'vouchers','action'=>'vendors_data'));?>"+'?q='+search_value;
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
			var url = adminUrl+'vouchers/vouchers_data';
		}else{
			$(this).attr('switchTo','grid').parent().find('i').removeClass('fa fa-bars').addClass('fa fa-th');

			var url = adminUrl+'vouchers/vouchers_data';	
		}
		loadPiece(url,'#empdata',changeStatus);		
	});

	function switchViewUrl(){
	
		return url = adminUrl+'vouchers/vendors';	
		
	}


	$("#addvendorformbutton").click(function () {
        $("#addvendorformdata").toggle()
   });

	/* add vendor */

	$(".jq_add_vendor").click( function() {

        $("#loading_image").show();
        $('.err-remove-validate').remove();
        $('.form-line').removeClass('error');
        $('.form-line').removeClass('focused');
        var ajaxOptions = {
        url         : adminUrl+'vouchers/add_vendor/',
        resetForm   : false,
        dataType    : 'json',
        success     : ajaxSuccess
        };
        $( '#VendorAddForm' ).ajaxForm( ajaxOptions );
        $( '#VendorAddForm' ).on('submit',function() {
        $("#loading_image").show();
        });
        function ajaxSuccess( data , responseCode , xhr ) {  

  
        if(data.success == false){
            var errors  = data.message;
            $.each( data.message, function( key, value ) {
                $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                $('#'+key).parents('.form-line').addClass('error');
                $('#'+key).parents('.form-line').addClass('focused'); 
            });

              $("#loading_image").hide();
            }else if(data.success == true){
               $(".success_box").show();
               $(".success_msg").html(data.message);
               $("#addvendorformdata").toggle()
               $("#VendorAddForm").trigger("reset");
             	var url = adminUrl+'vouchers/vendors_data';
	            loadPiece(url,'#empdata');
               $("#loading_image").hide();
            //setTimeout(function(){ window.location.href = adminUrl+'vouchers'; }, 500);      
        } 
        }
    });


});
</script>

