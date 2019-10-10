<?php 
    echo $this->Html->script("wecontrol/jquery.multi-select");
    echo $this->Html->css(array('wecontrol/multiple-select.css'));
    echo $this->Html->script(array('wecontrol/jquery.multiple.select.js'));
?>
<section class="content content-custom">  
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>  
        <li><?php  echo $this->Html->link('<i class="material-icons">account_circle</i> Notifications',array('controller'=>'notifications','action'=>'index'),array('escape'=>false)) ; ?></li>      
        <li class="active"><i class="material-icons">account_circle</i> Add Notification </li>
    </ol>
    <?php echo $this->element('flash_message'); ?>
    <div class="container-fluid">  
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Add Notification
                        </h2>
                    </div>
                    <div class="body">
                        <?php  
                        echo $this->Form->create('UserNotification',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'AddUserNotificationForm')) ;
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="email_address">Message</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <?php echo $this->Form->text('UserNotification.message',array('placeholder' => 'Enter Contact','class' => 'form-control')); ?>
                                                    </div>
                                                </div>
                                            </div>                
                                        </div>                                          
                                    </div>
                                </div>
                            </div>   
                        </div>              
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect add_Setting">Send</button>
                        <?php echo $this->Form->end(); ?>      
                    </div>
                </div>
            </div>
        </div>            
    </div>
</section>
<script type="text/javascript">
    $('.jq_status_list').multipleSelect({
        width: '100%',
        filter: true,
        selectAll: true,
        placeholder:'Select Users'
    });
    $('.add_Setting').on('click',function(){
        var frmData = $("#AddUserNotificationForm").serialize(); 
        bootbox.confirm({
            message: " Are you sure, you want to add this notification?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {  
                if(result == true) {
                    $("#loading_image").show();
                    $('.err-remove-validate').remove();
                    $('.form-line').removeClass('error');
                    $('.form-line').removeClass('focused');
                    $.ajax({
                        type: "POST",
                        async: true,
                        url: adminUrl+'notifications/add_notification/',
                        data: frmData,
                        dataType: 'json',
                    error:function(a,b,c) {
                        $("#loading_image2").hide();              
                    },             
                        success: function (data) {
                        $("#loading_image2").hide();
                            if(data.success == false){
                                var errors  = data.message;
                                $.each( data.message, function( key, value ) {
                                    $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                                    $('#'+key).parents('.form-line').addClass('error');
                                    $('#'+key).parents('.form-line').addClass('focused');             
                                });
                            }else if(data.success == true){
                                setTimeout(function(){ 
                                window.location.href = adminUrl+'notifications'; }, 1000); 
                            }
                        }
                    });
                }
            },className: "bootbox-m"
        });
    });
</script>

