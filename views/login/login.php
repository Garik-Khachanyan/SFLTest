<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>





        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Username : </label>
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" name="userName" placeholder="Username..." type="text">
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Password : </label>
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" name="password" placeholder="Password..." type="password">
                    </div>
                </div>
                </div>
            </div>
            <button class="btn btn-success" id="login-btn">Login</button>
        </div>



</div>
