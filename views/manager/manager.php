<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Manager Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<button class="btn btn-success addTable"> Create New Table</button>
<hr>
<div class="tables">
<?php if(!empty($tables)){ ?>
    <div class="row" >
    <div class="col-sm-4"> Table Description</div>
    <div class="col-sm-4"> Seats Count</div>
    <div class="col-sm-4"> Manage</div>
    </div>
    <hr>
    <?php foreach($tables as $table){ ?>
        <div class="row" id="<?=$table['tableId']?>">
            <div class="col-sm-4 description"><?= $table['description'] ?></div>
            <div class="col-sm-4 seats"> <?= $table['seats'] ?></div>
            <div class="col-sm-4">
                <a class="btn btn-success assignTable" data-userId = "<?=$table['waiterId']?>" data-id="<?=$table['tableId']?>"> Assign Table</a>
                <a class="btn btn-primary editTable" data-id="<?=$table['tableId']?>"> Edit</a>
                <a class="btn btn-danger deleteTable" data-id="<?=$table['tableId']?>"> Delete</a>
            </div>
        </div>
        <hr>

<?php }} else{ ?>
   <div> No Data Found </div>
<?php } ?>
    </div>
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New  Table</h4>
            </div>
            <div class="modal-body">
                <div class="error-message" style="color:red"></div>
                <div class="row">
                    <div class="col-sm-4">
                        Description
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="description" class="form-control" name="description" placeholder="Description...">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        Seats
                    </div>
                    <div class="col-sm-6">
                        <input type="number" id="number" class="form-control" name="seats" min="1" placeholder="Number of Seats...">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success add-table" >Save</button>
            </div>
        </div>

    </div>
</div>
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
               <p> Are you sure you want to delete this table? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirmDelete" >Yes</button>
            </div>
        </div>

    </div>
</div>
<div id="assignedTables" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">User List</h4>
            </div>
            <div class="modal-body" id="userTables">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>