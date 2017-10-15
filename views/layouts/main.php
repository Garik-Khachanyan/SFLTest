<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar"><div class="container">
            <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                <a class="navbar-brand" href="/">My Company</a>
            </div>
            <div id="w0-collapse" class="collapse navbar-collapse">
                <?php if(Yii::$app->session->get('userType') == 'manager'){ ?>

                    <ul id="w1" class="navbar-nav navbar-right nav">
                    <li class="<?=$_SERVER['REQUEST_URI'] == '/manager' ? 'active':'' ?>"><a  href="/manager">Tables</a></li>
                    <li class="<?=$_SERVER['REQUEST_URI'] == '/manager/products' ? 'active':'' ?>"><a href="/manager/products">Products</a></li>
                    <li class="<?=$_SERVER['REQUEST_URI'] == '/manager/users' ? 'active':'' ?>"><a href="/manager/users">Users</a></li>
                    <li><a href="/site/logout">Logout</a></li>
                </ul>
               <?php }elseif(Yii::$app->session->get('userType') == 'waiter'){ ?>
                    <ul id="w1" class="navbar-nav navbar-right nav">
                        <li class="<?=$_SERVER['REQUEST_URI'] == '/manager' ? 'active':'' ?>"><a href="/waiter">My Tables</a></li>
                        <li class="<?=$_SERVER['REQUEST_URI'] == '/manager' ? 'active':'' ?>"><a href="/site/logout">Logout</a></li>
                    </ul>
                <?php } ?>

            </div>
          </div>
    </nav>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php $this->endPage() ?>
