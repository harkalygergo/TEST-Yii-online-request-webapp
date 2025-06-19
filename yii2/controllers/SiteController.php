<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\RequestForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'request' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRequest()
    {
        $model = new RequestForm();
        $success = false;

        if ($model->load(Yii::$app->request->post()) && $model->saveRequest()) {
            $success = true;
            $model = new RequestForm(); // Reset form
        }

        return $this->render('request', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
