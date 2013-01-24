<?php

/**
 * This is the model class for table "quiz_results".
 *
 * The followings are the available columns in table 'quiz_results':
 * @property integer $result_id
 * @property integer $section_id
 * @property integer $user_id
 * @property string $passed_at
 * @property string $results
 * @property integer $total_questions_count
 * @property integer $right_answers_count
 * @property integer $wrong_answers_count
 * @property string $right_percent_amount
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property QuizSections $section
 */
class Result extends CActiveRecord
{

    protected $_themes = array();
    protected $_section;

    /**
     * Do some operations before save
     *
     * @return Result
     */
    protected function beforeSave()
    {
        if (is_array($this->results)) {
            $this->results = serialize($this->results);
        }
        if (!$this->right_percent_amount) {
            $this->right_percent_amount = $this->getRightAnswersPercent();
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Result the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Get right answers percent
     *
     * @return decimal
     */
    public function getRightAnswersPercent()
    {
        if (!$this->total_questions_count) {
            return 0;
        }
        return $this->right_answers_count * 100 / $this->total_questions_count;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'quiz_results';
    }

    /**
     * Set result user
     *
     * @param User|int $user user
     * @return Result
     */
    public function setUser($user)
    {
        if (!is_numeric($user)) {
            $user = $user->user_id;
        }
        $this->user_id = $user;
        return $this;
    }

    /**
     * Set result section
     *
     * @param Section $section section
     * @return Result
     */
    public function setSection(Section $section)
    {
        $this->section_id = $section->section_id;
        $this->_section = $section;
        return $this;
    }

    /**
     * get question section
     *
     * @return Section
     */
    public function getSection()
    {
        if (!isset($this->_section)) {
            $this->_section = Section::model()->findByPk($this->section_id);
        }
        return $this->_section;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section_id, user_id, results, total_questions_count, right_answers_count, wrong_answers_count', 'required'),
            array('section_id, user_id, total_questions_count, right_answers_count, wrong_answers_count', 'numerical', 'integerOnly'=>true),
            array('right_percent_amount', 'length', 'max'=>10),
            array('passed_at, results', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('result_id, section_id, user_id, passed_at, results, total_questions_count, right_answers_count, wrong_answers_count, right_percent_amount', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'section' => array(self::BELONGS_TO, 'QuizSections', 'section_id'),
        );
    }

    /**
     * Get attribute labels
     * 
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'result_id'             => 'Result',
            'section_id'            => 'Section',
            'user_id'               => 'User',
            'passed_at'             => 'Passed At',
            'results'               => 'Results',
            'total_questions_count' => 'Total Questions Count',
            'right_answers_count'   => 'Right Answers Count',
            'wrong_answers_count'   => 'Wrong Answers Count',
            'right_percent_amount'  => 'Right Percent Amount',
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

        $criteria->compare('result_id',$this->result_id);
        $criteria->compare('section_id',$this->section_id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('passed_at',$this->passed_at,true);
        $criteria->compare('results',$this->results,true);
        $criteria->compare('total_questions_count',$this->total_questions_count);
        $criteria->compare('right_answers_count',$this->right_answers_count);
        $criteria->compare('wrong_answers_count',$this->wrong_answers_count);
        $criteria->compare('right_percent_amount',$this->right_percent_amount,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * process result
     *
     * @param Array $result result
     *
     * @return Result
     */
    public function processResult(Array $result)
    {
        $this->total_questions_count = 0;
        $this->wrong_answers_count = 0;
        $this->right_answers_count = 0;
        $this->results = $result;
        $themes = array();
        foreach ($this->getSection()->getRelated('questions') as $questionId => $question) {
            if (!$question->hasRightAnswer()) {
                continue;
            }
            $this->total_questions_count++;

            if (!isset($result[$questionId]) || !$question->isValidResult($result[$questionId])) {
                $this->wrong_answers_count++;
                $theme[] = $question->theme;
                continue;
            }
            $this->right_answers_count++;
        }
        return true;
    }
}