<?php

use yii\db\Migration;

/**
 * Class m201120_143233_add_products_table
 */
class m201120_143233_add_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'name' => $this->string('50'),
            'price' => $this->float(4),
        ]);


        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'contacts' => $this->string(100),
            'status' => $this->tinyInteger(1)->defaultValue(0)->notNull(),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->createTable('ordered_products', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products');
        $this->dropTable('ordered_products');
        $this->dropTable('orders');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201120_143233_add_products_table cannot be reverted.\n";

        return false;
    }
    */
}
