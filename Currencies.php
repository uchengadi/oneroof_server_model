<?php

/**
 * This is the model class for table "currencies".
 *
 * The followings are the available columns in table 'currencies':
 * @property string $id
 * @property string $currency_name
 * @property string $currency_code
 * @property string $currency_symbol
 * @property string $description
 * @property string $country_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property CurrencyExchange[] $currencyExchanges
 * @property CurrencyExchange[] $currencyExchanges1
 * @property PlatformSettings[] $platformSettings
 * @property Stores[] $stores
 */
class Currencies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currencies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('currency_name, description', 'length', 'max'=>200),
			array('currency_code, country_id', 'length', 'max'=>10),
			array('currency_symbol', 'length', 'max'=>5),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, currency_name, currency_code, currency_symbol, description, country_id, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'currencyExchanges' => array(self::HAS_MANY, 'CurrencyExchange', 'base_currency_id'),
			'currencyExchanges1' => array(self::HAS_MANY, 'CurrencyExchange', 'currency_id'),
			'platformSettings' => array(self::HAS_MANY, 'PlatformSettings', 'platform_default_currency_id'),
			'stores' => array(self::HAS_MANY, 'Stores', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'currency_name' => 'Currency Name',
			'currency_code' => 'Currency Code',
			'currency_symbol' => 'Currency Symbol',
			'description' => 'Description',
			'country_id' => 'Country',
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
		$criteria->compare('currency_name',$this->currency_name,true);
		$criteria->compare('currency_code',$this->currency_code,true);
		$criteria->compare('currency_symbol',$this->currency_symbol,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('country_id',$this->country_id,true);
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
	 * @return Currencies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
