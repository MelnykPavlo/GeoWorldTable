<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

?>

<?php Pjax::begin([
    'id' => 'world-form-container'
]); ?>
<?php $form = ActiveForm::begin([
    'options' => ['data' => ['pjax' => true],],
    'id' => 'world-form'
]); ?>

<?= $form->field($model, 'continent_id')->dropDownList(ArrayHelper::map($continents, 'continent_id', 'name'), [
    'id' => 'field-continent-id',
    'onchange' => '$("#world-form").submit()',
    'prompt' => 'Choose continent'
]) ?>

<?php if ($countries): ?>
    <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map($countries, 'country_id', 'name'), [
        'id' => 'field-country-id',
        'onchange' => '$("#world-form").submit()',
        'prompt' => 'Choose country'
    ]) ?>
<?php endif; ?>

<?php if ($regions && $model->continent_id == $country->continent_id):; ?>
    <?= $form->field($model, 'region_id')->dropDownList(ArrayHelper::map($regions, 'region_id', 'name_language'), [
        'id' => 'field-region-id',
        'onchange' => '$("#world-form").submit()',
        'prompt' => 'Choose region'
    ]) ?>
<?php endif; ?>

<?php if ($cities && $model->continent_id == $country->continent_id && $model->country_id == $region1->country_id): ; ?>
    <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map($cities, 'city_id', 'name_language'), [
        'id' => 'field-city-id',
        'onchange' => '$("#world-form").submit()',
        'prompt' => 'Choose city'
    ]) ?>
<?php endif; ?>
<?php ActiveForm::end(); ?>
<?php if ($continent): ?>
<table class="table table-striped">
        <tr>
            <th scope="col">Continent</th>
            <th scope="col"><?= $continent->name ?></th>
        </tr>
    <?php if ($model->continent_id == $country->continent_id): ?>
        <tr>
            <th scope="col">Country</th>
            <th scope="col"><?= $country->name ?></th>
        </tr>
    <?php endif ?>
    <?php if ($model->continent_id == $country->continent_id && $model->country_id == $region1->country_id): ?>
    <tr>
        <th scope="col">Region</th>
        <th scope="col"><?= $region->name_language ?></th>
    </tr>
    <?php endif ?>
    <?php if ($model->continent_id == $country->continent_id && $model->country_id == $region1->country_id && $model->region_id == $city1->region_id): ?>
        <tr>
            <th scope="col">City</th>
            <th scope="col"><?= $city->name_language  ?></th>
        </tr>
    <?php endif ?>
</table>
<?php endif ?>

<?php if ($model->continent_id == $country->continent_id && $model->country_id == $region1->country_id && $model->region_id == $city1->region_id && $city): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Погода в місті</th>
            <th scope="col">Темпуратура</th>
            <th scope="col">Вологість</th>
            <th scope="col">Вітер</th>
        </tr>
        </thead>
        <tr>
            <th scope="col"><?= $dataJson->name; ?></th>
            <th scope="col"><?= $dataJson->main->temp_min; ?>°C</th>
            <th scope="col"><?= $dataJson->main->humidity; ?> %</th>
            <th scope="col"><?= $dataJson->wind->speed; ?> км/г</th>
        </tr>
    </table>
<?php endif ?>

<?php Pjax::end(); ?>

