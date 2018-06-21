<?php

/**
 * This is the model class for table "bank_collect_for_country".
 *
 * The followings are the available columns in table 'bank_collect_for_country':
 * @property string $bank_id
 * @property string $country_id
 * @property string $status
 * @property string $payment_mode
 * @property integer $approved
 * @property integer $approved_user_id
 * @property integer $disapproved_user_id
 * @property integer $activated_user_id
 * @property string $activated_time
 * @property string $approved_time
 * @property string $disapproved_time
 * @property string $initiator_create_time
 * @property string $initiator_update_time
 * @property integer $initiator_create_user_id
 * @property integer $initiator_update_user_id
 */
class BankCollectForCountry extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bank_collect_for_country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_id, country_id, status', 'required'),
			array('approved, approved_user_id, disapproved_user_id, activated_user_id, initiator_create_user_id, initiator_update_user_id', 'numerical', 'integerOnly'=>true),
			array('bank_id, country_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('payment_mode', 'length', 'max'=>13),
			array('activated_time, approved_time, disapproved_time, initiator_create_time, initiator_update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bank_id, country_id, status, payment_mode, approved, approved_user_id, disapproved_user_id, activated_user_id, activated_time, approved_time, disapproved_time, initiator_create_time, initiator_update_time, initiator_create_user_id, initiator_update_user_id', 'safe', 'on'=>'search'),
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
			'bank_id' => 'Bank',
			'country_id' => 'Country',
			'status' => 'Status',
			'payment_mode' => 'Payment Mode',
			'approved' => 'Approved',
			'approved_user_id' => 'Approved User',
			'disapproved_user_id' => 'Disapproved User',
			'activated_user_id' => 'Activated User',
			'activated_time' => 'Activated Time',
			'approved_time' => 'Approved Time',
			'disapproved_time' => 'Disapproved Time',
			'initiator_create_time' => 'Initiator Create Time',
			'initiator_update_time' => 'Initiator Update Time',
			'initiator_create_user_id' => 'Initiator Create User',
			'initiator_update_user_id' => 'Initiator Update User',
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

		$criteria->compare('bank_id',$this->bank_id,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('payment_mode',$this->payment_mode,true);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('approved_user_id',$this->approved_user_id);
		$criteria->compare('disapproved_user_id',$this->disapproved_user_id);
		$criteria->compare('activated_user_id',$this->activated_user_id);
		$criteria->compare('activated_time',$this->activated_time,true);
		$criteria->compare('approved_time',$this->approved_time,true);
		$criteria->compare('disapproved_time',$this->disapproved_time,true);
		$criteria->compare('initiator_create_time',$this->initiator_create_time,true);
		$criteria->compare('initiator_update_time',$this->initiator_update_time,true);
		$criteria->compare('initiator_create_user_id',$this->initiator_create_user_id);
		$criteria->compare('initiator_update_user_id',$this->initiator_update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BankCollectForCountry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that gets the active bank for collection for a country 
         */
        public function getThisCountryActiveBankAccountForCollection($country_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='country_id=:countryid and status=:status';
             $criteria->params = array(':countryid'=>$country_id,':status'=>'active');
             $bank= BankCollectForCountry::model()->find($criteria);
             
             return $bank['bank_id'];
            
        }
}
