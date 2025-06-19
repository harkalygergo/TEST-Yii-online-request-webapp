<?php
use yii\helpers\Html;

$this->title = 'Főoldal';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Üdvözöljük!</h1>
        <p class="lead">Építőipari Igénykezelő Rendszer</p>
        <p>
            Szakmai építőipari szolgáltatásokat nyújtunk. Ha igénye van munkáinkra,
            kérjük töltse ki igénybejelentő űrlapunkat.
        </p>
        <p>
            <?= Html::a('Igény beküldése', ['/site/request'], ['class' => 'btn btn-lg btn-success']) ?>
        </p>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <h3>Állapotfelmérés</h3>
            <p>Szakértő csapatunk felmérést végez épületek jelenlegi állapotáról,
                azonosítva a szükséges javításokat és fejlesztési lehetőségeket.</p>
        </div>
        <div class="col-lg-3">
            <h3>Alapozás-előkészítés</h3>
            <p>Professzionális alapozási munkálatok tervezése és kivitelezése,
                amely biztosítja építményei szilárd alapjait.</p>
        </div>
        <div class="col-lg-3">
            <h3>Építkezés</h3>
            <p>Teljes körű építkezési szolgáltatások lakóházaktól
                ipari létesítményekig, magas minőségben.</p>
        </div>
        <div class="col-lg-3">
            <h3>Műszaki ellenőrzés</h3>
            <p>Részletes műszaki ellenőrzések és szakértői vélemények
                a biztonságos és szabványos kivitelezés érdekében.</p>
        </div>
    </div>
</div>
