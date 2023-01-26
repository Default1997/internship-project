<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quota_utilization".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $date
 * @property string $request_method
 * @property string $api_method
 * @property string|null $params
 */
class QuotaUtilization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quota_utilization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'request_method', 'api_method'], 'required'],
            [['user_id'], 'integer'],
            [['date', 'params'], 'safe'],
            [['request_method'], 'string', 'max' => 10],
            [['api_method'], 'string', 'max' => 255],
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
            'date' => 'Date',
            'request_method' => 'Request Method',
            'api_method' => 'Api Method',
            'params' => 'Params',
        ];
    }
}
