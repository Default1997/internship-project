<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quota_utilization}}`.
 */
class m230116_062643_create_quota_utilization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quota_utilization}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(50)->notNull(),
            'date' => $this->timestamp(),
            'request_method' => $this->string(10)->notNull(),
            'api_method' => $this->string()->notNull(),
            'params' => $this->json(),
        ]);

        $this->createIndex(
            'idx-quota_utilization-user_id',
            'quota_utilization',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quota_utilization}}');
    }
}
