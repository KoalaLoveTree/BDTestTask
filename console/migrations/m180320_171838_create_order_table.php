<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180320_171838_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey()->unsigned(),
            'vendor_id' => $this->integer()->unsigned(),
            'client_id' => $this->integer()->unsigned(),
            'type' => $this->string(127),
            'service_id' => $this->integer()->unsigned(),
            'status' => $this->integer()->unsigned(),
            'price' => $this->string(127),
            'date'=> $this->string(127),
            'time_start' => $this->string(127),
            'time_end' => $this->string(127),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }
}
