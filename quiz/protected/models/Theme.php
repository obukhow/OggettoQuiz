<?php

/**
 * This is the model class for table "section_themes".
 *
 * The followings are the available columns in table 'section_themes':
 * @property integer $theme_id
 * @property integer $section_id
 * @property string $theme
 *
 * The followings are the available model relations:
 * @property QuizSections $section
 */
class Theme extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Theme the static model class
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
		return 'section_themes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('section_id', 'required'),
			array('section_id', 'numerical', 'integerOnly'=>true),
			array('theme', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('theme_id, section_id, theme', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'theme_id' => 'Theme',
			'section_id' => 'Section',
			'theme' => 'Theme',
		);
	}

	/**
	 * Get typeahead options
	 * 
	 * @return array
	 */
	public function getTypeaheadOptions($sectionId)
	{
		$options = Theme::model()->findAllByAttributes(array('section_id' => $sectionId));
		if ($options) {
			return array_values(Chtml::listData($options, 'theme_id', 'theme'));
		}
		return array();
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

		$criteria->compare('theme_id',$this->theme_id);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('theme',$this->theme,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Add new theme entry
	 * 
	 * @param Question $question question
	 * 
	 * @return void
	 */
	public function addQuestionTheme(Question $question)
	{
		$theme = Theme::model()->findByAttributes(array('section_id' => $question->section_id, 'theme' => $question->theme));
		if (! $theme) {
			$theme = new Theme;
			$theme->section_id = $question->section_id;
			$theme->theme = $question->theme;
			$theme->save();
		}
	}
}