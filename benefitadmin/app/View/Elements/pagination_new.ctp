<div class="table-footer clearfix custom-pagination">
    <div class="DT-label pull-left margin-top5">
        <div class="dataTables_info">
            <?php echo $this->Paginator->counter(array('format' => 'Page %page% of %pages%, Showing %current% of %count% records')); ?>
        </div>
    </div>
    <div class="DT-pagination pull-right">
        <?php if($this->Paginator->numbers() != '') { ?>

            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination no-margin">
                    <li class="paginate_button previous disabled" id="jq-datatables-example_previous">
                        <?php if($this->Paginator->numbers() != null) {

                            echo $this->Paginator->prev("Previous", array('escape'=>false, 'tag'=>'span','class'=>'jq_prev'), null, null);
                        } ?>
                    </li>
                    <?php echo '<li class="paginate_button ajaxlink">';
                        echo $this->Paginator->numbers(array('modulus'=>'5', 'separator'=>'','class'=>'ajaxlink'));
                    echo '</li>'; ?>
                    <li class="paginate_button next" id="jq-datatables-example_next">
                        <?php if($this->Paginator->numbers()!=null) {

                            echo $this->Paginator->next("Next", array('escape'=>false, 'tag'=>'span','class'=>'fa fa-chevron-right1 jq_next'), null, null);
                        } ?>
                    </li>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>