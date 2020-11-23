<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Таблица для внесения корректирующих записей для указания таймзон станций, в которых таймзона не приходит от немо.
 *
 * @property int $id
 * @property int $updated_at
 * @property int $created_at
 */
class Orders extends \yii\db\ActiveRecord
{
    public $productsForOrder = []; // товары для заказа передавать сюда при заказе.
    private $totalSumm = null; // сумма заказа. Заполняется после поиска всех товаров в заказе и пересчете их стоимости
    public $warnings = []; // предупреждающие сообщения. Список текстов.

    const STATUS_NEW  = 0; // новый заказ
    const STATUS_PAID = 1; // заказ оплачен

    const SCENARIO_CREATE = 1; // первичное создание заказа
    const SCENARIO_PAY    = 2; // сценарий при оплате

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'updated_at', 'created_at'], 'integer'],
        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status'     => 'статус',
            'updated_at' => 'обновлено',
            'created_at' => 'создано'
        ];
    }



    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }



    public static function statusLabels()
    {
        return [
            self::STATUS_NEW  => 'новый',
            self::STATUS_PAID => 'оплачен'
        ];
    }



    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[Orders::SCENARIO_CREATE] = ['status'];
        $scenarios[Orders::SCENARIO_PAY]    = ['status'];
        return $scenarios;
    }



    /**
     * Связь с товарами через таблицу связей.
     * @return \yii\db\ActiveQuery
     */
    public function getOrderedProducts()
    {
        return $this->hasMany(Products::class, ['id' => 'product_id'])
            ->viaTable('ordered_products', ['order_id' => 'id']);
    }




    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario == Orders::SCENARIO_CREATE) { // после создания заказа, еще надо сохранить все товары в заказе.
            if (!count($this->productsForOrder)) {
                $this->warnings[] = 'Вы не приложили товары к заказу';
                return false; // можно эксепшн сделать, но пусть так хотябы. Уж лучше пустой заказ с контактами, чем никакого заказов
            }
            $countDirtyProducts = count($this->productsForOrder);
            $this->clearProducts();

            foreach ($this->productsForOrder as $product_id) {
                $orderedProduct = new OrderedProducts([
                    'order_id'   => $this->id,
                    'product_id' => $product_id
                ]);
                $orderedProduct->save();
            }

            if ($countDirtyProducts > count($this->productsForOrder)) {
                $this->warnings[] = 'Некоторые из товаров не были добавлены к заказу, так как не существют';
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }


    /**
     * Считает общую сумму заказа, записывает в свойство.
     */
    public function calculateSumm() {
        foreach ($this->orderedProducts as $product) {
            /** @var $product Products */
            $this->totalSumm += $product->price;
        }
    }


    public function getSumm()
    {
        if ($this->totalSumm !== null) { return $this->totalSumm; }
        $this->calculateSumm();
        return $this->totalSumm;
    }



    /**
     * Чистка входящих ID-шников продуктов к покупке.
     * А то мало ли что могут прислать.
     */
    private function clearProducts() {
        // простейшая валидация предварительная номеров товаров, чтоб они были похожи на номера
        $products = array_filter($this->productsForOrder, function ($value){
            if (!is_numeric($value)) { return false; }
            if (!is_int($value*1)) { return false; }
            if ($value*1 < 0) { return false; }
            return true;
        });

        $products = Products::find()->select(['id'])->where(['id' => $products])->asArray()->all();
        $this->productsForOrder = ArrayHelper::getColumn($products, 'id'); // оставляем только те ID, товары которых есть.
    }




}
