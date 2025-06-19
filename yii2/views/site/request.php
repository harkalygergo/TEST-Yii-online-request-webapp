<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Request;

$this->title = 'Igény beküldése';
?>
<div class="site-request">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <h4><i class="glyphicon glyphicon-ok"></i> Sikeres beküldés!</h4>
            <p>Köszönjük igényének beküldését! Munkatársaink hamarosan felveszik Önnel a kapcsolatot.</p>
            <p><?= Html::a('Új igény beküldése', ['/site/request'], ['class' => 'btn btn-success']) ?></p>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Kérjük, töltse ki az alábbi űrlapot, hogy felvehessük Önnel a kapcsolatot építőipari igényével kapcsolatban.</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <?php $form = ActiveForm::begin([
                    'id' => 'request-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                ]); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Teljes név']) ?>

                <?= $form->field($model, 'email')->input('email', ['maxlength' => true, 'placeholder' => 'pelda@email.com']) ?>

                <?= $form->field($model, 'work_type')->dropDownList(
                    Request::getWorkTypes(),
                    ['prompt' => 'Válasszon munka típust...']
                ) ?>

                <?= $form->field($model, 'work_details')->textarea([
                    'rows' => 6,
                    'placeholder' => 'Kérjük, részletezze igényét, elvárásait, specifikus követelményeit...'
                ]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton('Igény beküldése', [
                            'class' => 'btn btn-primary btn-lg',
                            'name' => 'submit-button'
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Kapcsolati információk</h3>
                    </div>
                    <div class="panel-body">
                        <p><strong>Telefon:</strong> +36 1 234 5678</p>
                        <p><strong>E-mail:</strong> info@epitoipari.hu</p>
                        <p><strong>Cím:</strong> 1234 Budapest, Példa utca 12.</p>
                        <hr>
                        <p><small>Munkaidő: Hétfő-Péntek 8:00-17:00</small></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
