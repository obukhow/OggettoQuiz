<?php

class m130129_063508_add_themes_column_to_result_table extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('quiz_results', 'themes', 'TEXT');
	}

	public function safeDown()
	{
        $this->dropColumn('quiz_results', 'themes');
	}
}