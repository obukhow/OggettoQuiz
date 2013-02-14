<?php

class m130212_102903_add_section_themes_table extends CDbMigration
{
    public function safeUp()
	{
		$this->createTable('section_themes', array(
			'theme_id'    => 'pk',
            'section_id'     => 'INT NOT NULL',
            'theme'          => 'VARCHAR(500)',
        ));
        $this->createIndex('SECTION', 'section_themes', 'section_id');
        $this->addForeignKey('THEMES_SECTION_ID_SECTION_SECTION_ID',
        	'section_themes', 'section_id', 'quiz_sections', 'section_id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('section_themes');
	}
}