<?php

/**
 * This is the model class for table "membership_subscription".
 *
 * The followings are the available columns in table 'membership_subscription':
 * @property string $id
 * @property string $member_id
 * @property string $membership_type_id
 * @property string $membership_start_date
 * @property string $membership_end_date
 * @property string $status
 * @property integer $number_of_years
 * @property string $date_activated
 * @property string $date_deactivated
 * @property string $date_suspended
 * @property integer $activated_by_id
 * @property integer $deactivated_by_id
 * @property integer $suspended_by_id
 * @property string $subscription_initiation_date
 * @property integer $subscription_initiated_by
 * @property string $date_extended
 * @property integer $extended_by_id
 *
 * The followings are the available model relations:
 * @property Members $member
 * @property Membershiptype $membershipType
 */
class MembershipSubscription extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'membership_subscription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, membership_type_id, status', 'required'),
			array('number_of_years, activated_by_id, deactivated_by_id, suspended_by_id, subscription_initiated_by, extended_by_id', 'numerical', 'integerOnly'=>true),
			array('member_id, membership_type_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('membership_start_date, membership_end_date, date_activated, date_deactivated, date_suspended, subscription_initiation_date, date_extended', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, membership_type_id, membership_start_date, membership_end_date, status, number_of_years, date_activated, date_deactivated, date_suspended, activated_by_id, deactivated_by_id, suspended_by_id, subscription_initiation_date, subscription_initiated_by, date_extended, extended_by_id', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Members', 'member_id'),
			'membershipType' => array(self::BELONGS_TO, 'Membershiptype', 'membership_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_id' => 'Member',
			'membership_type_id' => 'Membership Type',
			'membership_start_date' => 'Membership Start Date',
			'membership_end_date' => 'Membership End Date',
			'status' => 'Status',
			'number_of_years' => 'Number Of Years',
			'date_activated' => 'Date Activated',
			'date_deactivated' => 'Date Deactivated',
			'date_suspended' => 'Date Suspended',
			'activated_by_id' => 'Activated By',
			'deactivated_by_id' => 'Deactivated By',
			'suspended_by_id' => 'Suspended By',
			'subscription_initiation_date' => 'Subscription Initiation Date',
			'subscription_initiated_by' => 'Subscription Initiated By',
			'date_extended' => 'Date Extended',
			'extended_by_id' => 'Extended By',
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
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('membership_type_id',$this->membership_type_id,true);
		$criteria->compare('membership_start_date',$this->membership_start_date,true);
		$criteria->compare('membership_end_date',$this->membership_end_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('number_of_years',$this->number_of_years);
		$criteria->compare('date_activated',$this->date_activated,true);
		$criteria->compare('date_deactivated',$this->date_deactivated,true);
		$criteria->compare('date_suspended',$this->date_suspended,true);
		$criteria->compare('activated_by_id',$this->activated_by_id);
		$criteria->compare('deactivated_by_id',$this->deactivated_by_id);
		$criteria->compare('suspended_by_id',$this->suspended_by_id);
		$criteria->compare('subscription_initiation_date',$this->subscription_initiation_date,true);
		$criteria->compare('subscription_initiated_by',$this->subscription_initiated_by);
		$criteria->compare('date_extended',$this->date_extended,true);
		$criteria->compare('extended_by_id',$this->extended_by_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MembershipSubscription the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that calculates the subscription end date
         */
        public function getTheSubscriptionEndDate($membership_start_date,$number_of_months){
            
           $new_number_of_years = $number_of_months/12;
           $number_of_years = (int)$new_number_of_years;
            $usable_months = ($number_of_months)%12;
            $subscription_start_date = getdate(strtotime($membership_start_date));
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
           if(($subscription_start_date['year'] -$today['year'])<=0 ){
               if(($subscription_start_date['mon']- $today['mon'])<=0 ){
                        if(($subscription_start_date['mday']- $today['mday'])<=0 ){
                                    $subscription_end_date = (mktime(0, 0, 0, date("m")+($usable_months)  , date("d")-1, date("Y")+$number_of_years));
                                }else{
                                    $day_diff = $subscription_start_date['mday']- $today['mday'];
                                     $subscription_end_date = (mktime(0, 0, 0, date("m")+($usable_months)  , date("d")-1+$day_diff, date("Y")+$number_of_years));
                                }
                            }else{
                                $mon_diff = $subscription_start_date['mon']- $today['mon'];
                                if(($subscription_start_date['mon']- $today['mon'])<=0){
                                   $subscription_end_date = (mktime(0, 0, 0, date("m")+$mon_diff+($usable_months)  , date("d")-1, date("Y")+$number_of_years));  
                                }else{
                                    $day_diff = $subscription_start_date['mday']- $today['mday'];
                                     $subscription_end_date = (mktime(0, 0, 0, date("m")+$mon_diff+($usable_months)  , date("d")-1+$day_diff, date("Y")+$number_of_years));
                                }
                            }
                        }else{
                            $year_diff = $subscription_start_date['year'] -$today['year'];
                            if(($subscription_start_date['mon']- $today['mon'])<=0){
                                if(($subscription_start_date['mday']- $today['mday'])<=0){
                                    $subscription_end_date = (mktime(0, 0, 0, date("m")+($usable_months)  , date("d")-1, date("Y")+$number_of_years+$year_diff));
                                }else{
                                   $day_diff = $subscription_start_date['mday']- $today['mday'];
                                   $subscription_end_date = (mktime(0, 0, 0, date("m")+$usable_months , date("d")-1+$day_diff, date("Y")+$number_of_years+$year_diff)); 
                                }
                            }else{
                                $mon_diff = $subscription_start_date['mon']- $today['mon'];
                                if(($subscription_start_date['mday']- $today['mday'])<=0){
                                    $subscription_end_date = (mktime(0, 0, 0, date("m")+$mon_diff+($usable_months)  , date("d")-1, date("Y")+$number_of_years+$year_diff));
                                }else{
                                    $day_diff = $subscription_start_date['mday']- $today['mday'];
                                     $subscription_end_date = (mktime(0, 0, 0, date("m")+$mon_diff+($usable_months)  , date("d")-1+$day_diff, date("Y")+$number_of_years+$year_diff)); 
                                }
                            }
                        }
            
            return date("Y-m-d H:i:s", $subscription_end_date);
                   
    
        }
        
        
         /**
         * This is the function that calculates the subscription end date
         */
        public function getTheSubscriptionEndDateForExtensions($membership_current_end_date,$number_of_months){
            
           $new_number_of_years = $number_of_months/12;
           $number_of_years = (int)$new_number_of_years;
           $usable_months = ($number_of_months)%12;
           $subscription_current_end_date = getdate(strtotime($membership_current_end_date));
           
           $new_year = $subscription_current_end_date['year'] + $number_of_years;
           $new_month = $subscription_current_end_date['mon'] + $usable_months;
           $new_day = $subscription_current_end_date['mday'] - 1;
          
           $new_date = (mktime(0, 0, 0, $new_month , $new_day, $new_year));
           
           return date("Y-m-d H:i:s", $new_date);
            
           
                   
    
        }
        
        
        /**
         * This is the funnction that ensures the assignment of membership type to a new member 
         */
        public function isThisAssignmentOfMembershipTypeSuccessful($id,$membership_type,$number_of_months,$gross,$discount,$net_amount,$is_term_acceptable,$status){
            $model = new SubscriptionPayment;
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('membership_subscription',
                         array('member_id'=>$id,
                                'membership_type_id' =>$membership_type,
                                 'status'=>strtolower($status),
                                 'number_of_months'=>$number_of_months,
                                 'expecting_payment'=>1,
                                 'is_term_acceptable'=>$is_term_acceptable,
                                 'subscription_initiation_date'=>new CDbExpression('NOW()'),
                                 'subscription_initiated_by'=>$id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     $model->effectMembershipSubscriptionPayment($id,$membership_type,$gross,$discount,$net_amount);
                     return true;
                 }else{
                     return false;
                 }
                
            
          
        }
        
        
         /**
         * This is the function that get the membership type of a member
         */
        public function getThisMemberMembershipType($member_id){
            $model = new Membershiptype;            
            //get the country of this member
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:id and status=:status';
             $criteria->params = array(':id'=>$member_id,':status'=>'active');
             $member= MembershipSubscription::model()->find($criteria);
             
                return($model->getTheNameOfThisMembershipType($member['membership_type_id']));
   
        }
        
        
        /**
         * This is the function that gets a membership type id of a member
         */
        public function getThisMemberMembershipTypeId($member_id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:id and status=:status';
             $criteria->params = array(':id'=>$member_id,':status'=>'active');
             $member= MembershipSubscription::model()->find($criteria);
             
            return $member['membership_type_id'];
            
        }
        
         /**
         * This is the function that gets a membership type id of a member
         */
        public function getThisMemberActiveMembershipTypeId($id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $member= MembershipSubscription::model()->find($criteria);
             
            return $member['membership_type_id'];
            
        }
        
        
       
        
        
          /**
         * This is the function that gets the active membership type of this member
         */
        public function getTheActiveMembershipSubscriptionRow($member_id,$membershiptype_id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='(member=:id and membership_type_id =:typeid)and status=:status';
             $criteria->params = array(':id'=>$member_id,':typeid'=>$membershiptype_id,':status'=>'active');
             $member= MembershipSubscription::model()->find($criteria);
             
            return $member['id'];
            
        }
        
        
             
        /**
         * This is the function that determines if a subscription is the prevailing subscription
         */
        public function isThisThePrevailingSubscription($membership_end_date){
            
            if($this->membershipEndDateExceeedsToday($membership_end_date)){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if membership end date exceeds today
         */
        public function membershipEndDateExceeedsToday($membership_end_date){
            
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            $end_date = getdate(strtotime($membership_end_date));
            
             if(($end_date['year'] - $today['year'])<=0){
                if(($end_date['mon'] - $today['mon'])<=0){
                    if(($end_date['mday'] - $today['mday'])<=0){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
                
            }else{
                return true;
            }
            
        }
        
        
        /**
         * This is the function that retrieves the date of renewal or the subscription end date
         */
        public function getTheDateOfMembershipRenewalOfThisMember($member_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:id and status=:status';
             $criteria->params = array(':id'=>$member_id,':status'=>'active');
             $member= MembershipSubscription::model()->find($criteria);
            
             return $member['membership_end_date'];
            
        } 
        
        
        
        /**
         * This is the function that effects the renewal of membership
         */
        public function isThisRenewalOfMembershipTypeSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net,$is_term_acceptable){
            $model = new SubscriptionPayment;
            if($this->isThisSubscriptionToBeExtended($subscription_id)){
               if($this->isExtensionOfThisSubscriptionSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net,$is_term_acceptable)){
                   $model->effectMembershipSubscriptionPayment($member_id,$membership_type_id,$gross,$discount,$net);
                   return true;
               }else{
                   return false;
               }
                
            }else{
                if($this->isRenewalOfThisSubscriptionSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net,$is_term_acceptable)){
                    $model->effectMembershipSubscriptionPayment($member_id,$membership_type_id,$gross,$discount,$net);
                    return true;
                }else{
                    return false;
                }
                
                
            } 
           
        }
        
        
        
        /**
         * This is the function that effects the renewal of membership
         */
        public function isThisExtensionOfMembershipSubscriptionSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net,$is_term_acceptable){
            $model = new SubscriptionPayment;
            
            if($this->isThisSubscriptionToBeExtended($subscription_id)){
               if($this->isExtensionOfThisSubscriptionSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net,$is_term_acceptable)){
                   $model->effectMembershipSubscriptionPayment($member_id,$membership_type_id,$gross,$discount,$net);
                   return true;
               }else{
                   return false;
               }
                
            }else{
                if($this->isRenewalOfThisSubscriptionSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net,$is_term_acceptable)){
                    $model->effectMembershipSubscriptionPayment($member_id,$membership_type_id,$gross,$discount,$net);
                    return true;
                }else{
                    return false;
                }
                
                
            } 
           
        }
        
        
        /**
         * This is the function that determines if a membership account is to be exrended 
         */
        public function isThisSubscriptionToBeExtended($subscription_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$subscription_id);
             $member= MembershipSubscription::model()->find($criteria);
             
            if($this->membershipEndDateExceeedsToday($member['membership_end_date'])){
                     return true;
                 }else{
                     return false;
                 }
            
        }
        
        
        /**
         * This is the function that extends membership sunscription
         */
        public function isExtensionOfThisSubscriptionSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net,$is_term_acceptable){
            
              $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('membership_subscription',
                                  array(
                                    'number_of_months'=>$number_of_months,
                                      'is_term_acceptable'=>$is_term_acceptable,
                                      'expecting_payment'=>1,
                                      'extended_by_id'=>Yii::app()->user->id,
                                      'date_extended'=>new CDbExpression('NOW()'),
                                      'membership_end_date'=>$this->getTheNewSubscriptionEndDateAfterExtension($subscription_id,$number_of_months)
                       
                            ),
                     ("id=$subscription_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
            
        }
        
        
        /**
         * This is the function that confirms the renewal of membership subscription
         */
        public function isRenewalOfThisSubscriptionSuccessful($member_id,$membership_type_id,$subscription_id,$number_of_months,$gross,$discount,$net_amount,$is_term_acceptable){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('membership_subscription',
                                  array(
                                    'number_of_months'=>$number_of_months,
                                      'is_term_acceptable'=>$is_term_acceptable,
                                      'expecting_payment'=>1,
                                      'renewed_by_id'=>Yii::app()->user->id,
                                      'date_renewed'=>new CDbExpression('NOW()'),
                                      'membership_start_date'=>new CDbExpression('NOW()'),
                                      'membership_end_date'=>$this->getTheNewSubscriptionEndDateAfterRenewal($number_of_months)
                       
                            ),
                     ("id=$subscription_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
            
        }
        
        
        
        /**
         * This is the funtion that gets the new subscription end date after extension
         */
        public function getTheNewSubscriptionEndDateAfterExtension($subscription_id,$number_of_months){
            
            //get the current the end date
            $current_end_date = $this->getTheCurrentSubscriptionEndDate($subscription_id);
            
            return $this->getTheSubscriptionEndDateForExtensions($current_end_date,$number_of_months);
        }
        
        
        /**
         * This is the function that gets the current end date of a subscription
         */
        public function getTheCurrentSubscriptionEndDate($subscription_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$subscription_id);
             $members= MembershipSubscription::model()->find($criteria);
             
             return $members['membership_end_date'];
            
        }
        
        
        /**
         * This is the function to retrieve the end date of a subscription after renewal
         */
        public function getTheNewSubscriptionEndDateAfterRenewal($number_of_months){
            
            //get the current the end date
            $today = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            
            return $this->getTheSubscriptionEndDate($today,$number_of_months);
            
            
        }
        
        
        /**
         * This is the function that gets a membership subscription
         */
        public function getTheNumberOfYearsOfThisMembershipSubscription($id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $subscription= MembershipSubscription::model()->find($criteria);
             
             return $subscription['membership_end_date'];
        }
       
        
        
        /**
         * This is the function that determines the status of a member's subscription
         */
        public function isMembershipSubscriptionActive($member_id){
            
           $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('membership_subscription')
                    ->where("member_id = $member_id and status='active'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that changes a member's membership type
         */
        public function isTheMembershipTypeChangeSuccessful($member_id,$new_membership_type_id,$existing_membership_type_id,$number_of_months,$gross,$discount,$net_amount,$is_term_acceptable){
            $model = new SubscriptionPayment; 
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('membership_subscription',
                         array('member_id'=>$member_id,
                                'membership_type_id' =>$new_membership_type_id,
                                 'status'=>'inactive',
                                 'number_of_months'=>$number_of_months,
                                 'expecting_payment'=>1,
                                 'is_term_acceptable'=>$is_term_acceptable,
                                 'subscription_initiation_date'=>new CDbExpression('NOW()'),
                                 'subscription_initiated_by'=>$member_id
                           
                        )
                          
                     );
            
           if($result>0){
               $model->effectMembershipSubscriptionPayment($member_id,$new_membership_type_id,$gross,$discount,$net_amount);
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * this is the function that gets a member active subscription id
         */
        public function getMemberActiveSubscriptionId($member_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:id and status=:status';
             $criteria->params = array(':id'=>$member_id,':status'=>'active');
             $member= MembershipSubscription::model()->find($criteria);
             
            return $member['id'];
        }
        
        
        
        /**
         * this is the function that gets a member active subscription id
         */
        public function getTheDateOfMembershipRenewalOfThisActiveMembershipSubscription($id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $member= MembershipSubscription::model()->find($criteria);
             
            return $member['membership_end_date'];
        }
        
        
        
        /**
         * this is the function that gets a member active subscription id
         */
        public function getTheMembershipStatusOfThisMember($id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $member= MembershipSubscription::model()->find($criteria);
             
            return $member['status'];
        }
        
        /**
         * This is the function that determines if a member is with active subscription
         */
        public function isThisMemberWithActiveSubscription($member_id){
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:id';
             $criteria->params = array(':id'=>$member_id);
             $members= MembershipSubscription::model()->findAll($criteria);
            
             foreach($members as $member){
               if($member['status'] == strtolower('active')){
                     return true;
                 }
             }
             return false;
            
        }
        
        
        /**
         * This is the function that gets the inactive membership type of a member that is farthest fron expiration
         */
        public function getThisMemberMembershipTypeIdOfTheLastToEndSubscription($member_id){
            if($this->isUserWithMultipleSubscription($member_id)){
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='member_id=:id';
                 $criteria->params = array(':id'=>$member_id);
                 $members= MembershipSubscription::model()->findAll($criteria);
            
             $farthest_subs = $members[0];
             $collector = [];
             $iteration_steps= 0;
             for($i=1;$i<=sizeof($members)-1;$i++){
               if($this->isThisSubscriptionDateHigherThanTheFarthestSubscriptionDate(getdate(strtotime($farthest_subs->membership_end_date)),getdate(strtotime($members[$i]->membership_end_date)))==false){
                    $farthest_subs = $members[$i]; 
                   $iteration_steps = $i;
                                          
               }
             }
             return $members[$iteration_steps]->membership_type_id;
            }else{
                return $this->getThisUserMembershipType($member_id);
            }
           
 
        }
        
        
        /**
         * This is the function that returns the membership type a members subscribed to
         */
        public function getThisUserMembershipType($member_id){
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='member_id=:id';
                 $criteria->params = array(':id'=>$member_id);
                 $member= MembershipSubscription::model()->find($criteria);
                 
                 return $member['membership_type_id'];
        }
        
        /**
         * This is the function that confirms if a user has multiple membership type
         */
        public function isUserWithMultipleSubscription($member_id){
            
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('membership_subscription')
                    ->where("member_id = $member_id ");
                $result = $cmd->queryScalar();
                
                if($result> 1){
                    return true;
                }else{
                    return false;
                }
        }
        
        /**
         * This is the function that compares two subscription dates
         */
        public function isThisSubscriptionDateHigherThanTheFarthestSubscriptionDate($farthest,$given){
            if(($farthest['year'] - $given['year'])>0){
                return true;
            }else if(($farthest['year'] - $given['year'])<0){
                return false;
            }else{
                if(($farthest['mon'] - $given['mon'])>0){
                    return true;
                }else if(($farthest['mon'] - $given['mon'])<0){
                    return false;
                }else{
                    if(($farthest['mday'] - $given['mday'])>0){
                        return true;
                    }else if(($farthest['mday'] - $given['mday'])==0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
        
        
        /**
         * This is the function that retrieves the end date for a subscription
         */
        public function getTheDateOfMembershipRenewalOfThisLastToEndSubscription($id){
            return $this->getTheDateOfMembershipRenewalOfThisActiveMembershipSubscription($id);
        }
        
        /**
         * This is the function that retrieves the status of a subscription
         */
        public function getTheMembershipStatusOfThisLastToEndSubscription($id){
            return $this->getTheMembershipStatusOfThisMember($id);
        }
        
        
        /**
         * This is the function that gets the subscription id of would be active subscription
         */
        public function getTheSubscriptionIdWithFarthestDateToExpiration($member_id){
             
            
             if($this->isUserWithMultipleSubscription($member_id)){
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='member_id=:id';
                 $criteria->params = array(':id'=>$member_id);
                 $members= MembershipSubscription::model()->findAll($criteria);
            
             $farthest_subs = $members[0];
             $iteration_steps= 0;
             for($i=1;$i<=sizeof($members)-1;$i++){
                 if($this->isThisSubscriptionDateHigherThanTheFarthestSubscriptionDate(getdate(strtotime($farthest_subs->membership_end_date)),getdate(strtotime($members[$i]->membership_end_date)))== false){
                   $farthest_subs = $members[$i]; 
                   $iteration_steps = $i;
                 }
             }
             return $members[$iteration_steps]->id;
                 
             }else{
                 return $this->getTheMemberSoleSubscriptionId($member_id);
             }
            
        }
        
        /**
         * This is the function that returns a members sole subscription id
         */
        public function getTheMemberSoleSubscriptionId($member_id){
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='member_id=:id';
                 $criteria->params = array(':id'=>$member_id);
                 $member= MembershipSubscription::model()->find($criteria);
                 
                 return $member['id'];
        }
        
        
        /**
         * This is the function that gets a member's prevailing subscribed membership type
         */
        public function getThisMemberPrevailingMembershipTypeId($member_id){
            if($this->isThisMemberWithActiveSubscription($member_id)){
                //get the subscription id
                $subscription_id = $this->getMemberActiveSubscriptionId($member_id);
                return $this->getThisMemberActiveMembershipTypeId($subscription_id);
            }else{
                return $this->getThisMemberMembershipTypeIdOfTheLastToEndSubscription($member_id);
            }
        }
        
        
        /**
         * This is the function that gets the prevailing subscription id of a member
         */
        public function getThePrevailingSubscriptionIdOfThisMember($member_id){
            if($this->isThisMemberWithActiveSubscription($member_id)){
                return $this->getMemberActiveSubscriptionId($member_id);
            }else{
                return $this->getTheSubscriptionIdWithFarthestDateToExpiration($member_id);
            }
        }
        
        
         /**
         * This is the function that confirms if end validity date is valid
         */
        public function isTodayLessThanOrEqualToEndValidityDate($today,$end_date){
            
            if(($end_date['year'] - $today['year'])>0){
                return true;
            }else if(($end_date['year'] - $today['year'])<0){
                return false;
            }else{
                if(($end_date['mon'] - $today['mon'])>0){
                    return true;
                }else if(($end_date['mon'] - $today['mon'])<0){
                    return false;
                }else{
                    if(($end_date['mday'] - $today['mday'])>0){
                        return true;
                    }else if(($end_date['mday'] - $today['mday'])==0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
            
               
        }
        
        
       /** 
        * This is the function that determines if a member can trade on this store
        */
        public function canMemberTradeOnThisProduct($member_id){
            
            $model = new Membershiptype;
            if($this->isThisMemberWithActiveSubscription($member_id)){
               $membership_type_id =  $this->getThisMemberMembershipTypeId($member_id);
                
            }else{
                $membership_type_id = $this->getThisMemberMembershipTypeIdOfTheLastToEndSubscription($member_id);
            }
            
            if($model->isThisAFreeMembershipType($membership_type_id) == false){
                return true;
            }else{
                return false;
            }
        }
        
       
       
         
}

