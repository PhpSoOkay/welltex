<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m241205_192435_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id'      => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'fk-order-user_id',
            'order',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createTable('order_data', [
            'id'         => $this->primaryKey(),
            'order_id'   => $this->integer()->notNull(),
            'food_id'    => $this->integer()->null(),
            'food_count' => $this->integer()->defaultValue(1),
        ]);

        $this->addForeignKey(
            'fk-order_data-order_id',
            'order_data',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-order_data-food_id',
            'order_data',
            'food_id',
            'food',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-order_data-order_id',
            'order_data'
        );
        $this->dropForeignKey(
            'fk-order_data-food_id',
            'order_data'
        );
        $this->dropTable('order_data');


        $this->dropForeignKey(
            'fk-order-user_id',
            'order'
        );
        $this->dropTable('order');
    }
}
