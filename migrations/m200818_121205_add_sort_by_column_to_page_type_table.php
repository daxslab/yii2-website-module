<?php

namespace daxslab\website\migrations;

/**
 * Handles adding columns to table `{{%page_type}}`.
 */
class m200818_121205_add_sort_by_column_to_page_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%page_type}}', 'sort_by', $this->string()->notNull()->defaultValue('created_at DESC'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%page_type}}', 'sort_by');
    }
}
