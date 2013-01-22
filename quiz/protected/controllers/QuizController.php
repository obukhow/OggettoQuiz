<?php

class QuizController extends Controller
{
     /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

     /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index', 'PostQuestion', 'Result', 'Ajaxquestion', 'question'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Include js files
     *
     * @return void
     */
    public function init()
    {
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getRequest()->getBaseUrl() . '/js/oggettoquiz.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getRequest()->getBaseUrl() . '/js/history.adapter.jquery.js');
        $markdown = new CMarkdown;
        $markdown->registerClientScript();

    }
    public function actionPostQuestion()
    {
        $question = Yii::app()->getRequest()->getPost('question');
        $session = Yii::app()->session;
        var_dump($question);
        if (!$question && !is_array($question)) {
            return;
        }
        foreach ($question as $sectionId => $_answer) {
            $question = $session->get('question', array());
            if (!isset($question[$sectionId])) {
                $question[$sectionId] = array();
            }
            $question = array_merge_recursive($question, $_answer);
            $session->add('question', $question);
        }

        var_dump($session->get('question'));
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
    public function actionAjaxquestion($section, $id)
    {
        return $this->actionQuestion($section, $id);
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
        $section = Section::model()->findByAttributes(array('url' => $sectionName));
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