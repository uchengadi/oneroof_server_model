<?php

/**
 * This is the model class for table "currency_exchange".
 *
 * The followings are the available columns in table 'currency_exchange':
 * @property string $base_currency_id
 * @property string $currency_id
 * @property double $exchange_rate
 * @property string $create_time
 * @property string $update_time
 * @property integer $created_by
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property Currencies $baseCurrency
 * @property Currencies $currency
 */
class CurrencyExchange extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currency_exchange';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('base_currency_id, currency_id, exchange_rate', 'required'),
			array('created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('exchange_rate', 'numerical'),
			array('base_currency_id, currency_id', 'length', 'max'=>10),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('base_currency_id, currency_id, exchange_rate, create_time, update_time, created_by, updated_by', 'safe', 'on'=>'search'),
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
			'baseCurrency' => array(self::BELONGS_TO, 'Currencies', 'base_currency_id'),
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'base_currency_id' => 'Base Currency',
			'currency_id' => 'Currency',
			'exchange_rate' => 'Exchange Rate',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
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

		$criteria->compare('base_currency_id',$this->base_currency_id,true);
		$criteria->compare('currency_id',$this->currency_id,true);
		$criteria->compare('exchange_rate',$this->exchange_rate);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CurrencyExchange the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
