<?php

namespace daxslab\website\migrations;

/**
 * Handles adding columns to table `{{%metadata_definition}}`.
 */
class m200815_005933_add_label_column_to_metadata_definition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%metadata_definition}}', 'label', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%metadata_definition}}', 'label');
    }
}
