<?php

class m130213_132639_update_themes_and_results extends CDbMigration
{
	public function safeUp()
	{
		$questions = Question::model()->findAll();
		foreach ($questions as $question) {
			$question->save();
		}
		$results = Result::model()->findAll();
		foreach ($results as $result) {
			UserAnswers::model()->saveResultAnswers($result);
		}
	}

	public function down()
	{
		echo "m130213_132639_update_themes_and_results does not support migration down.\n";
		return false;
	}
}