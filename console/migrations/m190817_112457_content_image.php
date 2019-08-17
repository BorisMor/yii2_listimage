<?php

use yii\db\Migration;

/**
 * Class m190817_112457_content_image
 */
class m190817_112457_content_image extends Migration
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

    }

    */

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('content_image', [
            'id' => $this->primaryKey() ,
            'base_name' => $this->string()->notNull(),
            'extension' => $this->string(),
            'size' => $this->integer(),
            'type' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('content_image');
        return true;
    }

}
