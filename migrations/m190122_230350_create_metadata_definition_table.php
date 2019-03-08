<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `metadata_definition`.
 * Has foreign keys to the tables:
 *
 * - `page_type`
 */
class m190122_230350_create_metadata_definition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('metadata_definition', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'params' => $this->text()->null()->defaultValue(null),
            'page_type_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-metadata_definition-unique',
            'metadata_definition',
            ['page_type_id', 'name'],
            true
        );

        // creates index for column `page_type_id`
        $this->createIndex(
            'idx-metadata_definition-page_type_id',
            'metadata_definition',
            'page_type_id'
        );

        // add foreign key for table `page_type`
        $this->addForeignKey(
            'fk-metadata_definition-page_type_id',
            'metadata_definition',
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
        // drops foreign key for table `page_type`
        $this->dropForeignKey(
            'fk-metadata_definition-page_type_id',
            'metadata_definition'
        );

        // drops index for column `page_type_id`
        $this->dropIndex(
            'idx-metadata_definition-page_type_id',
            'metadata_definition'
        );

        $this->dropTable('metadata_definition');
    }
}
