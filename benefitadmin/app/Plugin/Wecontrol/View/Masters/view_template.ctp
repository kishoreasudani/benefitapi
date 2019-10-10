<section class="content content-custom">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i>Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">mail_outline </i>Email Templates',array('controller'=>'masters','action'=>'email_templates'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>View Template</li>
  </ol>
  <div class="container-fluid">  
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    View Template
                </h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-xs-2 text-right">Title :</label>
                    <div class="col-xs-10">
                      <?php echo  $pages['NotifyTemplate']['title'];?>
                    </div>
                  </div>
                </div>
                 <div class="col-sm-6">
                  <div class="row">
                    <label class="col-xs-2 text-right">Heading :</label>
                    <div class="col-xs-10">
                      <?php echo  $pages['NotifyTemplate']['subject'];?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-2 text-right">Modified By :</label>
                    <div class="col-sm-10">
                      <?php echo ucfirst($user_name['0']['Admin']['first_name']).' '.ucfirst($user_name['0']['Admin']['last_name']);?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="row">
                    <label class="col-sm-1 text-right">Description :</label>
                    <div class="col-sm-10">
                      <?php echo $pages['NotifyTemplate']['content'];?>
                    </div>
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










