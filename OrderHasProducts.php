<?php

/**
 * This is the model class for table "order_has_products".
 *
 * The followings are the available columns in table 'order_has_products':
 * @property string $order_id
 * @property string $product_id
 * @property string $store_id
 * @property integer $number_of_portion
 * @property string $date_ordered
 * @property string $date_last_update
 * @property integer $ordered_by
 * @property integer $updated_by
 */
class OrderHasProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_has_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, store_id', 'required'),
			array('number_of_portion, ordered_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('order_id, product_id, store_id', 'length', 'max'=>10),
			array('date_ordered, date_last_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, product_id, store_id, number_of_portion, date_ordered, date_last_update, ordered_by, updated_by', 'safe', 'on'=>'search'),
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
			'order_id' => 'Order',
			'product_id' => 'Product',
			'store_id' => 'Store',
			'number_of_portion' => 'Number Of Portion',
			'date_ordered' => 'Date Ordered',
			'date_last_update' => 'Date Last Update',
			'ordered_by' => 'Ordered By',
			'updated_by' => 'Updated By',
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

		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('number_of_portion',$this->number_of_portion);
		$criteria->compare('date_ordered',$this->date_ordered,true);
		$criteria->compare('date_last_update',$this->date_last_update,true);
		$criteria->compare('ordered_by',$this->ordered_by);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderHasProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * This is the function that gets the gross amount of products in the cart
         */
        public function getTheTotalGrossAmountOfProductsInTheCart($order_id){
            
            //$model = new Product;
            
            //get all the products in this order
            $products = $this->getAllProductsInThisOrder($order_id);
            
            $sum = 0;
            
            foreach($products as $product){
                
                if($this->isThisProductAPresubscriptionDrawdown($order_id,$product) == false){
                     //get the portion of this product in the cart
                     $number_of_portion = $this->getThePortionOfThisProductInThisOrder($order_id,$product);
                     if($this->isThisARentTransaction($order_id,$product)){
                         //get the rent duration
                         $duration = $this->getTheDurationOfThisRentTransaction($order_id,$product);
                          $sum = $sum + ($this->getThisProductPriceInThisOrder($product,$order_id) * $number_of_portion * $duration);
                     }else if($this->isThisAPaasTransaction($order_id,$product)){
                         $paas_duration = $this->getTheDurationofThisPaasTransaction($order_id,$product);
                         $sum = $sum + ($this->getThisProductPriceInThisOrder($product,$order_id) * $number_of_portion * $paas_duration);
                         
                     }else if($this->isThisAFaasTransaction($order_id,$product)){
                        $faas_duration = $this->getTheDurationofThisFaasTransaction($order_id,$product);
                         $sum = $sum + ($this->getThisProductPriceInThisOrder($product,$order_id) * $number_of_portion * $faas_duration); 
                         
                     }else{
                          $sum = $sum + ($this->getThisProductPriceInThisOrder($product,$order_id) * $number_of_portion);
                     }
                     
                    
                }
               
            }
            
            return $sum;
           
    
            
        }
        
        
        /**
         * This is the function that confirms if a transaction is a rent transactiom
         */
        public function isThisARentTransaction($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['decision'] == 'rent'){
                 return true;
             }else{
                 return false;
             }
        }
        
        /**
         * This is the function that determines if a transacation is a paas transaction
         */
        public function isThisAPaasTransaction($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['decision'] == 'paas'){
                 return true;
             }else{
                 return false;
             }
        }
        
        
         /**
         * This is the function that determines if a transacation is a faas transaction
         */
        public function isThisAFaasTransaction($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['decision'] == 'faas'){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that retrieves the duration of a paas transaction
         */
        public function getTheDurationofThisPaasTransaction($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             return $order['actual_paas_duration'];
            
        }
        
        
         /**
         * This is the function that retrieves the duration of a paas transaction
         */
        public function getTheDurationofThisFaasTransaction($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             return $order['actual_faas_duration'];
            
        }
        
        
        /**
         * This is the function that gets the rent duration of a rented transaction in the cart
         */
        public function getTheDurationOfThisRentTransaction($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             return $order['actual_rent_duration'];
            
        }
        
        /**
         * This is the function that determines if a transaction in cart is a presubscription drawdown
         */
        public function isThisProductAPresubscriptionDrawdown($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['is_presubscription_drawdown'] == 1){
                 return true;
             }else{
                 return false;
             }
        }
        
        
         /**
         * This is the function that gets a product price in an order
         */
        public function getThisProductPriceInThisOrder($product_id,$order_id){
            
            $model = new Order;
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:id and product_id=:productid';
             $criteria->params = array(':id'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             $order_start_price_validity_date = $this->getThisOrderStartPriceValidityDate($order['order_id'],$order['product_id']); 
            
            $order_end_price_validity_date = $this->getThisOrderEndPriceValidityDate($order['order_id'],$order['product_id']); 
            
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            
             if($model->isTodayGreaterThanOrEqualToStartValidityDate($today, $order_start_price_validity_date)){
                    if($model->isTodayLessThanOrEqualToEndValidityDate($today,$order_end_price_validity_date)){
                            return  $order['cobuy_member_price_per_item_at_purchase'];
                        }else{
                             return $order['prevailing_retail_selling_price_per_item_at_purchase'];
                        }
                        
                    }else{
                         return $order['prevailing_retail_selling_price_per_item_at_purchase'];
                    }
        }
        
        /**
         * This is the function that gets the discount of all the products in the cart
         */
        public function getTheTotalDiscountAmountOfProductsInTheCart($order_id){
            $model = new Product;
            
            //get all the products in this order
            $products = $this->getAllProductsInThisOrder($order_id);
            
            $sum = 0;
            foreach($products as $product){
                
                 if($this->isThisProductAPresubscriptionDrawdown($order_id,$product)==false){
                     //get the portion of this product in the cart
                    $number_of_portion = $this->getThePortionOfThisProductInThisOrder($order_id,$product);
                    $sum = $sum + ($model->getThePerPortionDiscountAmountOfThisProduct($product,$order_id) * $number_of_portion );
                 }
                
            }
      
            return $sum;
            
        }
        
        
        /**
         * This is the function that gets all the products in this order
         */
        public function getAllProductsInThisOrder($order_id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:id';
             $criteria->params = array(':id'=>$order_id);
             $orders= OrderHasProducts::model()->findAll($criteria);
             
             $products = [];
             foreach($orders as $order){
                 $products[] = $order['product_id'];
             }
             
             return  $products;
        }
        
        
        /**
         * This is the function that retrieves the portion/quantity of a product ordered for
         */
        public function getThePortionOfThisProductInThisOrder($order_id,$product){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product);
             $orders= OrderHasProducts::model()->find($criteria);
             
             return $orders['number_of_portion'];
        }
        
        
        /**
         * This is the function that gets the retail selling price from an order
         */
        public function getTheRetailSellingPriceFromThisOrder($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasProducts::model()->find($criteria);
             
             return $orders['prevailing_retail_selling_price_per_item_at_purchase'];
            
        }
        
        
         /**
         * This is the function that gets the member selling price from an order
         */
        public function getTheMemberSellingPriceFromThisOrder($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasProducts::model()->find($criteria);
             
             return $orders['cobuy_member_price_per_item_at_purchase'];
            
        }
        
       
        
       
        
        
        
        /**
         * This is the function that adds new product to cart
         */
        public function isThisOrderSuccessfullyAddedToCart($order_id,$product_id,$quantity_of_purchase,$amount_saved_on_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$start_price_validity_period,$end_price_validity_period,$is_escrow_only,$is_escrow_accepted,$is_quote_only,$is_quote_and_escrow,$is_presubscription,$is_presubscription_and_escrow,$is_presubscription_and_drawdown,$is_postsubscription,$is_postsubscription_and_escrow,$is_hamper,$is_mainstore,$is_for_presubscription_topup,$future_trading,$month_of_delivery,$year_of_delivery,$initial_payment_rate,$payment_frequency,$decision,$monthly_paas_subscription_cost,$minimum_quantity_for_paas_subscription,$maximum_quantity_for_paas_subscription,$rent_cost_per_day,$maximum_rent_quantity_per_cycle,$minimum_rent_duration,$minimum_rent_quantity_per_cycle,$actual_rent_duration,$actual_rent_quantity,$paas_product_quantity,$minimum_paas_duration,$maximum_paas_duration,$actual_paas_duration){
            
            //confirm if that product is not already in the cart
            if($this->isProductNotAlreadyInTheCart($order_id,$product_id)){
                if($this->isAddingThisProductToCartASuccess($order_id,$product_id,$quantity_of_purchase,$amount_saved_on_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$start_price_validity_period,$end_price_validity_period,$is_escrow_only,$is_escrow_accepted,$is_quote_only,$is_quote_and_escrow,$is_presubscription,$is_presubscription_and_escrow,$is_presubscription_and_drawdown,$is_postsubscription,$is_postsubscription_and_escrow,$is_hamper,$is_mainstore,$is_for_presubscription_topup,$future_trading,$month_of_delivery,$year_of_delivery,$initial_payment_rate,$payment_frequency,$decision,$monthly_paas_subscription_cost,$minimum_quantity_for_paas_subscription,$maximum_quantity_for_paas_subscription,$rent_cost_per_day,$maximum_rent_quantity_per_cycle,$minimum_rent_duration,$minimum_rent_quantity_per_cycle,$actual_rent_duration,$actual_rent_quantity,$paas_product_quantity,$minimum_paas_duration,$maximum_paas_duration,$actual_paas_duration)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that updates the escrow status of a transaction in cart
         */
        public function isTheUpdateOfTheEscrowStatusOfATransactionASuccess($order_id,$product_id,$is_escrowed,$is_escrow_accepted){
            
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('order_has_products',
                         array('is_escrowed'=>$is_escrowed,
                           'is_escrow_accepted'=>$is_escrow_accepted,
                           
                             
                        ),
                        ("order_id=$order_id and product_id=$product_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that confirms if product is not already in the cart
         */
        public function isProductNotAlreadyInTheCart($order_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('order_has_products')
                    ->where("order_id= $order_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that adds product to cart
         */
        public function isAddingThisProductToCartASuccess($order_id,$product_id,$quantity_of_purchase,$amount_saved_on_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$start_price_validity_period,$end_price_validity_period,$is_escrow_only,$is_escrow_accepted,$is_quote_only,$is_quote_and_escrow,$is_presubscription,$is_presubscription_and_escrow,$is_presubscription_and_drawdown,$is_postsubscription,$is_postsubscription_and_escrow,$is_hamper,$is_mainstore,$is_for_presubscription_topup,$future_trading,$month_of_delivery,$year_of_delivery,$initial_payment_rate,$payment_frequency,$decision,$monthly_paas_subscription_cost,$minimum_quantity_for_paas_subscription,$maximum_quantity_for_paas_subscription,$rent_cost_per_day,$maximum_rent_quantity_per_cycle,$minimum_rent_duration,$minimum_rent_quantity_per_cycle,$actual_rent_duration,$actual_rent_quantity,$paas_product_quantity,$minimum_paas_duration,$maximum_paas_duration,$actual_paas_duration){
            
            if($decision == 'buy'){
                
                if($future_trading == 0){
                     $prevailing_retail_selling_price_value = $prevailing_retail_selling_price;
                     $cobuy_member_selling_price_value = $cobuy_member_selling_price;
                
                }else{
                    $prevailing_retail_selling_price_value =$prevailing_retail_selling_price * $initial_payment_rate;
                    $cobuy_member_selling_price_value = $cobuy_member_selling_price *$initial_payment_rate;
                }
                $amount_saved_per_item_on_this_order =($amount_saved_on_purchase/$quantity_of_purchase);
                $quantity_of_purchases = $quantity_of_purchase;
                
            }else if($decision == 'rent'){
                $prevailing_retail_selling_price_value = $rent_cost_per_day;
                $cobuy_member_selling_price_value = $rent_cost_per_day;
                $amount_saved_per_item_on_this_order = 0;
                $quantity_of_purchases=$actual_rent_quantity;
            }else if($decision == 'paas'){
                $prevailing_retail_selling_price_value = $monthly_paas_subscription_cost;
                $cobuy_member_selling_price_value = $monthly_paas_subscription_cost;
                $amount_saved_per_item_on_this_order=0;
                $quantity_of_purchases=$paas_product_quantity;
                $minimum_paas_duration = $minimum_paas_duration;
                $maximum_paas_duration=$maximum_paas_duration;
                $actual_paas_duration=$actual_paas_duration;
            }
            
            
            
          
            
            
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('order_has_products',
                         array('order_id'=>$order_id,
                                'product_id' =>$product_id,
                                'number_of_portion'=>$quantity_of_purchases,
                                 'amount_saved_per_item_on_this_order'=>$amount_saved_per_item_on_this_order,
                                 'prevailing_retail_selling_price_per_item_at_purchase'=>$prevailing_retail_selling_price_value,
                                 'cobuy_member_price_per_item_at_purchase'=>$cobuy_member_selling_price_value,
                                 'is_escrow_only'=>$is_escrow_only,
                                 'is_quote_only'=>$is_quote_only,
                                 'is_quote_and_escrow_only'=>$is_quote_and_escrow,
                                 'is_presubscription'=>$is_presubscription,
                                 'is_presubscription_and_escrow'=>$is_presubscription_and_escrow,
                                 'is_presubscription_drawdown'=>$is_presubscription_and_drawdown,
                                 'is_postsubscription'=>$is_postsubscription,
                                 'is_postsubscription_and_escrow'=>$is_postsubscription_and_escrow,
                                 'is_hamper'=>$is_hamper,
                                 'is_mainstore'=>$is_mainstore,
                                 'is_presubscription_topup'=>$is_for_presubscription_topup,
                                 'future_trading'=>$future_trading,
                                 'month_of_delivery'=>$month_of_delivery,
                                 'year_of_delivery'=>$year_of_delivery,
                                 'initial_payment_rate'=>$initial_payment_rate,
                                 'payment_frequency'=>$payment_frequency,
                                 'is_escrow_accepted'=>$is_escrow_accepted,
                                 'start_price_validity_period'=>$start_price_validity_period,
                                 'end_price_validity_period'=>$end_price_validity_period,
                                 'decision'=>$decision,
                                 'minimum_rent_duration'=>$minimum_rent_duration,
                                 'minimum_rent_quantity_per_cycle'=>$minimum_rent_quantity_per_cycle,
                                 'actual_rent_duration'=>$actual_rent_duration,
                                 'actual_rent_quantity'=>$actual_rent_quantity,
                                 'paas_product_quantity'=>$paas_product_quantity,
                                 'maximum_rent_quantity_per_cycle'=>$maximum_rent_quantity_per_cycle,
                                 'minimum_quantity_for_paas_subscription'=>$minimum_quantity_for_paas_subscription,
                                 'maximum_quantity_for_paas_subscription'=>$maximum_quantity_for_paas_subscription,
                                 'monthly_paas_subscription_cost'=>$monthly_paas_subscription_cost,
                                 'minimum_paas_duration'=>$minimum_paas_duration,
                                 'maximum_paas_duration'=>$maximum_paas_duration,
                                 'actual_paas_duration'=>$actual_paas_duration,
                                 'date_ordered'=>new CDbExpression('NOW()'),
                                 'ordered_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
            
            
        }
        
        
        /**
         * This is the function that adds a product and its constituents to cart
         */
        public function isThisProductWithConstituentOrderSuccessfullyAddedToCart($order_id,$product_id,$quantity_of_purchase,$amount_saved_on_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$start_price_validity_period,$end_price_validity_period,$is_escrow_only,$is_escrow_accepted,$is_quote_only,$is_quote_and_escrow,$is_presubscription,$is_presubscription_and_escrow,$is_presubscription_and_drawdown,$is_postsubscription,$is_postsubscription_and_escrow,$is_hamper,$is_mainstore,$is_for_presubscription_topup,$future_trading,$month_of_delivery,$year_of_delivery,$initial_payment_rate,$payment_frequency,$decision,$monthly_paas_subscription_cost,$minimum_quantity_for_paas_subscription,$maximum_quantity_for_paas_subscription,$rent_cost_per_day,$maximum_rent_quantity_per_cycle,$minimum_rent_duration,$minimum_rent_quantity_per_cycle,$actual_rent_duration,$actual_rent_quantity,$paas_product_quantity,$minimum_paas_duration,$maximum_paas_duration,$actual_paas_duration){
           if($this->isProductNotAlreadyInTheCart($order_id,$product_id)){
                 if($this->isAddingThisProductWithConstituentToCartASuccess($order_id,$product_id,$quantity_of_purchase,$amount_saved_on_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$start_price_validity_period,$end_price_validity_period,$is_escrow_only,$is_escrow_accepted,$is_quote_only,$is_quote_and_escrow,$is_presubscription,$is_presubscription_and_escrow,$is_presubscription_and_drawdown,$is_postsubscription,$is_postsubscription_and_escrow,$is_hamper,$is_mainstore,$is_for_presubscription_topup,$future_trading,$month_of_delivery,$year_of_delivery,$initial_payment_rate,$payment_frequency,$decision,$monthly_paas_subscription_cost,$minimum_quantity_for_paas_subscription,$maximum_quantity_for_paas_subscription,$rent_cost_per_day,$maximum_rent_quantity_per_cycle,$minimum_rent_duration,$minimum_rent_quantity_per_cycle,$actual_rent_duration,$actual_rent_quantity,$paas_product_quantity,$minimum_paas_duration,$maximum_paas_duration,$actual_paas_duration)){
                     return true;
                 }else {
                     return false;
                 }
                
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that adds a product with constituents to cart
         */
        public function isAddingThisProductWithConstituentToCartASuccess($order_id,$product_id,$quantity_of_purchase,$amount_saved_on_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$start_price_validity_period,$end_price_validity_period,$is_escrow_only,$is_escrow_accepted,$is_quote_only,$is_quote_and_escrow,$is_presubscription,$is_presubscription_and_escrow,$is_presubscription_and_drawdown,$is_postsubscription,$is_postsubscription_and_escrow,$is_hamper,$is_mainstore,$is_for_presubscription_topup,$future_trading,$month_of_delivery,$year_of_delivery,$initial_payment_rate,$payment_frequency,$decision,$monthly_paas_subscription_cost,$minimum_quantity_for_paas_subscription,$maximum_quantity_for_paas_subscription,$rent_cost_per_day,$maximum_rent_quantity_per_cycle,$minimum_rent_duration,$minimum_rent_quantity_per_cycle,$actual_rent_duration,$actual_rent_quantity,$paas_product_quantity,$minimum_paas_duration,$maximum_paas_duration,$actual_paas_duration){
            $model = new OrderHasConstituents;
            if($this->isAddingThisProductToCartASuccess($order_id,$product_id,$quantity_of_purchase,$amount_saved_on_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$start_price_validity_period,$end_price_validity_period,$is_escrow_only,$is_escrow_accepted,$is_quote_only,$is_quote_and_escrow,$is_presubscription,$is_presubscription_and_escrow,$is_presubscription_and_drawdown,$is_postsubscription,$is_postsubscription_and_escrow,$is_hamper,$is_mainstore,$is_for_presubscription_topup,$future_trading,$month_of_delivery,$year_of_delivery,$initial_payment_rate,$payment_frequency,$decision,$monthly_paas_subscription_cost,$minimum_quantity_for_paas_subscription,$maximum_quantity_for_paas_subscription,$rent_cost_per_day,$maximum_rent_quantity_per_cycle,$minimum_rent_duration,$minimum_rent_quantity_per_cycle,$actual_rent_duration,$actual_rent_quantity,$paas_product_quantity,$minimum_paas_duration,$maximum_paas_duration,$actual_paas_duration)){
                if($model->isAddingProductConstituentsToCartASuccess($order_id,$product_id)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that retrieves the quantity ordered for by a member
         */
        public function getThisProductQuantityOfPurchaseByThisMember($member_id,$product_id){
            
            $model = new Order;
            
            //get the open order belonging to this member
            $order_id = $model->getTheOpenOrderInitiatedByMember($member_id);
            return $this->getThePortionOfThisProductInThisOrder($order_id,$product_id);
        }
        
        
        /**
         * This is the function that ensures the removal of a product from the cart
         */
        public function isRemovalOfThisProductFromCartForThisMemberSuccessful($member_id,$product_id){
            
            $model = new Order;

            //get this member open order
            $order_id = $model->getTheOpenOrderInitiatedByMember($member_id);
            if($this->doesProductHaveConstituents($product_id)== false){
              if($this->isProductNotAlreadyInTheCart($order_id,$product_id)== false){
                
                if($this->isRemovalOfThisProductSuccessful($order_id,$product_id)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
                
                
            }else{
                if($this->isProductNotAlreadyInTheCart($order_id,$product_id)== false){
                
                if($this->isRemovalOfThisProductWithConstituentsSuccessful($order_id,$product_id)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
            }
               
        }
        
        
        
        /**
         * This is the function that determines if a product has constituents
         */
        public function doesProductHaveConstituents($product_id){
            $model = new ProductConstituents;
            
            return $model->doesProductHaveConstituents($product_id);
        }
        
        /**
         * This is the function that ensures the removal of a product from the cart 
         */
        public function isRemovalOfThisProductSuccessful($order_id,$product_id){
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('order_has_products', 'order_id=:orderid and product_id=:productid', array(':orderid'=>$order_id,':productid'=>$product_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the functin that effects changes in the products in the cart
         */
        public function isSavingOfChangesInThisProductInCartSuccessful($member_id,$product_id,$quantity_of_purchase,$prevailing_retail_selling_price,$cobuy_member_price,$start_price_validity_period,$end_price_validity_period, $amount_save_on_purchase){
            
            $model = new Order;

            //get this member open order
            $order_id = $model->getTheOpenOrderInitiatedByMember($member_id);
            if($this->isProductNotAlreadyInTheCart($order_id,$product_id)== false){
                
                if($this->isEffectingChangesOfThisProductSuccessful($order_id,$product_id,$quantity_of_purchase,$prevailing_retail_selling_price,$cobuy_member_price,$start_price_validity_period,$end_price_validity_period, $amount_save_on_purchase)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
        }
        
        
      
        
        
        /**
         * This is the function that effects product changes in the cart 
         */
        public function isEffectingChangesOfThisProductSuccessful($order_id,$product_id,$quantity_of_purchase,$prevailing_retail_selling_price,$cobuy_member_price,$start_price_validity_period,$end_price_validity_period,$amount_save_on_purchase){
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('order_has_products',
                                  array(
                                    'number_of_portion'=>$quantity_of_purchase,
                                     'prevailing_retail_selling_price_per_item_at_purchase'=>$prevailing_retail_selling_price,
                                     'cobuy_member_price_per_item_at_purchase'=> $cobuy_member_price,
                                      'amount_saved_per_item_on_this_order'=>($amount_save_on_purchase/$quantity_of_purchase),
                                      'start_price_validity_period'=>$start_price_validity_period,
                                      'end_price_validity_period'=>$end_price_validity_period,
                                      'date_last_update'=>new CDbExpression('NOW()')
                                                             
                            ),
                     ("order_id=$order_id and product_id=$product_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        
          /**
         * This is the function that modifies the paramters of rent data
         */
        public function isModifyingTheRentParametersASuccess($order_id,$product_id,$quantity_for_rent,$rent_duration){
            
            if($this->isProductNotAlreadyInTheCart($order_id,$product_id)== false){
                
                if($this->isEffectingChangesOfThisRentedProductSuccessful($order_id,$product_id,$quantity_for_rent,$rent_duration)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
        }
        
        
        /**
         * This is the function that modeifies the paas parameter in cart
         */
        public function ifModifyingThePaasParamerIsASuccess($order_id,$product_id,$paas_product_quantity,$actual_paas_duration){
            
             if($this->isProductNotAlreadyInTheCart($order_id,$product_id)== false){
                
                if($this->isEffectingChangesOfThisPaasProductSuccessful($order_id,$product_id,$paas_product_quantity,$actual_paas_duration)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
        }
        
        
        /**
         * This is the function that effects the product's rent modification in cart
         */
        public function isEffectingChangesOfThisRentedProductSuccessful($order_id,$product_id,$quantity_for_rent,$rent_duration){
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('order_has_products',
                                  array(
                                    'number_of_portion'=>$quantity_for_rent,
                                   'actual_rent_quantity'=>$quantity_for_rent,
                                     'actual_rent_duration'=> $rent_duration,
                                      'date_last_update'=>new CDbExpression('NOW()')
                                                             
                            ),
                     ("order_id=$order_id and product_id=$product_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
         /**
         * This is the function that effects changes to the paas product's service in cart
         */
        public function isEffectingChangesOfThisPaasProductSuccessful($order_id,$product_id,$paas_product_quantity,$actual_paas_duration){
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('order_has_products',
                                  array(
                                    'number_of_portion'=>$paas_product_quantity,
                                   'paas_product_quantity'=>$paas_product_quantity,
                                   'actual_paas_duration'=>$actual_paas_duration,   
                                   'date_last_update'=>new CDbExpression('NOW()')
                                                             
                            ),
                     ("order_id=$order_id and product_id=$product_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that removes products with its constituents
         */
          public function isRemovalOfThisProductWithConstituentsSuccessful($order_id,$product_id){
              
              $model = new ProductConstituents;
              
              $member_id = Yii::app()->user->id;
              //get all of this product constituent
              $constituents = $model->getAllProductConstituents($product_id);
              
              $counter = 0;
              
              foreach($constituents as $constituent){
                  //remove the constituent
                  if($this->isRemovalOfThisConstituentSuccessful($order_id,$constituent)){
                      if($this->isConstituentQuantityAmendedByMember($constituent,$member_id)){
                          if($this->isRemovalOfTheAmendedConstituentSuccessful($constituent,$member_id)){
                              $counter = $counter + 1;
                          }
                      }else{
                          $counter = $counter + 1;
                      }
                      
                  }
              }
              
              if($counter >0){
                if($this->isRemovalOfThisProductSuccessful($order_id,$product_id)){
                    return true;
                }else{
                    return false;
                }
              }else{
                  return false;
              }
              
              
          }   
          
          
          /**
           * This is the function that confirms if a constituent had been amended
           */
          public function isConstituentQuantityAmendedByMember($constituent,$member_id){
              $model = new MemberAmendedConstituents;
              return $model->isConstituentQuantityAmendedByMember($constituent,$member_id);
          }
          
          
          
          /**
           * This is the function that confirms if a constituent had been removed from the temporary table
           */
          public function isRemovalOfTheAmendedConstituentSuccessful($constituent,$member_id){
              $model = new MemberAmendedConstituents;
              return $model->isRemovalOfTheAmendedConstituentSuccessful($constituent,$member_id);
          }
          
          /**
           * This is the function that removes constituent from the cart
           */
          public function isRemovalOfThisConstituentSuccessful($order_id,$constituent){
              $model = new OrderHasConstituents;
              
              return $model->isRemovalOfThisConstituentSuccessful($order_id,$constituent);
          }
          
          
           /**
         * This is the function that updates the pack prices after constituents updates
         */
        public function isPackPricesUpdatedSuccessfully($order_id,$product_id,$pack_prevailing_retail_selling_price,$pack_member_selling_price){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('order_has_products',
                         array('prevailing_retail_selling_price_per_item_at_purchase'=>$pack_prevailing_retail_selling_price,
                           'cobuy_member_price_per_item_at_purchase'=>$pack_member_selling_price,
                           
                             
                        ),
                        ("order_id=$order_id and product_id=$product_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        
        /**
         * This is the function that gets the start price validity period
         */
        public function getThisOrderStartPriceValidityDate($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasProducts::model()->find($criteria);
             
             return getdate(strtotime($orders['start_price_validity_period']));
            
        }
        
        
        /**
         * This is the function that gets the end price validity period
         */
        public function getThisOrderEndPriceValidityDate($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasProducts::model()->find($criteria);
             
             return getdate(strtotime($orders['end_price_validity_period']));
            
        }
        
        
        
         /**
         * This is the function that determines if order dates are still valid
         */
        public function isOrderPriceStillValid($order_id,$product_id){
            
            $model = new Order; 
            
            $start_date = $this->getThisOrderStartPriceValidityDate($order_id,$product_id); 
            
            $end_date = $this->getThisOrderEndPriceValidityDate($order_id,$product_id); 
            
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            
             if($end_date != ""){
              
              if($model->isTodayGreaterThanOrEqualToStartValidityDate($today, $start_date)){
                if($model->isTodayLessThanOrEqualToEndValidityDate($today,$end_date)){
                    return true;
                }else{
                    return false;
                }
            }else{
               return false;
            }
              
          }else{
             return true;
          }
        }
       
        /**
         * This is the function that gets all the remaining quantity of products on sale
         */
        public function getTheRemainingQuantityOfItemsOnSale($product_id,$quantity){
            
            $model = new Order;
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='product_id=:productid';
             $criteria->params = array(':productid'=>$product_id);
             $purchased_quantities= OrderHasProducts::model()->findAll($criteria);
             
             $selected_quantity = 0;
             foreach($purchased_quantities as $purchased){
                 if($model->isOrderOpen($purchased['order_id'])== false){
                      $selected_quantity = $selected_quantity + $purchased['number_of_portion'];
                 }
                
             }
             $remaining_quantity = $quantity - $selected_quantity;
             if($remaining_quantity<0){
                 return 0;
             }else{
                 return  $remaining_quantity;
             }
             
            
            
        }
        
        
        /**
         * This is the function that gets the price of a product in an order
         */
        public function getTheAmountOfThisProductPurchasedInThisOrder($product_id,$order_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($this->isOrderPriceStillValid($order_id,$product_id)){
                 $product_price = $order['number_of_portion'] * $order['cobuy_member_price_per_item_at_purchase'];
                 
             }else{
                 $product_price = $order['number_of_portion'] * $order['prevailing_retail_selling_price_per_item_at_purchase'];
             }
             
             return $product_price;
             
        }
       
        
        /**
         * This is the function that adds a hamper to cart 
         */
        public function isThisHamperOrderSuccessfullyAddedToCart($order_id,$hamper_id,$quantity_of_purchase,$prevailing_retail_selling_price,$cobuy_member_selling_price,$is_hamper,$hamper_terms_and_condition){
            
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('order_has_products',
                         array('order_id'=>$order_id,
                                'product_id' =>$hamper_id,
                                'number_of_portion'=>$quantity_of_purchase,
                                 'prevailing_retail_selling_price_per_item_at_purchase'=>$prevailing_retail_selling_price,
                                 'cobuy_member_price_per_item_at_purchase'=>$cobuy_member_selling_price,
                                 'is_hamper'=>$is_hamper,
                                  'hamper_terms_and_condition'=>$hamper_terms_and_condition,
                                  'hamper_terms_and_condition'=>$is_hamper,
                                  'date_ordered'=>new CDbExpression('NOW()'),
                                 'ordered_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
            
        }
        
        
        /**
         * This is the function that confirms if a product delivery cost is applicable for a delivery
         */
        public function isThisProductDeliveryCostApplicableInThisComputation($order_id,$product_id){
              
             if($this->isProductInTheExclusiveDeliveryCostList($order_id,$product_id) == false){
               if($this->isTransactionAPresubscription($order_id,$product_id) == false){
                     return true;
                 }else{
                     return false;
                 }
                }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that determines if an order is a presunscription
         */
        public function isTransactionAPresubscription($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['is_presubscription'] == 1){
                 return true;
             }else if($order['is_presubscription_and_escrow'] == 1){
                 return true;
             }else if($order['is_presubscription_topup'] == 1){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that determines products that are in the exclusive cost list
         */
        public function isProductInTheExclusiveDeliveryCostList($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['is_hamper'] == 1){
                 return true;
             }else if($order['is_quote_only'] == 1){
                 return true;
             }else if($order['is_quote_and_escrow_only'] == 1){
                 return true;
             }else if($order['is_presubscription'] == 1){
                 return true;
             }else if($order['is_presubscription_and_escrow'] == 1){
                 return true;
             }else if($order['is_presubscription_topup'] == 1){
                 return true;
             }else if($order['decision'] == 'faas'){
                 return true;
             }else{
                 return false;
             }
            
        }
        
        
        /**
         * This is the function that gets the cost of exclusive products in an order 
         */
        public function getTheCostOfDeliveryForExclusiveProductsInAnOrder($order_id){
            $model = new HamperHasBeneficiary;
            
            $total_delivery_cost = 0;
            //get all the exclusive products in the order
            
            $products = $this->getAllProductsInThisOrder($order_id);
            
            foreach($products as $product){
                if($this->isProductInTheExclusiveDeliveryCostList($order_id,$product)){
                    if($this->isThisProductAHamper($order_id,$product)){
                        $total_delivery_cost = $total_delivery_cost + $model->getTheTotalCostOfDeliveryOfThisHamper($product);
                    }else if($this->isThisProductAPreSubscription($order_id,$product)){
                        $total_delivery_cost = 0;
                    }else{
                        $quote_id = $this->getTheQuoteIdOfThisTransaction($order_id,$product);
                       $total_delivery_cost = $total_delivery_cost + $this->getTheCostOfDeliveryOfThisQuote($quote_id); 
                    }
                }
            }
            return $total_delivery_cost;
                    
                    
        }
        
        /**
         * This is the product that confirms if a product is a presubscription
         */
        public function isThisProductAPreSubscription($order_id,$product_id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['is_presubscription_and_escrow'] == 1){
                 return true;
             }else if($order['is_presubscription'] == 1){
                 return true;
             }else if($order['is_presubscription_topup'] == 1){
                 return true;
                 
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that gets the cost of delivery of a quote
         */
        public function getTheCostOfDeliveryOfThisQuote($quote_id){
            $model = new QuoteHasResponse;
            return $model->getTheCostOfDeliveryOfThisQuote($quote_id);
        }
        
        /**
         * This is the function that gets a quote id of a transaction
         */
        public function getTheQuoteIdOfThisTransaction($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             return $order['quote_id'];
             
        }
        
        
        /**
         * This is the function that confirms if a product in an order is a hamper
         */
        public function isThisProductAHamper($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['is_hamper'] == 1){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that calculates the escrow amount in an order
         */
        public function getTheEscrowChargesOfThisOrder($order_id){
            $model = new Escrow;
            $products = $this->getAllProductsInThisOrder($order_id);
            
            $total_escrow_value = 0;
            foreach($products as $product){
                if($this->isThisTransactionEscrowed($order_id,$product)){
                    $escrow_id = $this->getTheEscrowIdOfThisTransaction($order_id,$product);
                    $total_escrow_value = $total_escrow_value + $model->getTheEscrowChargeForThisTransaction($escrow_id);
                }
                
            }
            return $total_escrow_value;
        }
        
        /**
         * This is the function that gets the escrow id of a transaction in the cart
         */
        public function getTheEscrowIdOfThisTransaction($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             return $order['escrow_id'];
        }
        
       /**
        * This is the function that determines if a transaction is escrowed
        */
        public function isThisTransactionEscrowed($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $order= OrderHasProducts::model()->find($criteria);
             
             if($order['escrow_id']>0){
                 return true;
             }else{
                 return false;
             }
            
        }
        
        
        /**
         * This is the function that confirms if an order contains only exclusive transactions like hampers and quotes
         */
        public function isOrderWithOnlyExclusiveProducts($order_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order_id);
             $products= OrderHasProducts::model()->findAll($criteria);
             
             $counter = 0;
             
             foreach($products as $product){
                 if($this->isProductInTheExclusiveDeliveryCostList($order_id,$product['product_id'])== false){
                     $counter = $counter + 1;
                 }
             }
             if($counter>0){
                 return false;
             }else{
                 return true;
             }
        }
        
        
        /**
         * This is the function that adds a quoted transaction to cart
         */
        public function isAddingThisQuoteToAMemberCartASuccess($quote_id,$product_id,$quantity,$escrow_id,$is_quote_escrowed,$is_escrow_terms_accepted,$total_amount_quoted,$delivery_cost){
            
            $model = new Order;
            
            $member_id = Yii::app()->user->id;
            //get a member open order
            if($model->isMemberWithOpenOrder($member_id)){
                $order_id = $model->getTheOpenOrderInitiatedByMember($member_id);
            }else{
                $order_id = $model->createNewOrderForThisMember($member_id);
            }
            if($this->isProductNotAlreadyInTheCart($order_id,$product_id)){
              if($this->isTheAdditionOfThisQuotedTransactionASuccess($order_id,$quote_id,$product_id,$quantity,$escrow_id,$is_quote_escrowed,$is_escrow_terms_accepted,$total_amount_quoted,$delivery_cost)){
                return true;
                }else{
                    return false;
                }
            }else{
                if($this->isRemovalOfThisProductSuccessful($order_id,$product_id)){
                     if($this->isTheAdditionOfThisQuotedTransactionASuccess($order_id,$quote_id,$product_id,$quantity,$escrow_id,$is_quote_escrowed,$is_escrow_terms_accepted,$total_amount_quoted,$delivery_cost)){
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
         * This is the function that add quoted transaction to a member's cart
         */
        public function isTheAdditionOfThisQuotedTransactionASuccess($order_id,$quote_id,$product_id,$quantity_of_purchase,$escrow_id,$is_quote_escrowed,$is_escrow_terms_accepted,$total_amount_quoted,$delivery_cost){
            
            if($escrow_id>0){
                $this_escrow_id = $escrow_id;
                $is_escrow_accepted = $is_escrow_terms_accepted;
                $is_quote_only = 0;
                $is_quote_and_escrow_only = 1;
            }else{
                $this_escrow_id = $escrow_id;
                $is_escrow_accepted = 0;
                $is_quote_only = 1;
                $is_quote_and_escrow_only = 0; 
            }
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('order_has_products',
                         array('order_id'=>$order_id,
                                'product_id' =>$product_id,
                                'number_of_portion'=>$quantity_of_purchase,
                                 'prevailing_retail_selling_price_per_item_at_purchase'=>($total_amount_quoted/$quantity_of_purchase),
                                 'cobuy_member_price_per_item_at_purchase'=>($total_amount_quoted/$quantity_of_purchase),
                                 'is_escrow_only'=>0,
                                 'is_quote_only'=>$is_quote_only,
                                 'is_quote_and_escrow_only'=>$is_quote_and_escrow_only,
                                 'is_presubscription'=>0,
                                 'is_presubscription_and_escrow'=>0,
                                 'is_presubscription_drawdown'=>0,
                                 'is_postsubscription'=>0,
                                 'is_postsubscription_and_escrow'=>0,
                                 'is_hamper'=>0,
                                 'is_mainstore'=>0,
                                 'escrow_id'=>$this_escrow_id,
                                 'is_escrow_accepted'=>$is_escrow_accepted,
                                 'quote_id'=>$quote_id,
                                 //'start_price_validity_period'=>$start_price_validity_period,
                                 //'end_price_validity_period'=>$end_price_validity_period,
                                 'date_ordered'=>new CDbExpression('NOW()'),
                                 'ordered_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        
        /**
         * This is the function that adds presubscribed product drawdowns to cart
         */
        public function isTheAdditionOfThisPrescriptionDrawdownASuccess($member_id,$product_id,$per_delivery_quantity,$is_presubscription_drawdown){
            
            $model = new Order;
            //get the open order for this member
             if($model->isMemberWithOpenOrder($member_id)){
                $order_id = $model->getTheOpenOrderInitiatedByMember($member_id);
            }else{
                $order_id = $model->createNewOrderForThisMember($member_id);
            }
            
            if($this->isProductNotAlreadyInTheCart($order_id,$product_id)){
              if($this->isTheAdditionOfPresubscribedProductDrawdownASuccess($order_id,$product_id,$per_delivery_quantity,$is_presubscription_drawdown)){
                return true;
                }else{
                    return false;
                }
            }else{
                if($this->isRemovalOfThisProductSuccessful($order_id,$product_id)){
                     if($this->isTheAdditionOfPresubscribedProductDrawdownASuccess($order_id,$product_id,$per_delivery_quantity,$is_presubscription_drawdown)){
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
         * This is the function that adds presubscribed drawdown products to cart
         */
        public function isTheAdditionOfPresubscribedProductDrawdownASuccess($order_id,$product_id,$per_delivery_quantity,$is_presubscription_drawdown){
            
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('order_has_products',
                         array('order_id'=>$order_id,
                                'product_id' =>$product_id,
                                'number_of_portion'=>$per_delivery_quantity,
                                 'prevailing_retail_selling_price_per_item_at_purchase'=>0,
                                 'cobuy_member_price_per_item_at_purchase'=>0,
                                 'is_escrow_only'=>0,
                                 'is_quote_only'=>0,
                                 'is_quote_and_escrow_only'=>0,
                                 'is_presubscription'=>0,
                                 'is_presubscription_and_escrow'=>0,
                                 'is_presubscription_drawdown'=>$is_presubscription_drawdown,
                                 'is_postsubscription'=>0,
                                 'is_postsubscription_and_escrow'=>0,
                                 'is_hamper'=>0,
                                 'is_mainstore'=>0,
                                 'escrow_id'=>0,
                                 'is_escrow_accepted'=>0,
                                 'quote_id'=>0,
                                 //'start_price_validity_period'=>$start_price_validity_period,
                                 //'end_price_validity_period'=>$end_price_validity_period,
                                 'date_ordered'=>new CDbExpression('NOW()'),
                                 'ordered_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
            
        }
        
        
        /**
         * this is the function that retrieves the amount of all products that could be paid for on delivery
         */
        public function getTheAmountOfPayableOnDeliveryProducts($order_id){
            $model = new Product;

            //get all the products in an order
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order_id);
             $products= OrderHasProducts::model()->findAll($criteria);
             $sum = 0;
             foreach($products as $product){
                 if($model->isProductPayableOnDelivery($product['product_id'])){
                     $sum =$sum + $this->getTheAmountOfThisProductPurchasedInThisOrder($product['product_id'],$order_id);
                 }
             }
             return $sum;
             
        }
        
        
        /**
         * This is the function that gets the amount of products that must be paid before delivery is effected
         */
        public function getTheTotalCostOfPayableBeforeDeliveryProducts($order_id){
            $model = new Product;

            //get all the products in an order
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order_id);
             $products= OrderHasProducts::model()->findAll($criteria);
             $sum = 0;
             foreach($products as $product){
                 if($model->isProductPayableOnDelivery($product['product_id']) == false){
                     $sum =$sum + $this->getTheAmountOfThisProductPurchasedInThisOrder($product['product_id'],$order_id);
                 }
             }
             return $sum;
        }
        
        
        
        /**
         * This is the function that will obtain the cost of delivery of products that could be paid for on delivery
         */
        public function getTheOrderDeliveryCostToThisCityOnPaymentOnDeliveryService($order_id,$city_of_delivery,$payment_method,$delivery_type){
            $model = new Product;
            //get all products in this order that could be payable on delivery
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order_id);
             $products= OrderHasProducts::model()->findAll($criteria);
             $sum = 0;
             foreach($products as $product){
                 if($model->isProductPayableOnDelivery($product['product_id'])){
                     //get the weight of this produt
                     $product_weight = $model->getTheWeightOfThisProduct($product['product_id']);
                     //get the quantity of this product in this order
                     $quantity = $this->getThePortionOfThisProductInThisOrder($order_id, $product['product_id']);
                     $product_total_weight = $product_weight * $quantity;
                     //get this product cost of delivery
                     $product_delivery_cost = $this->getTheDirectCostOfDeliveryOfThisProduct($product_total_weight,$city_of_delivery,$payment_method,$delivery_type);
                     $sum = $sum + $product_delivery_cost;
            
                 }
             }
             return $sum;
        }
        
        
        
        /**
         * This is the function that will obtain the cost of delivery of products that could not be paid for on delivery
         */
        public function getTheOrderDeliveryCostToThisCityOnPaymentByWalletOrOnlineService($order_id,$city_of_delivery,$payment_method,$delivery_type){
            $model = new Product;
            //get all products in this order that could be payable on delivery
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order_id);
             $products= OrderHasProducts::model()->findAll($criteria);
             $sum = 0;
             foreach($products as $product){
                 if($model->isProductPayableOnDelivery($product['product_id']) == false){
                     //get the weight of this produt
                     $product_weight = $model->getTheWeightOfThisProduct($product['product_id']);
                     //get the quantity of this product in this order
                     $quantity = $this->getThePortionOfThisProductInThisOrder($order_id, $product['product_id']);
                     $product_total_weight = $product_weight * $quantity;
                     //get this product cost of delivery
                     $product_delivery_cost = $this->getTheDirectCostOfDeliveryOfThisProduct($product_total_weight,$city_of_delivery,$payment_method,$delivery_type);
                     $sum = $sum + $product_delivery_cost;
            
                 }
             }
             return $sum;
        }
        
        
        /**
         * This is the function that gets teh direct cost of delivery of a product
         */
        public function getTheDirectCostOfDeliveryOfThisProduct($product_total_weight,$city_of_delivery,$payment_method,$delivery_type){
            $model = new City;
            return $model->getTheDirectCostOfDeliveryOfThisProduct($product_total_weight,$city_of_delivery,$payment_method,$delivery_type);
        }
       
        
        /**
         * This is the function that confirms if a product in cart is escrowed only
         */
        public function getTheEscrowStatusOfThisProductInTheCart($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['is_escrow_only'];
        }
        
        
        /**
         * This is the function that confirms if a product in cart is both quoted and escrowed 
         */
        public function getTheQuotedAndEscrowStatusOfThisProductInTheCart($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['is_quote_and_escrow_only'];
        }
        
        
        /**
         * This is the function that confirms if a product in cart is quoted only
         */
        public function getTheQuotedStatusOfThisProductInTheCart($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['is_quote_only'];
        }
        
        
         /**
         * This is the function that retrieves  the escrow id of a product in cart
         */
        public function getTheEscrowIdOfTheProductInTheCart($order_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['escrow_id'];
        }
        
        
          /**
         * This is the function that retrieves  the quote id of a product in cart
         */
        public function getTheQuoteIdOfTheProductInTheCart($order_id, $product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['quote_id'];
        }
        
        
        /**
         * This is the function that confirms if there is a hamper in an order
         */
        public function isThereAHamperInThisOrder($order_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order_id);
             $products= OrderHasProducts::model()->findAll($criteria);
             
             foreach($products as $product){
                 if($product['is_hamper'] == 1){
                     return true;
                 }
             }
             return false;
        }
        
        
        /**
         * This is the function that retreieves the prevailing selling price of a hamper in cart
         */
        public function getThePrevailingPriceOfThisProductInCart($order_id,$product_id){
           
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['prevailing_retail_selling_price_per_item_at_purchase'];
        }
        
        /**
         * Thia is the function that determines if a product is a custom hamper
         */
        public function isThisProductAHamperInCart($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['is_hamper'];
        }
        
         /**
         * Thia is the function that determines if a product in cart is quoted
         */
        public function isThisProductInCartQuotedOrEscrowed($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             if($product['is_quote_only'] == 1){
                 return true;
             }else if($product['is_quote_and_escrow_only'] == 1){
                 return true;
             }else if($product['is_escrow_only'] == 1){
                 return true;
             }else{
                 return false;
             }
        }
        
        
         /**
         * This is the function that retreieves the prevailing selling price of a quoted product in cart
         */
        public function getThePrevailingRetailingPriceForThisQuotedAndEscrowedTransactionInCart($order_id,$product_id){
           
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and product_id=:prodid';
             $criteria->params = array(':orderid'=>$order_id,':prodid'=>$product_id);
             $product= OrderHasProducts::model()->find($criteria);
             
             return $product['prevailing_retail_selling_price_per_item_at_purchase'];
        }
        
        
        /**
         * This is the function that confirms if there is any non-delivery item in an order
         */
        public function isThereNonOnDeliveryItemInThisOrder($order_id){
             
            $model = new Product; 
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order_id);
             $products= OrderHasProducts::model()->findAll($criteria);
             $counter = 0;
             foreach($products as $product){
                 if($product['is_hamper'] == 1){
                     return true;
                 }else if($product['is_presubscription'] == 1){
                     return true;
                 }else if($product['is_presubscription_and_escrow'] == 1){
                     return true;
                 }else if($product['is_presubscription_topup'] == 1){
                     return true;
                 }else{
                     if($model->isProductPayableOnDelivery($product['product_id'])==false){
                         $counter =  $counter + 1;
                     }
                    
                 }
             }
             if($counter>0){
                 return true;
             }else{
                 return false;
             }
        }
        
       /**
        * This is the function that gets all the products in an order
        */ 
        public function getAllTheProductsInThisOrder($order){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid';
             $criteria->params = array(':orderid'=>$order);
             $products= OrderHasProducts::model()->findAll($criteria);
             
             $all_products = [];
             
             foreach($products as $product){
                 $all_products[] = $product['product_id'];
             }
             
             return $all_products;
        }
       
        
        /**
         * This is the functionm that adds faas product to cart
         */
        public function isThisFaasOrderSuccessfullyAddedToCart($order_id,$product_id,$decision,$monthly_faas_subscription_cost,$minimum_quantity_for_faas_subscription,$maximum_quantity_for_faas_subscription,$faas_product_quantity,$minimum_faas_duration,$maximum_faas_duration,$actual_faas_duration,$is_mainstore){
           
             if($this->isProductNotAlreadyInTheCart($order_id,$product_id)){
                 $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('order_has_products',
                         array('order_id'=>$order_id,
                                'product_id' =>$product_id,
                                'number_of_portion'=>$faas_product_quantity,
                                 'prevailing_retail_selling_price_per_item_at_purchase'=>$monthly_faas_subscription_cost,
                                 'cobuy_member_price_per_item_at_purchase'=>$monthly_faas_subscription_cost,
                                 'is_mainstore'=>$is_mainstore,
                                 'decision'=>$decision,
                                 'faas_product_quantity'=>$faas_product_quantity,
                                 'minimum_quantity_for_faas_subscription'=>$minimum_quantity_for_faas_subscription,
                                 'maximum_quantity_for_faas_subscription'=>$maximum_quantity_for_faas_subscription,
                                 'monthly_faas_subscription_cost'=>$monthly_faas_subscription_cost,
                                 'minimum_faas_duration'=>$minimum_faas_duration,
                                 'maximum_faas_duration'=>$maximum_faas_duration,
                                 'actual_faas_duration'=>$actual_faas_duration,
                                 'date_ordered'=>new CDbExpression('NOW()'),
                                 'ordered_by'=>Yii::app()->user->id
                           
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
        
        
        /**
         * This is the function that modifies the faas parameter in cart
         */
        public function ifModifyingTheFaasParamerIsASuccess($order_id,$product_id,$faas_product_quantity,$actual_faas_duration){
            
             if($this->isProductNotAlreadyInTheCart($order_id,$product_id)== false){
                
                if($this->isEffectingChangesOfThisFaasProductSuccessful($order_id,$product_id,$faas_product_quantity,$actual_faas_duration)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
            
        }
        
        /**
         * This is the function that effects changes to faas product in the cart
         */
        public function isEffectingChangesOfThisFaasProductSuccessful($order_id,$product_id,$faas_product_quantity,$actual_faas_duration){
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('order_has_products',
                                  array(
                                    'number_of_portion'=>$faas_product_quantity,
                                   'faas_product_quantity'=>$faas_product_quantity,
                                   'actual_faas_duration'=>$actual_faas_duration,   
                                   'date_last_update'=>new CDbExpression('NOW()')
                                                             
                            ),
                     ("order_id=$order_id and product_id=$product_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
}
