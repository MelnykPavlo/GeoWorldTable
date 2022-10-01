<?php

namespace app\controllers;

use app\models\City;
use app\models\City_language;
use app\models\Continent;
use app\models\Country;
use app\models\Region;
use app\models\Region_language;
use yii\data\ActiveDataProvider;

use app\models\WorldForm;
use Yii;

class PjaxController extends \yii\web\Controller
{
    public function actionWorldForm()
    {

        $model = new WorldForm();
        $continents = Continent::find()->asArray()->all();
        $continent = null;
        $country = null;
        $countries = null;
        $cities = null;
        $city = null;
        $regions = null;
        $region = null;
        $apiKey = "e525a00caf58572579c3e2723291965b";

        if (Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            $continent = Continent::find()->where(['continent_id' => $model->continent_id])->one();
            $countries = Country::find()->where(['continent_id' => $model->continent_id])->all();
            if($model->country_id != 0){
                $country = Country::find()->where(['country_id' => $model->country_id])->one();
                $regions1 = Region::find()->where(['country_id' => $model->country_id])->all();
                $regions = Region_language::find()->where(['region_id' => $regions1, 'language' => "ua"])->all();
            }
            if($model->region_id != 0){
                $region1 = Region::find()->where(['region_id' => $model->region_id])->one();
                $region = Region_language::find()->where(['region_id' => $model->region_id])->one();
                $cities1 = City::find()->where(['region_id' => $model->region_id])->all();
                $cities = City_language::find()->where(['city_id' => $cities1, 'language' => "ua"])->all();
            }
            if($model->city_id != 0){
                $city = City_language::find()->where(['city_id' => $model->city_id])->one();
                $city1 = City::find()->where(['city_id' => $model->city_id])->one();
            }
        }

        if (Yii::$app->request->isPjax) {
            $url = "http://api.openweathermap.org/data/2.5/weather?q=" . ($city->name_language) . "&lang=ru&units=metric&appid=" . $apiKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            $dataJson = json_decode(curl_exec($ch));
        }


        return $this->render('world-form', [
            'model' => $model,
            'continents' => $continents,
            'continent' => $continent,
            'countries' => $countries,
            'country' => $country,
            'regions' => $regions,
            'region' => $region,
            'region1' => $region1,
            'cities' => $cities,
            'city' => $city,
            'city1' => $city1,
            'dataJson' => $dataJson,
        ]);
    }


}