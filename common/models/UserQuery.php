<?php


namespace common\models;


use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{

    public $role;
    public $tableName;

    public function prepare($builder)
    {
        if ($this->role !== null) {
            $this->andWhere(["$this->tableName.role" => $this->role]);
        }
        return parent::prepare($builder);
    }


}
