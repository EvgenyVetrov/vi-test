<?php
/**
 * Упрощенная модель-эмитация работы с платежной системой.
 * По хорошему все попытки платежей должны быть залогированы,
 * но тут это упрощено.
 *
 * Created by PhpStorm.
 * User: evetrov
 * Date: 22.11.20
 * Time: 0:51
 */

namespace common\components;


use yii\httpclient\Client;

class PaymentSystem
{
    public $summ;


    /**
     * Метод оплаты
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function pay()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://ya.ru') // можно конечно в конфиг прописать, но для теста без фанатизма
            ->setData(['summ' => $this->summ])
            ->setOptions(['timeout' => 10]) // таймаут должен быть какой-нибудь
            ->send();

        if ($response->isOk) {
            return true;
        }

        return false;
    }
}