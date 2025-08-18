<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal}}`.
 */
class m250818_180642_create_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'sum' => $this->decimal(8, 2),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal}}');
    }
}
