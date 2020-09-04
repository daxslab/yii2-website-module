<?php

namespace daxslab\website\migrations;

/**
 * Handles adding columns to table `{{%page_type}}`.
 */
class m200815_224355_add_allow_subpages_column_to_page_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%page_type}}', 'allow_subpages', $this->boolean()->notNull()->defaultValue(1)->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%page_type}}', 'allow_subpages');
    }
}
