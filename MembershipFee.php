<?php

/**
 * This is the model class for table "membership_fee".
 *
 * The followings are the available columns in table 'membership_fee':
 * @property string $id
 * @property double $amount
 * @property string $start_date
 * @property string $end_date
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Membershiptype[] $membershiptypes
 */
class MembershipFee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'membership_fee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('start_date, end_date, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, amount, start_date, end_date, create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
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
			'membershiptypes' => array(self::MANY_MANY, 'Membershiptype', 'membershiptype_has_fees(fee_id, membership_type_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MembershipFee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that gets the prevailing fee amount of a type
         */
        public function getThePrevailingMembershipFee($fee_id){
            
             $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$fee_id);
                $fee= MembershipFee::model()->find($criteria);
                
                return $fee['amount'];
        }
        
        
         /**
         * This is the function that gets the prevailing monthly fee amount of a type
         */
        public function getThePrevailingMonthlyMembershipFee($fee_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$fee_id);
                $fee= MembershipFee::model()->find($criteria);
                
                return $fee['amount_monthly'];
        }
        
        
}
