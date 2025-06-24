<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Request[] $requests */

$this->title = 'Requests';
?>
<div class="admin-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>E-mail</th>
                <th>Munka típusa</th>
                <th>Leírás</th>
                <th>Készült</th>
                <th>Módosítva</th>
                <th>IP cím</th>
                <th>Böngésző, operációs rendszer</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?= Html::encode($request->id) ?></td>
                    <td><?= Html::encode($request->name) ?></td>
                    <td><?= Html::encode($request->email) ?></td>
                    <td><?= Html::encode($request->work_type) ?></td>
                    <td><?= Html::encode($request->work_details) ?></td>
                    <td><?= Html::encode($request->created_at) ?></td>
                    <td><?= Html::encode($request->updated_at) ?></td>
                    <td><?= Html::encode($request->ip_address) ?></td>
                    <td><?= Html::encode($request->user_agent) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
