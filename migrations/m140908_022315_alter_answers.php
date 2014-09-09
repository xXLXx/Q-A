<?php

use yii\db\Schema;
use yii\db\Migration;

class m140908_022315_alter_answers extends Migration
{
    public function up()
    {
    	$tableName = 'answers';
    	$this->alterColumn($tableName, 'name', 'smallint UNSIGNED NOT NULL');
    	$this->renameColumn($tableName, 'name', 'user_group');
    	$this->alterColumn($tableName, 'email', 'integer UNSIGNED NOT NULL');
    	$this->renameColumn($tableName, 'email', 'user_id');
    }

    public function down()
    {
        echo "m140908_022315_alter_answers cannot be reverted.\n";

        return false;
    }
}
