<?php

class m130212_084043_test_several_attempts extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('quiz_sections', 'several_attempts', 'INT(1) DEFAULT 0');
	}

	public function safeDown()
	{
		$this->dropColumn('quiz_sections', 'several_attempts');
	}
}