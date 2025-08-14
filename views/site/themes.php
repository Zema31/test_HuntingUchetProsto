<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\Accordion;

$this->title = 'База знаний';
$this->params['breadcrumbs'][] = $this->title;

$themes = [
    'Raspberry Pi 4' => [
        'Разрядность CPU' => "64-Bit",
        'Частота CPU' => "1.5/1.8GHz",
        'GPU' => "VideoCore VI 600MHz",
    ],
    'Raspberry Pi 5' => [
        'Разрядность CPU' => "64-Bit",
        'Частота CPU' => "2.4GHz",
        'GPU' => "VideoCore VII 1GHz",
    ],
];

$items = [];
foreach ($themes as $themeTitle => $subThemes) {
    $subItems = [];

    foreach ($subThemes as $subTitle => $subSubThemes) {
        $subSubItems = [];
        $subItems[] = [
            'label' => $subTitle,
            'content' => $subSubThemes,
            'options' => ['class' => 'my-accordion'],
        ];
    }
    $items[] = [
        'label' => $themeTitle,
        'content' => Accordion::widget(['items' => $subItems]),
    ];
}

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Сравнение одноплатного компьютера Raspberry Pi
    </p>
    <?php 
    echo Accordion::widget([
        'items' => $items,
        'options' => ['class' => 'my-accordion'],
    ]);
    ?>

</div>