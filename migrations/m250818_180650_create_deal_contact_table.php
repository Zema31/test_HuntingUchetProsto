<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal_contact}}`.
 */
class m250818_180650_create_deal_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal_contact}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer()->notNull(),
            'contact_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(deal_id, contact_id)',
        ]);

        $this->createIndex(
            'idx-deal_contact-deal_id',
            'deal_contact',
            'deal_id'
        );

        $this->addForeignKey(
            'fk-deal_contact-deal_id',
            'deal_contact',
            'deal_id',
            'deal',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-deal_contact-contact_id',
            'deal_contact',
            'contact_id'
        );

        $this->addForeignKey(
            'fk-deal_contact-contact_id',
            'deal_contact',
            'contact_id',
            'contact',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal_contact}}');
    }
}
