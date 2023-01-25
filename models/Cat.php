<?php

namespace app\models;

use Yii;
use yii\web\BadRequestHttpException;

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
    /**
    * @OA\Get(
    *       path="/api/v1/createcat",
    *       description = "Создать случайного кота",
    *    @OA\Response(
    *         response="200",
    *         description="При успешном выполнении запроса будет возвращен объект созданного кота",
    *         @OA\JsonContent(
    *             @OA\Examples(example="result", value={"gender":"male","mustache":"0","feet":"3","tail":"4","id":16}, summary="An result object."),      
    *         )
    *    )
    * )
    */
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
    *  @OA\Parameter(
    *       name="id",
    *       in="query",
    *       description="id кота",
    *       required=true,
    * 
    *       @OA\Property(
    *           property="id",
    *           type="integer",
    *           example="14"
    *          )
    *  ),
    * 
    *  @OA\Parameter(
    *       name="gender",
    *       in="query",
    *       description="Пол кота",
    *       required=true,
    * 
    *       @OA\Property(
    *           property="gender",
    *           type="string",
    *           example="male"
    *      ),
    *  ),
    *  @OA\Parameter(
    *       name="mustache",
    *       in="query",
    *       description="Усы кота",
    *       required=true,
    * 
    *       @OA\Property(
    *           property="mustache",
    *           type="boolean",
    *           example="0"
    *      ),
    *  ),
    *  @OA\Parameter(
    *       name="feet",
    *       in="query",
    *       description="Количество ног",
    *       required=true,
    * 
    *       @OA\Property(
    *           property="feet",
    *           type="integer",
    *           example="4"
    *      ),
    *  ),
    *  @OA\Parameter(
    *       name="tail",
    *       in="query",
    *       description="Описание хвоста",
    *       required=true,
    * 
    *       @OA\Property(
    *           property="tail",
    *           type="string",
    *           example="Пушистый"
    *      ),
    *  ),
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
    /**
    * @OA\Get(
    *       path="/api/v1/deletecat",
    *       description = "Удалить кота по id",
    *  @OA\Parameter(
    *       name="id",
    *       in="query",
    *       description="id кота",
    *       required=true,
    * 
    *       @OA\Property(
    *           property="id",
    *           type="integer",
    *           example="14"
    *          )
    *  ),
    *
    *    @OA\Response(
    *         response="200",
    *         description="При успешном выполнении запроса кот будет удален"
    *    )
    * )
    */
    public function deleteCat($cat, $id)
    {
        $this->findCatById($id)->delete();
    }
    /**
    * @OA\Get(
    *       path="/api/v1/castratecat",
    *       description = "Кастрировать кота по id",
    *  @OA\Parameter(
    *       name="id",
    *       in="query",
    *       description="id кота",
    *       required=true,
    * 
    *       @OA\Property(
    *           property="id",
    *           type="integer",
    *           example="14"
    *          )
    *  ),
    *
    *    @OA\Response(
    *         response="200",
    *         description="При успешном выполнении запроса кот будет кастрирован и пол изменится на castrated и вернется объект кота",
    *         @OA\JsonContent(
    *             @OA\Examples(example="result", value={"gender":"male","castrated":"0","feet":"3","tail":"4","id":16}, summary="An result object."),      
    *         )
    *    ),
    *    @OA\Response(
    *         response="400",
    *         description="Проверьте пол кота. Это не кот а кошка! Либо уже кастрирован("
    *    )
    * )
    */
    public function Castrate($cat, $id)
    {
        $cat = $cat->findCatById($id);

        // print_r($cat);die;
        if ($cat->gender == 'male') {
            $cat->gender = 'castrated';
            $cat->save();

            return $cat;
        }else{
            throw new BadRequestHttpException('Это не кот а кошка! Либо уже кастрирован(');
        }
    }
}