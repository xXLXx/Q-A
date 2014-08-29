<?php

use yii\db\Schema;
use yii\db\Migration;

class m140827_034117_comments extends Migration
{
    public function up()
    {
    	$this->createTable('comments', [
    		'id'			=> Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    		'user_id'		=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'comment'		=> Schema::TYPE_TEXT.' NOT NULL',
    		'comment_for'	=> Schema::TYPE_INTEGER.' NOT NULL UNSIGNED',
    		'for_id'		=> Schema::TYPE_INTEGER.' NOT NULL UNSIGNED',
    		'created_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'updated_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',

    	]);
    }

    public function down()
    {
        $this->dropTable('comments');
    }
}