<?php

/**
 * This is the model class for table "membershiptype_has_fees".
 *
 * The followings are the available columns in table 'membershiptype_has_fees':
 * @property string $membership_type_id
 * @property string $fee_id
 * @property string $status
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class MembershiptypeHasFees extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'membershiptype_has_fees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('membership_type_id, fee_id, status', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('membership_type_id, fee_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('membership_type_id, fee_id, status, create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
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
			'membership_type_id' => 'Membership Type',
			'fee_id' => 'Fee',
			'status' => 'Status',
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

		$criteria->compare('membership_type_id',$this->membership_type_id,true);
		$criteria->compare('fee_id',$this->fee_id,true);
		$criteria->compare('status',$this->status,true);
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
	 * @return MembershiptypeHasFees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that retrieves the active membershiptype fee
         */
        public function getTheGrossAmountOfThisMembershipType($membership_type_id,$number_of_years){
            
            $model = new MembershipFee;
            
            //get the membership fee for this membership type
            $fee_id = $this->getTheMembershipFeeIdOfThisType($membership_type_id);
            
            return ($model->getThePrevailingMembershipFee($fee_id) * $number_of_years);
        }
        
        
        /**
         * This is the function that gets the prevailing membership fee of a membership type
         */
        public function getTheMembershipFeeIdOfThisType($membership_type_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='membership_type_id=:id and status=:status';
                $criteria->params = array(':id'=>$membership_type_id,':status'=>'active');
                $fee= MembershiptypeHasFees::model()->find($criteria);
                
                return $fee['fee_id'];
        }
        
        /**
         * This is the function that gets the monthly membership subscription
         */
        public function getTheGrossAmountOfThisMembershipTypeForMonthly($membership_type_id,$number_of_months){
            $model = new MembershipFee;

            //get the membership fee for this membership type
            $fee_id = $this->getTheMembershipFeeIdOfThisType($membership_type_id);
            
            return($model->getThePrevailingMonthlyMembershipFee($fee_id) * $number_of_months);
            
            
        }
}
