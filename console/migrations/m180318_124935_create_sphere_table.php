<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sphere`.
 */
class m180318_124935_create_sphere_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sphere', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(127),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sphere');
    }
}
