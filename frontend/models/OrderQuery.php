<?php


namespace frontend\models;


use yii\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{

    /** @var string */
    public $type;
    /** @var string */
    public $tableName;

    /**
     * @param $builder
     * @return $this|\yii\db\Query
     */
    public function prepare($builder)
    {
        if ($this->type !== null) {
            $this->andWhere(["$this->tableName.role" => $this->type]);
        }
        return parent::prepare($builder);
    }

}
