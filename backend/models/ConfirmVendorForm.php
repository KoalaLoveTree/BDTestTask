<?php


namespace backend\models;


use yii\base\Model;

class ConfirmVendorForm extends Model
{

    /** @var int */
    public $level;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['level', 'required'],
            ['level', 'number'],
        ];
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function confirmVendorLevel(int $id): bool
    {
        $vendor = Vendor::findOne(['id' => $id]);
        if ($vendor===null){
            return false;
        }
        $vendor->level = $this->level;
        $vendor->status = Vendor::STATUS_APPROVE;
        return (bool)$vendor->update();


    }

}
