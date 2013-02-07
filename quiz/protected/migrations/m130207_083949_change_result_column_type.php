<?php

class m130207_083949_change_result_column_type extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn('quiz_results', 'results', 'TEXT');
	}

	public function down()
	{
		echo "m130207_083949_change_result_column_type does not support migration down.\n";
		return false;
	}
}