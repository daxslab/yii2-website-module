<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `media`.
 * Has foreign keys to the tables:
 *
 * - `website`
 */
class m190105_054132_create_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('media', [
            'id' => $this->primaryKey(),
            'filename' => $this->string()->notNull(),
            'mime_type' => $this->string()->notNull(),
            'website_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `website_id`
        $this->createIndex(
            'idx-media-website_id',
            'media',
            'website_id'
        );

        // add foreign key for table `website`
        $this->addForeignKey(
            'fk-media-website_id',
            'media',
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
            'fk-media-website_id',
            'media'
        );

        // drops index for column `website_id`
        $this->dropIndex(
            'idx-media-website_id',
            'media'
        );

        $this->dropTable('media');
    }
}
