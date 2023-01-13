<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $requests_count
 * @property int $price
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'requests_count', 'price'], 'required'],
            [['requests_count', 'price'], 'integer'],
            [['name', 'code'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'requests_count' => 'Requests Count',
            'price' => 'Price',
        ];
    }
}
