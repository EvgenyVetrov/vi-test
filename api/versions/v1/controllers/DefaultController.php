<?php namespace app\api\modules\v1\controllers;

use yii\rest\ActiveController;

class DefaultController extends ActiveController
{
    public function actionHome() {
        return [
            'message' => 'Hello! It Works',
            'author'  => 'E. Vetrov',
            'version' => 'v1'
        ];
    }
}