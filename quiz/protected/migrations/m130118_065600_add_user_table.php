<?php

class m130118_065600_add_user_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('users', array(
            'user_id' => 'pk',
            'name'      => 'string NOT NULL',
            'email' => 'string UNIQUE',
            'photo_url' => 'string',
            'role'   => 'int(1)',
            'password' => 'string', 
            'is_oggetto' => 'int(1)',
            'facebook_id' => 'string',
            'github_id' => 'string',
            'google_id' => 'string',
            'linkedin_id' => 'string',
            'twitter_id' => 'string',
            'vk_id' => 'string',
            'yandex_id' => 'string',
        ));
	}

	public function safeDown()
	{
		$this->dropTable('users');
	}
}