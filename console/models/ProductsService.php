<?php
/**
 * Created by PhpStorm.
 * User: evetrov
 * Date: 20.11.20
 * Time: 19:49
 */

namespace console\models;


use common\models\Products;

class ProductsService
{
    private static $typeWord = [
        'Мотобур',
        'Перфоратор',
        'Виброплита',
        'Шуруповерт',
        'Генератор',
        'Штопор'
    ];

    private static $brandWord = [
        'Gucci',
        'Apple',
        'Durex',
        'Patek Philippe',
        'Miele',
        'Nissan'
    ];

    private static $modelWord = [
        '2000',
        'Ultra',
        'Priora',
        'Max',
        'Max+',
        '1',
        '2',
        '3',
        '2020',
        'Lux',
        '250',
    ];



    /**
     * Генерация относительно произвольного названия товара
     * генерируется из 3 слов. Слова берем из статичных списков в этом классе.
     *
     * @return string
     */
    private static function generateProductName(): string
    {
        // выбор произвольных номеров элементов массивов
        $firstRandIndex  = rand(0, count(self::$typeWord) - 1);
        $secondRandIndex = rand(0, count(self::$brandWord) - 1);
        $thirdRandIndex  = rand(0, count(self::$modelWord) - 1);
        // собственно сам выбор этих элементов
        $first  = self::$typeWord[$firstRandIndex];
        $second = self::$brandWord[$secondRandIndex];
        $third  = self::$modelWord[$thirdRandIndex];

        return $first . ' ' . $second . ' ' . $third;
    }



    /**
     * Создание (генерация) товаров.
     * @param int $number - количество товаров, которое надо сгенерировать
     * @return array - списо созданых товаров
     */
    public static function createProducts(int $number = 20): array
    {
        $i = 0;
        $resultArr = [];
        while ($i < $number) {
            $productModel = new Products([
                'name' => self::generateProductName(),
                'price' => rand(1, 100) * 100 - 5
            ]);

            if ($productModel->save()) {
                $resultArr[] = [
                    'id'    => $productModel->id,
                    'name'  => $productModel->name,
                    'price' => $productModel->price
                ];
            }

            $i++;
        }
        return $resultArr;
    }



    /**
     * Подготовка красивых данных клиенту о списке товаров в каталоге
     * @param array $products
     * @return array
     */
    public static function prepareListProducts(array $products): array
    {
        $result = [];
        foreach ($products as $product) {
            /** @var $product Products */
            $result[] = self::prepareOneProduct($product);
        }
        return $result;
    }



    /**
     * Подготовка красивых данных для клиента по продукту.
     * В данном случае данные не отличаются от бд. В реальном проекте
     * тут будет куча дополнений, форматирований, вспомогательных свойств
     *
     * @param Products $product
     * @return array
     */
    public static function prepareOneProduct(Products $product): array
    {
        return [
            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->price
        ];
    }

}