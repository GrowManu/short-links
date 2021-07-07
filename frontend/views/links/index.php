<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LinksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Links';
?>
<div class="links-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Links', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => 'Infinity'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'link',
            [
                'attribute' => 'short_link',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->short_link, ['link', 'id' => $model->id]);
                },
            ],
            'time:datetime',
            'counter',

            ['class' => 'yii\grid\ActionColumn','template' => '{delete}'],
        ],
    ]);?>

    <?php Pjax::end(); ?>

</div>
