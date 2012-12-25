<?php

/**
 * This is the model class for table "quiz_questions".
 *
 * The followings are the available columns in table 'quiz_questions':
 * @property integer $question_id
 * @property integer $section_id
 * @property string $title
 * @property string $theme
 * @property string $is_multichoice
 *
 * The followings are the available model relations:
 * @property QuizSections $section
 * @property QuizQuestionsAnswers[] $quizQuestionsAnswers
 */
class Question extends CActiveRecord
{
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
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section_id, title', 'required'),
            array('section_id', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>255),
            array('theme', 'length', 'max'=>500),
            array('is_multichoice', 'length', 'max'=>1),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('question_id, section_id, title, theme, is_multichoice', 'safe', 'on'=>'search'),
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
            'theme' => 'Theme',
            'is_multichoice' => 'Is Multichoice',
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

        $criteria->compare('question_id',$this->question_id);
        $criteria->compare('section_id',$this->section_id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('theme',$this->theme,true);
        $criteria->compare('is_multichoice',$this->is_multichoice,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}