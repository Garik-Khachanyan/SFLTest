<?php

namespace app\controllers;

use app\models\Orders;
use app\models\Tables;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\db\Exception;


class TableController extends Controller
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
     * Save Table functionality
     * ADD and Edit
     * Based on Yii Active Records
     * @return \yii\web\Response
     */
    public function actionSave()
    {
        $post = Yii::$app->request->post();
        if(empty($post['description']) || empty($post['seats'])){
            return $this->asJson(['error' => true]);
        }
        if(!isset($post['tableId'])){
            $table = new Tables($post);
        }else{
            $table = Tables::findOne($post['tableId']);
            $table->setAttribute('description', $post['description']);
            $table->setAttribute('seats', $post['seats']);
        }
        try{
            $table->save();
            $data = [
                'tableId'     => $table->getAttribute('tableId'),
                'description' => $post['description'],
                'seats'       => $post['seats'],
            ];
            return $this->asJson(['success' => true,'data' => $data]);
        }catch (Exception $e){
            return $this->asJson(['error' => true]);
        }
    }

    /**
     * Delete Table
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        if(empty($post['tableId'])){
            return $this->asJson(['error' => true]);
        }
        try{
            $table = Tables::findOne($post['tableId']);
            $table->delete();
            return $this->asJson(['success' => true]);

        }catch (Exception $e){
            return $this->asJson(['error' => true]);

        }

    }

    /**
     * Get All Waiters for Assign List
     * @return \yii\web\Response
     */
    public function actionUsers()
    {
        $get = Yii::$app->request->get();
        if(empty($get['tableId'])){
            return $this->asJson(['error' => true]);
        }
        return $this->asJson(['success' => true, 'data' => User::findAll(['userType' => 'waiter'])]);
    }

    /**
     * Assign Table To User
     * If table have a waiter, and pending order,
     * System doesn't allow to assign to the new waiter
     * @return \yii\web\Response
     */
    public function actionAssign()
    {
        $post = Yii::$app->request->post();
        if(empty($post['tableId']) || empty($post['userId'])){
            return $this->asJson(['error' => true]);
        }
        if(empty(User::findOne($post['userId']))){
            return $this->asJson(['error' => true]);
        }
        if(!Orders::checkExistingOrder($post['tableId'])){
            return $this->asJson(['error' => true]);
        }

        $table = Tables::findOne($post['tableId']);
        $table->setAttribute('waiterId', $post['userId']);
        try{
            $table->save();
            return $this->asJson(['success' => true]);
        }catch (Exception $e){
            return $this->asJson(['error' => true]);
        }

    }


}