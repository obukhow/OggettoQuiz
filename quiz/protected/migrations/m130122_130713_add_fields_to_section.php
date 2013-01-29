<?php

class m130122_130713_add_fields_to_section extends CDbMigration
{
	public function safeUp()
	{
            $this->addColumn('quiz_sections', 'description', 'TEXT');
            $this->addColumn('quiz_sections', 'url', 'string');
	}

	public function safeDown()
	{
            $this->dropColumn(' quiz_sections', 'description');
            $this->dropColumn('quiz_sections', 'url', 'string');
	}
}