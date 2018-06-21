<?php

/**
 * This is the model class for table "member_subscribed_to_products".
 *
 * The followings are the available columns in table 'member_subscribed_to_products':
 * @property string $member_id
 * @property string $product_id
 * @property string $status
 * @property string $day_of_delivery
 * @property string $week_of_delivery
 * @property string $delivery_frequency
 * @property string $date_of_first_delivery
 * @property string $date_of_last_delivery
 * @property string $date_of_next_delivery
 * @property string $date_product_was_subscribed_to_member
 * @property string $date_product_to_member_was_updated
 * @property integer $product_was_subscribed_by
 * @property integer $product_was_updated_by
 */
class MemberSubscribedToProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_subscribed_to_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, product_id, status', 'required'),
			array('product_was_subscribed_by, product_was_updated_by', 'numerical', 'integerOnly'=>true),
			array('member_id, product_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('day_of_delivery', 'length', 'max'=>9),
			array('week_of_delivery', 'length', 'max'=>17),
			array('delivery_frequency', 'length', 'max'=>18),
			array('date_of_first_delivery, date_of_last_delivery, date_of_next_delivery, date_product_was_subscribed_to_member, date_product_to_member_was_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, product_id, status, day_of_delivery, week_of_delivery, delivery_frequency, date_of_first_delivery, date_of_last_delivery, date_of_next_delivery, date_product_was_subscribed_to_member, date_product_to_member_was_updated, product_was_subscribed_by, product_was_updated_by', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'status' => 'Status',
			'day_of_delivery' => 'Day Of Delivery',
			'week_of_delivery' => 'Week Of Delivery',
			'delivery_frequency' => 'Delivery Frequency',
			'date_of_first_delivery' => 'Date Of First Delivery',
			'date_of_last_delivery' => 'Date Of Last Delivery',
			'date_of_next_delivery' => 'Date Of Next Delivery',
			'date_product_was_subscribed_to_member' => 'Date Product Was Subscribed To Member',
			'date_product_to_member_was_updated' => 'Date Product To Member Was Updated',
			'product_was_subscribed_by' => 'Product Was Subscribed By',
			'product_was_updated_by' => 'Product Was Updated By',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('day_of_delivery',$this->day_of_delivery,true);
		$criteria->compare('week_of_delivery',$this->week_of_delivery,true);
		$criteria->compare('delivery_frequency',$this->delivery_frequency,true);
		$criteria->compare('date_of_first_delivery',$this->date_of_first_delivery,true);
		$criteria->compare('date_of_last_delivery',$this->date_of_last_delivery,true);
		$criteria->compare('date_of_next_delivery',$this->date_of_next_delivery,true);
		$criteria->compare('date_product_was_subscribed_to_member',$this->date_product_was_subscribed_to_member,true);
		$criteria->compare('date_product_to_member_was_updated',$this->date_product_to_member_was_updated,true);
		$criteria->compare('product_was_subscribed_by',$this->product_was_subscribed_by);
		$criteria->compare('product_was_updated_by',$this->product_was_updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberSubscribedToProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
         /**
         * This is the function that confirms if a product is not already subscribed to by a member
         */
        public function isProductNotAlreadySubscribedToByMember($member_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_subscribed_to_products')
                    ->where("member_id= $member_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that determines the status of the subscribed product to a member
         */
        public function isSubscribedProductToMemberNotYetActive($member_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid and product_id=:productid';
             $criteria->params = array(':memberid'=>$member_id,':productid'=>$product_id);
             $status= MemberSubscribedToProducts::model()->find($criteria);
             
             if($status['status'] == 'inactive'){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the product that confirms the subscription of product to a member
         */
        public function isTheSuscriptionOfProductToMemberASuccess($member_id,$product_id,$subscription_type,$subscription_quantity){
           if($this->isProductNotAlreadySubscribedToByMember($member_id,$product_id)){
             if($subscription_type == 'post'){
                $status = 'active';
            }else{
                $status = 'inactive';
            }
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->insert('member_subscribed_to_products',
                         array('member_id'=>$member_id,
                                'product_id' =>$product_id,
                                'status'=>$status,
                                'type'=>$subscription_type,
                                 'subscription_quantity'=>$subscription_quantity,
                                'remaining_subscription_quantity'=>$subscription_quantity,
                                'date_product_was_subscribed_to_member'=>new CDbExpression('NOW()'),
                                 'product_was_subscribed_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
                 
             }else{
                 if($this->isRemovalOfProductSubscriptionFromTheMemberSuccessful($member_id,$product_id)){
                     
                     if($subscription_type == 'post'){
                $status = 'active';
            }else{
                $status = 'inactive';
            }
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->insert('member_subscribed_to_products',
                         array('member_id'=>$member_id,
                                'product_id' =>$product_id,
                                'status'=>$status,
                                'type'=>$subscription_type,
                                 'subscription_quantity'=>$subscription_quantity,
                                'remaining_subscription_quantity'=>$subscription_quantity,
                                'date_product_was_subscribed_to_member'=>new CDbExpression('NOW()'),
                                 'product_was_subscribed_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
                     
                 }else{
                     return false;
                 }
             }
            
        }
        
        /**
         * This is the function that confirms if a member is subscribed to a product
         */
        public function isMemberSubscribedToThisProduct($member_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_subscribed_to_products')
                    ->where("member_id= $member_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        /**
         * This is the function that retrieves the subscription quantity
         */
        public function getTheProductSubscriptionQuantity($member_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid and product_id=:productid';
             $criteria->params = array(':memberid'=>$member_id,':productid'=>$product_id);
             $subscription= MemberSubscribedToProducts::model()->find($criteria);
             
             return $subscription['subscription_quantity'];
        }
        
        
         /**
         * This is the function that retrieves the remaining subscription quantity
         */
        public function getTheRemainingProductSubscriptionQuantity($member_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid and product_id=:productid';
             $criteria->params = array(':memberid'=>$member_id,':productid'=>$product_id);
             $subscription= MemberSubscribedToProducts::model()->find($criteria);
             
             return $subscription['remaining_subscription_quantity'];
        }
        
        
         /**
         * This is the function that retrieves the per subscription quantity delivery
         */
        public function getThePerDeliveryProductQuantity($member_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid and product_id=:productid';
             $criteria->params = array(':memberid'=>$member_id,':productid'=>$product_id);
             $subscription= MemberSubscribedToProducts::model()->find($criteria);
             
             return $subscription['per_delivery_quantity'];
        }
        
        
        /**
         * This is the function that confirms if a subscription is escrowed
         */
        public function isThisSubscriptionEscrowed($member_id,$product_id){
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid and product_id=:productid';
             $criteria->params = array(':memberid'=>$member_id,':productid'=>$product_id);
             $subscription= MemberSubscribedToProducts::model()->find($criteria);
             
             return $subscription['need_escrow_agreement'];
        }
        
        
        /**
         * This is the function that unsubscribe a member from a product
         */
        public function isRemovalOfProductSubscriptionFromTheMemberSuccessful($member_id,$product_id){
            if($this->isMemberSubscribedToThisProduct($member_id,$product_id)){
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->delete('member_subscribed_to_products', 'member_id=:memberid and product_id=:productid', array(':memberid'=>$member_id,':productid'=>$product_id));
            
             if($result >0){
                    return true;
             }else{
                return false;
            }
                
            }else{
                return true;
            }
        }
        
        
        /**
         * This is the function that schedules a product subscription
         */
        public function isProductSubscriptionSchedulingSuccessful($product_id,$member_id,$day_of_delivery,$week_of_delivery,$delivery_frequency,$date_of_first_delivery,$per_delivery_quantity,$subscription_type){
            
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('member_subscribed_to_products',
                                  array(
                                    'day_of_delivery'=>$day_of_delivery,
                                     'week_of_delivery'=>$week_of_delivery,
                                    'delivery_frequency'=>$delivery_frequency,
                                    'date_of_first_delivery'=>$date_of_first_delivery,
                                     'is_delivery_scheduled'=>1, 
                                    'per_delivery_quantity'=>$per_delivery_quantity,
                                     'date_product_to_member_was_updated'=>new CDbExpression('NOW()'),
                                     'product_was_updated_by'=>Yii::app()->user->id  
                                                             
                            ),
                     ("member_id = $member_id and product_id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
    
            
        }
        
        /**
         * This is the function that initiates frawdowns on subscribed product
         */
        public function isSubscriptionDrawdownSuccessful($member_id,$product_id,$per_delivery_quantity,$date_of_next_delivery,$remaining_subscription_quantity){
            
            $remaining_quantity = $remaining_subscription_quantity - $per_delivery_quantity;
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('member_subscribed_to_products',
                                  array(
                                    'remaining_subscription_quantity'=>$remaining_quantity,
                                    'date_of_next_delivery'=>$date_of_next_delivery,
                                    'per_delivery_quantity'=>$per_delivery_quantity,
                                     'date_product_to_member_was_updated'=>new CDbExpression('NOW()'),
                                     'product_was_updated_by'=>Yii::app()->user->id  
                                                             
                            ),
                     ("member_id = $member_id and product_id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
            
        }
        
        
        /**
         * This is the function that effect the top up of a subscribed product
         */
        public function isTopupOfTheSubscribedProductSuccessful($member_id,$product_id,$total_subscription_quantity,$remaining_subscription_quantity,$topup_quantity){
             
            $new_subscription_quantity = $total_subscription_quantity + $topup_quantity;
            $new_remaining_quantity = $remaining_subscription_quantity + $topup_quantity;
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('member_subscribed_to_products',
                                  array(
                                    'remaining_subscription_quantity'=>$new_remaining_quantity,
                                    'subscription_quantity'=>$new_subscription_quantity,
                                    'date_product_to_member_was_updated'=>new CDbExpression('NOW()'),
                                     'product_was_updated_by'=>Yii::app()->user->id
                                                                                                 
                            ),
                     ("member_id = $member_id and product_id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
            
        }
        
       
        
       /**
        * This is the function that escrows a subscribed product
        * 
        */
        public function isTheEscrowOfThisSubscriptionSuccessful($member_id,$product_id,$need_escrow_agreement,$escrow_agreement_file){
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('member_subscribed_to_products',
                                  array(
                                    'need_escrow_agreement'=>$need_escrow_agreement,
                                    'escrow_agreement_file'=>$escrow_agreement_file,
                                    'date_product_to_member_was_updated'=>new CDbExpression('NOW()'),
                                     'product_was_updated_by'=>Yii::app()->user->id
                                                                                                 
                            ),
                     ("member_id = $member_id and product_id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
            
        }
        
        
        /**
         * This is the function that determines if a subscription is already in progress
         */
        public function isThisSubscriptionNotAlreadyInProcess($member_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid and product_id=:productid';
             $criteria->params = array(':memberid'=>$member_id,':productid'=>$product_id);
             $subscription= MemberSubscribedToProducts::model()->find($criteria);
             
             
             if($subscription['need_escrow_agreement'] == 0){
                 return true;
             }else{
                 return false;
             }
           
        }
        
        /**
         * This is the function that determines if a subscription escrow had already been accepted
         */
        public function isThisEscrowAlreadyAccepted($member_id,$product_id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid and product_id=:productid';
             $criteria->params = array(':memberid'=>$member_id,':productid'=>$product_id);
             $subscription= MemberSubscribedToProducts::model()->find($criteria);
             
             
             if($subscription['is_escrow_accepted'] == 1){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the funstion that updates the subscription table after the additionto cart
         */
        public function isProductSubscriptionTopupSuccessful($member_id,$product_id,$quantity_of_purchase,$subscription_type){
          // $new_subscription_quantity = $quantity_of_purchase + $this->getTheProductSubscriptionQuantity($member_id,$product_id);
            //$new_remaining_quantity = $quantity_of_purchase + $this->getTheRemainingProductSubscriptionQuantity($member_id,$product_id);
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('member_subscribed_to_products',
                                  array(
                                  //  'remaining_subscription_quantity'=>$new_remaining_quantity,
                                    'top_up_quantity'=>$quantity_of_purchase,
                                    'topup_status'=>'inactive', 
                                     'date_product_to_member_was_updated'=>new CDbExpression('NOW()'),
                                     'product_was_updated_by'=>Yii::app()->user->id
                                                                                                 
                            ),
                     ("member_id = $member_id and product_id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
            
        }
        
        
        /**
         * This is the function that gets the accepted date of  first day of delivery
         */
        public function getTheAcceptedDateOfDelivery($date_of_first_delivery){
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            $given_first_delivery_date = getdate(strtotime($date_of_first_delivery));
            
            if($this->isTodayGreaterThanTheDeliveryDate($today, $given_first_delivery_date)){
                $delivery_date = date("Y-m-d H:i:s",(mktime(0, 0, 0, date("m")  , date("d"), date("Y"))));
            }else{
                 $delivery_date = date("Y-m-d H:i:s",strtotime($date_of_first_delivery));
            }
            
            return $delivery_date;
            
        }
        
        
        
         /**
         * This is the function that confirms if start validity date is valid
         */
        public function isTodayGreaterThanTheDeliveryDate($today, $first_date){
            
            if(($today['year'] - $first_date['year'])>0){
                return true;
            }else if(($today['year'] - $first_date['year'])<0){
                return false;
            }else{
                if(($today['mon'] - $first_date['mon'])>0){
                    return true;
                }else if(($today['mon'] - $first_date['mon'])<0){
                    return false;
                }else{
                    if(($today['mday'] - $first_date['mday'])>0){
                        return true;
                    }else if(($today['mday'] - $first_date['mday'])==0){
                        return false;
                    }else{
                        return false;
                    }
                }
            }
        }
          
        
        /**
         * This is the function that modifies the escrow facility on subscribed product
         */
        public function isModifyingEscrowFacilityAtSubscriptionASuccess($product_id,$member_id,$quantity){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('member_subscribed_to_products',
                         array(
                                'subscription_quantity'=>$quantity,
                                'remaining_subscription_quantity'=>$quantity
                                                             
                        ),
                        ("product_id=$product_id and member_id=$member_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        
        }
        
        
        /**
         * This is the function that removes the escrow facility from a subscribed product
         */
        public function isRemovingEscrowFacilityAtSubscriptionASuccess($product_id,$member_id){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('member_subscribed_to_products',
                         array(
                                'need_escrow_agreement'=>0,
                                'escrow_id'=>0
                                                             
                        ),
                        ("product_id=$product_id and member_id=$member_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that updates a product subscription information
         */
        public function isProductSubscriptionUpdatedSuccessfully($escrow_id,$member_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('member_subscribed_to_products',
                         array(
                                'need_escrow_agreement'=>1,
                                'escrow_initiation_date'=>new CDbExpression('NOW()'),
                                'escrow_initiated_by'=>$member_id,
                                'escrow_id'=>$escrow_id
                                                             
                        ),
                        ("product_id=$product_id and member_id=$member_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
}
