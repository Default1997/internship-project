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
            'user_id' => $this->integer()->notNull(),
            'count' => $this->integer(50)->notNull()->defaultValue('0'),
            'date_update' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-limitSpending-user_id',
            'limitSpending',
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
