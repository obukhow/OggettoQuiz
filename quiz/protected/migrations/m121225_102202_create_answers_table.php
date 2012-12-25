<?php

class m121225_102202_create_answers_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('quiz_questions_answers', array(
			'answer_id'      => 'pk',
			'question_id'    => 'INT NOT NULL',
            'title'          => 'string NOT NULL',
            'is_correct'     => 'INT(1) UNSIGNED NOT NULL DEFAULT "0"'
        ));
        $this->createIndex('QUESTION', 'quiz_questions_answers', 'question_id');
        $this->addForeignKey('ANSWERS_QUESTION_ID_QUESTION_QUESTION_ID',
        	'quiz_questions_answers', 'question_id', 'quiz_questions', 'question_id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('quiz_questions_answers');
	}
}