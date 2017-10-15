<?php

namespace app\controllers;

use app\models\Products;
use Yii;
use yii\db\Exception;
use yii\web\Controller;


class ProductController extends Controller
{


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
     * Save product
     * ADD and Edit functionality
     * Based on Yii Active Records
     *
     * @return \yii\web\Response
     */
    public function actionSave()
    {
        $post = Yii::$app->request->post();
        if(empty($post['description']) || empty($post['price']) || empty($post['price']) || empty($post['name'])){
            return $this->asJson(['error' => true]);
        }
        if(!isset($post['productId'])){
            $product = new Products($post);
        }else{
            $product = Products::findOne($post['productId']);
            $product->setAttribute('description',$post['description']);
            $product->setAttribute('name',$post['name']);
            $product->setAttribute('price',$post['price']);
            $product->setAttribute('cookingTime',$post['cookingTime']);
        }
        try{
            $product->save();
            $data = $post;
            $data['productId'] = $product->getAttribute('productId');
            return $this->asJson(['success' => true,'data' => $data]);
        }catch (Exception $e){
            return $this->asJson(['error' => true]);
        }
    }

    /**
     * Delete Product
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        if(empty($post['productId'])){
            return $this->asJson(['error' => true]);
        }
        try{
            $product = Products::findOne($post['productId']);
            $product->delete();
            return $this->asJson(['success' => true]);

        }catch (Exception $e){
            return $this->asJson(['error' => true]);

        }

    }


}