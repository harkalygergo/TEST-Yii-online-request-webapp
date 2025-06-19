<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'CSV Export - Admin';
?>
<div class="admin-export">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-warning">
        <strong>Figyelem!</strong> Ez az admin felület. Csak jogosult személyek használhatják.
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Havi export generálása</h3>
                </div>
                <div class="panel-body">
                    <?php if (empty($availableMonths)): ?>
                        <div class="alert alert-info">
                            <p>Még nincsenek beérkezett igények az adatbázisban.</p>
                        </div>
                    <?php else: ?>
                        <?php $form = ActiveForm::begin(['method' => 'post']); ?>

                        <div class="form-group">
                            <label for="month" class="control-label">Válasszon hónapot:</label>
                            <?= Html::dropDownList('month', null, $availableMonths, [
                                'class' => 'form-control',
                                'prompt' => 'Válasszon hónapot...',
                                'id' => 'month'
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('CSV Export', [
                                'class' => 'btn btn-success',
                                'name' => 'export-button'
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <hr>
                        <h4>Elérhető hónapok:</h4>
                        <ul>
                            <?php foreach ($availableMonths as $monthKey => $monthLabel): ?>
                                <li>
                                    <?= Html::a($monthLabel, ['export', 'month' => $monthKey], [
                                        'class' => 'btn btn-sm btn-default'
                                    ]) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">CSV Export információk</h3>
                </div>
                <div class="panel-body">
                    <h4>A CSV fájl tartalma:</h4>
                    <ul>
                        <li>ID</li>
                        <li>Név</li>
                        <li>E-mail cím</li>
                        <li>Munka típusa</li>
                        <li>Munka részletezése</li>
                        <li>IP cím</li>
                        <li>Böngésző információ</li>
                        <li>Beérkezés időpontja</li>
                    </ul>

                    <h4>Fájl formátum:</h4>
                    <ul>
                        <li>Karakterkódolás: UTF-8 BOM</li>
                        <li>Elválasztó: pontosvessző (;)</li>
                        <li>Fájlnév: igenyek_YYYY-MM.csv</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
