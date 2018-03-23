<?php


namespace common\models;


use yii\db\ActiveRecord;

/**
 * Service model
 *
 * @property integer $id
 * @property string $title
 */
class Sphere extends ActiveRecord
{

    public static function tableName()
    {
        return 'sphere';
    }

    public static function findAllSpheresId()
    {
        return static::find()->all();
    }

    public function findSphereByTitle(string $title)
    {
        return static::findOne(['title' => $title]);
    }

    public static function findAllSpheres()
    {
        return static::find()->all();
    }

    public function getVendor()
    {
        return $this->hasMany(Vendor::className(), ['sphere_id' => 'id']);
    }

}
