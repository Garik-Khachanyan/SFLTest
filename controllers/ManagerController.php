<?php

namespace app\controllers;

use app\models\Products;
use app\models\Tables;
use app\models\User;
use Yii;
use yii\db\Exception;
use yii\web\Controller;


class ManagerController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Check Session Before Calling function
     *
     * ATTENTION
     *
     * Can be implemented Once in Base Controller and called in childs,
     * but Controller is in Vendor ,
     * and vendor is under .gitignore ,
     * so I decided to implement in each child controller
     *
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $userId = Yii::$app->session->get('userId');
        $userType = Yii::$app->session->get('userType');
        if(!isset($userId) || $userType != 'manager')
        {
            $this->redirect(array('/login'));
        }

        return true;
    }

    /**
     * Index page for manager with existing table list
     * @return string
     */
    public function actionIndex()
    {
        $tables = Tables::getAllTables();
        return $this->render('manager',['tables' => $tables]);
    }

    /**
     * Products list for manager
     * @return string
     */
    public function actionProducts()
    {
        $products = Products::getAllProducts();
        return $this->render('products',['products' => $products]);
    }

    /**
     * User List for manager
     * @return string
     */
    public function actionUsers(){
        $users = User::getAllUsersWithTables();
        return $this->render('users',['users' => $users]);
    }



}