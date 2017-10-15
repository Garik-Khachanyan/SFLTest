<?php

namespace app\controllers;

use app\models\Tables;
use app\models\User;
use Yii;
use yii\db\Exception;
use yii\web\Controller;


class UserController extends Controller
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
     * Save User functionality
     * ADD and Edit
     * Based on Yii Active Records
     *
     * Password can be passed to function empty, in case of Editing
     * @return \yii\web\Response
     */
    public function actionSave()
    {
        $post = Yii::$app->request->post();
        if(empty($post['userName']) || (empty($post['password']) && empty($post['userId']))) {
            return $this->asJson(['error' => true]);
        }
        if(!isset($post['userId'])){
            $post['userType'] = 'waiter';
            $user = new User($post);
        }else{
            $user = User::findOne($post['userId']);
            $user->setAttribute('userName',$post['userName']);
        }
        if(isset($post['password'])){
            $user->setAttribute('password',md5($post['password']));
        }
        try{
            $user->save();
            $data = $post;
            $data['userId'] = $user->getAttribute('userId');
            return $this->asJson(['success' => true,'data' => $data]);
        }catch (Exception $e){
            return $this->asJson(['exception' => true]);
        }
    }
    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        if(empty($post['userId'])){
            return $this->asJson(['error' => true]);
        }
        try{
            $user = User::findOne($post['userId']);
            $user->delete();
            return $this->asJson(['success' => true]);

        }catch (Exception $e){
            return $this->asJson(['error' => true]);

        }

    }
    public function actionTables()
    {
        $get = Yii::$app->request->get();
        if(empty($get['userId'])){
            return $this->asJson(['error' => true]);
        }
        return $this->asJson(['success' => true, 'data' => User::getUserTablesByUserId($get['userId']) ]);
    }


}