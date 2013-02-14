<?php

/**
 * This is the model class for table "user_answers".
 *
 * The followings are the available columns in table 'user_answers':
 * @property integer $answer_id
 * @property integer $user_id
 * @property integer $question_id
 * @property integer $theme_id
 * @property integer $is_correct
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserAnswers extends CActiveRecord
{
    public $percent;
    public $theme;

    const SUCCESS_THEME_RESULT = 75;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserAnswers the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_answers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, question_id, theme_id', 'required'),
            array('user_id, question_id, theme_id, is_correct, result_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('answer_id, user_id, question_id, theme_id, is_correct, result_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'result' => array(self::BELONGS_TO, 'Result', 'result_id'),
            'theme' => array(self::BELONGS_TO, 'Theme', 'theme_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'answer_id' => 'Answer',
            'user_id' => 'User',
            'result_id' => 'Result',
            'question_id' => 'Question',
            'theme_id' => 'Theme',
            'is_correct' => 'Is Correct',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('answer_id', $this->answer_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('theme_id', $this->theme_id);
        $criteria->compare('is_correct', $this->is_correct);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Get result good answers statistic
     *
     * @param int $resultId result id
     *
     * @return mixed
     */
    public function getGoodThemesResult($resultId)
    {
        $criteria = $this->_getThemeStatisticSelect($resultId);
        $criteria->having = 'percent >= ' . self::SUCCESS_THEME_RESULT;
        return $this->findAll($criteria);
    }

    /**
     * Get result bad answers statistic
     *
     * @param int $resultId result id
     *
     * @return mixed
     */
    public function getBadThemesResult($resultId)
    {
        $criteria = $this->_getThemeStatisticSelect($resultId);
        $criteria->having = 'percent < ' . self::SUCCESS_THEME_RESULT;
        return $this->findAll($criteria);
    }

    /**
     * Get theme statistic select
     *
     * @param int $resultId result id
     *
     * @return CDbCriteria
     */
    protected function _getThemeStatisticSelect($resultId)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('theme');
        $criteria->compare('result_id', $resultId);
        $criteria->select= 'SUM(t.is_correct)/COUNT(t.theme_id)*100 as percent, theme.theme as theme';
        $criteria->group = 't.theme_id';
        $criteria->order = 'percent DESC';
        return $criteria;
    }

    /**
     * Save result user answers
     *
     * @param Result $result result
     *
     * @return void
     */
    public function saveResultAnswers(Result $result)
    {
        if (!$result->getResult()) {
            return;
        }
        $answers = $result->getResult();
        foreach ($result->getSection()->getRelated('questions') as $question) {
            $questionId = $question->question_id;
            if (!$question->hasRightAnswer()) {
                continue;
            }
            if (!$question->theme) {
                continue;
            }
            $theme = Theme::model()->getSectionThemeByName($result->section_id, $question->theme);
            if (!$theme) {
                return;
            }
            $answer = new self;
            $answer->user_id = $result->user_id;
            $answer->result_id = $result->result_id;
            $answer->question_id = $questionId;
            $answer->theme_id = $theme->theme_id;
            $answer->is_correct = (int) (isset($answers[$questionId]) && $question->isValidResult($answers[$questionId]));
            $answer->save();
        }
    }
}