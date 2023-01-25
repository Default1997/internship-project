<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "limitspending".
 *
 * @property int $id
 * @property int $user_id
 * @property int $count
 * @property int $date_update
 */
class Limitspending extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'limitspending';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date_update'], 'required'],
            [['user_id', 'count', 'date_update'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'count' => 'Count',
            'date_update' => 'Date Update',
        ];
    }
}
