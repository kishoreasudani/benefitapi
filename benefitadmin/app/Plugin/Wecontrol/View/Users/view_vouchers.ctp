<section class="content content-custom">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home </i>Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">people </i>Users',array('controller'=>'users','action'=>'index'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>View Voucher</li>
  </ol>
  <div class="container-fluid">  
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    View Voucher
                </h2>
            </div>
            <div class="body">
            <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                      <th width="5%" style="text-align:center;">#</th>
                      <th  class="sortLink" width="15%"><?php echo $this->Paginator->sort('Voucher.name','Name'); ?></th> 
                      <th  class="sortLink" width="15%"><?php echo $this->Paginator->sort('Voucher.code','Code'); ?></th>
                      <th class="sortLink" width="15%" style="text-align:center;"><?php echo $this->Paginator->sort('UserOrder.created','Created'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php     
                    if(isset($listingData) && !empty($listingData)){   
                    $i = 1;       
                      foreach ($listingData as $key => $value) {   
                    ?>
                    <tr>
                      <td align="center"><?php echo $i++; ?></td>
                      <td><?php echo $value['Voucher']['name'] ?> </td>
                      <td><?php echo ucwords($value['Voucher']['code']); ?> </td>
                      <td align="center"><?php   echo date(dateFormat,strtotime($value['UserOrder']['created'])); ?> </td>
                    </tr>
                    <tr class="edit_u_account_details" style="display:none;">
                      <td colspan="6"></td>
                    </tr>
                    <?php   }
                     }else{ ?>
                    <tr align="center">
                      <td colspan="56">No data found.</td>
                    </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            <?php echo $this->element('pagination_new'); ?>
        </div>
            </div>
        </div>
      </div>
    </div>            
  </div>
</section>
<script type= "text/javascript">
$(document).ready(function(){
 
	$('.sortLink').click( function() {
      var Href = $(this).find('a').attr("href"); 
      if(Href != null){
        loadPiece(Href,"#empdata");
      }
      return false;
    });

	$('.jq_prev').click( function() {
      var HrefOne = $(this).find('a').attr("href"); 
      if(HrefOne != null){
       loadPiece(HrefOne,"#empdata");
     }
       return false;
    });

    $('.jq_next').click(function() {
      var HrefNext = $(this).find('a').attr("href");
      if(HrefNext != null){ 
        loadPiece(HrefNext,"#empdata");
      }
      return false;
    });

    $('.ajaxlink').click(function() {
      var HrefLink = $(this).find('a').attr("href");
      if(HrefLink != null){  
        loadPiece(HrefLink,"#empdata");
      }
      return false;
    });

});
</script>










