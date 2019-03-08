<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `page_type`.
 * Has foreign keys to the tables:
 *
 * - `website`
 */
class m190104_004059_create_page_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('page_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'website_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-page_type-website_id-name',
            'page_type',
            ['website_id', 'name'],
            true
        );

        // creates index for column `website_id`
        $this->createIndex(
            'idx-page_type-website_id',
            'page_type',
            'website_id'
        );

        // add foreign key for table `website`
        $this->addForeignKey(
            'fk-page_type-website_id',
            'page_type',
            'website_id',
            'website',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `website`
        $this->dropForeignKey(
            'fk-page_type-website_id',
            'page_type'
        );

        // drops index for column `website_id`
        $this->dropIndex(
            'idx-page_type-website_id',
            'page_type'
        );

        $this->dropTable('page_type');
    }
}
