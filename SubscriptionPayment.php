<?php

/**
 * This is the model class for table "subscription_payment".
 *
 * The followings are the available columns in table 'subscription_payment':
 * @property string $id
 * @property string $status
 * @property string $payment_mode
 * @property string $invoice_number
 * @property string $bank_account_id
 * @property string $remark
 * @property string $reason_for_failure
 * @property double $amount
 * @property double $discounted_amount
 * @property string $payment_date
 * @property string $paid_by_id
 * @property string $membership_type_id
 * @property integer $payment_confirmed_by
 * @property string $date_of_confirmation
 * @property string $member_id
 *
 * The followings are the available model relations:
 * @property Membershiptype $membershipType
 * @property Members $paidBy
 * @property Banker $bankAccount
 */
class SubscriptionPayment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscription_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, bank_account_id, amount, paid_by_id, membership_type_id, member_id', 'required'),
			array('payment_confirmed_by', 'numerical', 'integerOnly'=>true),
			array('amount, discounted_amount', 'numerical'),
			array('status', 'length', 'max'=>11),
			array('payment_mode', 'length', 'max'=>17),
			array('invoice_number', 'length', 'max'=>50),
			array('bank_account_id, paid_by_id, membership_type_id, member_id', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>200),
			array('reason_for_failure, payment_date, date_of_confirmation', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, payment_mode, invoice_number, bank_account_id, remark, reason_for_failure, amount, discounted_amount, payment_date, paid_by_id, membership_type_id, payment_confirmed_by, date_of_confirmation, member_id', 'safe', 'on'=>'search'),
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
			'membershipType' => array(self::BELONGS_TO, 'Membershiptype', 'membership_type_id'),
			'paidBy' => array(self::BELONGS_TO, 'Members', 'paid_by_id'),
			'bankAccount' => array(self::BELONGS_TO, 'Banker', 'bank_account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'status' => 'Status',
			'payment_mode' => 'Payment Mode',
			'invoice_number' => 'Invoice Number',
			'bank_account_id' => 'Bank Account',
			'remark' => 'Remark',
			'reason_for_failure' => 'Reason For Failure',
			'amount' => 'Amount',
			'discounted_amount' => 'Discounted Amount',
			'payment_date' => 'Payment Date',
			'paid_by_id' => 'Paid By',
			'membership_type_id' => 'Membership Type',
			'payment_confirmed_by' => 'Payment Confirmed By',
			'date_of_confirmation' => 'Date Of Confirmation',
			'member_id' => 'Member',
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
		$criteria->compare('status',$this->status,true);
		$criteria->compare('payment_mode',$this->payment_mode,true);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('bank_account_id',$this->bank_account_id,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('reason_for_failure',$this->reason_for_failure,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('discounted_amount',$this->discounted_amount);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('paid_by_id',$this->paid_by_id,true);
		$criteria->compare('membership_type_id',$this->membership_type_id,true);
		$criteria->compare('payment_confirmed_by',$this->payment_confirmed_by);
		$criteria->compare('date_of_confirmation',$this->date_of_confirmation,true);
		$criteria->compare('member_id',$this->member_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubscriptionPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that gets the subscription date
         */
        public function getTheMemberSubscriptionDate($member_id){
            
               $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='member_id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= MembershipSubscription::model()->find($criteria);
                
                $date = $this->getThisDate($member['subscription_initiation_date']);
                
                return $date;
        }
        
        
        /**
         * This is the function that returns a date for invoicing
         */
        public function getThisDate($subscription_initiation_date){
            
            $date = getdate(strtotime($subscription_initiation_date));
            $dated = $date['year'].$date['mon'].$date['mday'];
            
            return $dated;
        }
        
        
         /**
         * This is the function that verifies the existence of an invoice number
         */
        public function isInvoiceNumberNotAlreadyExisting($invoice_number){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('subscription_payment')
                    ->where("invoice_number = '$invoice_number'");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
            
            
        }
        
        
        
        /**
         * This is the function that effects subsciption payment
         */
        public function effectMembershipSubscriptionPayment($id,$membership_type,$gross,$discount,$net_amount){
           $model = new Members; 
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('subscription_payment',
                         array('member_id'=>$id,
                                'membership_type_id' =>$membership_type,
                                 'status'=>'unconfirmed',
                                 'payment_mode'=>'online',
                                 'amount'=>$gross,
                                 'discounted_amount'=>$discount,
                                 'net_amount'=>$net_amount,
                                 'payment_date'=>new CDbExpression('NOW()'),
                                 'paid_by_id'=>$id,
                                 'bank_account_id'=>$model->getTheBankAccountIdForThisMemberCountry($id),
                                 'invoice_number'=>$this->generateTheInvoiceNumberForThisMemberSubscription($id),
                                 'remark'=>'Subscription Payment made by a new member'
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
                 
       
        }
        
        
           
        /**
         * This is the function that generates an invoice number for subscription payment
         */
        public function generateTheInvoiceNumberForThisMemberSubscription($member_id){
            
            $city_number = $this->getThisMemberCityNumber($member_id);
            $state_number = $this->getThisMemberStateNumber($member_id);
            $member_code = $this->getTheLastFourDigitsOfThisMemberMembershipNumber($member_id);
            $subscription_date = $this->getTheMemberSubscriptionDate($member_id);
                       
            $invoice_number = $state_number.'-'.$city_number.'-'.$member_code.'-'.$subscription_date;
            
            if($this->isInvoiceNumberNotAlreadyExisting($invoice_number)){
                return $invoice_number;
            }else{
                return($invoice_number.'_'.$this->uniqueNumberDifferentiator());
            }
        }
        
        
              
           
        /**
         * This is the function that will get the last four digits of a members membership number
         */
        public function getTheLastFourDigitsOfThisMemberMembershipNumber($member_id){
            
                $model = new Members;
                
               return  $model->getTheLastFourDigitsOfThisMemberMembershipNumber($member_id);
            
        }
        
        
        
        /**
         * This is the function that gets a states number
         */
        public function getThisMemberStateNumber($member_id){
                $model = new Members;
                
                return $model->getThisMemberStateNumber($member_id);
        }
        
        /**
       
        /**
         * This is the function that gets the member city number
         */
        public function getThisMemberCityNumber($member_id){
            
                 $model = new Members;
                
                return $model->getThisMemberCityNumber($member_id);
            
        }
        
        
            
        
        /**
         * This is the function that gets the new unique number differentiator
         */
        public function uniqueNumberDifferentiator(){
                
            $model = new PlatformSettings;
                             
            return $model->uniqueNumberDifferentiator();
                
        }
        
        
        
        /**
         * This is the function that retrieves the invoice of an unconfirmed payment of a member
         */
        public function getTheInvoiceNumberOfThisPayment($member_id,$membership_type_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='member_id=:id and (status=:status and membership_type_id=:typeid)';
                $criteria->params = array(':id'=>$member_id,':status'=>'unconfirmed',':typeid'=>$membership_type_id);
                $payment= SubscriptionPayment::model()->find($criteria);
                
                return $payment['invoice_number'];
        }
}
