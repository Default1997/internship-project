<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat".
 *
 * @property int $id
 * @property int|null $mustache
 * @property string|null $gender
 * @property int|null $feet
 * @property string|null $tail
 */
class Cat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mustache', 'feet'], 'integer'],
            [['gender', 'tail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mustache' => 'Mustache',
            'gender' => 'Gender',
            'feet' => 'Feet',
            'tail' => 'Tail',
        ];
    }
    public function findCatById($id)
    {
        return Cat::findOne(['id' => $id]);
    }

    public function create($cat)
    {
        $data = rand(0,1);
        $cat->gender = ($data == 0) ? 'male' : 'female';

        $data = rand(0,1);
        $cat->mustache = ($data == 0) ? 'true' : 'false';
        
        $cat->feet = 4;
        $cat->tail = 1;
        // $cat->save();

        return $cat;
    }

    public function updateCat($cat, $gender, $mustache, $feet, $tail)
    {   
        $cat->findCatById($id);

        $cat->gender = $gender;
        $cat->mustache = $mustache;
        $cat->feet = $feet;
        $cat->tail = $tail;
        $cat->save();

        return $cat;
    }

    public function deleteCat($id)
    {
        Cat::delete(['id' => $id]);
        return 'success, cat '.$id.' killed';
    }

    public function Castrate($id)
    {
        $cat->findCatById($id);
        if ($cat->gender == 'male') {
            $cat->gender = 'castrated';
            $cat->save();

            return $cat;
        }else{
            return 'Это не кот, а кошка! Либо уже кастрирован(';
        }
    }

}
