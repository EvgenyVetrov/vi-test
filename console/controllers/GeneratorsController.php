<?php

namespace console\controllers;

use console\models\ProductsService;
use yii\console\Controller;

class GeneratorsController extends Controller
{
    /**
     * Генерация указанного количества товаров.
     * @param int $number
     * @return bool
     */
    public function actionProducts(int $number)
    {
        ProductsService::createProducts($number);
        echo PHP_EOL .'Сгенерировано '. $number . ' товаров'. PHP_EOL . PHP_EOL;
        return true;
    }
}
