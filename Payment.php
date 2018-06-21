<?php

/**
 * This is the model class for table "payment".
 *
 * The followings are the available columns in table 'payment':
 * @property string $id
 * @property string $status
 * @property string $payment_mode
 * @property string $invoice_number
 * @property string $order_id
 * @property string $bank_account_id
 * @property string $remark
 * @property string $reason_for_failure
 * @property double $net_amount
 * @property double $gross_amount
 * @property double $discounted_amount
 * @property double $vat
 * @property string $payment_date
 * @property integer $paid_by
 * @property integer $payment_confirmed_by
 * @property string $date_of_confirmation
 * @property double $revenue
 *
 * The followings are the available model relations:
 * @property Order $order
 */
class Payment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, order_id, bank_account_id, net_amount, gross_amount, revenue', 'required'),
			array('paid_by, payment_confirmed_by', 'numerical', 'integerOnly'=>true),
			array('net_amount, gross_amount, discounted_amount, vat, revenue', 'numerical'),
			array('status', 'length', 'max'=>11),
			array('payment_mode', 'length', 'max'=>17),
			array('invoice_number', 'length', 'max'=>50),
			array('order_id, bank_account_id', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>200),
			array('reason_for_failure, payment_date, date_of_confirmation', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, payment_mode, invoice_number, order_id, bank_account_id, remark, reason_for_failure, net_amount, gross_amount, discounted_amount, vat, payment_date, paid_by, payment_confirmed_by, date_of_confirmation, revenue', 'safe', 'on'=>'search'),
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
			'status' => 'Status',
			'payment_mode' => 'Payment Mode',
			'invoice_number' => 'Invoice Number',
			'order_id' => 'Order',
			'bank_account_id' => 'Bank Account',
			'remark' => 'Remark',
			'reason_for_failure' => 'Reason For Failure',
			'net_amount' => 'Net Amount',
			'gross_amount' => 'Gross Amount',
			'discounted_amount' => 'Discounted Amount',
			'vat' => 'Vat',
			'payment_date' => 'Payment Date',
			'paid_by' => 'Paid By',
			'payment_confirmed_by' => 'Payment Confirmed By',
			'date_of_confirmation' => 'Date Of Confirmation',
			'revenue' => 'Revenue',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('bank_account_id',$this->bank_account_id,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('reason_for_failure',$this->reason_for_failure,true);
		$criteria->compare('net_amount',$this->net_amount);
		$criteria->compare('gross_amount',$this->gross_amount);
		$criteria->compare('discounted_amount',$this->discounted_amount);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('paid_by',$this->paid_by);
		$criteria->compare('payment_confirmed_by',$this->payment_confirmed_by);
		$criteria->compare('date_of_confirmation',$this->date_of_confirmation,true);
		$criteria->compare('revenue',$this->revenue);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
            /**
         * This is the function that verifies the existence of an invoice number
         */
        public function isInvoiceNumberNotAlreadyExisting($invoice_number){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('payment')
                    ->where("invoice_number = '$invoice_number'");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
            
            
        }
        
        
         /**
         * This is the function that generates an invoice for this order payment
         */
        public function generateTheInvoiceNumberForThisOrder($order_id){
            
           //get the member that made this order
            
            $member_id = $this->getTheMemberThatMadeThisOrder($order_id);
            
            $city_number = $this->getThisMemberCityNumber($member_id);
            $state_number = $this->getThisMemberStateNumber($member_id);
            $member_code = $this->getTheLastFourDigitsOfThisMemberMembershipNumber($member_id);
            $ordered_date = $this->getTheDateThisOrderWasInitiated($order_id);
                       
            $invoice_number = $state_number.'-'.$city_number.'-'.$member_code.'-'.$ordered_date;
            
            if($this->isInvoiceNumberNotAlreadyExisting($invoice_number)){
                return $invoice_number;
            }else{
                return($invoice_number.'_'.$this->uniqueNumberDifferentiator());
            }
            
            
        }
        
        
        /**
         * this is the function that gets the member that initiated an order
         */
        public function getTheMemberThatMadeThisOrder($order_id){
            $model = new Order;
            
            return $model->getTheMemberThatMadeThisOrder($order_id);
        }
        
        
           /**
         * This is the function that gets the order date
         */
        public function getTheDateThisOrderWasInitiated($order_id){
            
              $model = new Order;
              
              return $model->getTheDateThisOrderWasInitiated($order_id);
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
         * This is the function that gets the invoice number of an order payment
         */
        public function getTheInvoiceNumberOfThisPayment($order_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='order_id=:orderid';
            $criteria->params = array(':orderid'=>$order_id);
            $invoice = Payment::model()->find($criteria);
            
            return $invoice['invoice_number'];
        }
        
        
          /**
         * This is the function that gets the expected revenue in an order
         */
        public function getTheExpectedIncomeFromThisOrder($order_id){
            
            //get all the products in this order
            
            $products = $this->getAllTheProductsOnThisOrder($order_id);
            
            $revenue_amount = 0;
            
            foreach($products as $product){
                
                $revenue_amount = $revenue_amount + $this->getTheRevenueAmountFromThisProduct($product,$order_id);
            }
            
            return $revenue_amount;
            
            
        }
        
        
         /**
         * This is the function that retrieves all the products in an order 
         */
        public function getAllTheProductsOnThisOrder($order_id){
            
            $model = new Order;
            
            return $model->getAllTheProductsOnThisOrder($order_id);
        }
        
         /**
         * This is the function that gets the revenue amount accruable from a product sale
         */
        public function getTheRevenueAmountFromThisProduct($product,$order_id){
            
            $model= new Product;
            
            return $model->getTheRevenueAmountFromThisProduct($product,$order_id);
            
        }
        
        
        /**
         * This is the function that calculates the vat amount in an order  
         */
        public function getTheVatOfThisOrder($order_id){
            
            if($this->isVatEnabledForTheCountryOfThisOrder($order_id)){
                
                //get all the product on this order
                 $products = $this->getAllTheProductsOnThisOrder($order_id);
            
                $vat_amount = 0;
            
                 foreach($products as $product){
                
                        $vat_amount = $vat_amount + (($this->getTheVatRateOfThisProductType($product,$order_id)/100) * $this->getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id));
                  }
            
                  return $vat_amount;
                
            }
            return 0;
            
            
        }
        
        /**
         * This is function that gets the quantity of the product ordered
         */
        public function getThePortionOfThisProductInThisOrder($order_id,$product){
            $model = new OrderHasProducts;
            return $model->getThePortionOfThisProductInThisOrder($order_id,$product);
        }
       
        
         /**
         * This is the function that gets the amount of a product
         */
        public function getTheAmountOfThisProduct($product_id){
            $model = new Product;
            
            return $model->getTheAmountOfThisProduct($product_id);
            
        }
        
        
        
        /**
         * This is the function that gets the amount of a product purchased
         */
        public function getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id){
            $model = new OrderHasProducts;
            return $model->getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id);
        }
        
        /**
         * This is the function that determines if vat is enabled for a country
         */
        public function isVatEnabledForTheCountryOfThisOrder($order_id){
            
            $model = new Order;
            
            return $model->isVatEnabledForTheCountryOfThisOrder($order_id);
        }
        
        
        /**
         * This is the function that determines if vat amount for a product
         */
        public function getTheVatRateOfThisProductType($product,$order_id){
            $model = new Product;
            
            return $model->getTheVatRateOfThisProductType($product,$order_id);
        }
        
        
        /**
         * This is the function that effects order payment
         */
        public function isThisOrderPaymentSuccessful($order_id,$cart_amount_for_computation,$delivery_charges_for_computation,$escrow_charges,$delivery_type,$member_id,$payment_mode,$remark){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('payment',
                         array('order_id'=>$order_id,
                                'payment_mode' =>$payment_mode,
                                 'status'=>'unconfirmed',
                                 'invoice_number'=>$this->generateTheInvoiceNumberForThisOrder($order_id),
                                 'bank_account_id'=>$this->getTheBankAccountIdForThisMemberCountry($member_id),
                                 'remark'=>$remark,
                                 'gross_amount'=>$cart_amount_for_computation,
                                 'revenue'=>$this->getTheExpectedIncomeFromThisOrder($order_id),
                                 'vat'=>$this->getTheVatOfThisOrder($order_id),
                                 'delivery_charges'=>$delivery_charges_for_computation,
                                 'escrow_charge'=>$escrow_charges,
                                 'delivery_type'=>$delivery_type,
                                 'paid_by'=>$member_id,
                                 'payment_date'=>new CDbExpression('NOW()')
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
            
        }
        
        /**
         * This is the function that gets the current bank account assigned to a country
         */
        public function getTheBankAccountIdForThisMemberCountry($member_id){
            $model = new Members;
            
            return $model->getTheBankAccountIdForThisMemberCountry($member_id);
        }
        
        
        /**
         * This is the function that confirms if an order payment had already been effected
         */
        public function isOrderPaymentNotAlreadyEffected($order_id){
           
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('payment')
                    ->where("order_id = $order_id");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that confirms the payment status of an order
         */
        public function getThePaymentStatusOfThisOrder($order_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='order_id=:orderid';
            $criteria->params = array(':orderid'=>$order_id);
            $payment = Payment::model()->find($criteria);
            
            return $payment['status'];
        }
        
        
        
         /**
         * This is the function that retrieves the order delivery type
         */
        public function getTheOrderDeliveryType($order_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='order_id=:orderid';
            $criteria->params = array(':orderid'=>$order_id);
            $payment = Payment::model()->find($criteria);
            
            return $payment['delivery_type'];
        }
        
        
        
        
        /**
         * This is the function that effects transaction payment from a wallet
         */
        public function isThisOrderPaymentFromWalletSuccessful($order_id,$cart_amount_for_computation,$delivery_charges_for_computation,$delivery_type,$member_id,$payment_mode,$remark){
            //get all the product in an order
            $model = new Wallet;
            
            //get the wallet id of this member
            $wallet_id = $model->getTheWalletIdOfMember($member_id);
           
          //get all the products in this order
            $products = $this->getAllTheProductsOnThisOrder($order_id);
            
            //get the total weight of an order
            $order_total_weight = $this->getTheTotalWeightOfThisOrder($order_id);
            
            //get the cost per weight of an item for delivery
            $delivery_cost_per_weight = ($delivery_charges_for_computation/$order_total_weight);
            
                      
            $due_product_payment= 0;
            $due_amount_for_delivery = 0;
            $is_expensibility_position_adjusted = 0;
            $product_could_not_be_settled = 0;
            $fully_settled_products = [];
            $not_settled_products = [];
            
            foreach($products as $product){
                //get this product cost of delivery
                    $product_cost_for_delivery = $this->getTheWeightOfThisProduct($product) * $delivery_cost_per_weight;
                    //get the cost of product
                    $cost_of_this_product = $this->getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id);
                    
                    //get the quantity of this product in this order
                    $product_quantity = $this->getThePortionOfThisProductInThisOrder($order_id,$product);
                    
                    //get the total cost of delivery
                    $total_delivery_cost = $product_cost_for_delivery * $product_quantity;
                if($this->isProductWithExpensibilityLimitInTheWallet($wallet_id,$product)){
                    //get the prevailing product expensibility limit 
                    $product_expensibility_limit = $this->getThisProductPrevailingExpensibilityLimit($wallet_id,$product);
                    $product_expensibility_limit_from = $this->getTheOriginOfTheProductPrevailingExpensibilityLimit($wallet_id,$product);
                    if($this->isTheProductExpensibilityLimitHigherThanItsCostOfPurchase($wallet_id,$product,$cost_of_this_product,$total_delivery_cost)){
                        $product_settlement_from = strtolower('limits_only');
                        if($this->isTheAdjustmentOfWalletAndProductExpensibilityPositionASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from,$product_expensibility_limit,$product_expensibility_limit_from)){
                            $due_product_payment = $due_product_payment + $cost_of_this_product;
                            $due_amount_for_delivery = $due_amount_for_delivery + $total_delivery_cost;
                            $is_expensibility_position_adjusted = $is_expensibility_position_adjusted +1;
                            $fully_settled_products[] = $product;
                        }
                    }else{
                        $product_settlement_from = strtolower('limits_and_free_pool');
                        if($this->isTheUnencumberedFundInTheWalletAbleToOffsetThisProductCost($wallet_id,$product,$cost_of_this_product,$total_delivery_cost,$product_expensibility_limit,$product_settlement_from)){
                             if($this->isTheAdjustmentOfWalletAndProductExpensibilityPositionASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from,$product_expensibility_limit,$product_expensibility_limit_from)){
                                $due_product_payment = $due_product_payment + $cost_of_this_product;
                                $due_amount_for_delivery = $due_amount_for_delivery + $total_delivery_cost;
                                $is_expensibility_position_adjusted = $is_expensibility_position_adjusted +1;
                                $fully_settled_products[] = $product;
                            }
                        }else{
                            
                            //the cost of this product could not be offset in this wallet
                            if($this->isTheRegistrationOfNonSettledProductASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from)){
                                 $product_could_not_be_settled = $product_could_not_be_settled +1;
                            }
                           
                           
                        }
                    }
                    
                }else{
                    $product_expensibility_limit = 0;
                    $product_expensibility_limit_from = 0;
                    $product_settlement_from = strtolower('free_pool_only');
                    if($this->isTheUnencumberedFundInTheWalletAbleToOffsetThisProductCost($wallet_id,$product,$cost_of_this_product,$total_delivery_cost,$product_expensibility_limit,$product_settlement_from)){
                        if($this->isTheAdjustmentOfWalletAndProductExpensibilityPositionASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from,$product_expensibility_limit,$product_expensibility_limit_from)){
                                $due_product_payment = $due_product_payment + $cost_of_this_product;
                                $due_amount_for_delivery = $due_amount_for_delivery + $total_delivery_cost;
                                $is_expensibility_position_adjusted = $is_expensibility_position_adjusted +1;
                                $fully_settled_products[] = $product;
                            }
                    }else{
                        //the cost of this product could not be offset in this wallet
                            if($this->isTheRegistrationOfNonSettledProductASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from)){
                                 $product_could_not_be_settled = $product_could_not_be_settled +1;
                            }
                    }
                }
                
            }
            if($is_expensibility_position_adjusted>0){
               if($this->isThisOrderPaymentSuccessful($oorder_id, $due_product_payment, $due_amount_for_delivery, $delivery_type, $member_id,$payment_mode,$remark)){
                   if($product_could_not_be_settled == 0){
                        return 0;
                   }else{
                       //some of the products could not be settled
                       return 1;
                   }
                   
                }else{
                    if($product_could_not_be_settled == 0){
                     if($this->isTheReconstructionOfTheWalletAndLimitPositionsASuccess($wallet_id,$order_id)){
                        return 2;
                    }else{
                        return 3;
                    }
                  }else{
                       //some of the products could not be settled
                    if($this->isTheReconstructionOfTheWalletAndLimitPositionsASuccess($wallet_id,$order_id)){
                        return 4;
                    }else{
                        return 5;
                    }
                   }
                    
                }
                
            }
            

        }
        
        
        /**
         * This is the function that registers all the products that could not be delivered
         */
        public function isTheRegistrationOfNonSettledProductASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from){
            $model = new UndeliveredOrderedProducts;
            return $model->isTheRegistrationOfNonSettledProductASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from);
        }
        
        /**
         * This is the function that gets the origin of a product expensibility limit
         */
        public function getTheOriginOfTheProductPrevailingExpensibilityLimit($wallet_id,$product){
            $model = new WalletHasProductExpendableLimit;
            return $model->getTheOriginOfTheProductPrevailingExpensibilityLimit($wallet_id,$product);
        }
        
        /**
         * This is the function that confirms the success of a wallet reconstruction after settlement failure
         */
        public function isTheReconstructionOfTheWalletAndLimitPositionsASuccess($wallet_id,$order_id){
            $model = new Wallet;
            return $model->isTheReconstructionOfTheWalletAndLimitPositionsASuccess($wallet_id,$order_idt);
        }
        
        
        /**
         * This is the function that confirms if the unencumbered fund in a wallet is able to offest product cost
         */
        public function isTheUnencumberedFundInTheWalletAbleToOffsetThisProductCost($wallet_id,$product,$cost_of_this_product,$total_delivery_cost,$product_expensibility_limit,$product_settlement_from){
            $model = new Wallet;
            return $model->isTheUnencumberedFundInTheWalletAbleToOffsetThisProductCost($wallet_id,$product,$cost_of_this_product,$total_delivery_cost,$product_expensibility_limit,$product_settlement_from);
        }
        
        /**
         * This is the function that confirms the wallet & limits adjustment positions
         */
        public function isTheAdjustmentOfWalletAndProductExpensibilityPositionASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from,$product_expensibility_limit,$product_expensibility_limit_from){
            $model = new Wallet;
            return $model->isTheAdjustmentOfWalletAndProductExpensibilityPositionASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from,$product_expensibility_limit,$product_expensibility_limit_from);
        }
        
        /**
         * This is the function that determines if a product expensibility limit is higher that the product cost
         */
        public function isTheProductExpensibilityLimitHigherThanItsCostOfPurchase($wallet_id,$product,$cost_of_this_product,$total_delivery_cost){
            $model = new WalletHasProductExpendableLimit;
            return $model->isTheProductExpensibilityLimitHigherThanItsCostOfPurchase($wallet_id,$product,$cost_of_this_product,$total_delivery_cost);
        }
        
        
        /**
         * This is the function that gets a product expensibility limits in a wallet
         */
        public function getThisProductPrevailingExpensibilityLimit($wallet_id,$product){
            $model = new WalletHasProductExpendableLimit;
            return $model->getThisProductPrevailingExpensibilityLimit($wallet_id,$product);
        }
       /**
        * This is the function that determines if a product has an expensibility limit in a wallet
        */
        public function isProductWithExpensibilityLimitInTheWallet($wallet_id,$product){
            $model = new WalletHasProductExpendableLimit;
            return $model->isProductWithExpensibilityLimitInTheWallet($wallet_id,$product);
        }
        
        
       
        
        /**
         * This is the function that gets the weight of a product
         */
        public function getTheWeightOfThisProduct($product_id){
            $model = new Product;
            return $model->getTheWeightOfThisProduct($product_id);
        }
        
        /**
         * This is the function that gets the total weight of an order
         */
        public function getTheTotalWeightOfThisOrder($order_id){
            $model = new Product;
            return $model->getTheTotalWeightOfThisOrder($order_id);
        }
        
        /**
         * This is the function that obtaines the avalable usable funcd in a wallet
         */
        public function getTheAvailableUsableFunds($wallet_id,$operation){
            $model = new WalletHasVouchers;
            return $model->getTheAvailableUsableFunds($wallet_id,$operation);
        }
        
        
        /**
         * This is the function that confirms if the payment of of non limited products in a wallet is successful
         */
        public function getTheTotalAmountFromNonLimitingContentsInThisOrder($wallet_id,$order_id){
            $model = new Wallet;
            return $model->getTheTotalAmountFromNonLimitingContentsInThisOrder($wallet_id,$order_id);
            
        }
        
        /**
         * This is the function that confirms if the payment of of non limited products in a wallet is successful
         */
        public function getTheTotalAmountFromLimitedContentsInThisOrder($wallet_id,$order_id){
            $model = new Wallet;
            return $model->getTheTotalAmountFromLimitedContentsInThisOrder($wallet_id,$order_id);
            
        }
        
        
        /**
         * This is the function that gets the amount of limiting product that could not be settled
         */
        public function getTheTotalAmountThatCannotBeSettledFromExpendibleBalanceInThisOrder($wallet_id,$order_id){
            $model = new Wallet;
            return $model->getTheTotalAmountThatCannotBeSettledFromExpendibleBalanceInThisOrder($wallet_id,$order_id);
        }
        
        /**
         * This is the function that obtains the recalculated delivery charge
         */
        public function getTheRecalculatedDeliveryChargeForThisTransaction($order_id,$wallet_id,$delivery_type){
            $model = new City;
            return $model->getTheRecalculatedDeliveryChargeForThisTransaction($order_id,$wallet_id,$delivery_type);
        }
            
        
        /**
         * This is the function that confirms if an order payment is confirmed
         */
        public function isThisOrderPaymentConfirmed($order_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('payment')
                    ->where("order_id = $order_id and status='confirmed'");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
            
        }
               
}
