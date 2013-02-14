<?php

class QuizController extends Controller
{
    public $layout='//layouts/quiz/column2';
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
                'actions'=>array('index', 'PostQuestion', 'Result', 'Ajaxquestion', 'question', 'initCountdown', 'success'),
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
        Yii::app()->bootstrap->registerCoreCss();
        Yii::app()->getClientScript()->registerCssFile(Yii::app()->getRequest()->getBaseUrl() . '/css/main.css');
        Yii::app()->getClientScript()->registerCssFile(Yii::app()->getRequest()->getBaseUrl() . '/css/jquery.countdown.timer.css');
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getRequest()->getBaseUrl() . '/js/oggettoquiz.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getRequest()->getBaseUrl() . '/js/history.adapter.jquery.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getRequest()->getBaseUrl() . '/js/jquery.countdown.counter.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getRequest()->getBaseUrl() . '/js/jquery.timeout.interval.idle.js');
        $markdown = new CMarkdown;
        $markdown->registerClientScript();

    }

    /**
     * Post question
     *
     * @return void
     */
    public function actionPostQuestion()
    {
        $question = Yii::app()->getRequest()->getPost('question');
        $session = Yii::app()->session;
        if (!$question && !is_array($question)) {
            return;
        }
        foreach ($question as $sectionId => $_answer) {
            $question = $session->get('question', array());
            if (!isset($question[$sectionId])) {
                $question[$sectionId] = array();
            }
            foreach ($_answer as $__questionId => $__answers) {
                $question[$sectionId][$__questionId] = $__answers;
            }
            $session->add('question', $question);
        }

    }

    /**
     * Process result action
     *
     * @return void
     */
    public function actionSuccess($section)
    {
        $session = Yii::app()->session;
        $section = $this->_initSection($section);
        $question = $session->get('question');
        if (!isset($question[$section->section_id])) {
            return $this->redirect($section->getUrl());
        }
        $question[$section->section_id]['finished'] = true;
        
        $session->add('question', $question);
        
        $result = new Result();
        $result->setSection($section)
            ->setUser(Yii::app()->user->id);

        $result->processResult($question[$section->section_id]);
        
        if ($result->save()) {
            UserAnswers::model()->saveResultAnswers($result);
            $session->remove('question');
            return $this->redirect($section->getUrl() . '/result/' . $result->result_id);
        }
        return redirect($section->getUrl());

    }

    /**
     * Init countdown for section
     *
     * @param string $section section name
     *
     * @return void
     */
    public function actionInitCountdown($section)
    {
        $session = Yii::app()->session;
        $section = $this->_initSection($section);
        $question = $session->get('question');
        if (isset($question[$section->section_id]) && isset($question[$section->section_id]['start'])) {
            return;
        }
        $question[$section->section_id]['start'] = time();
        $session->add('question', $question);
    }

    /**
     * Show result action
     *
     * @param string $section  section name
     * @param int    $question question number
     *
     * @return void
     */
    public function actionResult($section, $id)
    {
        $result = Result::model()->findByPk($id);
        $section = $this->_initSection($section);
        $this->render('result', array(
            'result' => $result,
            'section' => $section,
            'goodThemes' => UserAnswers::model()->getGoodThemesResult($id),
            'badThemes'  => UserAnswers::model()->getBadThemesResult($id),
        ));
    }

    /**
     * Show question action
     *
     * @param string $section  section name
     * @param int    $question question number
     *
     * @return void
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

        $this->render('index', array('section' => $section, 'question' => $question, 'limit' => $this->getSectionTimeout($section), 'number' => $id));
    }

    /**
     * Ajax get question redirects to question action
     * 
     * For history js cache prevent
     *
     * @param string $section section name
     * @param int    $id      question id
     *
     * @return void
     */
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
        $this->render('index', array('section' => $section, 'question' => null, 'limit' => $this->getSectionTimeout($section), 'number' => 0));

    }

    /**
     * Get section time limit
     *
     * @param Section $section section
     *
     * @return int
     */
    public function getSectionTimeout($section)
    {
        if (!$section->time_limit) {
            return 'null';
        }
        $session = Yii::app()->session->get('question');
        if ($session && isset($session[$section->section_id]['start'])) {
            return $section->getTimeLimit() - (time() - $session[$section->section_id]['start']);
        }
        return $section->getTimeLimit();
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
        if (!$section->several_attempts && Yii::app()->controller->action->id != 'result') {
            $result = Result::model()->findByAttributes(array('section_id' => $section->section_id, 'user_id' => Yii::app()->user->id));
            if ($result) {
                Yii::app()->user->setFlash('warning', "Вы уже проходили этот тест!");
                return $this->redirect('/');
            }
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
        $criteria->limit  = 1;
        $criteria->offset = ($id <= 0) ? 1 : $id - 1;
        $criteria->params = array(':section_id' => $section->section_id);
        $criteria->order  = 'position, question_id'; 
        $question = Question::model()->find($criteria);
        return $question;
    }
}