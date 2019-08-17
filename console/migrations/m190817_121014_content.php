<?php

use yii\db\Migration;

/**
 * Class m190817_121014_content
 */
class m190817_121014_content extends Migration
{
    /**
     * {@inheritdoc}
     */

    /*
    public function safeUp()
    {

    }
    */

    /**
     * {@inheritdoc}
     */
    /*
    public function safeDown()
    {
        echo "m190817_121014_content cannot be reverted.\n";

        return false;
    }
    */


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('content', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'view' => $this->integer()->defaultValue(0),
            'content_image_id' => $this->integer()
        ]);


        $this->addForeignKey('fk-content-content_image_id',
            'content',  'content_image_id',
            'content_image', 'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-content-content_image_id',
            'content'
        );

        $this->dropTable('content');

        return true;
    }
}
