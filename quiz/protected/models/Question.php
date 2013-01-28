<?php

/**
 * This is the model class for table "quiz_questions".
 *
 * The followings are the available columns in table 'quiz_questions':
 * @property integer $question_id
 * @property integer $section_id
 * @property string $title
 * @property string $text
 * @property string $theme
 * @property string $type
 *
 * The followings are the available model relations:
 * @property QuizSections $section
 * @property QuizQuestionsAnswers[] $quizQuestionsAnswers
 */
class Question extends CActiveRecord
{
    const TYPE_ONECHOICE   = 0;
    const TYPE_MULTICHOICE = 1;
    const TYPE_FREEFORM    = 2;
    const TYPE_POLL        = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Question the static model class
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
        return 'quiz_questions';
    }

    /**
     * Has right answer flag
     *
     * @return boolean
     */
    public function hasRightAnswer()
    {
        return in_array($this->type, array(self::TYPE_ONECHOICE, self::TYPE_MULTICHOICE));
    }

    /**
     * Validate question result flag
     *
     * @param mixed $result result
     *
     * @return boolean
     */
    public function isValidResult($result)
    {
        $result = (array) $result;
        return $this->_compareArrays($result, $this->getRightAnswers());
    }

   /**
    * Compare arrays
    *
    * @param Array $array1 array to compare
    * @param Array $array2 array to compare
    *
    * @return bool
    */
    protected function _compareArrays(Array $array1, Array $array2)
    {
        sort($array1);
        sort($array2);
        return ($array1 == $array2);
    }

    /**
     * Get question right answers
     *
     * @return array
     */
    public function getRightAnswers()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.answer_id';
        $criteria->condition = 't.is_correct = :is_correct AND t.question_id = :question_id';
        $criteria->params = array(
            ':is_correct'  => QuestionsAnswer::IS_CORRECT, 
            ':question_id' => $this->question_id,
            );
        $answers = array();
        $result =  QuestionsAnswer::model()->findAll($criteria);
        foreach ($result as $item) {
            $answers[] = $item->answer_id;
        }
        return $answers;
    }

    /**
     * Check if answer is selected
     *
     * @param  QuestionsAnswer $answer answer
     * @param  Array           $result result
     *
     * @return boolean
     */
    public function isSelectedAnswer(QuestionsAnswer $answer, Array $result)
    {
        if (!isset($result[$this->question_id])) {
            return false;
        }
        $result = $result[$this->question_id];
        if (!is_array($result)) {
            return ($answer->answer_id == $result);
        }
        return (in_array($answer->answer_id, $result));
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section_id, title', 'required'),
            array('section_id', 'numerical', 'integerOnly'=>true),
            array('theme', 'length', 'max'=>500),
            array('title', 'length', 'max'=>255),
            array('type', 'length', 'max'=>1),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('question_id, section_id, title, theme, type, text', 'safe'),
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
            'section' => array(self::BELONGS_TO, 'Section', 'section_id'),
            'answers' => array(self::HAS_MANY, 'QuestionsAnswer', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'question_id' => 'Question',
            'section_id' => 'Section',
            'title' => 'Title',
            'text' => 'Text',
            'theme' => 'Theme',
            'type' => 'Type',
        );
    }

    /**
     * Get question type option
     *
     * @return array
     */
    public function getTypeOptions()
    {
        return array(
                self::TYPE_ONECHOICE   => 'One choice',
                self::TYPE_MULTICHOICE => 'Multiple choice',
                self::TYPE_FREEFORM    => 'Free form',
                self::TYPE_POLL        => 'Poll'
            );
    }

    /**
     * Get type of question string
     *
     * @return string
     */
    public function getTypeOptionValue()
    {
        $options = $this->getTypeOptions();
        if (array_key_exists($this->type, $options)) {
            return $options[$this->type];
        }
        return null;
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

        $criteria->compare('question_id',$this->question_id);
        $criteria->compare('section_id',$this->section_id);
        // $criteria->with = 'section';
        // $criteria->compare('section', $this->section->title);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('theme',$this->theme,true);
        $criteria->compare('type',$this->type,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}