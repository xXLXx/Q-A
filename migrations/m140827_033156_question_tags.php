<?php

use yii\db\Schema;
use yii\db\Migration;

class m140827_033156_question_tags extends Migration
{
    public function up()
    {
    	$this->createTable('question_tags', [
    		'id'			=> Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    		'tag_id'		=> Schema::TYPE_INTEGER.' UNSIGNED NOT NULL',
    		'question_id'	=> Schema::TYPE_INTEGER.' UNSIGNED NOT NULL',
    	]);
    }

    public function down()
    {
        $this->dropTable('question_tags');
    }
}
