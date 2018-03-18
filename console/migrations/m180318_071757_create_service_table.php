<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m180318_071757_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('service', [
            'id' => $this->primaryKey()->unsigned(),
            'vendor_id' => $this->integer()->unsigned(),
            'title' => $this->string(127),
            'description' => $this->text(),
            'price' => $this->string(127),
            'status' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('service');
    }
}
