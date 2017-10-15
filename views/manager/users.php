<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Manager Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<button class="btn btn-success addUser"> Create New User</button>
<hr>
<div class="users">
    <?php if(!empty($users)){ ?>
        <div class="row" >
            <div class="col-sm-4"> Username</div>
            <div class="col-sm-4"> Assigned Tables Count</div>
            <div class="col-sm-4"> Manage</div>
        </div>
        <hr>
        <?php foreach($users as $user){ ?>
            <div class="row" id="<?=$user['userId']?>">
                <div class="col-sm-4 userName"><?= $user['userName'] ?></div>
                <div class="col-sm-4 assignedTables"> <?= $user['assignedTables'] ?></div>
                <div class="col-sm-4">
<!--                    <a class="btn btn-success viewTables" data-id="--><?//=$user['userId']?><!--"> View Tables</a>-->

                    <a class="btn btn-primary editUser" data-id="<?=$user['userId']?>"> Edit</a>
                    <a class="btn btn-danger deleteUser" data-id="<?=$user['userId']?>"> Delete</a>
                </div>
            </div>
            <hr>

        <?php }} else{ ?>
        <div> No Data Found </div>
    <?php } ?>
</div>
<div id="addUserModal" class="modal fade" role="dialog">
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
                        Username
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="userName" class="form-control" name="userName" placeholder="Username...">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        Password
                    </div>
                    <div class="col-sm-6">
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                       Confirm Password
                    </div>
                    <div class="col-sm-6">
                        <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="Confirm Password...">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success add-user" >Save</button>
            </div>
        </div>

    </div>
</div>
<div id="deleteUserModal" class="modal fade" role="dialog">
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
                <button type="button" class="btn btn-danger confirmUserDelete" >Yes</button>
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
                <h4 class="modal-title">User Assigned Tables</h4>
            </div>
            <div class="modal-body" id="userTables">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>