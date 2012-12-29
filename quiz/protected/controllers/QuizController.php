<?php

class QuizController extends Controller
{
	public function actionPostQuestion()
	{
		$this->render('postQuestion');
	}

	public function actionResult()
	{
		$this->render('result');
	}

	/**
	 * Show question action
	 *
	 * @param string $section  section name
	 * @param int    $question question number
	 *
	 * @return [type]           [description]
	 */
	public function actionShowQuestion($section, $question)
	{
		$section = $this->_initSection($section);
		
		$this->render('showQuestion');
	}

	public function actionIndex($section)
	{
		$section = $this->_initSection($section);
		$questionCount = count($section->questions);
		var_dump($questionCount);
		$this->render('index');

	}

	/**
	 * Init current section model
	 *
	 * @param string $sectionName section name
	 *
	 * @return Section
	 */
	protected function _initSection($sectionName)
	{
		$section = Section::model()->findByAttributes(array('title' => $sectionName));
		if ($section == null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $section;

	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}