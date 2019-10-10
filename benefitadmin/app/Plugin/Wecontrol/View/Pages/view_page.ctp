<section class="content content-custom">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">pages</i> Pages',array('controller'=>'pages','action'=>'static_page'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i> View Page</li>
  </ol>
  <div class="container-fluid">  
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    View Page
                </h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-xs-2 text-right">Title :</label>
                    <div class="col-xs-10">
                      <?php echo  $pages['Page']['title'];?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-xs-2 text-right">Heading :</label>
                    <div class="col-xs-10">
                      <?php echo  $pages['Page']['heading'];?>
                    </div>
                  </div>
                </div>
              </div>  
            </div>

            <div class="body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="row">
                    <label class="col-xs-1 text-right">Description :</label>
                    <div class="col-xs-10">
                      <?php echo $pages['Page']['description'];?>
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










