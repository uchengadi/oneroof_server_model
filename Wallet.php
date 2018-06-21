<?php

/**
 * This is the model class for table "wallet".
 *
 * The followings are the available columns in table 'wallet':
 * @property string $id
 * @property string $member_owner_id
 * @property string $status
 * @property string $date_created
 * @property string $date_updated
 * @property integer $create_by
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property Members $memberOwner
 * @property Category[] $categories
 * @property Product[] $products
 * @property Voucher[] $vouchers
 */
class Wallet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wallet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_owner_id, status', 'required'),
			array('create_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('member_owner_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_owner_id, status, date_created, date_updated, create_by, updated_by', 'safe', 'on'=>'search'),
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
			'memberOwner' => array(self::BELONGS_TO, 'Members', 'member_owner_id'),
			'categories' => array(self::MANY_MANY, 'Category', 'wallet_has_category_expendable_limit(wallet_id, category_id)'),
			'products' => array(self::MANY_MANY, 'Product', 'wallet_has_product_expendable_limit(wallet_id, product_id)'),
			'vouchers' => array(self::MANY_MANY, 'Voucher', 'wallet_has_vouchers(wallet_id, voucher_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_owner_id' => 'Member Owner',
			'status' => 'Status',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'create_by' => 'Create By',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('member_owner_id',$this->member_owner_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Wallet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that confirms if a member has wallet
         */
        public function doMemberHasWallet($member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('wallet')
                    ->where("member_owner_id = $member_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that gets the wallet id of a member
         */
        public function getTheWalletIdOfMember($member_id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='member_owner_id=:id';
            $criteria->params = array(':id'=>$member_id);
            $wallet= Wallet::model()->find($criteria);
            
            return $wallet['id'];
        }
        
        
        /**
         * This is the function that creates a member's wallet
         */
        public function isTheCreationOfMemberWalletSuccessful($member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('wallet',
                         array( 
                             'member_owner_id'=>$member_id,
                             'status'=>strtolower('active'),
                               'date_created'=>new CDbExpression('NOW()'),
                               'create_by'=>Yii::app()->user->id
                                
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        /**
         * This is the function that gets the name of a wallet owner
         */
        public function getTheNameOfTheWalletOwner($wallet_id){
            
            $model = new Members;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$wallet_id);
            $wallet= Wallet::model()->find($criteria);
            
            return $model->getTheNameOfThisMember($wallet['member_owner_id']);
        }
        
        
        /**
         * This is the function that confirms if an order content is limited in a wallet
         */
        public function isOrderContentsWithLimitedExpendibilityInThisWallet($wallet_id,$order_id){
            $model = new OrderHasProducts;    
           //get all the products in this order
            
            $counter = 0;
            $category_counter = 0;
            
            $products = $model->getAllProductsInThisOrder($order_id);
            
            foreach($products as $product){
                if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product)){
                    $counter = $counter + 1;
                }
            }
            if($counter>0){
                return true;
            }else{
                foreach($products as $product){
                    $category_id = $this->getTheCategoryIdOfThisProduct($product);
                    if($this->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                        $category_counter = $category_counter + 1;
                    }
                }
                if($category_counter>0){
                    return true;
                }else{
                    return false;
                }
            }
            
            
        }
        
        
        /**
         * This is the function that gets the category id of a product
         */
        public function getTheCategoryIdOfThisProduct($product_id){
            $model = new Product;
            return $model->getTheCategoryIdOfThisProduct($product_id);
        }
        
        /**
         * This is the function that confirms if a product has an expendibility limit in a wallet
         */
        public function doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product){
            $model = new WalletHasProductExpendableLimit;
            return $model->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product);
        }
        
        /**
         * This is the function that confirms if a category has an expendibility limit in a wallet
         */
        public function doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id){
            $model = new WalletHasCategoryExpendableLimit;
            return $model->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id);
        }
        
        
        /**
         * This is the function that gets the sum of all non limiting contents in an order
         */
        public function getTheTotalAmountFromNonLimitingContentsInThisOrder($wallet_id,$order_id){
            $model = new OrderHasProducts;  
            //get all the products in this order
            $products = $model->getAllProductsInThisOrder($order_id);
            $sum = 0;
            foreach($products as $product){
                if($this->doesThisProductHaveAnExpendibilityLimitInThisWallet($wallet_id,$product)== false){
                    $sum = $sum + $model->getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id);
                }
            }
            return $sum;
            
        }
        
        
        /**
         * This is the function that gets the sum of all limiting contents in an order
         */
        public function getTheTotalAmountFromLimitedContentsInThisOrder($wallet_id,$order_id){
            $model = new OrderHasProducts;  
            //get all the products in this order
            $products = $model->getAllProductsInThisOrder($order_id);
            $sum = 0;
            foreach($products as $product){
                if($this->doesThisProductHaveAnExpendibilityLimitInThisWallet($wallet_id,$product)){
                    //get the amount of this product in the order
                    $order_product_amount = $model->getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id);
                    if($this->getTheExpendableLimitOfThisProductInThisWallet($wallet_id,$product)>=$order_product_amount){
                        $sum = $sum + $order_product_amount;
                    }
                    
                }
            }
            return $sum;
            
        }
        
        /**
         * This is the function that gets the amount of limiting products that could not be settled
         */
        public function getTheTotalAmountThatCannotBeSettledFromExpendibleBalanceInThisOrder($wallet_id,$order_id){
            
            $model = new OrderHasProducts;  
            //get all the products in this order
            $products = $model->getAllProductsInThisOrder($order_id);
            $sum = 0;
            foreach($products as $product){
                if($this->doesThisProductHaveAnExpendibilityLimitInThisWallet($wallet_id,$product)){
                    //get the amount of this product in the order
                    $order_product_amount = $model->getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id);
                    if($this->getTheExpendableLimitOfThisProductInThisWallet($wallet_id,$product)<$order_product_amount){
                        $sum = $sum + $order_product_amount;
                    }
                    
                }
            }
            return $sum;
        }
       
        
        /**
         * This is the function that confirms if a product has an expendable limit in a wallet
         */
        public function doesThisProductHaveAnExpendibilityLimitInThisWallet($wallet_id,$product){
           
            if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product)){
                    return true;
                }else{
                    $category_id = $this->getTheCategoryIdOfThisProduct($product);
                    if($this->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                        return true;
                    }else{
                        return false;
                    }
                }
        }
        
        
        /**
         * This is the function that gets the expendable limit of a product in a wallet
         */
        public function getTheExpendableLimitOfThisProductInThisWallet($wallet_id,$product_id){
            $model = new WalletHasProductExpendableLimit;
            //get the category id of this product
            $category_id = $this->getTheCategoryIdOfThisProduct($product_id);
            if($this->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                $category_expendable_amount = $this->getTheExistingExpendableValue($wallet_id,$category_id);
            }else{
               $category_expendable_amount = 0; 
            }
            //get the expendable limit of this product in this wallet
            $product_expendable_limit = $model->getTheExistingExpendableValue($wallet_id,$product_id);
            
            //the total expendable limit for this product is
            $total_expendable_limit_for_product = $product_expendable_limit + $category_expendable_amount;
            
            return $total_expendable_limit_for_product;
        }
        
        /**
         * This is the function that gets the expendable limit of a category in a wallet
         */
        public function getTheExistingExpendableValue($wallet_id,$category_id){
            $model = new WalletHasCategoryExpendableLimit;
            return $model->getTheExistingExpendableValue($wallet_id,$category_id);
        }
        
        
        /**
         * This is the function that confirms if the settlement of a transaction is possible using a member wallet
         */
        public function isTheSettlementOfThisAmountPossibleWithMemberWallet($member_id,$cart_amount_for_computation,$delivery_charges_for_computation){
            
            $model = new WalletHasVouchers;
            //get the member wallet id
            $wallet_id = $this->getTheWalletIdOfMember($member_id);
            
            //get the total available usable fund in a member wallet
            $usable_available_fund = $model->getAllTheExpendableAndAvailableAmountInThisWallet($wallet_id);
            
            if($usable_available_fund>=($cart_amount_for_computation + $delivery_charges_for_computation)){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if the settlement of a product is possible in a wallet
         */
        public function isTheSettlementOfThisProductPossibleInThisWallet($wallet_id,$order_id,$product){
            $model = new OrderHasProducts;  
            if($this->doesThisProductHaveAnExpendibilityLimitInThisWallet($wallet_id,$product)){
                $order_product_amount = $model->getTheAmountOfThisProductPurchasedInThisOrder($product,$order_id);
                if($this->getTheExpendableLimitOfThisProductInThisWallet($wallet_id,$product)<$order_product_amount){
                        return false;
                    }else{
                        return true;
                    }
            }else{
                return true;
            }
        }
        
        
       
        
        
        /**
         * This is the function that confirms if the money in the free pool could settle a product transaction
         */
        public function isTheUnencumberedFundInTheWalletAbleToOffsetThisProductCost($wallet_id,$product,$cost_of_this_product,$total_delivery_cost,$product_expensibility_limit,$product_settlement_from){
           
           //calculate the total cost of the product
            $product_cost = $cost_of_this_product + $total_delivery_cost;
            
            //get the fund from the free pool in the wallet
            $wallet_free_fund = $this->getTheTotalFreeAndUsableFundInTheWallet($wallet_id);
                
            if($product_settlement_from == strtolower('limits_and_free_pool')){
                if(($wallet_free_fund-$product_expensibility_limit)>=$product_cost){
                    return true;
                }else{
                    return false;
                }
            }else if($product_settlement_from == strtolower('free_pool_only')){
                if($wallet_free_fund>=$product_cost){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        
        /**
         * This is the function that gets all the free and unallocated funds in a wallet
         */
        public function getTheTotalFreeAndUsableFundInTheWallet($wallet_id){
            $model = new WalletHasVouchers;
            return $model->getTheTotalFreeAndUsableFundInTheWallet($wallet_id);
        }
        
        /**
         * This is the function that confirms if the adjustment of wallet and expendibility limit are a success
         */
        public function isTheAdjustmentOfWalletAndProductExpensibilityPositionASuccess($wallet_id,$order_id,$product,$cost_of_this_product,$total_delivery_cost,$product_settlement_from,$product_expensibility_limit,$product_expensibility_limit_from){
            //calculate the product cost
            $product_cost = $cost_of_this_product + $total_delivery_cost;
            
            $counter = 0;
            
            if($product_settlement_from == strtolower('limits_only')){
                //reduce the expensibility limit by the product cost
                $new_expensibility_limit = $product_expensibility_limit - $product_cost;
                if($this->isTheRegistrationOfThisLimitAdjustmentASuccess($wallet_id,$order_id,$product,$product_expensibility_limit,$new_expensibility_limit,$product_expensibility_limit_from)){
                     if($this->isTheAdjustmentOfTheProductExpensibilityLimitASuccess($wallet_id,$product,$new_expensibility_limit,$product_settlement_from,$product_expensibility_limit_from,$product_cost)){
                   
                        if($this->isTheAdjustmentOfTheWalletPositionASuccess($wallet_id,$order_id,$product,$product_cost,$product_settlement_from)){
                            $counter = $counter + 1;
                            
                        }
                    
                }
                 }
                
                
            }else if($product_settlement_from == strtolower('limits_and_free_pool')){
                $new_expensibility_limit = 0;
                 if($this->isTheRegistrationOfThisLimitAdjustmentASuccess($wallet_id,$order_id,$product,$product_expensibility_limit,$new_expensibility_limit,$product_expensibility_limit_from)){
                     if($this->isTheAdjustmentOfTheProductExpensibilityLimitASuccess($wallet_id,$product,$new_expensibility_limit,$product_settlement_from,$product_expensibility_limit_from,$product_cost)){
                   
                        if($this->isTheAdjustmentOfTheWalletPositionASuccess($wallet_id,$order_id,$product,$product_cost,$product_settlement_from)){
                            $counter = $counter + 1;
                            
                        }
                    
                }
                 }
                
                
                
            }else if($product_settlement_from == strtolower('free_pool_only')){
                 if($this->isTheAdjustmentOfTheWalletPositionASuccess($wallet_id,$order_id,$product,$product_cost,$product_settlement_from)){
                      $counter = $counter + 1;
                    }
                
                
            }
            
            if($counter>0){
                return true;
            }else{
                return false;
            }
        }
        
        /**
         * This is the function that effects the extensibility limit of a product in the wallet
         */
        public function isTheAdjustmentOfTheProductExpensibilityLimitASuccess($wallet_id,$product,$new_expensibility_limit,$product_settlement_from,$product_expensibility_limit_from,$product_cost){
            $model = new WalletHasProductExpendableLimit;
            return $model->isTheAdjustmentOfTheProductExpensibilityLimitASuccess($wallet_id,$product,$new_expensibility_limit,$product_settlement_from,$product_expensibility_limit_from,$product_cost);
        }
        
        /**
         * This is the function that confirms the adjustmrnt of a wallet a position 
         */
        public function isTheAdjustmentOfTheWalletPositionASuccess($wallet_id,$order_id,$product,$product_cost,$product_settlement_from){
            $model = new WalletHasVouchers;
            return $model->isTheAdjustmentOfTheWalletPositionASuccess($wallet_id,$order_id,$product,$product_cost,$product_settlement_from);
        }
        
        
        /**
         * This is the function that reconstruct the wallet after unsuccessful payment attempt
         */
        public function isTheReconstructionOfTheWalletAndLimitPositionsASuccess($wallet_id,$order_id){
            $model = new ExpendabilityLimitAdjuster;
            $counter = 0;
            if($model->isTheExpendibilityLimitReconstructionSuccessful($wallet_id,$order_id)){
                if($this->isTheWalletReconstructionSuccessful($wallet_id,$order_id)){
                    $counter = $counter + 1;
                }
            }
           if($counter>0){
               return true;
            }else{
                return false;
            }
     
                
        }
        
        
        /**
         * This is the function that confirms if the wallet reconstruction is a success
         */
        public function isTheWalletReconstructionSuccessful($wallet_id,$order_id){
            $model = new WalletAdjuster;
            return $model->isTheWalletReconstructionSuccessful($wallet_id,$order_id);
        }
        
        
        /**
         * This is the function that confirms if the expendibility reconstruction is a success
         */
        public function isTheExpendibilityLimitReconstructionSuccessful($wallet_id,$order_id){
            $model = new ExpendabilityLimitAdjuster;
            return $model->isTheExpendibilityLimitReconstructionSuccessful($wallet_id,$order_id);
        }
        
       /**
        * This is the function that gets the weight of a product
        */
        public function getTheWeightOfThisProduct($product_id){
            $model = new Product;
            return $model->getTheWeightOfThisProduct($product_id);
        }
        
        
        /**
         * This is the function that reconstructs products expensibility limit in a wallet
         */
        public function isTheReconstructionOfThisWalletProductLimitASuccess($wallet_id,$product,$total_product_cost){
            $model = new WalletHasProductExpendableLimit;
            return $model->isTheReconstructionOfThisWalletProductLimitASuccess($wallet_id,$product,$total_product_cost);
        }
        
        /**
         * This is the function that reconstructs a wallet unallocated pool fund
         */
        public function isTheReconstructionOfThisWalletUnallocatedFundPoolSuccess($wallet_id,$product,$total_product_cost){
            $model = new WalletHasVouchers;
            return $model->isTheReconstructionOfThisWalletUnallocatedFundPoolSuccess($wallet_id,$product,$total_product_cost);
        }
        
        /**
         * This is the function that registers a limit adjustment
         */
        public function isTheRegistrationOfThisLimitAdjustmentASuccess($wallet_id,$order_id,$product,$product_expensibility_limit,$new_expensibility_limit,$product_expensibility_limit_from){
            $model = new ExpendabilityLimitAdjuster;
            return $model->isTheRegistrationOfThisLimitAdjustmentASuccess($wallet_id,$order_id,$product,$product_expensibility_limit,$new_expensibility_limit,$product_expensibility_limit_from);
        }
        
       
}


