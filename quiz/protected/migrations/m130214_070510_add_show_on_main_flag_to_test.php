<?php

class m130214_070510_add_show_on_main_flag_to_test extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('quiz_sections', 'show_on_main_page', 'INT(1) DEFAULT 1');
	}

	public function safeDown()
	{
		$this->dropColumn('quiz_sections', 'show_on_main_page');
	}
}