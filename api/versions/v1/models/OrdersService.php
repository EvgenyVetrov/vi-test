<?php
/**
 * Created by PhpStorm.
 * User: evetrov
 * Date: 21.11.20
 * Time: 0:14
 */

namespace app\api\versions\v1\models;


use common\components\OrdersRepository;
use common\components\PaymentSystem;
use common\models\Orders;
use common\models\Products;

class OrdersService
{

    /**
     * Первичное создание заказа
     *
     * @param array $products_ids
     * @return array
     */
    public static function createOrder(array $products_ids)
    {
        if (!count($products_ids)) {
            return [
                'status'  => 'error',
                'message' => 'Нет товаров в заказе',
                'code'    => 'no_products'
            ];
        }
        $orderModel = new Orders([
            'scenario'         => Orders::SCENARIO_CREATE,
            'productsForOrder' => $products_ids
        ]);

        if ($orderModel->save()) {
            return [
                'status'           => count($orderModel->warnings) ? 'warning' : 'success',
                'message'          => 'Заказ успешно дбавлен под номером: '. $orderModel->id,
                'warnings_list'    => $orderModel->warnings,
                'ordered_products' => $orderModel->productsForOrder,
                'order_id'         => $orderModel->id,
            ];
        } else {
            return [
                'status'   => 'error',
                'message'   => 'Ошибка во время сохранения заказа',
                'code'       => 'while_save_order',
                'errors_list' => $orderModel->getErrors()
            ];
        }
    }



    /**
     * Проверка на совпадение суммы оплаты и стоимости заказа
     *
     * @param Orders $order
     * @param float $summ
     * @return bool
     */
    public static function checkSumm(Orders $order, float $summ): bool
    {
        return ($order->summ == $summ);
    }



    /**
     * Действия при оплате заказа
     *
     * @param Orders $order
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function pay(Orders $order)
    {
        $paymentSystem = new PaymentSystem();
        $paymentSystem->summ = $order->summ;

        if ($paymentSystem->pay()) {
            $order->scenario = Orders::SCENARIO_PAY;
            $order->status   = Orders::STATUS_PAID;
            $isSave = $order->save();

            return [
                'status'      => 'paid',
                'save_order'  => $isSave,
                'errors_list' => $isSave ? [] : $order->getErrors()
            ];
        }

        return [
            'status' => 'not_paid'
        ];
    }



    /**
     * Готовим список красивых объектов заказов для клиента
     * @param array $orders
     * @return array
     */
    public static function prepareOrdersList(array $orders)
    {
        $result = [];
        foreach ($orders as $order) {
            /** @var $order Orders */
            $result[] = self::prepareOneOrder($order);
        }
        return $result;
    }



    /**
     * Подготовка красивого массива данных для отдачи клиенту.
     * Можно скрыть схему базы данных, добавить простейшие вспомогательные данные, отформатировать что нужно
     * Допускается минимальная логика для причесывания данных
     *
     *
     * @param Orders $order
     * @return array
     */
    public static function prepareOneOrder(Orders $order): array {
        $result = [
            'id'           => $order->id,
            'summ'         => $order->summ,
            'status'       => $order->status,
            'status_label' => Orders::statusLabels()[$order->status],
            'created_at'   => $order->created_at,
            'created_text' => date('Y.m.d H:i', $order->created_at),
        ];

        $products = [];
        foreach ($order->orderedProducts as $product) {
            /** @var $product Products
             * По идее можно былобы задействовать ProductsService::prepareOneProduct(),
             * но формат данных товара для заказа в реальности скорее всего будет отличаться от данных товара для каталога.
             */
            $products[] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
            ];
        }

        $result['products'] = $products;
        return $result;
    }
}