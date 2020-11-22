<?php namespace app\api\versions\v1\controllers;

use app\api\versions\v1\models\OrdersService;
use common\components\OrdersRepository;
use common\models\Orders;
use common\models\Products;
use console\models\ProductsService;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use yii\rest\Controller;

class DefaultController extends Controller
{
    protected function verbs()
    {
        return [
            'home' => ['get'],
            'generate-products' => ['get'],
            'pay' => ['get'],
            'site-data' => ['get'],
            'order' => ['post'],
            //'active-subscriptions' => ['get'],
        ];
    }

    /**
     * Тестовый экшн. Проверить, что все работает.
     * @return array
     */
    public function actionHome() {
        return [
            'message' => 'Hello! It Works',
            'author'  => 'E. Vetrov',
            'version' => 'v1'
        ];
    }



    /**
     * Экшн генерации продуктов
     *
     * @param int $number - сколько продуктов генерировать
     * @return array
     */
    public function actionGenerateProducts(int $number = 20)
    {
        if ($number > 30) {
            return [
                'status' => 'error',
                'message' => 'Мы не можем сгенерировать такое количество товаров за раз.'
            ];
        }

        $products = ProductsService::createProducts($number);
        return [
            'status'   => 'success',
            'counter'  => count($products),
            'products' => $products
        ];
    }



    /**
     * Заказ товаров (без оплаты)
     * @return array
     */
    public function actionOrder()
    {
        $post = \Yii::$app->request->post();
        if (!isset($post['contacts']) OR !isset($post['products'])) {
            return [
                'status' => 'error',
                'message' => 'Недостаточно данных для заказа'
            ];
        }

        $result = OrdersService::createOrder($post['contacts'], (array) $post['products']);
        return $result;
    }



    /**
     * @param $order_id
     * @param $summ
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPay($order_id, $summ)
    {
        $orders = new OrdersRepository();
        $order = $orders->findModel($order_id);

        if (!OrdersService::checkSumm($order, $summ)) {
            return [
                'status' => 'error',
                'message' => 'Сумма оплаты ('.$summ.'р.) не совпадает со стоимостью товаров ('.$order->summ.'р.). Возможно стоимость товаров изменилась.'
            ];
        }

        $result = OrdersService::pay($order); // запрос на оплату

        if ($result['status'] == 'paid' AND $result['save_order']) {
            return [
                'status' => 'success',
                'message' => 'Оплата прошла успешно. Заказ оплачен'
            ];
        }
        if ($result['status'] == 'paid' AND !$result['save_order']) {
            return [
                'status' => 'warning',
                'message' => 'Оплата прошла успешно, но заказ не удалось изменить в системе'
            ];
        }

        if ($result['status'] == 'not_paid') {
            return [
                'status' => 'error',
                'message' => 'Не удалось оплатить'
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Оп! Случилась непредвиденная ошибка при оплате'
        ];

    }



    public function actionSiteData()
    {
        $orders = new OrdersRepository();
        $models = Orders::find()->joinWith('orderedProducts')->limit(1000)->all(); // должен же быть какой-то предохранитель
        $orders->multiSet($models);
        $preparedOrders = OrdersService::prepareOrdersList($orders->getAll());

        $productsModels = Products::find()->limit(1000)->all();

        $preparedProducts = ProductsService::prepareListProducts($productsModels);

        return [
            'status'        => 'success',
            'orders_list'   => $preparedOrders,
            'products_list' => $preparedProducts
        ];
    }
}