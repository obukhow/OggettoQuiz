<?php

/**
 * This is the model class for table "quiz_sections".
 *
 * The followings are the available columns in table 'quiz_sections':
 * @property integer $section_id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property QuizQuestions[] $quizQuestions
 */
class Section extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Section the static model class
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
        return 'quiz_sections';
    }

    /**
     * Get quiz time limit in seconds
     *
     * @return integer
     */
    public function getTimeLimit()
    {
        if ($this->time_limit) {
            return $this->time_limit * 60;
        }
        return 0;
    }

    /**
     * Get Section Url
     *
     * @return string
     */
    public function getUrl()
    {
        return Yii::app()->createAbsoluteUrl('/quiz/' .$this->url);
    }

    /**
     * Get section questions count
     *
     * @return int
     */
    public function getQuestionsCount()
    {
        return Question::model()->count("section_id=:section_id", array("section_id" => $this->section_id));
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, url', 'required'),
            array('title, time_limit', 'length', 'max' => 255),
            array('several_attempts, show_on_main_page', 'length', 'max' => 2),
                        array('description, url', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('time_limit', 'numerical',
                'integerOnly' => true,
                'min' => 0,
                'max' => 90,
            ),
            array('section_id, title', 'safe', 'on' => 'search'),
        );
    }

        /**
         * Before save
         *
         * @return bool
         */
        public function beforeSave()
        {
            $this->url = ($this->url) ? $this->sanitize($this->url) : $this->sanitize($this->title);

            return parent::beforeSave();
        }

        /**
         * Sanitize url
         *
         * @param str $string url
         * @return str
         */
        public function sanitize($string)
        {
            $match = array("/\s+/","/[^a-zA-Zа-яА-Я0-9\-]/u","/-+/","/^-+/","/-+$/");
            $replace = array("-","","-","","");
            $string = preg_replace($match, $replace, $string);
            $string = mb_strtolower($string, 'UTF-8');
            return $string;
        }

        /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'questions' => array(self::HAS_MANY, 'Question', 'section_id', 'order' => 'position, question_id ASC'),
            'themes' => array(self::HAS_MANY, 'Theme', 'section_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'section_id'        => 'Test',
            'title'             => 'Title',
            'url'               => 'URL Key',
            'time_limit'        => 'Time Limit (minutes)',
            'several_attempts'  => 'Allow Several Attempts',
            'show_on_main_page' => 'Show Test On Main Page',
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

        $criteria->compare('section_id',$this->section_id);
        $criteria->compare('title',$this->title,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}