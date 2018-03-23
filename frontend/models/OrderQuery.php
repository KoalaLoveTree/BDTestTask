<?php


namespace frontend\models;


use yii\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{

    public $type;
    public $tableName;

    public function prepare($builder)
    {
        if ($this->type !== null) {
            $this->andWhere(["$this->tableName.role" => $this->type]);
        }
        return parent::prepare($builder);
    }

}
