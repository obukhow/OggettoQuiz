<?php

class m130117_133321_add_question_text extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('quiz_questions', 'text', 'TEXT');
	}

	public function safeDown()
	{
		$this->dropColumn('quiz_questions', 'text');
	}
}