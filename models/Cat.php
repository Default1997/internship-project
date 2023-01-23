<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "cat".
 *
 * @property int $id
 * @property int|null $mustache
 * @property string|null $gender
 * @property int|null $feet
 * @property string|null $tail
 */

 /**
 * @OA\Info(
 *     title="Cat model meow meow meow ",
 *     version="0.3"
 * ),
 *  * @OA\OpenApi(
 *   security={{"bearerAuth": {}}}
 * ),
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer"
 * )
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
        $cat->mustache = ($data == 0) ? 0 : 1;
        
        $cat->feet = 4;
        $cat->tail = 'пушистый хвостик';
        $cat->save();

        return $cat;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/updatecat",
    *       description = "Обновить данные существующего кота",
    *   @OA\Parameter(
    *         name="id",
    *         in="query",
    *         description="id кота которого нужно изменить",
    *         required=true,
    *      
    *          @OA\Schema(
    *              schema="integer",
    *              @OA\Property(property="id", type="integer")
    *          )
    *      ),
    * 
    *  *   @OA\Parameter(
    *         name="gender",
    *         in="query",
    *         description="пол кота",
    *         required=true,
    *      
    *          @OA\Schema(
    *              schema="string",
    *              @OA\Property(property="gender", type="string")
    *          )
    *      ),
    * 
    *  *   @OA\Parameter(
    *         name="mustache",
    *         in="query",
    *         description="есть ли у кота усы 0 или 1",
    *         required=true,
    *      
    *          @OA\Schema(
    *              schema="integer",
    *              @OA\Property(property="mustache", type="integer")
    *          )
    *      ),
    * 
    *  *   @OA\Parameter(
    *         name="feet",
    *         in="query",
    *         description="количество ног",
    *         required=true,
    *      
    *          @OA\Schema(
    *              schema="integer",
    *              @OA\Property(property="feet", type="integer")
    *          )
    *      ),
    * 
    *  *   @OA\Parameter(
    *         name="tail",
    *         in="query",
    *         description="описание хвоста кота",
    *         required=true,
    *      
    *          @OA\Schema(
    *              schema="string",
    *              @OA\Property(property="tail", type="string")
    *          )
    *      ),
    * 
    *
    *    @OA\Response(
    *         response="200",
    *         description="При успешном выполнении запроса будут внесены ихменения в модель",
    *         @OA\JsonContent(
    *             @OA\Examples(example="result", value={"gender":"male","mustache":"0","feet":"3","tail":"4","id":16}, summary="An result object."),      
    *         )
    *    )
    * )
    */
    public function updateCat($cat, $id, $gender, $mustache, $feet, $tail)
    {   
        $cat = $cat->findCatById($id);

        // print_r($cat);die;
        $cat->gender = $gender;
        $cat->mustache = $mustache;
        $cat->feet = $feet;
        $cat->tail = $tail;
        $cat->save();

        return $cat;
    }

    public function deleteCat($cat, $id)
    {
        $this->findCatById($id)->delete();
    }

    public function Castrate($cat, $id)
    {
        $cat->findCatById($id);
        if ($cat->gender == 'male') {
            $cat->gender = 'castrated';
            $cat->save();

            return $cat;
        }else{
            throw new ErrorException('Это не кот, а кошка! Либо уже кастрирован(');
        }
    }

}
