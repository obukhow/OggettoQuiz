<?php

class m130213_085721_add_user_answers_table extends CDbMigration
{
    public function safeUp()
	{
		$this->createTable('user_answers', array(
			'answer_id'    => 'pk',
            'user_id'      => 'INT NOT NULL',
            'question_id'  => 'INT NOT NULL',
            'result_id'    => 'INT NOT NULL',
            'theme_id'     => 'INT NOT NULL',
            'is_correct'   => 'INT(1) NOT NULL DEFAULT 0',
        ));
        $this->createIndex('USER_ID', 'user_answers', 'user_id');
        $this->createIndex('THEME_ID', 'user_answers', 'theme_id');
        $this->createIndex('RESULT_ID', 'user_answers', 'result_id');
        $this->addForeignKey('USERANSWERS_USER_ID_USER_USER_ID',
        	'user_answers', 'user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('USERANSWERS_RESULT_ID_RESULT_RESULT_ID',
            'user_answers', 'result_id', 'quiz_results', 'result_id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('user_answers');
	}
}