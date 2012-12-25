<?php

class m121225_095142_create_sections_table extends CDbMigration
{

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('quiz_sections', array(
            'section_id' => 'pk',
            'title'      => 'string NOT NULL',
        ));
	}

	public function safeDown()
	{
		$this->dropTable('quiz_sections');
	}
	
}