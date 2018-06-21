<?php

/**
 * This is the model class for table "banker".
 *
 * The followings are the available columns in table 'banker':
 * @property string $id
 * @property string $bank_name
 * @property string $account_number
 * @property string $swift_code
 * @property string $sort_code
 * @property string $type
 * @property integer $default_bank
 * @property string $account_name
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Country[] $countries
 */
class Banker extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banker';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('default_bank, create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('bank_name, account_name', 'length', 'max'=>200),
			array('account_number, swift_code, sort_code', 'length', 'max'=>30),
			array('type', 'length', 'max'=>11),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bank_name, account_number, swift_code, sort_code, type, default_bank, account_name, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'countries' => array(self::MANY_MANY, 'Country', 'bank_collect_for_country(bank_id, country_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bank_name' => 'Bank Name',
			'account_number' => 'Account Number',
			'swift_code' => 'Swift Code',
			'sort_code' => 'Sort Code',
			'type' => 'Type',
			'default_bank' => 'Default Bank',
			'account_name' => 'Account Name',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_user_id' => 'Create User',
			'update_user_id' => 'Update User',
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
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('swift_code',$this->swift_code,true);
		$criteria->compare('sort_code',$this->sort_code,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('default_bank',$this->default_bank);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
