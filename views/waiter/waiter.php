<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Waiter Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<hr>
<div class="tables">
    <?php if(!empty($tables)){ ?>
        <div class="row" >
            <div class="col-sm-4"> Table Description</div>
            <div class="col-sm-4"> Seats Count</div>
            <div class="col-sm-4"> Manage</div>
        </div>
        <hr>
        <?php foreach($tables as $table){?>
            <div class="row" id="<?=$table['tableId']?>">
                <div class="col-sm-4 description"><?= $table['tableDescription'] ?></div>
                <div class="col-sm-4 seats"> <?= $table['seats'] ?></div>
                <div class="col-sm-4">
                    <?php if(is_null($table['orderId'])){ ?>
                        <a class="btn btn-success createOrder" data-id="<?=$table['tableId']?>"> Create Order</a>
                    <?php }else{ ?>
                        <a class="btn btn-danger closeOrder" data-id="<?=$table['orderId']?>"> Close Order</a>
                   <?php }?>

                </div>
            </div>
            <hr>

        <?php }} else{ ?>
        <div> No Data Found </div>
    <?php } ?>
</div>

<div id="closeModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to close this order? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirmClose" >Yes</button>
            </div>
        </div>

    </div>
</div>
<div id="createOrder" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choose product</h4>
            </div>
            <div class="modal-body" id="userTables">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success saveOrder" >Save</button>
            </div>
        </div>

    </div>
</div>
