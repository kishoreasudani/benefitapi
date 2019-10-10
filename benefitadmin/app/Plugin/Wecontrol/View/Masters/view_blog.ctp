<section class="content content-custom">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i>Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">speaker_notes </i>Blogs',array('controller'=>'masters','action'=>'blogs'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>View Blog</li>
  </ol>
  <div class="container-fluid">  
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    View Blog
                </h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Title :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Blog']['title'];?>
                    </div>
                  </div>
                </div>
                 <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Summary :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Blog']['summary'];?>
                    </div>
                  </div>
                </div>
              </div>
       
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Created On :</label>
                    <div class="col-sm-8">
                      <?php echo  date(dateTimeFormat,strtotime($pages['Blog']['created']));?>
                    </div>
                  </div>
                </div>
                 <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-4 text-right">Last Updated By :</label>
                    <div class="col-sm-8">
                      <?php echo  $pages['Blog']['last_updated_by']['Admin']['first_name'].' '.$pages['Blog']['last_updated_by']['Admin']['last_name'];?>
                    </div>
                  </div>
                </div>
              </div>
       
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="row">
                    <label class="col-sm-2 text-right">Content :</label>
                    <div class="col-sm-9">
                      <?php echo $pages['Blog']['content'];?>
                    </div>
                  </div>
                </div>
              </div>
           </div>
        </div>
      </div>
    </div>            
  </div>
</section>










