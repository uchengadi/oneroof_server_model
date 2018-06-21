<?php

/**
 * This is the model class for table "futures_has_payment".
 *
 * The followings are the available columns in table 'futures_has_payment':
 * @property string $futures_id
 * @property string $payment_id
 * @property string $payment_due_date
 * @property string $actual_date_of_payment
 * @property string $status
 */
class FuturesHasPayment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'futures_has_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('futures_id, payment_id, status', 'required'),
			array('futures_id, payment_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('payment_due_date, actual_date_of_payment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('futures_id, payment_id, payment_due_date, actual_date_of_payment, status', 'safe', 'on'=>'search'),
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
			'futures_id' => 'Futures',
			'payment_id' => 'Payment',
			'payment_due_date' => 'Payment Due Date',
			'actual_date_of_payment' => 'Actual Date Of Payment',
			'status' => 'Status',
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

		$criteria->compare('futures_id',$this->futures_id,true);
		$criteria->compare('payment_id',$this->payment_id,true);
		$criteria->compare('payment_due_date',$this->payment_due_date,true);
		$criteria->compare('actual_date_of_payment',$this->actual_date_of_payment,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FuturesHasPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
