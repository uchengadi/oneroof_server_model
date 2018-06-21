<?php

/**
 * This is the model class for table "assigning_order_for_delivery".
 *
 * The followings are the available columns in table 'assigning_order_for_delivery':
 * @property string $member_id
 * @property string $order_id
 * @property integer $order_assigned_by
 * @property integer $order_assigned_to
 * @property string $date_of_assignment
 * @property string $status
 * @property string $failed_remark
 * @property string $ondispute_remark
 * @property string $delivered_remark
 * @property string $ontransit_remark
 * @property string $ontransit_commencement_date
 * @property string $delivery_return_date
 */
class AssigningOrderForDelivery extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'assigning_order_for_delivery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, order_id, order_assigned_by, order_assigned_to, status', 'required'),
			array('order_assigned_by, order_assigned_to', 'numerical', 'integerOnly'=>true),
			array('member_id, order_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('date_of_assignment, failed_remark, ondispute_remark, delivered_remark, ontransit_remark, ontransit_commencement_date, delivery_return_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, order_id, order_assigned_by, order_assigned_to, date_of_assignment, status, failed_remark, ondispute_remark, delivered_remark, ontransit_remark, ontransit_commencement_date, delivery_return_date', 'safe', 'on'=>'search'),
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
			'member_id' => 'Member',
			'order_id' => 'Order',
			'order_assigned_by' => 'Order Assigned By',
			'order_assigned_to' => 'Order Assigned To',
			'date_of_assignment' => 'Date Of Assignment',
			'status' => 'Status',
			'failed_remark' => 'Failed Remark',
			'ondispute_remark' => 'Ondispute Remark',
			'delivered_remark' => 'Delivered Remark',
			'ontransit_remark' => 'Ontransit Remark',
			'ontransit_commencement_date' => 'Ontransit Commencement Date',
			'delivery_return_date' => 'Delivery Return Date',
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

		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('order_assigned_by',$this->order_assigned_by);
		$criteria->compare('order_assigned_to',$this->order_assigned_to);
		$criteria->compare('date_of_assignment',$this->date_of_assignment,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('failed_remark',$this->failed_remark,true);
		$criteria->compare('ondispute_remark',$this->ondispute_remark,true);
		$criteria->compare('delivered_remark',$this->delivered_remark,true);
		$criteria->compare('ontransit_remark',$this->ontransit_remark,true);
		$criteria->compare('ontransit_commencement_date',$this->ontransit_commencement_date,true);
		$criteria->compare('delivery_return_date',$this->delivery_return_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssigningOrderForDelivery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
