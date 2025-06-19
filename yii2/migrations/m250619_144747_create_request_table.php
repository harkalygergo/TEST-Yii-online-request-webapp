<?php

use yii\db\Migration;

class m250619_144747_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('requests', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'work_type' => "ENUM('allapotfelmeres', 'alapozas_elokeszites', 'epitekzes', 'muszaki_ellenorzes') NOT NULL",
            'work_details' => $this->text()->notNull(),
            'ip_address' => $this->string(45),
            'user_agent' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('requests');
    }
}
