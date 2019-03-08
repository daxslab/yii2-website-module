<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `menu`.
 * Has foreign keys to the tables:
 *
 * - `website`
 */
class m190105_014225_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'website_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-menu-website_id-name',
            'menu',
            ['website_id', 'name'],
            true
        );

        // creates index for column `website_id`
        $this->createIndex(
            'idx-menu-website_id',
            'menu',
            'website_id'
        );

        // add foreign key for table `website`
        $this->addForeignKey(
            'fk-menu-website_id',
            'menu',
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
            'fk-menu-website_id',
            'menu'
        );

        // drops index for column `website_id`
        $this->dropIndex(
            'idx-menu-website_id',
            'menu'
        );

        $this->dropTable('menu');
    }
}
