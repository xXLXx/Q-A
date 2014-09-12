<?php

use yii\db\Schema;
use yii\db\Migration;

class m140912_020111_user_votes extends Migration
{
    public function up()
    {
        $this->createTable('user_votes', [
            'id'            => Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'user_id'       => Schema::TYPE_INTEGER.' UNSIGNED NOT NULL',
            'vote_for'      => Schema::TYPE_SMALLINT.' UNSIGNED NOT NULL',
            'for_id'        => Schema::TYPE_INTEGER.' UNSIGNED NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('user_votes');
    }
}
