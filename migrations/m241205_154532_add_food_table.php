<?php

use yii\db\Migration;

/**
 * Class m241205_154532_add_food_table
 */
class m241205_154532_add_food_table extends Migration
{
    public function up(): void
    {
        $this->createTable('food', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string()->notNull()->defaultValue('Empty Food Title'),
            'description' => $this->text()->null(),
            'thumbnail'   => $this->string()->notNull()->defaultValue('/img/no_image.jpg'),
        ]);
    }

    public function down(): void
    {
        $this->dropTable('food');
    }
}
