<?php

class m130207_143118_add_test_time_limit extends CDbMigration
{

	public function safeUp()
	{
        $this->addColumn('quiz_sections', 'time_limit', 'INT DEFAULT 0');
	}

	public function safeDown()
	{
		$this->dropColumn('quiz_sections', 'time_limit');
	}
}