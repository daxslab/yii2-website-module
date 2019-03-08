<?php

namespace daxslab\website\migrations;

/**
 * Handles the creation of table `menu_item`.
 * Has foreign keys to the tables:
 *
 * - `menu`
 */
class m190105_014226_create_menu_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu_item', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'position' => $this->integer()->notNull()->defaultValue(1),
        ]);

        // creates index for column `menu_id`
        $this->createIndex(
            'idx-menu_item-menu_id',
            'menu_item',
            'menu_id'
        );

        // add foreign key for table `menu`
        $this->addForeignKey(
            'fk-menu_item-menu_id',
            'menu_item',
            'menu_id',
            'menu',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `menu`
        $this->dropForeignKey(
            'fk-menu_item-menu_id',
            'menu_item'
        );

        // drops index for column `menu_id`
        $this->dropIndex(
            'idx-menu_item-menu_id',
            'menu_item'
        );

        $this->dropTable('menu_item');
    }
}
