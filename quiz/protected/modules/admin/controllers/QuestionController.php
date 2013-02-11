<?php

class QuestionController extends AbstractController
{


    /**
     * Displays a particular model.
     * 
     * @param integer $id the ID of the model to be displayed
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return void
     */
    public function actionCreate()
    {
        $model = new Question;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Question'])) {
            $model->attributes = $_POST['Question'];

            $result = $model->save();
            if ($model->save()) {
                if (isset($_POST['answers'])) {
                    $this->_saveAnswers($model, $_POST['answers']);
                }
                Yii::app()->user->setFlash('success', "Question created!");
                if (Yii::app()->getRequest()->getParam('return')) {
                    return $this->redirect(array('create', 'section' => $model->section_id));
                }
                return $this->redirect(array('view','id' => $model->question_id));
            }
        }
        if ($sectionId = Yii::app()->getRequest()->getParam('section')) {
            $model->section_id = $sectionId;
        }
        $this->render('create', array(
            'model' => $model,
            'answers' => Yii::app()->getRequest()->getPost('answers'),
        ));
    }

    protected function _saveAnswers($model, $data)
    {
        foreach ($data as $key => $answer) {
            $isNew = (strpos($key, 'val_') !== false);
            if (!$isNew) {
                $answerModel = QuestionsAnswer::model()->findByPk($key);
            } else {
                $answerModel = new QuestionsAnswer();
            }
            if (isset($answer['deleted']) && $answer['deleted'] == 1) {
                if (!$isNew) {
                    $answerModel->delete();
                }
                continue;
            }
            $answerModel->question_id = $model->question_id;
            $answerModel->title =  $answer['title'];
            $answerModel->is_correct = (isset($answer['is_correct'])) ? $answer['is_correct'] : 0;
            $answerModel->save();

        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Question']))
        {
            $model->attributes=$_POST['Question'];
            if($model->save()) {
                if (isset($_POST['answers'])) {
                    $this->_saveAnswers($model, $_POST['answers']);
                }
                $this->redirect(array('index'));
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model=new Question('search');
        $model->unsetAttributes();
        if(isset($_GET['Question']))
            $model->attributes=$_GET['Question'];
        $this->render('admin',array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Question::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
