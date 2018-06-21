<?php

/**
 * This is the model class for table "wallet_has_vouchers".
 *
 * The followings are the available columns in table 'wallet_has_vouchers':
 * @property string $wallet_id
 * @property string $voucher_id
 * @property string $status
 * @property double $voucher_share_in_percentage
 * @property double $actual_voucher_share
 * @property double $available_voucher_value
 * @property double $used_voucher_value
 * @property string $usage_commencement_date
 * @property string $date_voucher_was_added_to_wallet
 * @property string $date_voucher_was_updated
 * @property integer $voucher_was_added_by
 * @property integer $voucher_was_updated_by
 */
class WalletHasVouchers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wallet_has_vouchers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_id, voucher_id, status', 'required'),
			array('voucher_was_added_by, voucher_was_updated_by', 'numerical', 'integerOnly'=>true),
			array('voucher_share_in_percentage, actual_voucher_share, available_voucher_value, used_voucher_value', 'numerical'),
			array('wallet_id, voucher_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('usage_commencement_date, date_voucher_was_added_to_wallet, date_voucher_was_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wallet_id, voucher_id, status, voucher_share_in_percentage, actual_voucher_share, available_voucher_value, used_voucher_value, usage_commencement_date, date_voucher_was_added_to_wallet, date_voucher_was_updated, voucher_was_added_by, voucher_was_updated_by', 'safe', 'on'=>'search'),
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
			'voucher_id' => 'Voucher',
			'status' => 'Status',
			'voucher_share_in_percentage' => 'Voucher Share In Percentage',
			'actual_voucher_share' => 'Actual Voucher Share',
			'available_voucher_value' => 'Available Voucher Value',
			'used_voucher_value' => 'Used Voucher Value',
			'usage_commencement_date' => 'Usage Commencement Date',
			'date_voucher_was_added_to_wallet' => 'Date Voucher Was Added To Wallet',
			'date_voucher_was_updated' => 'Date Voucher Was Updated',
			'voucher_was_added_by' => 'Voucher Was Added By',
			'voucher_was_updated_by' => 'Voucher Was Updated By',
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
		$criteria->compare('voucher_id',$this->voucher_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('voucher_share_in_percentage',$this->voucher_share_in_percentage);
		$criteria->compare('actual_voucher_share',$this->actual_voucher_share);
		$criteria->compare('available_voucher_value',$this->available_voucher_value);
		$criteria->compare('used_voucher_value',$this->used_voucher_value);
		$criteria->compare('usage_commencement_date',$this->usage_commencement_date,true);
		$criteria->compare('date_voucher_was_added_to_wallet',$this->date_voucher_was_added_to_wallet,true);
		$criteria->compare('date_voucher_was_updated',$this->date_voucher_was_updated,true);
		$criteria->compare('voucher_was_added_by',$this->voucher_was_added_by);
		$criteria->compare('voucher_was_updated_by',$this->voucher_was_updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WalletHasVouchers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that funds a members wallet from a voucher
         */
        public function isTheFundingOfMemberWalletASucess($wallet_id,$voucher_id,$member_id,$remaining_voucher_value,$voucher_value,$allocated_voucher_value,$terms_and_conditions,$usage_commencement_date){
            if($this->hasThisVoucherFundedThisWalletBefore($wallet_id,$voucher_id)==false){
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->insert('wallet_has_vouchers',
                         array( 
                             'voucher_id'=>$voucher_id,
                             'wallet_id'=>$wallet_id,
                             'status'=>strtolower('inactive'),
                               'actual_voucher_share'=>$allocated_voucher_value,
                                'available_voucher_value'=>$allocated_voucher_value,
                                'used_voucher_value'=>0.00,
                                'voucher_share_in_percentage'=>(($allocated_voucher_value/$voucher_value)*100),
                                'accepted_terms_and_conditions'=>$terms_and_conditions,
                                'usage_commencement_date'=>$usage_commencement_date,
                                'date_voucher_was_added_to_wallet'=>new CDbExpression('NOW()'),
                               'voucher_was_added_by'=>Yii::app()->user->id
                                
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
                
            }else{
                $new_actual_voucher_share = $this->getTheExistActualValueInThewallet($wallet_id,$voucher_id) + $allocated_voucher_value;
                $voucher_share_in_percentage = (($new_actual_voucher_share)/$voucher_value)*100;
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_vouchers',
                                  array(
                                    'actual_voucher_share'=>$new_actual_voucher_share,
                                     'voucher_share_in_percentage'=>$voucher_share_in_percentage,
                                      'available_voucher_value'=>$new_actual_voucher_share,
                                                             
                            ),
                     ("voucher_id=$voucher_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
                
            }    
            
        }
        
        /**
         * This is the function that gets the existing actual value in the wallet
         */
        public function getTheExistActualValueInThewallet($wallet_id,$voucher_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='voucher_id=:voucherid and wallet_id=:walletid';
            $criteria->params = array(':voucherid'=>$voucher_id, ':walletid'=>$wallet_id);
            $wallet= WalletHasVouchers::model()->find($criteria);
            return $wallet['actual_voucher_share'];
        }
        
        
        /*8
         * This is the function that confirms if a voucher had funded a wallet before
         */
        public function hasThisVoucherFundedThisWalletBefore($wallet_id,$voucher_id){
            
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('wallet_has_vouchers')
                    ->where("wallet_id = $wallet_id and voucher_id=$voucher_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that ensures the activation of a fund in a waalet
         */
        public function isTheActivationOfThisFundSuccessful($wallet_id,$voucher_id,$usage_commencement_date){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_vouchers',
                                  array(
                                    'status'=>strtolower('active'),
                                     'usage_commencement_date'=>$usage_commencement_date
                                      
                                                             
                            ),
                     ("voucher_id=$voucher_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
            
        }
        
        
          /**
         * This is the function that ensures the suspension of a fund in a waalet
         */
        public function isTheSuspensionOfThisFundSuccessful($wallet_id,$voucher_id,$usage_commencement_date){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_vouchers',
                                  array(
                                    'status'=>strtolower('suspend'),
                                     'usage_commencement_date'=>$usage_commencement_date
                                      
                                                             
                            ),
                     ("voucher_id=$voucher_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
            
        }
        
        /**
         * This is the function that removes fund from a wallet
         */
        public function isTheRemovalOfThisFundFromWalletSuccessful($wallet_id,$voucher_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('wallet_has_vouchers', 'wallet_id=:walletid and voucher_id=:voucherid', array(':walletid'=>$wallet_id,':voucherid'=>$voucher_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that tops up a members value
         */
        public function isTheFundTopupOfMemberWalletASucess($wallet_id,$voucher_id,$new_allocated_voucher_value,$voucher_value,$usage_commencement_date,$new_available_balance){
            
            
            $voucher_share_in_percentage = (($new_allocated_voucher_value)/$voucher_value)*100;
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_vouchers',
                                  array(
                                    'actual_voucher_share'=>$new_allocated_voucher_value,
                                     'voucher_share_in_percentage'=>$voucher_share_in_percentage,
                                      'usage_commencement_date'=>$usage_commencement_date,
                                      'available_voucher_value'=>$new_available_balance
                                                             
                            ),
                     ("voucher_id=$voucher_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
            
        }
        
        
         /**
         * This is the function that gets the voucher's available balance in a members wallet
         */
        public function getTheAvailableBalanceOfThisVoucherInTheWallet($wallet_id,$voucher_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='voucher_id=:voucherid and wallet_id=:walletid';
            $criteria->params = array(':voucherid'=>$voucher_id, ':walletid'=>$wallet_id);
            $wallet= WalletHasVouchers::model()->find($criteria);
            return $wallet['available_voucher_value'];
        }
        
        
        /**
         * This is the function that gets the voucher's used balance in a members wallet
         */
        public function getTheAlreadyUsedVoucherValueInThisWallet($wallet_id,$voucher_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='voucher_id=:voucherid and wallet_id=:walletid';
            $criteria->params = array(':voucherid'=>$voucher_id, ':walletid'=>$wallet_id);
            $wallet= WalletHasVouchers::model()->find($criteria);
            return $wallet['used_voucher_value'];
        }
        
        
        /**
         * This is the function that determines if the status of a product limiter in wallet is active
         */
        public function isTheStatusOfThisProductLimiterActive($wallet_id, $product_id){
            
            $model = new VoucherLimitedToProducts;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
         
            foreach($wallets as $wallet){
            if($wallet['status'] ==strtolower('active')){
                if($model->isThisProductLimitingThisVoucher($wallet['voucher_id'],$product_id)){
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
         * This is the function that determines if the status of a category limiter in wallet is active
         */
        public function isTheStatusOfThisCategoryLimiterActive($wallet_id, $category_id){
            
            $model = new VoucherLimitedToCategories;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
         
            foreach($wallets as $wallet){
            if($wallet['status'] ==strtolower('active')){
                if($model->isThisCategoryLimitingThisVoucher($wallet['voucher_id'],$category_id)){
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
         * This is the function that determines if the status of a product limiter in wallet is suspended
         */
        public function isTheStatusOfThisProductLimiterSuspended($wallet_id, $product_id){
            
            $model = new VoucherLimitedToProducts;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
         
            foreach($wallets as $wallet){
            if($wallet['status'] ==strtolower('suspend')){
                if($model->isThisProductLimitingThisVoucher($wallet['voucher_id'],$product_id)){
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
         * This is the function that determines if the status of a category limiter in wallet is suspended
         */
        public function isTheStatusOfThisCategoryLimiterSuspended($wallet_id, $category_id){
            
            $model = new VoucherLimitedToCategories;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
         
            foreach($wallets as $wallet){
            if($wallet['status'] ==strtolower('suspend')){
                if($model->isThisCategoryLimitingThisVoucher($wallet['voucher_id'],$category_id)){
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
         * This is the function that retrieves usabe available funds
         */
        public function getTheAvailableUsableFunds($wallet_id,$operation){
            
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
            if($operation == 'expendable'){
                foreach($wallets as $wallet){
                    if($wallet['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($wallet['usage_commencement_date'])){
                           
                           if($this->isTheVoucherLimited($wallet['voucher_id'])==false){
                                $sum = $sum + $wallet['available_voucher_value'];
                            }
                        }
                    }
                }
                
            }else if($operation == 'suspended'){
                foreach($wallets as $wallet){
                    if($wallet['status']==strtolower('suspend')){
                        if($this->isThisFundImmediatelyAvailableForUse($wallet['usage_commencement_date'])){
                           if($this->isTheVoucherLimited($wallet['voucher_id'])==false){
                                $sum = $sum + $wallet['available_voucher_value'];
                            }
                        }
                    }
                }
            }
            return $sum;
        }
        
        
        /**
         * This is the function that retrieves  available funds for the future
         */
        public function getTheAvailableFundsForTheFuture($wallet_id,$operation){
            
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
            if($operation == 'expendable'){
                foreach($wallets as $wallet){
                    if($wallet['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($wallet['usage_commencement_date'])==false){
                            if($this->isTheVoucherLimited($wallet['voucher_id'])==false){
                                $sum = $sum + $wallet['available_voucher_value'];
                            }
                            
                            
                        }
                    }
                }
                
            }else if($operation == 'suspended'){
                foreach($wallets as $wallet){
                    if($wallet['status']==strtolower('suspend')){
                        if($this->isThisFundImmediatelyAvailableForUse($wallet['usage_commencement_date'])==false){
                            if($this->isTheVoucherLimited($wallet['voucher_id'])==false){
                                $sum = $sum + $wallet['available_voucher_value'];
                            }
                        }
                    }
                }
            }
            return $sum;
        }
        
        
        /**
         * This is the function that confirms if the available fund is ready for use
         */
        public function isThisFundImmediatelyAvailableForUse($usage_commencement_date){
            
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            
            $usage_commencement_date = getdate(strtotime($usage_commencement_date));
            
            if($this->isTodayGreaterThanOrEqualToUsageCommencementDate($today,$usage_commencement_date)){
                return true;
            }else{
                return false;
            }
        }
        
        /**
         * This is the that confirms the immediate usability of funds
         */
        public function isTodayGreaterThanOrEqualToUsageCommencementDate($today,$usage_commencement_date){
            
            if(($today['year'] - $usage_commencement_date['year'])>0){
                return true;
            }else if(($today['year'] - $usage_commencement_date['year'])<0){
                return false;
            }else{
                if(($today['mon'] - $usage_commencement_date['mon'])>0){
                    return true;
                }else if(($today['mon'] - $usage_commencement_date['mon'])<0){
                    return false;
                }else{
                    if(($today['mday'] - $usage_commencement_date['mday'])>0){
                        return true;
                    }else if(($today['mday'] - $usage_commencement_date['mday'])==0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
        
        
        /**
         * This is the function that determines if a voucher is limited
         */
        public function isTheVoucherLimited($voucher_id){
            if($this->isThisVoucherLimitedByProduct($voucher_id)){
                return true;
            }else if($this->isThisVoucherLimitedByCategory($voucher_id)){
                return true;
            }else{
                return false;
            }
            
        }
        
        /**
         * This is the function that determines if a voucher is limited by product
         */
        public function isThisVoucherLimitedByProduct($voucher_id){
            $model = new VoucherLimitedToProducts;
            return $model->isThisVoucherLimitedByProduct($voucher_id);
        }
        
        
         /**
         * This is the function that determines if a voucher is limited by category
         */
        public function isThisVoucherLimitedByCategory($voucher_id){
            $model = new VoucherLimitedToCategories;
            return $model->isThisVoucherLimitedByCategory($voucher_id);
        }
        
        
        /**
         * This is the function that gets the total available value in a wallet
         */
        public function getTheToTalAvailableValueInThisWallet($wallet_id){
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
           foreach($wallets as $wallet){
               if($wallet['status'] ==strtolower('active')){
                   $sum = $sum + $wallet['available_voucher_value'];
               }
           }
           return $sum;
        }
        
        
         /**
         * This is the function that gets the total suspended value in a wallet
         */
        public function getTheTotalSuspendedValueInThisWallet($wallet_id){
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
           foreach($wallets as $wallet){
               if($wallet['status'] ==strtolower('suspend')){
                   $sum = $sum + $wallet['available_voucher_value'];
               }
           }
           return $sum;
        }
        
        
        /**
         * This is the function that gets all available vouchers in a wallet
         */
        public function getAllTheExpendableAndAvailableVouchersInThisWallet($wallet_id){
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
            $vouchers = [];
            foreach($wallets as $wallet){
                    if($wallet['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($wallet['usage_commencement_date'])){
                           
                           $vouchers[] = $wallet['wallet_id'];
                        }
                    }
                }
                return $vouchers;
        }
        
        
        /**
         * This is the function that gets all available vouchers in a wallet
         */
        public function getAllTheExpendableAndAvailableAmountInThisWallet($wallet_id){
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $wallets= WalletHasVouchers::model()->findAll($criteria);
            
            $vouchers = [];
            foreach($wallets as $wallet){
                    if($wallet['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($wallet['usage_commencement_date'])){
                           
                           $sum = $sum + $wallet['available_voucher_value'];
                        }
                    }
                }
                return $sum;
        }
        
        
        /**
         * This is the function that provides all the free and usable fund in a wallet
         */
        public function getTheTotalFreeAndUsableFundInTheWallet($wallet_id){
            $model = new Voucher;
            
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $vouchers= WalletHasVouchers::model()->findAll($criteria);
            
           foreach($vouchers as $voucher){
                    if($voucher['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($voucher['usage_commencement_date'])){
                           if($model->isThisVoucherLimited($voucher['voucher_id'])){
                               if($model->isThisLimitedVoucherWithUnallocatedFund($wallet_id,$voucher['voucher_id'])){
                                   $sum = $sum + $this->getTheUnallocatedAndAvailableFundOfThisLimitedVoucherInTheWallet($wallet_id, $voucher['voucher_id']);
                               }
                               
                           }else{
                               $sum = $sum + $this->getTheAvailableBalanceOfThisVoucherInTheWallet($wallet_id, $voucher['voucher_id']);
                           }
                           
                        }
                    }
                }
                return $sum;
        }
        
        
        /**
         * This is the function that confirms if the adjustment of the wallet position is a success
         */
        public function isTheAdjustmentOfTheWalletPositionASuccess($wallet_id,$order_id,$product,$product_cost,$product_settlement_from){
            $model = new VoucherLimitedToProducts;
            if($product_settlement_from == strtolower('limits_only')){
                //get the wallet voucher that limited to this product and is ideal for value adjustment
                $voucher_id = $this->getTheIdealVoucherForAdjustment($wallet_id,$product,$product_cost);
                 $voucher_available_value = $this->getTheAvailableBalanceOfThisVoucherInTheWallet($wallet_id,$voucher_id);
                 $used_voucher_value = $this->getTheAlreadyUsedVoucherValueInThisWallet($wallet_id,$voucher_id);
                 $new_used_voucher_value = $used_voucher_value + $product_cost;
                $new_voucher_available_value = $voucher_available_value - $product_cost;
               
                 if($this->isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher_id,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value)){
                     if($this->isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher_id,$new_voucher_available_value,$new_used_voucher_value)){
                          return true;
                      }else{
                          return false;
                      }
                 }else{
                     return false;
                 }
                      
            }else if($product_settlement_from == strtolower('limits_and_free_pool')){
                $deductable_sum = 0;
                $actual_product_cost = $product_cost;
               //gets all the vouchers that is ideal for value adjustment
                $vouchers = $this->getAllVouchersIdealForValueAdjustmentInThisWallet($wallet_id,$product,$product_cost);
                foreach($vouchers as $voucher){
                    //get the current voucher value in the wallet
                    $voucher_available_value = $this->getTheAvailableBalanceOfThisVoucherInTheWallet($wallet_id,$voucher_id);
                     $used_voucher_value = $this->getTheAlreadyUsedVoucherValueInThisWallet($wallet_id,$voucher_id);
                   if($product_cost>=$voucher_available_value){
                       $new_used_voucher_value = $used_voucher_value + $voucher_available_value;
                       $new_voucher_available_value = $voucher_available_value + $voucher_available_value;
                       if($this->isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value)){
                           if($this->isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher_id,$voucher_available_value,$new_used_voucher_value)){
                                $deductable_sum = $deductable_sum + $voucher_available_value;
                                $product_cost = $product_cost - $voucher_available_value;
                            }
                       }
                       
                   }else{
                      $new_voucher_available_value = $voucher_available_value - $product_cost;
                      $new_used_voucher_value = $used_voucher_value + $product_cost;
                      if($this->isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value)){
                          if($this->isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher_id,$new_voucher_available_value,$new_used_voucher_value)){
                            $deductable_sum = $deductable_sum + $product_cost;
                            $product_cost = $product_cost - $product_cost;
                       }
                      }
                       
                   }
                }
                 if($actual_product_cost == $deductable_sum){
                        return true;
                  }else{
                        return false;
                    }
                
                
            }else if($product_settlement_from == strtolower('free_pool_only')){
                $deductable_sum = 0;
                $actual_product_cost = $product_cost;
               //gets all the vouchers that is ideal for value adjustment
                $vouchers = $this->getAllUnallocatedVouchersIdealForValueAdjustmentInThisWallet($wallet_id,$product,$product_cost);
                foreach($vouchers as $voucher){
                    //get the current voucher value in the wallet
                    $voucher_available_value = $this->getTheAvailableBalanceOfThisVoucherInTheWallet($wallet_id,$voucher_id);
                    $used_voucher_value = $this->getTheAlreadyUsedVoucherValueInThisWallet($wallet_id,$voucher_id);
                   if($product_cost>=$voucher_available_value){
                       $new_used_voucher_value = $used_voucher_value + $voucher_available_value;
                       $new_voucher_available_value = $voucher_available_value + $voucher_available_value;
                       if($this->isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value)){
                           if($this->isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher_id,$voucher_available_value,$new_used_voucher_value)){
                                $deductable_sum = $deductable_sum + $voucher_available_value;
                                $product_cost = $product_cost - $voucher_available_value;
                            }
                       }
                       
                   }else{
                      $new_voucher_available_value = $voucher_available_value - $product_cost;
                       $new_used_voucher_value = $used_voucher_value + $product_cost;
                       if($this->isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value)){
                           if($this->isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher_id,$voucher_available_value,$new_used_voucher_value)){
                                $deductable_sum = $deductable_sum + $product_cost;
                                $product_cost = $product_cost - $product_cost;
                            }
                       }
                       
                   }
                }
                if($actual_product_cost == $deductable_sum){
                        return true;
                  }else{
                        return false;
                    }
                
            }
           
        }
        
        
        /**
         * This is the function that gets all unallocated vouchers in a wallet that will be ideal for a particular settlement
         */
        public function getAllUnallocatedVouchersIdealForValueAdjustmentInThisWallet($wallet_id,$product,$product_cost){
            
            $model = new Voucher;
          
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $vouchers= WalletHasVouchers::model()->findAll($criteria);
            $all_vouchers = [];
            foreach($vouchers as $voucher){
                    if($voucher['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($voucher['usage_commencement_date'])){
                           if($model->isThisVoucherLimited($voucher_id) == false){
                                   $all_vouchers[] = $voucher['voucher_id'];
                               }
                           
                        }
                    }
                }
                return $all_vouchers;
            
        }
        
        
        /**
         * This is the function that gets all vouchers in a wallet that will be ideal for a particular settlement
         */
        public function getAllVouchersIdealForValueAdjustmentInThisWallet($wallet_id,$product,$product_cost){
            
            $model = new Voucher;
          
            $sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $vouchers= WalletHasVouchers::model()->findAll($criteria);
            $all_vouchers = [];
            foreach($vouchers as $voucher){
                    if($voucher['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($voucher['usage_commencement_date'])){
                           if($model->isThisVoucherLimitedToThisProduct($voucher['voucher_id'],$product)){
                              $all_vouchers[] = $voucher['voucher_id'];
                              
                           }else{
                               if($model->isThisVoucherLimited($voucher_id) == false){
                                   $all_vouchers[] = $voucher['voucher_id'];
                               }
                           }
                           
                        }
                    }
                }
                return $all_vouchers;
            
        }
        
        /**
         * This is the function that gets the voucher id for product cost settlement for limit-only settlement
         */
        public function getTheIdealVoucherForAdjustment($wallet_id,$product,$product_cost){
            $model = new Voucher;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid';
            $criteria->params = array(':walletid'=>$wallet_id);
            $vouchers= WalletHasVouchers::model()->findAll($criteria);
            $all_vouchers = [];
            foreach($vouchers as $voucher){
                    if($voucher['status']==strtolower('active')){
                        if($this->isThisFundImmediatelyAvailableForUse($voucher['usage_commencement_date'])){
                           if($model->isThisVoucherLimitedToThisProduct($voucher['voucher_id'],$product)){
                               if($this->canTheVoucherAvailableBalanceCoverTheCostOfThisProduct($wallet_id,$voucher['voucher_id'],$product_cost)){
                                   return $voucher['voucher_id'];
                                   
                               }
                           }
                           
                        }
                    }
                }
        
        }
        
        
        /**
         * This is the function that determines if an available balance of a voucher in a wallet can offset a product cost
         */
        public function canTheVoucherAvailableBalanceCoverTheCostOfThisProduct($wallet_id,$voucher_id,$product_cost){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid and voucher_id=:voucherid';
            $criteria->params = array(':walletid'=>$wallet_id,':voucherid'=>$voucher_id);
            $voucher= WalletHasVouchers::model()->find($criteria);
            
            if($voucher['available_voucher_value']>=$product_cost){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if a wallet adjustment after product payment
         */
        public function isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher_id,$new_voucher_available_value,$new_used_voucher_value){
             
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_vouchers',
                                  array(
                                    'available_voucher_value'=>$new_voucher_available_value,
                                    'used_voucher_value'=>$new_used_voucher_value,
                                              
                            ),
                     ("voucher_id=$voucher_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that reconstruct the unallocated fund of a wallet
         */
        public function isTheReconstructionOfThisWalletUnallocatedFundPoolSuccess($wallet_id,$product,$total_product_cost){
            //get all the vouchers in this wallet
            $counter = 0;
            $vouchers = $this->getAllVouchersIdealForValueAdjustmentInThisWallet($wallet_id, $product, $total_product_cost);
            
            foreach($vouchers as $voucher){
                //get the value actual share
                $voucher_share_amount = $this->getTheExistActualValueInThewallet($wallet_id,$voucher_id);
                //get the voucher available balance
                $voucher_available_balance = $this->getTheAvailableBalanceOfThisVoucherInTheWallet($wallet_id,$voucher_id);
                
                //get the used voucher amount
                $used_voucher_amount = $this->getTheAlreadyUsedVoucherValueInThisWallet($wallet_id,$voucher_id);
                
                if(($voucher_available_balance + $total_product_cost)<=$voucher_share_amount){
                    $new_available_balance = $voucher_available_balance + $total_product_cost;
                    $new_used_voucher_amount = $used_voucher_amount - $total_product_cost;
                    //effect the voucher update in the wallet
                    if($this->isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher,$new_available_balance,$new_used_voucher_amount)){
                        $total_product_cost = $total_product_cost-$total_product_cost;
                        $counter = $counter + 1;
                    }
                }else{
                    $amount_for_voucher = $voucher_share_amount - $voucher_available_balance;
                    $new_available_balance = $voucher_available_balance + $amount_for_voucher;
                    $new_used_voucher_amount = $used_voucher_amount -$amount_for_voucher;
                    if($this->isTheAdjustmentOfThisWalletASuccess($wallet_id,$voucher,$new_available_balance,$new_used_voucher_amount)){
                        $total_product_cost = $total_product_cost-$amount_for_voucher;
                        $counter = $counter + 1;
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
         * this is the function that registers a wallet adjuster and confirms its success
         */
        public function isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value){
            $model = new WalletAdjuster;
            return $model->isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value);
        }
      
        
        /**
         * This is the function that confirms the success of a wallet reconstruction after an adjustment
         */
        public function isTheReconstructionOfThisVoucherASuccess($wallet_id,$voucher_id,$previous_voucher_available_balance,$previous_voucher_used_balance){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_has_vouchers',
                                  array(
                                    'available_voucher_value'=>$previous_voucher_available_balance,
                                    'used_voucher_value'=>$previous_voucher_used_balance,
                                              
                            ),
                     ("voucher_id=$voucher_id and wallet_id=$wallet_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that gets the unallocated fund in a limited voucher
         */
        public function getTheUnallocatedAndAvailableFundOfThisLimitedVoucherInTheWallet($wallet_id, $voucher_id){
            $model = new VoucherLimitedToCategories;
            
            //$voucher_actual_value = $this->getTheExistActualValueInThewallet($wallet_id, $voucher_id);
            
           if($model->isThisVoucherLimitedByCategory($voucher_id)){
                $category_unallocated_amount = $model->getTheUnallocatedCategoryFundInTheLImitedVoucher($wallet_id,$voucher_id);
            }else{
                $category_unallocated_amount = 0;
            }
            if($this->isThisVoucherLimitedByProduct($voucher_id)){
                $product_unallocated_amount = $this->getTheUnallocatedProductFundInTheLimitedVoucher($wallet_id,$voucher_id);
            }else{
                $product_unallocated_amount = 0;
            }
            
            if($category_unallocated_amount>=$product_unallocated_amount){
                return $category_unallocated_amount;
            }else{
                return $product_unallocated_amount;
            }
                    
        }
        
        
        /**
         * This is the function that gets the unallocated fund in a product-limiting voucher
         */
        public function getTheUnallocatedProductFundInTheLimitedVoucher($wallet_id,$voucher_id){
            $model = new VoucherLimitedToProducts;
            return $model->getTheUnallocatedProductFundInTheLimitedVoucher($wallet_id,$voucher_id);
        }
}
