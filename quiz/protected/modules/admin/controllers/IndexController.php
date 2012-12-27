<?php

/**
 * Index controller
 *
 * @author     Dmitry Kovalev <kovalev.dmitry@oggettoweb.com>
 * @version    0.1
 * @package    intellitalent
 * @subpackage controllers
 */
class IndexController extends Controller
{
    public $layout = 'column1';
    protected $_type = 'User';

    /**
     * Set filters
     *
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function init()
    {
        Yii::app()->bootstrap->register();
    }

    /**
     * Set access rules
     *
     * @return array
     */
    // public function accessRules()
    // {
    //     return array(
    //         array('allow',
    //             'actions' => array('index'),
    //             'roles' => array('administrator'),
    //         ),
    //         array('allow',
    //             'actions' => array('login', 'error', 'logout'),
    //             'users' => array('*'),
    //         ),
    //         array('deny',
    //             'users' => array('*'),
    //         ),
    //     );
    // }

    /**
     * Index action
     *
     * @throws Exception
     * @return void
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * Login page
     *
     * @throws Exception
     * @return void
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest) {
            $model = new LoginForm;
            $loginFormData = Yii::app()->getRequest()->getPost('LoginForm');

            if(isset($loginFormData)) {
                $model->attributes = $loginFormData;
                $model->type = $this->_type;
                if ($model->validate() && $model->login()) {
                    $this->redirect(array('index'));
                }
            }
            $this->render('login', array('model' => $model));
        } else {
            $this->redirect(array('index'));
        }
    }

    /**
     * Logout action
     *
     * @return void
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('login'));
    }

   /**
    * This is the action to handle external exceptions.
    */
    public function actionError()
    {
        if($error = Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->renderPartial('error', $error);
            }
        }
    }
}