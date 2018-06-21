<?php

/**
 * This is the model class for table "order_delivery".
 *
 * The followings are the available columns in table 'order_delivery':
 * @property string $id
 * @property string $order_id
 * @property string $status
 * @property string $member_remark
 * @property integer $order_delivered_by
 * @property string $date_of_delivery
 * @property integer $delivery_confirmed_by
 * @property string $date_of_delivery_confirmation
 *
 * The followings are the available model relations:
 * @property Order $order
 */
class OrderDelivery extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_delivery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, status, order_delivered_by, delivery_confirmed_by', 'required'),
			array('order_delivered_by, delivery_confirmed_by', 'numerical', 'integerOnly'=>true),
			array('order_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>11),
			array('member_remark, date_of_delivery, date_of_delivery_confirmation', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, status, member_remark, order_delivered_by, date_of_delivery, delivery_confirmed_by, date_of_delivery_confirmation', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'status' => 'Status',
			'member_remark' => 'Member Remark',
			'order_delivered_by' => 'Order Delivered By',
			'date_of_delivery' => 'Date Of Delivery',
			'delivery_confirmed_by' => 'Delivery Confirmed By',
			'date_of_delivery_confirmation' => 'Date Of Delivery Confirmation',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('member_remark',$this->member_remark,true);
		$criteria->compare('order_delivered_by',$this->order_delivered_by);
		$criteria->compare('date_of_delivery',$this->date_of_delivery,true);
		$criteria->compare('delivery_confirmed_by',$this->delivery_confirmed_by);
		$criteria->compare('date_of_delivery_confirmation',$this->date_of_delivery_confirmation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderDelivery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
