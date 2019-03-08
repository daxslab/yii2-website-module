<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `website`.
 */
class m190103_202248_create_website_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('website', [
            'id' => $this->primaryKey(),
            'token' => $this->string()->notNull()->unique(),
            'url' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('website');
    }
}
