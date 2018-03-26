<?php


namespace common\models;


use yii\db\ActiveQuery;
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

    /**
     * @return array|ActiveRecord[]
     */
    public static function findAllSpheres():array
    {
        return static::find()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor():ActiveQuery
    {
        return $this->hasMany(Vendor::className(), ['sphere_id' => 'id']);
    }

}
