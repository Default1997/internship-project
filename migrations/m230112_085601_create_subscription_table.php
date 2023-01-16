<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m230112_085601_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'code' => $this->string(50)->notNull()->unique(),
            'requests_count' => $this->integer(50)->notNull(),
            'price' => $this->integer(50)->notNull(),
        ]);

        $this->createIndex(
            'idx-subscription-code',
            'subscription',
            'code'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscription}}');
    }
}
