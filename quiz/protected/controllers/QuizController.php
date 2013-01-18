<?php

class QuizController extends Controller
{
    /**
     * Include js files
     *
     * @return void
     */
    public function init()
    {
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::app()->getClientScript()->registerScriptFile('/js/oggettoquiz.js');
        Yii::app()->getClientScript()->registerScriptFile('/js/history.adapter.jquery.js');

    }
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
    public function actionQuestion($section, $id)
    {
        $section = $this->_initSection($section);
        $question = $this->_initQuestion($section, $id);
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $result = array(
                'html'  => $this->renderPartial('question', array('question' => $question), true),
                'title' => sprintf('Question %s', $id),
            );
            header("Content-type: application/json");
            echo CJSON::encode($result);
            Yii::app()->end();
        }
        
        $this->render('index', array('section' => $section, 'question' => $question, 'number' => $id));
    }

    /**
     * index action
     *
     * @param string $section section
     *
     * @return void
     */
    public function actionIndex($section)
    {
        $section = $this->_initSection($section);
        $this->render('index', array('section' => $section, 'question' => null, 'number' => 0));

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

    /**
     * init question
     *
     * @param  [type] $section [description]
     * @param  [type] $id      [description]
     *
     * @return [type]          [description]
     */
    protected function _initQuestion($section, $id)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.section_id = :section_id');
        $criteria->limit = 1;
        $criteria->offset = ($id <= 0) ? 1 : $id - 1;
        $criteria->params= array(':section_id' => $section->section_id);
        $question = Question::model()->find($criteria);
        return $question;
    }
}