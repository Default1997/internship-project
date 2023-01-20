<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cat}}`.
 */
class m230120_123804_create_cat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cat}}', [
            'id' => $this->primaryKey(),
            'mustache' => $this->boolean(),
            'gender' => $this->string(),
            'feet' => $this->integer(),
            'tail' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cat}}');
    }
}
