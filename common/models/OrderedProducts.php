<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Таблица для связи заказов и продуктов.
 * в нее можо добавить количество каждой заказываемой позиции
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 */
class OrderedProducts extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordered_products';
    }


    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'order_id'  => 'order_id',
            'product_id' => 'product_id'
        ];
    }






}
