<?php
/**
 * Интерфейс простейшего репозитория
 *
 * Created by PhpStorm.
 * User: evetrov
 * Date: 21.11.20
 * Time: 0:49
 */

namespace common\components;


interface RepositoryInterface
{

    /**
     * Добавление объекта в коллекцию (репозиторий) или обновление
     *
     * @param $id
     * @param $object
     * @return mixed
     */
    public function set($object, $id = null): int ;


    /**
     * Возвращает все модели
     * @return mixed
     */
    public function getAll();

    /**
     * Возвращение одной модели
     *
     * @param $id
     * @return mixed
     */
    public function findModel(int $id);
}