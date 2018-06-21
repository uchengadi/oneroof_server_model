<?php

/**
 * This is the model class for table "contact_us".
 *
 * The followings are the available columns in table 'contact_us':
 * @property string $id
 * @property string $requester_name
 * @property string $requester_type
 * @property string $requester_institution
 * @property string $requester_email
 * @property string $requester_landline
 * @property string $requester_mobile_number
 * @property string $how_to_contact_requester
 * @property string $best_time_to_contact_requester
 * @property string $best_day_to_contact_requester
 * @property string $request
 * @property string $subject
 * @property string $request_time
 */
class ContactUs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact_us';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('requester_email, request, subject', 'required'),
			array('requester_name, requester_institution, requester_landline', 'length', 'max'=>200),
			array('requester_type', 'length', 'max'=>21),
			array('requester_email, requester_mobile_number', 'length', 'max'=>100),
			array('how_to_contact_requester', 'length', 'max'=>12),
			array('best_time_to_contact_requester', 'length', 'max'=>22),
			array('best_day_to_contact_requester', 'length', 'max'=>13),
			array('request_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, requester_name, requester_type, requester_institution, requester_email, requester_landline, requester_mobile_number, how_to_contact_requester, best_time_to_contact_requester, best_day_to_contact_requester, request, subject, request_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'requester_name' => 'Requester Name',
			'requester_type' => 'Requester Type',
			'requester_institution' => 'Requester Institution',
			'requester_email' => 'Requester Email',
			'requester_landline' => 'Requester Landline',
			'requester_mobile_number' => 'Requester Mobile Number',
			'how_to_contact_requester' => 'How To Contact Requester',
			'best_time_to_contact_requester' => 'Best Time To Contact Requester',
			'best_day_to_contact_requester' => 'Best Day To Contact Requester',
			'request' => 'Request',
			'subject' => 'Subject',
			'request_time' => 'Request Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('requester_name',$this->requester_name,true);
		$criteria->compare('requester_type',$this->requester_type,true);
		$criteria->compare('requester_institution',$this->requester_institution,true);
		$criteria->compare('requester_email',$this->requester_email,true);
		$criteria->compare('requester_landline',$this->requester_landline,true);
		$criteria->compare('requester_mobile_number',$this->requester_mobile_number,true);
		$criteria->compare('how_to_contact_requester',$this->how_to_contact_requester,true);
		$criteria->compare('best_time_to_contact_requester',$this->best_time_to_contact_requester,true);
		$criteria->compare('best_day_to_contact_requester',$this->best_day_to_contact_requester,true);
		$criteria->compare('request',$this->request,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('request_time',$this->request_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactUs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
