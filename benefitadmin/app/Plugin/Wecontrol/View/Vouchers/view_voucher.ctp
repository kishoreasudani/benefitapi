<section class="content content-custom">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i>Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">collections_bookmark </i>Vouchers',array('controller'=>'vouchers','action'=>'index'),array('escape'=>false)) ; ?></li>        
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
              <div class="row margin-bottom15">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Name :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Voucher']['name'];?>
                    </div>
                  </div>
                </div>
                 <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Code :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Voucher']['code'];?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row margin-bottom15">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Amount :</label>
                    <div class="col-sm-8">
                      <?php echo  '₹'.$pages['Voucher']['amount'];?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Coins Required:</label>
                    <div class="col-sm-8">
                      <?php echo $pages['Voucher']['coins_required'];?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row margin-bottom15">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Start Date :</label>
                    <div class="col-sm-8">
                      <?php echo  date(dateFormat,strtotime($pages['Voucher']['start_date']));?>
                    </div>
                  </div>
                </div>
                 <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">End Date :</label>
                    <div class="col-sm-8">
                      <?php echo  date(dateFormat,strtotime($pages['Voucher']['end_date']));?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row margin-bottom15">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Status :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Voucher']['status'];?>
                    </div>
                  </div>
                </div>
                <?php if(isset($pages['Voucher']['created_by']['Admin']['first_name']) && !empty($pages['Voucher']['created_by']['Admin']['first_name'])){?>
                 <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Created By :</label>
                    <div class="col-sm-8">
                      <?php 
                      
                      echo  $pages['Voucher']['created_by']['Admin']['first_name'].' '.$pages['Voucher']['created_by']['Admin']['last_name'];?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
              <div class="row margin-bottom15">
                <?php if(isset($pages['Voucher']['modified_by']['Admin']['first_name']) && !empty($pages['Voucher']['modified_by']['Admin']['first_name'])){?>
                 <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Modified By :</label>
                    <div class="col-sm-8">
                      <?php 
                      
                      echo  $pages['Voucher']['modified_by']['Admin']['first_name'].' '.$pages['Voucher']['modified_by']['Admin']['last_name'];?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">End Date :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Voucher']['end_date'];?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row margin-bottom15">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">T&C :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Voucher']['terms_and_conditions'];?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Descriptions :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Voucher']['descriptions'];?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row margin-bottom15">
                <?php   if(isset($pages['Voucher']['image']) && !empty($pages['Voucher']['image'])){?>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Logo :</label>
                    <div class="col-sm-8">
                      <?php $fileName = $pages['Voucher']['image'];
                      $imagepath = Configure::read('SiteSettings.Relative.VoucherImage').'/'.$fileName;
                      if(!is_dir($imagepath) && file_exists( $imagepath)){
                      $imagepath = Configure::read('SiteSettings.Absolute.VoucherImage').'/'.$fileName;
                      } ?>                             
                      <?php echo $this->Html->image($imagepath,array('width'=>'100%;'));?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php   if(isset($pages['Voucher']['bg_image']) && !empty($pages['Voucher']['bg_image'])){?>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Background Image :</label>
                    <div class="col-sm-8">
                      <?php $fileName_bg = $pages['Voucher']['bg_image'];
                      $imagepath_bg = Configure::read('SiteSettings.Relative.VoucherImage').'/'.$fileName_bg;
                      if(!is_dir($imagepath) && file_exists( $imagepath_bg)){
                      $imagepath_bg = Configure::read('SiteSettings.Absolute.VoucherImage').'/'.$fileName_bg;
                      } ?>                             
                      <?php echo $this->Html->image($imagepath_bg,array('width'=>'100%;'));?>
                    </div>
                  </div>
                </div>
                </div>
              <?php } ?>
              </div>
            </div>
        </div>
      </div>
    </div>            
  </div>
</section>










