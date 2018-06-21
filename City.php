<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $state_id
 * @property string $zip_code
 * @property string $city_number
 * @property integer $location_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property State $state
 * @property Members[] $members
 */
class City extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, state_id', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			//array('description', 'length', 'max'=>150),
			array('state_id, zip_code', 'length', 'max'=>10),
			array('city_number', 'length', 'max'=>2),
			array('description,create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, state_id, zip_code, city_number,create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
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
			'state' => array(self::BELONGS_TO, 'State', 'state_id'),
			'members' => array(self::HAS_MANY, 'Members', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'state_id' => 'State',
			'zip_code' => 'Zip Code',
			'city_number' => 'City Number',
			'location_id' => 'Location',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('state_id',$this->state_id,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('city_number',$this->city_number,true);
		$criteria->compare('location_id',$this->location_id);
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
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
       /**
        * This is the function that gets the code of a city
        */
        public function getThisCityNumberCode($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $city= City::model()->find($criteria);
                
                return $city['city_number'];
        }
        
        
        /**
         * This is the function that gets this city's new sequence number 
         */
        public function getThisCityNewPaddedSequenceNumber($id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $city= City::model()->find($criteria);
                
                $new_sequence_number = $city['number_sequence'] + 1;
                
                if($this->isSequenceNumberIncremented($new_sequence_number,$city['id'])){
                    return $this->paddedNewSequenceNumber($new_sequence_number);
                }else{
                    return $this->paddedNewSequenceNumber($city['number_sequence']);
                }
        }
        
        
        /**
         * This is the function that retrieves a padded number 
         */
        public function paddedNewSequenceNumber($new_sequence_number){
            
            $number_length = 7;
            return $this->number_pad($new_sequence_number,$number_length);
            
        }
        
        
        public function number_pad($number,$number_length){
            
            return str_pad((int) $number,$number_length,"0",STR_PAD_LEFT);
            
        }
        
        
        
        /**
         * This is the function that determines if sequence number had been incremented
         */
        public function isSequenceNumberIncremented($new_sequence_number,$id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('city',
                         array('number_sequence'=>$new_sequence_number,
                             
                        ),
                        ("id=$id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        /**
         * This is the function that gets the name of a city
         */
        public function getThisCityName($city_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$city_id);
             $city= City::model()->find($criteria);
             return $city['name'];
        }
        
        
        /**
         * This is the function that gets an existing city number
         */
        public function getTheExistingCityNumber($city_id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$city_id);
             $city= City::model()->find($criteria);
             return $city['city_number'];
        }
  
        
        /**
         * This is the function that gets the cost of delivery to a city
         */
        public function getTheCostOfHamperDeliveryToThisCity($hamper_id,$city_id,$delivery_type){
            $model = new Product;
            //get the total weight of the hamper
            $hamper_weight = $model->getTheTotalWeightOfThisHamper($hamper_id);
            
            //get the cost of delivery of this hamper in this city
            $ideal_hamper_delivery_cost = $hamper_weight * $this->getThisHamperDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_id,$delivery_type);
            
            if($ideal_hamper_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_id,$delivery_type)){
                return $ideal_hamper_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_id,$delivery_type);
            }
  
    
        }
        
        /**
         * This is the function that gets the hamper delivery cost per kg for a city
         */
        public function getThisHamperDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_id,$delivery_type){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$city_id);
             $city= City::model()->find($criteria);
             
             if($delivery_type == strtolower('standard')){
                 return $city['standard_delivery_price_per_kg'];
             }else if($delivery_type == strtolower('priority')){
                 return $city['priority_delivery_price_per_kg'];
             }else if($delivery_type == strtolower('top')){
                 return $city['top_priority_delivery_price_per_kg'];
             }
        }
        
        /**
         * This is the function that returns the minimum delivery cost per delivery type
         */
        public function minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_id,$delivery_type){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$city_id);
             $city= City::model()->find($criteria);
             
             if($delivery_type == strtolower('standard')){
                 return $city['minimum_standard_delivery_amount'];
             }else if($delivery_type == strtolower('priority')){
                 return $city['minimum_priority_delivery_amount'];
             }else if($delivery_type == strtolower('top')){
                 return $city['minimum_top_priority_delivery_amount'];
             }
        }
        
        
        /**
         * This is the function that retrieves the minimum number required for mass discount for a delivery type
         */
        public function getTheMinimumBeneficiaryNumberRequiredForMassDeliveryDiscountForThisCity($city_id,$delivery_type){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$city_id);
             $city= City::model()->find($criteria);
             
             if($delivery_type == strtolower('standard')){
                 return $city['standard_minimum_mass_delivery_number'];
             }else if($delivery_type == strtolower('priority')){
                 return $city['priority_minimum_mass_delivery_number'];
             }else if($delivery_type == strtolower('top')){
                 return $city['top_priority_minimum_mass_delivery_number'];
             }
            
        }
        
        
        /**
         * This is the function that retrieves the mass delivery discount rate for a city
         */
        public function getThisCityMassDeliveryDiscountRate($city_id,$delivery_type){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$city_id);
             $city= City::model()->find($criteria);
             
             if($delivery_type == strtolower('standard')){
                 return $city['standard_discount_rate_for_mass_delivery'];
             }else if($delivery_type == strtolower('priority')){
                 return $city['priority_discount_rate_for_mass_delivery'];
             }else if($delivery_type == strtolower('top')){
                 return $city['top_priority_discount_rate_for_mass_delivery'];
             }
        }
        
        
        /**
         * This is the function that gets the cost of Order delivery to a city by top priority
         */
        public function getTheCostOfOrderDeliveryToThisCityForTopPriority($order_id,$city_of_delivery){
            
            $model = new Product;
            
            $delivery_type = strtolower('top');
            //get the total weight of the order
            $order_weight = $model->getTheTotalWeightOfThisOrder($order_id);
            
            //get the cost of delivery of this order in this city
            $ideal_order_delivery_cost = $order_weight * $this->getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_of_delivery,$delivery_type);
            
            if($ideal_order_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type)){
                return $ideal_order_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type);
            }
        }
        
        
        
         /**
         * This is the function that gets the cost of Order delivery to a city by priority
         */
        public function getTheCostOfOrderDeliveryToThisCityForPriority($order_id,$city_of_delivery){
            
            $model = new Product;
            
            $delivery_type = strtolower('priority');
            //get the total weight of the order
            $order_weight = $model->getTheTotalWeightOfThisOrder($order_id);
            
            //get the cost of delivery of this order in this city
            $ideal_order_delivery_cost = $order_weight * $this->getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_of_delivery,$delivery_type);
            
            if($ideal_order_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type)){
                return $ideal_order_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type);
            }
        }
        
        
        
         /**
         * This is the function that gets the cost of Order delivery to a city by standard
         */
        public function getTheCostOfOrderDeliveryToThisCityForStandard($order_id,$city_of_delivery){
            
            $model = new Product;
            
            $delivery_type = strtolower('standard');
            //get the total weight of the order
            $order_weight = $model->getTheTotalWeightOfThisOrder($order_id);
            
            //get the cost of delivery of this order in this city
            $ideal_order_delivery_cost = $order_weight * $this->getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_of_delivery,$delivery_type);
            
            if($ideal_order_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type)){
                return $ideal_order_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type);
            }
        }
        
        
        /**
         * This is the function that gets a order delivery cost per kg
         */
        public function getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_id,$delivery_type) {
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$city_id);
             $city= City::model()->find($criteria);
             
             if($delivery_type == strtolower('standard')){
                 return $city['standard_delivery_price_per_kg'];
             }else if($delivery_type == strtolower('priority')){
                 return $city['priority_delivery_price_per_kg'];
             }else if($delivery_type == strtolower('top')){
                 return $city['top_priority_delivery_price_per_kg'];
             }
            
        }
          
        
        
        /**
         * This is the function that obtains a delivery charge of an order when some part of an order will not be settled
         */
        public function getTheRecalculatedDeliveryChargeForThisTransaction($order_id,$wallet_id,$delivery_type){
            
            $model = new Product;
            
            $delivery_type = strtolower($delivery_type);
            //get the total weight of the order
            $order_weight = $model->getTheTotalWeightOfDeliverableContentsInAnOrder($order_id,$wallet_id);
            
            //get this order city of delivery
            
            $city_of_delivery = $this->getThisOrderCityOfDelivery($order_id);
            
            //get the cost of delivery of this order in this city
            $ideal_order_delivery_cost = $order_weight * $this->getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_of_delivery,$delivery_type);
            
            if($ideal_order_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type)){
                return $ideal_order_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type);
            }
        }
        
        
        /**
         * This is the function that gets this order city of delivery
         */
        public function getThisOrderCityOfDelivery($order_id){
            $model = new Order;
            return $model->getThisOrderCityOfDelivery($order_id);
        }
       
        
        
        /**
         * This is the function that gets the direct cost of a product
         */
        public function getTheDirectCostOfDeliveryOfThisProduct($product_total_weight,$city_of_delivery,$payment_method,$delivery_type){
            
            $model = new Product;
            
            if($delivery_type == strtolower('standard')){
                $cost_of_delivery = $this->getTheCostOfProductDeliveryForStandard($product_total_weight,$city_of_delivery,$delivery_type);
            }else if($delivery_type == strtolower('priority')){
                $cost_of_delivery = $this->getTheCostOfProductDeliveryForPriority($product_total_weight,$city_of_delivery,$delivery_type);
            }else if($delivery_type == strtolower('top')){
                 $cost_of_delivery = $this->getTheCostOfProductDeliveryForTopPriority($product_total_weight,$city_of_delivery,$delivery_type);
            }
            return $cost_of_delivery;
        }
        
        
        /**
         * This is the function that get the cost of product delivery for standard delivery methos
         */
        public function getTheCostOfProductDeliveryForStandard($product_total_weight,$city_of_delivery,$delivery_type){
            
            $model = new Product;
            
            //$delivery_type = strtolower('standard');
            //get the total weight of the product in the order
            $product_weight = $product_total_weight;
            
            //get the cost of delivery of this product in this city
            $ideal_order_delivery_cost = $product_weight * $this->getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_of_delivery,$delivery_type);
            
            if($ideal_order_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type)){
                return $ideal_order_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type);
            }
        }
        
        
        /**
         * This is the function that gets the cost of delivery of a product to a city for priority
         */
        public function getTheCostOfProductDeliveryForPriority($product_total_weight,$city_of_delivery,$delivery_type){
            $model = new Product;
            
            //$delivery_type = strtolower('priority');
            //get the total weight of the product in the order
            $product_weight = $product_total_weight;
            
            //get the cost of delivery of this product in this city
            $ideal_order_delivery_cost = $product_weight * $this->getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_of_delivery,$delivery_type);
            
            if($ideal_order_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type)){
                return $ideal_order_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type);
            } 
        }
        
        
         /**
         * This is the function that gets the cost of delivery of a product to a city for top priority
         */
        public function getTheCostOfProductDeliveryForTopPriority($product_total_weight,$city_of_delivery,$delivery_type){
            $model = new Product;
            
           // $delivery_type = strtolower('top');
            //get the total weight of the product in the order
            $product_weight = $product_total_weight;
            
            //get the cost of delivery of this product in this city
            $ideal_order_delivery_cost = $product_weight * $this->getThisOrderDeliveryCostPerKgInThisCityUsingThisDeliveryType($city_of_delivery,$delivery_type);
            
            if($ideal_order_delivery_cost >= $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type)){
                return $ideal_order_delivery_cost;
            }else{
                return $this->minimumRequiredDeliveryOfThisDeliveryTypeInThisCity($city_of_delivery,$delivery_type);
            } 
        }
        
        
        /**
         * This is the function that confirms if payment on delivery is acceptable in a city
         */
        public function isOrderCityOfDeliveryAcceptPaymentOnDelivery($order_id){
            $model = new Order;
            
            //get the city of delivery of this order
            $city_of_delivery = $model->getThisOrderCityOfDelivery($order_id);
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$city_of_delivery);
            $city= City::model()->find($criteria);
            
            if($city['accept_payment_on_delivery'] == 1){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that confirms if payment on delivery is accepted in a city
         */
        public function isPaymentOnDeliveryAllowedInThisCity($city_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$city_id);
            $city= City::model()->find($criteria);
            
            if($city['accept_payment_on_delivery'] == 1){
                return true;
            }else{
                return false;
            }
        }

}
