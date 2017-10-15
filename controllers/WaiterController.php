<?php

namespace app\controllers;

use app\models\Orders;
use app\models\Products;
use app\models\Tables;
use app\models\User;
use Yii;
use yii\db\Exception;
use yii\web\Controller;


class WaiterController extends Controller
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
        if(!isset($userId) || $userType != 'waiter')
        {
            $this->redirect(array('/login'));
        }

        return true;
    }

    /**
     * index page for waiter
     * @return string
     */
    public function actionIndex()
    {
        $tables = User::getUserTablesByUserId(Yii::$app->session->get('userId'));
        return $this->render('waiter',['tables' => $tables]);
    }

    /**
     * Product List for waiter for choosing
     * before creating an order
     * @return \yii\web\Response
     */
    public function actionProducts()
    {
        $products = Products::getAllProducts();
        return $this->asJson(['success' => true,'data' => $products]);
    }

    /**
     * Creates new order for given Table
     * if table already have a pending order
     * return false
     * @return \yii\web\Response
     */
    public function actionOrder()
    {
        $post = Yii::$app->request->post();
        if(empty($post['tableId']) || empty($post['products'])){
            return $this->asJson(['error' => true]);
        }
        if(!Orders::createOrderWithProducts($post['tableId'], $post['products'])){
            return $this->asJson(['error' => true]);
        }
        return $this->asJson(['success' => true]);;

    }

    /**
     * Close pending Order
     * @return \yii\web\Response
     */
    public function actionClose()
    {
        $post = Yii::$app->request->post();
        if(empty($post['orderId'])){
            return $this->asJson(['error' => true]);
        }
        $order = Orders::findOne($post['orderId']);
        $order->setAttribute('status','closed');
        try{
            $order->save();
            return $this->asJson(['success' => true]);
        }catch (Exception $e){
            return $this->asJson(['error' => true]);

        }

    }



}