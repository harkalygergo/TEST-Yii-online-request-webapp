<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Request;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'export'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'export' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new \app\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionExport($month = null)
    {
        if (Yii::$app->request->isPost) {
            $selectedMonth = Yii::$app->request->post('month');
            if ($selectedMonth) {
                return $this->redirect(['export', 'month' => $selectedMonth]);
            }
        }

        if ($month) {
            return $this->generateCsv($month);
        }

        // Generate available months
        $availableMonths = $this->getAvailableMonths();

        return $this->render('export', [
            'availableMonths' => $availableMonths,
        ]);
    }

    private function generateCsv($month)
    {
        if (!preg_match('/^(\d{4})-(\d{2})$/', $month, $matches)) {
            throw new \yii\web\BadRequestHttpException('Hibás hónap formátum');
        }

        $year = (int)$matches[1];
        $monthNum = (int)$matches[2];

        $requests = Request::getRequestsByMonth($year, $monthNum);

        $filename = "igenyek_{$month}.csv";

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/csv; charset=utf-8');
        Yii::$app->response->headers->add('Content-Disposition', "attachment; filename=\"{$filename}\"");

        $output = fopen('php://output', 'w');

        // BOM for UTF-8
        fwrite($output, "\xEF\xBB\xBF");

        // CSV header
        fputcsv($output, [
            'ID',
            'Név',
            'E-mail cím',
            'Munka típusa',
            'Munka részletezése',
            'IP cím',
            'Böngésző információ',
            'Beérkezés időpontja'
        ], ';');

        // CSV data
        foreach ($requests as $request) {
            fputcsv($output, [
                $request->id,
                $request->name,
                $request->email,
                $request->getWorkTypeLabel(),
                $request->work_details,
                $request->ip_address,
                $request->user_agent,
                $request->created_at
            ], ';');
        }

        fclose($output);
        return Yii::$app->response;
    }

    private function getAvailableMonths()
    {
        $sql = "SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m') as month
                FROM requests
                ORDER BY month DESC";

        $months = Yii::$app->db->createCommand($sql)->queryColumn();

        $result = [];
        foreach ($months as $month) {
            $date = \DateTime::createFromFormat('Y-m', $month);
            $result[$month] = $date->format('Y. F');
        }

        return $result;
    }
}
