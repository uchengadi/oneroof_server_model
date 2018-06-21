<?php

/**
 * This is the model class for table "wallet_has_category_expendable_limit".
 *
 * The followings are the available columns in table 'wallet_has_category_expendable_limit':
 * @property string $wallet_id
 * @property string $category_id
 * @property double $expendable_value
 */
class WalletHasCategoryExpendableLimit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wallet_has_category_expendable_limit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_id, category_id', 'required'),
			array('expendable_value', 'numerical'),
			array('wallet_id, category_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wallet_id, category_id, expendable_value', 'safe', 'on'=>'search'),
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
			'category_id' => 'Category',
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
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('expendable_value',$this->expendable_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WalletHasCategoryExpendableLimit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that limits the espendability of a products in a wallet
         */
        public function isTheLimitingOfThisWalletByCategorySuccessful($category_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id){
            
          if($this->doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id)){
                
                if($this->isAnUpdateOfTheExtensibilityLimitInAWalletSuccessful($category_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                if($this->isTheCreationOfNewExpendibilityLimitForACategoryASuccess($category_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        
        /**
         * This is the function that determines if an expendibility limit of a product exist in a wallet
         */
        public function doesAnExpendibilityLimitOfThisCategoryExistInThisWallet($wallet_id,$category_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('wallet_has_category_expendable_limit')
                    ->where("wallet_id = $wallet_id and category_id=$category_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        /**
         * This is the function that updates the extensibility limit of a category in a wallet
         */
        public function isAnUpdateOfTheExtensibilityLimitInAWalletSuccessful($category_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id){
            
           //get the previous expensible value in the wallet
            $existing_expendable_value = $this->getTheExistingExpendableValue($wallet_id,$category_id);
            if($expendable_limits_in_percentage != -1){
                $expendable_value = ($expendable_limits_in_percentage/100) * $actual_voucher_share;
            }else{
                $expendable_value = $actual_voucher_share;
            }
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_category_expendable_limit',
                                  array(
                                    'expendable_value'=>$expendable_value + $existing_expendable_value,
                                    
                                      
                                                             
                            ),
                     ("category_id=$category_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
            
            
        }
        
        
        
        /**
         * This is the function that creates an expendible limit for a product
         */
        public function isTheCreationOfNewExpendibilityLimitForACategoryASuccess($category_id,$expendable_limits_in_percentage,$actual_voucher_share,$wallet_id){
             if($expendable_limits_in_percentage != -1){
                $expendable_value = ($expendable_limits_in_percentage/100) * $actual_voucher_share;
            }else{
                $expendable_value = $actual_voucher_share;
            }
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->insert('wallet_has_category_expendable_limit',
                         array( 
                             'category_id'=>$category_id,
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
         * This is the function that gets an existing expendible category limit
         */
        public function getTheExistingExpendableValue($wallet_id,$category_id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='category_id=:categoryid and wallet_id=:walletid';
            $criteria->params = array(':categoryid'=>$category_id, ':walletid'=>$wallet_id);
            $wallet= WalletHasCategoryExpendableLimit::model()->find($criteria);
            return $wallet['expendable_value'];
        }
        
        
        /**
         * This is the value that updates the value of the extensibility limit in a category
         */
        public function updateTheExpensibilityLimitOfThisCategoryByThisAmount($wallet_id,$category_id,$expensibility_limit,$product_expensibility_limit_from,$product_cost){
            
            //get the expensibility limit of this category
            $category_limit = $this->getTheExistingExpendableValue($wallet_id, $category_id);
            $new_category_expensibility_limit = $category_limit - $product_cost;
            if($new_category_expensibility_limit >=0){
                $new_category_expensibility_limit=$new_category_expensibility_limit;
            }else{
                $new_category_expensibility_limit=0;
            }
            
            if($product_expensibility_limit_from =='category'){
               $new_expensibility_limit = $expensibility_limit; 
            }else{
               $new_expensibility_limit = $new_category_expensibility_limit; 
            }
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_category_expendable_limit',
                                  array(
                                    'expendable_value'=>$new_expensibility_limit,
                                    
                                      
                                                             
                            ),
                     ("category_id=$category_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that reconstruct a category limiter after an adgustment 
         */
        public function isThisCategoryLimitReconstructionASuccess($wallet_id,$category_id,$previous_limit){
            
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('wallet_has_category_expendable_limit',
                                  array(
                                    'expendable_value'=>$previous_limit,
                                    
                                      
                                                             
                            ),
                     ("category_id=$category_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
       
}
