<?php

class m121225_100109_create_question_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('quiz_questions', array(
			'question_id'    => 'pk',
            'section_id'     => 'INT NOT NULL',
            'title'          => 'string NOT NULL',
            'theme'          => 'VARCHAR(500)',
            'type' => 'INT(1) UNSIGNED NOT NULL DEFAULT "0"'
        ));
        $this->createIndex('SECTION', 'quiz_questions', 'section_id');
        $this->addForeignKey('QUESTIONS_SECTION_ID_SECTION_SECTION_ID',
        	'quiz_questions', 'section_id', 'quiz_sections', 'section_id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('quiz_questions');
	}
}