<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Таблица товаров. Очень краткое предстваление товара.
 * При удалении товара лучше не удалять связанные заказы и прочие сущности, поэтому жесткой связи на уровне БД нет.
 *
 * @property int $id
 * @property float $price
 * @property string $name
 */
class Products extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'name'  => 'название',
            'price' => 'цена'
        ];
    }






}
