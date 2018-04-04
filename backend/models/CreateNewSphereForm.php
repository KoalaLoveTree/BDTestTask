<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 4/4/18
 * Time: 5:13 PM
 */

namespace backend\models;


use common\models\Sphere;
use yii\base\Model;

class CreateNewSphereForm extends Model
{

    public $title;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 127],
        ];
    }

    public function createSphere()
    {
        $sphere = new Sphere();
        $sphere->title = $this->title;
        return (bool)$sphere->save();
    }

}
