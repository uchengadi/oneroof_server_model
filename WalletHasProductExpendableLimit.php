<?php

/**
 * This is the model class for table "wallet_has_product_expendable_limit".
 *
 * The followings are the available columns in table 'wallet_has_product_expendable_limit':
 * @property string $wallet_id
 * @property string $product_id
 * @property double $expendable_value
 */
class WalletHasProductExpendableLimit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wallet_has_product_expendable_limit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_id, product_id', 'required'),
			array('expendable_value', 'numerical'),
			array('wallet_id, product_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wallet_id, product_id, expendable_value', 'safe', 'on'=>'search'),
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
			'wallet_id' => 'Wallet',
			'product_id' => 'Product',
			'expendable_value' => 'Expendable Value',
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

		$criteria->compare('wallet_id',$this->wallet_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('expendable_value',$this->expendable_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WalletHasProductExpendableLimit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * This is the function that limits the espendability of a products in a wallet
         */
        public function isTheLimitingOfThisWalletByProductSuccessful($product_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id){
            
            //$model = new WalletHasProductExpendableLimit;
            
            if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product_id)){
                
                if($this->isAnUpdateOfTheExtensibilityLimitInAWalletSuccessful($product_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                if($this->isTheCreationOfNewExpendibilityLimitForAProductASuccess($product_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        
        /**
         * This is the function that determines if an expendibility limit of a product exist in a wallet
         */
        public function doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('wallet_has_product_expendable_limit')
                    ->where("wallet_id = $wallet_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        /**
         * This is the function that updates the extensibility limit of a product in a wallet
         */
        public function isAnUpdateOfTheExtensibilityLimitInAWalletSuccessful($product_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id){
            
           //get the previous expensible value in the wallet
            $existing_expendable_value = $this->getTheExistingExpendableValue($wallet_id,$product_id);
            if($expendable_limits_in_percentage != -1){
                $expendable_value = ($expendable_limits_in_percentage/100) * $actual_voucher_share;
            }else{
                $expendable_value = $actual_voucher_share;
            }
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_product_expendable_limit',
                                  array(
                                    'expendable_value'=>$expendable_value + $existing_expendable_value,
                                    
                                      
                                                             
                            ),
                     ("product_id=$product_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
            
            
        }
        
        
        
        /**
         * This is the function that creates an expendible limit for a product
         */
        public function isTheCreationOfNewExpendibilityLimitForAProductASuccess($product_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id){
             if($expendable_limits_in_percentage != -1){
                $expendable_value = ($expendable_limits_in_percentage/100) * $actual_voucher_share;
            }else{
                $expendable_value = $actual_voucher_share;
            }
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->insert('wallet_has_product_expendable_limit',
                         array( 
                             'product_id'=>$product_id,
                             'wallet_id'=>$wallet_id,
                              'expendable_value'=>$expendable_value,
                
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
            
        }
        
        
        /*
         * This is the function that gets an existing expendible product limit
         */
        public function getTheExistingExpendableValue($wallet_id,$product_id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='product_id=:productid and wallet_id=:walletid';
            $criteria->params = array(':productid'=>$product_id, ':walletid'=>$wallet_id);
            $wallet= WalletHasProductExpendableLimit::model()->find($criteria);
            return $wallet['expendable_value'];
        }
        
        
        /**
         * This is the function that confirms if a product has an expensibility limit for the ease of purchase settlement
         */
        public function isProductWithExpensibilityLimitInTheWallet($wallet_id,$product_id){
            
            $model = new WalletHasCategoryExpendableLimit;
            //get the category of this product
            $category_id = $this->getTheCategoryIdOfThisProduct($product_id);
            if($model->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                return true;
            }else{
                if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product_id)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        /**
         * This is the function that gets a products prevailing expensibility limit
         */
        public function getThisProductPrevailingExpensibilityLimit($wallet_id,$product_id){
            $model = new WalletHasCategoryExpendableLimit;
            //get the category of this product
            $category_id = $this->getTheCategoryIdOfThisProduct($product_id);
            
            if($model->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                //get the category expensibility limit
                $product_category_limit = $model->getTheExistingExpendableValue($wallet_id,$category_id);
            }else{
                $product_category_limit = 0;
            }
            
            if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product_id)){
                //get the product expensibility limit
                $product_limit = $this->getTheExistingExpendableValue($wallet_id,$product_id);
            }else{
                $product_limit = 0;
            }
            
            if($product_category_limit>=$product_limit){
                return $product_category_limit; 
            }else{
                return $product_limit;
            }
            
        }
        
        
        /**
         * This is the function that determines the origin of a products expensibility limit
         */
        public function getTheOriginOfTheProductPrevailingExpensibilityLimit($wallet_id,$product_id){
            $model = new WalletHasCategoryExpendableLimit;
            //get the category of this product
            $category_id = $this->getTheCategoryIdOfThisProduct($product_id);
            
            if($model->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                //get the category expensibility limit
                $product_category_limit = $model->getTheExistingExpendableValue($wallet_id,$category_id);
            }else{
                $product_category_limit = 0;
            }
            
            if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product_id)){
                //get the product expensibility limit
                $product_limit = $this->getTheExistingExpendableValue($wallet_id,$product_id);
            }else{
                $product_limit = 0;
            }
            
            if($product_category_limit>=$product_limit){
                return strtolower('category');
            }else{
                return strtolower('product');
            }
        }
        
        
        /**
         * This is the function that confirms if a product expensibility limit is higher than its purchase cost
         */
        public function isTheProductExpensibilityLimitHigherThanItsCostOfPurchase($wallet_id,$product,$cost_of_this_product,$total_delivery_cost){
            //get the product cost of purchase
            $product_cost_of_purchase =  $cost_of_this_product + $total_delivery_cost;
            
            if($this->getThisProductPrevailingExpensibilityLimit($wallet_id,$product)>=$product_cost_of_purchase){
                return true;
            }else{
                return false;
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
         * This is the function that effects a new expensibility limit after adjustment
         */
        public function isTheAdjustmentOfTheProductExpensibilityLimitASuccess($wallet_id,$product_id,$new_expensibility_limit,$product_settlement_from,$product_expensibility_limit_from,$product_cost){
            
            $model = new WalletHasCategoryExpendableLimit;
            
            //get the category of this product
            $category_id = $this->getTheCategoryIdOfThisProduct($product_id);
            
            if($model->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                if($model->updateTheExpensibilityLimitOfThisCategoryByThisAmount($wallet_id,$category_id,$new_expensibility_limit,$product_expensibility_limit_from,$product_cost)){
                    if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product_id)){
                        if($this->updateTheExtensibilityOfThisProductByThisAmount($wallet_id,$product_id,$new_expensibility_limit,$product_expensibility_limit_from,$product_cost)){
                            return true;
                        }else{
                            return false;
                        }
                    
                    }else{
                        return true;
                    }
                }
            }else{
                if($this->doesAnExpendibilityLimitOfThisProductExistInThisWallet($wallet_id,$product_id)){
                        if($this->updateTheExtensibilityOfThisProductByThisAmount($wallet_id,$product_id,$new_expensibility_limit,$product_expensibility_limit_from,$product_cost)){
                            return true;
                        }else{
                            return false;
                        }
                    
                    }else{
                        return true;;
                    }
            }
        }
        
        /**
         * This is the function that updates the expensibility limit of a product
         */
        public function updateTheExtensibilityOfThisProductByThisAmount($wallet_id,$product_id,$expensibility_limit,$product_expensibility_limit_from,$product_cost){
            //get the expensibility limit of this product in this wallet
            $product_limit = $this->getTheExistingExpendableValue($wallet_id, $product_id);
            $new_product_expensibility_limit = $product_limit - $product_cost;
            if($new_product_expensibility_limit>=0){
                $new_product_expensibility_limit=$new_product_expensibility_limit;
            }else{
                $new_product_expensibility_limit=0;
            }
            
            if($product_expensibility_limit_from =='product'){
               $new_expensibility_limit = $expensibility_limit; 
            }else{
                $new_expensibility_limit = $new_product_expensibility_limit;
            }
        
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_product_expendable_limit',
                                  array(
                                    'expendable_value'=>$new_expensibility_limit,
                                    
                                      
                                                             
                            ),
                     ("product_id=$product_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that confirms the success of the reconstruction of a wallet product limit
         */
        public function isTheReconstructionOfThisWalletProductLimitASuccess($wallet_id,$product,$total_product_cost){
            
             $current_product_limit = $this->getTheExistingExpendableValue($wallet_id, $product_id);
             $new_expensibility_limit = $current_product_limit + $total_product_cost;
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_product_expendable_limit',
                                  array(
                                    'expendable_value'=>$new_expensibility_limit,
                                    
                                      
                                                             
                            ),
                     ("product_id=$product_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that reconstruct a product limiter after an adjustment
         */
        public function isProductLimitReconstructionASuccess($wallet_id,$product_id,$previous_limit){
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_product_expendable_limit',
                                  array(
                                    'expendable_value'=>$previous_limit,
                                    
                                      
                                                             
                            ),
                     ("product_id=$product_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
       
}
