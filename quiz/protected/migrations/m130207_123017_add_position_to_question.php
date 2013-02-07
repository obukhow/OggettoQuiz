<?php

class m130207_123017_add_position_to_question extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('quiz_questions', 'position', 'INT');
        $this->update('quiz_questions', array('position' => new CDbExpression('question_id')));
	}

	public function safeDown()
	{
		$this->dropColumn('quiz_questions', 'position');
	}
}