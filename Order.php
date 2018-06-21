<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $id
 * @property string $order_number
 * @property string $status
 * @property string $order_initiation_date
 * @property string $last_updated_date
 * @property integer $order_initiated_by
 * @property integer $order_updated_by
 * @property string $delivery_address1
 * @property string $delivery_address2
 * @property string $delivery_city_id
 * @property string $delivery_state_id
 * @property string $delivery_country_id
 * @property string $delivery_mobile_number
 * @property string $address_landmark
 * @property string $nearest_bus_stop
 * @property string $person_in_care_of
 *
 * The followings are the available model relations:
 * @property Members[] $members
 * @property OrderDelivery[] $orderDeliveries
 * @property Products[] $products
 * @property Payment[] $payments
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'required'),
			array('order_initiated_by, order_updated_by', 'numerical', 'integerOnly'=>true),
			array('order_number', 'length', 'max'=>50),
			array('status', 'length', 'max'=>6),
			array('delivery_address1, delivery_address2, delivery_mobile_number, address_landmark, nearest_bus_stop', 'length', 'max'=>100),
			array('delivery_city_id, delivery_state_id, delivery_country_id', 'length', 'max'=>10),
			array('person_in_care_of', 'length', 'max'=>200),
			array('order_initiation_date, last_updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_number, status, order_initiation_date, last_updated_date, order_initiated_by, order_updated_by, delivery_address1, delivery_address2, delivery_city_id, delivery_state_id, delivery_country_id, delivery_mobile_number, address_landmark, nearest_bus_stop, person_in_care_of', 'safe', 'on'=>'search'),
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
			'members' => array(self::MANY_MANY, 'Members', 'assigning_order_for_delivery(order_id, member_id)'),
			'orderDeliveries' => array(self::HAS_MANY, 'OrderDelivery', 'order_id'),
			'products' => array(self::MANY_MANY, 'Products', 'order_has_products(order_id, product_id)'),
			'payments' => array(self::HAS_MANY, 'Payment', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_number' => 'Order Number',
			'status' => 'Status',
			'order_initiation_date' => 'Order Initiation Date',
			'last_updated_date' => 'Last Updated Date',
			'order_initiated_by' => 'Order Initiated By',
			'order_updated_by' => 'Order Updated By',
			'delivery_address1' => 'Delivery Address1',
			'delivery_address2' => 'Delivery Address2',
			'delivery_city_id' => 'Delivery City',
			'delivery_state_id' => 'Delivery State',
			'delivery_country_id' => 'Delivery Country',
			'delivery_mobile_number' => 'Delivery Mobile Number',
			'address_landmark' => 'Address Landmark',
			'nearest_bus_stop' => 'Nearest Bus Stop',
			'person_in_care_of' => 'Person In Care Of',
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
		$criteria->compare('order_number',$this->order_number,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('order_initiation_date',$this->order_initiation_date,true);
		$criteria->compare('last_updated_date',$this->last_updated_date,true);
		$criteria->compare('order_initiated_by',$this->order_initiated_by);
		$criteria->compare('order_updated_by',$this->order_updated_by);
		$criteria->compare('delivery_address1',$this->delivery_address1,true);
		$criteria->compare('delivery_address2',$this->delivery_address2,true);
		$criteria->compare('delivery_city_id',$this->delivery_city_id,true);
		$criteria->compare('delivery_state_id',$this->delivery_state_id,true);
		$criteria->compare('delivery_country_id',$this->delivery_country_id,true);
		$criteria->compare('delivery_mobile_number',$this->delivery_mobile_number,true);
		$criteria->compare('address_landmark',$this->address_landmark,true);
		$criteria->compare('nearest_bus_stop',$this->nearest_bus_stop,true);
		$criteria->compare('person_in_care_of',$this->person_in_care_of,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        
          /**
         * This is the function that gets the order date
         */
        public function getTheDateThisOrderWasInitiated($order_id){
            
               $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$order_id);
                $member= Order::model()->find($criteria);
                
                $date = $this->getThisDate($member['order_initiation_date']);
                
                return $date;
        }
        
        
          /**
         * This is the function that returns a date for invoicing
         */
        public function getThisDate($order_initiation_date){
            
            $date = getdate(strtotime($order_initiation_date));
            $dated = $date['year'].$date['mon'].$date['mday'];
            
            return $dated;
        }
        
        
        /**
         * This is the function that gets the member that initiated an order
         */
        public function getTheMemberThatMadeThisOrder($order_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$order_id);
                $member= Order::model()->find($criteria);
                
                return $member['order_initiated_by'];
        }
        
        
        /**
         * This is the function that gets all the products in an order
         * 
         */
        public function getAllTheProductsOnThisOrder($order_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='order_id=:id';
                $criteria->params = array(':id'=>$order_id);
                $products= OrderHasProducts::model()->findAll($criteria);
                
                $all_products = [];
                
                foreach($products as $product){
                    $all_products[] = $product['product_id'];
                }
                return $all_products;
            
        }
        
        
        /**
         * This is the function that determines if the country of a member initiating the order is vat enabled
         */
        public function isVatEnabledForTheCountryOfThisOrder($order_id){
            
            //get the country of the member that is initiated this order
            $model = new Members;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$order_id);
             $order= Order::model()->find($criteria);
            
            
            return $model->isVatEnabledForThisMemberCountry($order['order_initiated_by']);
        }
        
        
        /**
         * This is the function that determines the default tax rate or a country
         */
        public function TheCountryDefaultVatRate($order_id){
            
            $model = new Members;
            //get the member that made the order
            $member_id = $this->getTheMemberThatMadeThisOrder($order_id);
            return $model->theVatRateForTheCountryOfThisMember($member_id);
        }
        
        
        /**
         * This is the function that determines if vat rate is applicable
         */
        public function isVatRateCurrentlyApplicable($vat_rate_commencement_date,$order_id,$product_id){
            //get the date when this order was done
            $order_date = getdate(strtotime($this->getTheDateOfThisOrder($order_id,$product_id)));
            $date_vat_commenced = getdate(strtotime($vat_rate_commencement_date));
            
             if(($order_date['year'] - $date_vat_commenced['year'])>0){
                return true;
            }else if(($order_date['year'] - $date_vat_commenced['year'])<0){
                return false;
            }else{
                if(($order_date['mon'] - $date_vat_commenced['mon'])>0){
                    return true;
                }else if(($order_date['mon'] - $date_vat_commenced['mon'])<0){
                    return false;
                }else{
                    if(($order_date['mday'] - $date_vat_commenced['mday'])>0){
                        return true;
                    }else if(($order_date['mday'] - $date_vat_commenced['mday'])==0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
            
            
        }
        
        
        /**
         * This is the fhnction that gets the date of this order
         */
        public function getTheDateOfThisOrder($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:id and product_id=:product';
             $criteria->params = array(':id'=>$order_id,':product'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             return $order['date_ordered'];
            
        }
        
        /**
         * This is the function that gets the current open order of a member
         */
        public function getTheOpenOrderInitiatedByMember($member_id){
            if($this->isMemberWithOpenOrder($member_id)){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='order_initiated_by=:initiatedby and status=:status';
                $criteria->params = array(':initiatedby'=>$member_id,':status'=>'open');
                $order= Order::model()->find($criteria);
             
                return $order['id'];
            }else{
                return 0;
            }
             
        }
        
        
        /**
         * This is the function that determines if a member has an open order
         */
        public function isMemberWithOpenOrder($member_id){
            
           $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('order')
                    ->where("order_initiated_by = $member_id and status='open'");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function confirms if an order had been closed
         */
        public function isOrderClosed($order_id){
            
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('order',
                                  array(
                                    'status'=>'closed',
                                                             
                            ),
                     ("id=$order_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that creates new order initiated by member
         */
        public function createNewOrderForThisMember($member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('order',
                         array( 'status'=>'open',
                                 'order_number'=>$this->generateTheOrderNumberForThisMember($member_id),
                                  'order_initiated_by'=>$member_id,
                                 'order_initiation_date'=>new CDbExpression('NOW()')
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return $this->getTheOpenOrderInitiatedByMember($member_id);
                 }else{
                     return 0;
                 }
            
        }
        
        
       
        
        
        /**
         * This is the function that generates a new order number for a member 
         */
        public function generateTheOrderNumberForThisMember($member_id){
            
            $city_number = $this->getThisMemberCityNumber($member_id);
            $member_code = $this->getTheLastSevenDigitsOfThisMemberMembershipNumber($member_id);
            $ordered_date = $this->getTodayDateForThisOrder();
                       
            $order_number = $ordered_date.$city_number.$member_code;
            
            if($this->isOrderNumberNotAlreadyExisting($order_number)){
                return $order_number;
            }else{
                return($order_number.$this->uniqueNumberDifferentiator());
            }
        }
        
        
        /**
         * This is the function that gets the member city number
         */
        public function getThisMemberCityNumber($member_id){
            
                 $model = new Members;
                
                return $model->getThisMemberCityNumber($member_id);
            
        }
        
        
        /**
         * This is the function that will get the last four digits of a members membership number
         */
        public function getTheLastSevenDigitsOfThisMemberMembershipNumber($member_id){
            
                $model = new Members;
                
               return  $model->getTheLastFourDigitsOfThisMemberMembershipNumber($member_id);
            
        }
        
        
         /**
         * This is the function that gets the new unique number differentiator
         */
        public function uniqueNumberDifferentiator(){
                
            $model = new PlatformSettings;
                             
            return $model->uniqueNumberDifferentiator();
                
        }
        
        
            /**
         * This is the function that verifies the existence of an order number
         */
        public function isOrderNumberNotAlreadyExisting($order_number){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('order')
                    ->where("order_number = '$order_number'");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
            
            
        }
        
        
        /**
         * This is the function that gets the date an order was initiated
         */
        public function getTodayDateForThisOrder(){
            
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            $dated = $today['year'].$today['mon'].$today['mday'];
            
            return $dated;
        }
      
        
        
        /**
         * This is the function that confirms if start validity date is valid
         */
        public function isTodayGreaterThanOrEqualToStartValidityDate($today, $start_date){
            
            if(($today['year'] - $start_date['year'])>0){
                return true;
            }else if(($today['year'] - $start_date['year'])<0){
                return false;
            }else{
                if(($today['mon'] - $start_date['mon'])>0){
                    return true;
                }else if(($today['mon'] - $start_date['mon'])<0){
                    return false;
                }else{
                    if(($today['mday'] - $start_date['mday'])>0){
                        return true;
                    }else if(($today['mday'] - $start_date['mday'])==0){
                        return true;
                    }else{
                        return false;
                    }
                }
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
         * This is the function that confirms if an order is open
         */
        public function isOrderOpen($order_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('order')
                    ->where("id= $order_id  and status='open'");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        
        /**
         * This is the function that gets all member orders not exceeding six months
         */
        public function getAllMemberOrdersNotExceedingSixMonths($member_id){
            
            //get all closed orders by this member
            
            $orders = $this->getAllMemberClosedOrders($member_id);
            
            $selected_orders = [];
            
            foreach($orders as $order){
                if($this->isOrderNotExceedingSixMonths($order)){
                    $selected_orders[] = $order;
                }
            }
            return $selected_orders;
        }
        
        
        
         /**
         * This is the function that gets all member orders beyond six months
         */
        public function getAllMemberOrdersBeyondSixMonths($member_id){
            
             //get all closed orders by this member
            
            $orders = $this->getAllMemberClosedOrders($member_id);
            
            $selected_orders = [];
            
            foreach($orders as $order){
                if($this->isOrderNotExceedingSixMonths($order)==false){
                    $selected_orders[] = $order;
                }
            }
            return $selected_orders;
            
        }
        
        
        /**
         * This is the function that retrieves all closed member orders
         */
        public function getAllMemberClosedOrders($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='order_initiated_by=:orderedby and status=:status';
                $criteria->params = array(':orderedby'=>$member_id,':status'=>'closed');
                $orders= Order::model()->findAll($criteria);
                
                $all_orders = [];
                foreach($orders as $order){
                    $all_orders[] = $order['id'];
                }
                
                return $all_orders;
            
        }
        
        
        
        /**
         * This is the function that confirms if an order is not more that six months
         */
        public function isOrderNotExceedingSixMonths($order_id){
            
            //get the date this order was initiated
            $ordered_date = $this->getTheInitiationDateOfThisOrder($order_id);
            
            if($this->isThisDateNotExceedingSixMonthsFromToday($ordered_date)){
                return true;
            }else{
                return false;
            }
        }
       
        
        /**
         * This is the function that gets the date an order was initiated
         */
        public function getTheInitiationDateOfThisOrder($order_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$order_id);
                $order= Order::model()->find($criteria);
                
                return $order['order_initiation_date'];
            
        }
        
        
        /**
         * This is the function that confirms if  a date is not exceeding six months from today
         */
        public function isThisDateNotExceedingSixMonthsFromToday($ordered_date){
            
           $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
             $date_of_order = getdate(strtotime($ordered_date));
             
             if(($today['year'] - $date_of_order['year'])>1 ){
                 return false;
             }else{
                 if(($today['mon'] - $date_of_order['mon'])>6){
                     return false;
                 }else{
                     return true;
                 }
             }
             
         
             
        }
        
        
        /**
         * This is the function that gets the order number of an order
         */
        public function getTheOrderNumberOfThisOrder($order_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$order_id);
                $order= Order::model()->find($criteria);
                
                return $order['order_number'];
        }
       
        
        
        /**
         * This is the function that gets an order's city of delivery
         */
        public function getThisOrderCityOfDelivery($order_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$order_id);
                $order= Order::model()->find($criteria);
                
                return $order['delivery_city_id'];
        }
        
        
        /**
         * This is the function that gets all the closed orders for a user
         */
        public function getAllClosedOrdersByThisUser($user_id){
            
            $model = new Payment;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='status=:status and order_initiated_by=:userid';
            $criteria->params = array(':status'=>"closed",':userid'=>$user_id);
            $orders= Order::model()->findAll($criteria);
            
            $all_orders = [];
            foreach($orders as $order){
                if($model->isThisOrderPaymentConfirmed($order['id'])){
                    $all_orders[] = $order['id'];
                }
                
            }
            
            return $all_orders;
            
            
            
        }
      
        
        
        
}
