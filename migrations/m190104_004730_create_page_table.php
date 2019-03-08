<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `page`.
 * Has foreign keys to the tables:
 *
 * - `website`
 * - `page`
 * - `page_type`
 */
class m190104_004730_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull()->defaultValue(3),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'abstract' => $this->text()->null(),
            'body' => $this->text()->null(),
            'image' => $this->string()->null(),
            'language' => $this->string()->notNull(),
            'position' => $this->integer()->defaultValue(1),
            'website_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->null(),
            'page_type_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `website_id`
        $this->createIndex(
            'idx-page-website_id',
            'page',
            'website_id'
        );

        // add foreign key for table `website`
        $this->addForeignKey(
            'fk-page-website_id',
            'page',
            'website_id',
            'website',
            'id',
            'CASCADE'
        );

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-page-parent_id',
            'page',
            'parent_id'
        );

        // add foreign key for table `page`
        $this->addForeignKey(
            'fk-page-parent_id',
            'page',
            'parent_id',
            'page',
            'id',
            'CASCADE'
        );

        // creates index for column `page_type_id`
        $this->createIndex(
            'idx-page-page_type_id',
            'page',
            'page_type_id'
        );

        // add foreign key for table `page_type`
        $this->addForeignKey(
            'fk-page-page_type_id',
            'page',
            'page_type_id',
            'page_type',
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
            'fk-page-website_id',
            'page'
        );

        // drops index for column `website_id`
        $this->dropIndex(
            'idx-page-website_id',
            'page'
        );

        // drops foreign key for table `page`
        $this->dropForeignKey(
            'fk-page-parent_id',
            'page'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            'idx-page-parent_id',
            'page'
        );

        // drops foreign key for table `page_type`
        $this->dropForeignKey(
            'fk-page-page_type_id',
            'page'
        );

        // drops index for column `page_type_id`
        $this->dropIndex(
            'idx-page-page_type_id',
            'page'
        );

        $this->dropTable('page');
    }
}
