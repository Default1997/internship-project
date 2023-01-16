<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%limitSpending}}`.
 */
class m230112_115822_create_limitSpending_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%limitSpending}}', [
            'user_id' => $this->integer(50)->notNull(),
            'count' => $this->integer(50)->notNull()->defaultValue('0'),
            'updated_at' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-subscription-user_id',
            'subscription',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%limitSpending}}');
    }
}
