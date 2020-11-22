<?php
/**
 * Коллекция заказов
 *
 * Created by PhpStorm.
 * User: evetrov
 * Date: 21.11.20
 * Time: 1:04
 */

namespace common\components;


use common\models\Orders;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class OrdersRepository implements RepositoryInterface
{
    private $orders = [];


    public function getAll()
    {
        return $this->orders;
    }


    /**
     * Заполнение хранилища несколькими объектами.
     * Объекты должны быть подготовлены (сджоинены с orderedProducts)
     * @param array $objects
     */
    public function multiSet(array $objects): void
    {
        foreach ($objects as $object) {
            /** @var $object Orders */
            $this->set($object, $object->id);
        }
    }



    /**
     * Запись или обновление нового объекта в коллекции
     *
     * @param $object
     * @param null $id - id заказа из базы или произвольный ID, по которому потом можно найти заказ в этой коллекции
     * @return integer - возвращает идентификатор записи в коллекции. Обычно идентичен с базой.
     */
    public function set($object, $id = null): int
    {
        if ($id === null) {
            $this->orders[] = $object;
            return array_pop( array_keys( $this->orders));
        }

        $this->orders[$id] = $object;
        return $id;
    }



    /**
     * Возвращает конкретный заказ из коллекции.
     * Если нет в коллекции, то ищет в бд, вытаскивает всю нужную смежную инфрмацию
     * и добавляет в коллекцию, чтоб потом к бд не обращаться
     *
     * @param int $id - заказ
     * @return Orders - вмесе с заполненной информацией о товарах
     * @throws NotFoundHttpException
     */
    public function findModel(int $id)
    {
        if (isset($this->orders[$id])) {
            return $this->orders[$id];
        }

        $model = Orders::find()->joinWith('orderedProducts')->where(['orders.id' => $id])->one();
        if ($model) {
            $model->calculateSumm();
            $this->set($model, $id);
            return $model;
        }

        throw new NotFoundHttpException('Заказ #'. $id .' не найден');
    }
}