<?php

class m130122_122254_add_result_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('quiz_results', array(
			'result_id'             => 'pk',
			'section_id'            => 'INT NOT NULL',
			'user_id'               => 'INT NOT NULL',
			'passed_at'             => 'DATETIME',
            'results'               => 'string NOT NULL',
			'total_questions_count' => 'INT NOT NULL',
			'right_answers_count'   => 'INT NOT NULL',
			'wrong_answers_count'   => 'INT NOT NULL',
			'right_percent_amount'  => 'DECIMAL NOT NULL',
        ));
        $this->createIndex('SECTION', 'quiz_results', 'section_id');
        $this->createIndex('USER', 'quiz_results', 'user_id');
        $this->addForeignKey('RESULTS_SECTION_ID_TO_SECTION_ID',
        	'quiz_results', 'section_id', 'quiz_sections', 'section_id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('RESULTS_USER_ID_TO_USER_ID',
        	'quiz_results', 'user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropTable('quiz_results');
		return false;
	}
}