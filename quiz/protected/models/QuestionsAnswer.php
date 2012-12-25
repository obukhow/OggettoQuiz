<?php

/**
 * This is the model class for table "quiz_questions_answers".
 *
 * The followings are the available columns in table 'quiz_questions_answers':
 * @property integer $answer_id
 * @property integer $question_id
 * @property string $title
 * @property string $is_correct
 *
 * The followings are the available model relations:
 * @property QuizQuestions $question
 */
class QuestionsAnswer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuestionsAnswer the static model class
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
		return 'quiz_questions_answers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_id, title', 'required'),
			array('question_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('is_correct', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('answer_id, question_id, title, is_correct', 'safe', 'on'=>'search'),
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
			'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'answer_id' => 'Answer',
			'question_id' => 'Question',
			'title' => 'Title',
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

		$criteria->compare('answer_id',$this->answer_id);
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('is_correct',$this->is_correct,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}