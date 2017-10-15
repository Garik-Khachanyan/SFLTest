<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;


class LoginController extends Controller
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
     * @return string
     */
    public function actionIndex(){
        return $this->render('login');
    }

    /**
     * Login User Depend UserType
     * @return \yii\web\Response
     */
    public function actionLogin(){
        $post = Yii::$app->request->post();
        if(empty($post['userName']) || empty($post['password'])){
            return $this->asJson(['error' => true]);
        }
        $user = User::loginUser($post);
        if(!$user){
            return $this->asJson(['error' => true]);
        }
        $session = Yii::$app->session;
        $session->open();
        $session->set('userId',$user['userId']);
        $session['userType'] = $user['userType'];
        return $this->asJson(['success' => true,'userType' => $user['userType']]);
    }

}