<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `metadata`.
 * Has foreign keys to the tables:
 *
 * - `page`
 * - `metadata_definition`
 */
class m190123_131635_create_metadata_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('metadata', [
            'id' => $this->primaryKey(),
            'value' => $this->text()->null(),
            'page_id' => $this->integer()->notNull(),
            'metadata_definition_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `page_id`
        $this->createIndex(
            'idx-metadata-page_id',
            'metadata',
            'page_id'
        );

        // add foreign key for table `page`
        $this->addForeignKey(
            'fk-metadata-page_id',
            'metadata',
            'page_id',
            'page',
            'id',
            'CASCADE'
        );

        // creates index for column `metadata_definition_id`
        $this->createIndex(
            'idx-metadata-metadata_definition_id',
            'metadata',
            'metadata_definition_id'
        );

        // add foreign key for table `metadata_definition`
        $this->addForeignKey(
            'fk-metadata-metadata_definition_id',
            'metadata',
            'metadata_definition_id',
            'metadata_definition',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `page`
        $this->dropForeignKey(
            'fk-metadata-page_id',
            'metadata'
        );

        // drops index for column `page_id`
        $this->dropIndex(
            'idx-metadata-page_id',
            'metadata'
        );

        // drops foreign key for table `metadata_definition`
        $this->dropForeignKey(
            'fk-metadata-metadata_definition_id',
            'metadata'
        );

        // drops index for column `metadata_definition_id`
        $this->dropIndex(
            'idx-metadata-metadata_definition_id',
            'metadata'
        );

        $this->dropTable('metadata');
    }
}
