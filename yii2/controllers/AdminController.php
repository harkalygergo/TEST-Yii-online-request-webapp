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
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'export' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $requests = Request::find()->all(); // Fetch all requests
        return $this->render('index', ['requests' => $requests]);
    }

    public function actionRegister()
    {
        $model = new \app\models\RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', 'Registration successful.');
            return $this->redirect(['login']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['export']);
        }

        $model = new \app\models\LoginForm();
        $unsuccessfulAttempts = Yii::$app->session->get('unsuccessfulLoginAttempts', 0);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                Yii::$app->session->setFlash('success', 'Login successful.');
                return $this->redirect(['export']);
            }

            // count unsuccesful login attempt and set flash with number
            $unsuccessfulAttempts++;
            Yii::$app->session->set('unsuccessfulLoginAttempts', $unsuccessfulAttempts);
            Yii::$app->session->setFlash('warning', 'Login failed. Attempt #' . $unsuccessfulAttempts);
            if ($unsuccessfulAttempts >= 3) {
                Yii::$app->session->setFlash('danger', 'Too many unsuccessful login attempts. Please try again later.');
                // send email to dotenv SUPERADMIN_EMAIL
                Yii::$app->mailer->compose()
                    ->setFrom([Yii::$app->params['SENDER_EMAIL'] => Yii::$app->params['SENDER_NAME']])
                    ->setTo(Yii::$app->params['SUPERADMIN_EMAIL'])
                    ->setSubject('Too many unsuccessful login attempts')
                    ->setTextBody($model->username. " has been {$unsuccessfulAttempts} unsuccessful login attempts.")
                    ->send();
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->homeUrl);
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
