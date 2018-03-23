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
        ];
    }

    public function confirmVendorLevel(int $id)
    {
        return Vendor::confirmVendor($id, $this->level);
    }

}
