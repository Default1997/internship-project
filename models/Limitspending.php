<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "limitspending".
 *
 * @property int $user_id
 * @property int $count
 * @property string|null $uptaded_at
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
            [['user_id'], 'required'],
            [['user_id', 'count'], 'integer'],
            [['uptaded_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'count' => 'Count',
            'uptaded_at' => 'Uptaded At',
        ];
    }

    public static function primaryKey()
    {
    return [
        'user_id'
    ];
    }
}
