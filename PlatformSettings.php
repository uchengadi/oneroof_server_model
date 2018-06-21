<?php

/**
 * This is the model class for table "platform_settings".
 *
 * The followings are the available columns in table 'platform_settings':
 * @property string $id
 * @property string $platform_default_currency_id
 * @property string $platform_default_time_zone_id
 * @property double $managemenr_fee_in_percetanges
 * @property double $handling_charges_in_percetanges
 * @property double $shipping_charges_in_percetanges
 * @property integer $include_management_fees
 * @property integer $include_handling_charges
 * @property integer $include_shipping_charges
 * @property integer $icon_height
 * @property string $icon_mime_type
 * @property string $poster_mime_type
 * @property integer $poster_height
 * @property integer $poster_width
 * @property integer $icon_width
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Currencies $platformDefaultCurrency
 * @property Timezones $platformDefaultTimeZone
 */
class PlatformSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'platform_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('platform_default_currency_id, platform_default_time_zone_id, icon_height, poster_height, poster_width, icon_width', 'required'),
			array('include_management_fees, include_handling_charges, include_shipping_charges, icon_height, poster_height, poster_width, icon_width, create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('managemenr_fee_in_percetanges, handling_charges_in_percetanges, shipping_charges_in_percetanges', 'numerical'),
			array('platform_default_currency_id, platform_default_time_zone_id', 'length', 'max'=>10),
			array('icon_mime_type, poster_mime_type, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, platform_default_currency_id, platform_default_time_zone_id, managemenr_fee_in_percetanges, handling_charges_in_percetanges, shipping_charges_in_percetanges, include_management_fees, include_handling_charges, include_shipping_charges, icon_height, icon_mime_type, poster_mime_type, poster_height, poster_width, icon_width, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'platformDefaultCurrency' => array(self::BELONGS_TO, 'Currencies', 'platform_default_currency_id'),
			'platformDefaultTimeZone' => array(self::BELONGS_TO, 'Timezones', 'platform_default_time_zone_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'platform_default_currency_id' => 'Platform Default Currency',
			'platform_default_time_zone_id' => 'Platform Default Time Zone',
			'managemenr_fee_in_percetanges' => 'Managemenr Fee In Percetanges',
			'handling_charges_in_percetanges' => 'Handling Charges In Percetanges',
			'shipping_charges_in_percetanges' => 'Shipping Charges In Percetanges',
			'include_management_fees' => 'Include Management Fees',
			'include_handling_charges' => 'Include Handling Charges',
			'include_shipping_charges' => 'Include Shipping Charges',
			'icon_height' => 'Icon Height',
			'icon_mime_type' => 'Icon Mime Type',
			'poster_mime_type' => 'Poster Mime Type',
			'poster_height' => 'Poster Height',
			'poster_width' => 'Poster Width',
			'icon_width' => 'Icon Width',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_user_id' => 'Create User',
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
		$criteria->compare('platform_default_currency_id',$this->platform_default_currency_id,true);
		$criteria->compare('platform_default_time_zone_id',$this->platform_default_time_zone_id,true);
		$criteria->compare('managemenr_fee_in_percetanges',$this->managemenr_fee_in_percetanges);
		$criteria->compare('handling_charges_in_percetanges',$this->handling_charges_in_percetanges);
		$criteria->compare('shipping_charges_in_percetanges',$this->shipping_charges_in_percetanges);
		$criteria->compare('include_management_fees',$this->include_management_fees);
		$criteria->compare('include_handling_charges',$this->include_handling_charges);
		$criteria->compare('include_shipping_charges',$this->include_shipping_charges);
		$criteria->compare('icon_height',$this->icon_height);
		$criteria->compare('icon_mime_type',$this->icon_mime_type,true);
		$criteria->compare('poster_mime_type',$this->poster_mime_type,true);
		$criteria->compare('poster_height',$this->poster_height);
		$criteria->compare('poster_width',$this->poster_width);
		$criteria->compare('icon_width',$this->icon_width);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlatformSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
         /**
         * This is the function that gets the new unique number differentiator
         */
        public function uniqueNumberDifferentiator(){
                
                             
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $number= PlatformSettings::model()->find($criteria);
                
               $differentiator = $number['unique_number_differentiator'] + 1;
               
               //increment the value of the unique number differentiator
               $this->differentiatorIncrement($differentiator);
                   
               return $differentiator;
                
                
        }
        
        
        
         /**
         * This is the function that increments the differentiator
         */
        public function differentiatorIncrement($differentiator){
            
                           
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('platform_settings',
                         array('unique_number_differentiator'=>$differentiator,
                            
                        )
                        
                          
                     );
        }
        
        
        /**
         * This is the function that determines if management fees are allowed as part of the revenue
         */
        public function isManagementFeesIncluded(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                if($settings['include_management_fees'] == true){
                    return true;
                }else{
                    return false;
                }
                    
        }
        
        
        /**
         * This is the function that determines if management fees are allowed as part of the revenue
         */
        public function isHandlingChargesIncluded(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                if($settings['include_handling_charges'] == true){
                    return true;
                }else{
                    return false;
                }
                    
        }
        
        
        /**
         * This is the function that determines if management fees are allowed as part of the revenue
         */
        public function isShippingChargesIncluded(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                if($settings['include_shipping_charges'] == true){
                    return true;
                }else{
                    return false;
                }
                    
        }
        
        
        /**
         * This is the function that fetches the management charges in percentage
         */
        public function getTheManagementFees(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return ($settings['managemenr_fee_in_percetanges']);
            
            
        }
        
        
        
         /**
         * This is the function that fetches the management charges in percentage
         */
        public function getTheHandingCharges(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['handling_charges_in_percetanges'];
            
            
        }
        
        
        
         /**
         * This is the function that fetches the management charges in percentage
         */
        public function getTheShippingCharges(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['shipping_charges_in_percetanges'];
            
            
        }
        
        
        /**
         * This is the function that obtain applicable discount for a membership subscription
         */
        public function getThisApplicableDiscountForThisMembershiptype($membership_type_id,$number_of_years){
            $model = new MembershiptypeHasFees;
            
            if($this->isNumberOfYearsQualifiedForDiscount($number_of_years)){
                //get the applicable discount rate
                return ($this->getTheApplicableDiscountRate()*0.01 * $model->getTheGrossAmountOfThisMembershipType($membership_type_id,$number_of_years));
                
            }else{
                return 0;
            }
        }
        
        
        /**
         * This is the function that obtain applicable discount for a monthly membership subscription
         */
        public function getThisApplicableDiscountForThisMembershiptypeForMonthly($membership_type_id,$number_of_months){
            $model = new MembershiptypeHasFees;
            
            if($this->isNumberOfMonthsQualifiedForDiscount($number_of_months)){
                //get the applicable discount rate
                return ($this->getTheApplicableMonthlyDiscountRate()*0.01 * $model->getTheGrossAmountOfThisMembershipTypeForMonthly($membership_type_id,$number_of_months));
                
            }else{
                return 0;
            }
        }
        
        
        /**
         * This is the function that determines  if the provided nummber of years is qualified for discount
         */
        public function isNumberOfYearsQualifiedForDiscount($nunmber_of_years){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                if($settings['min_years_required_for_discount'] <= $nunmber_of_years){
                    return true;
                }else{
                    return false;
                }
        }
        
        
         /**
         * This is the function that determines  if the provided nummber of months is qualified for discount
         */
        public function isNumberOfMonthsQualifiedForDiscount($number_of_months){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                if($settings['min_months_required_for_discount'] <= $number_of_months){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /*
         *This is the function that obtains the applicable discount rate
         */
        public function getTheApplicableDiscountRate(){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['discount_rate'];
        }
        
        
        /*
         *This is the function that obtains the applicable monthly discount rate
         */
        public function getTheApplicableMonthlyDiscountRate(){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['monthly_discount_rate'];
        }
        
        
        
        /**
         * This is the function that retrieves the top priority delivery charges in percentages 
         */
        public function getTheTopPriorityDeliveryPercentageCharge(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['top_priority_delivery_in_percentage'];
            
            
        }
        
        
        /**
         * This is the function that retrieves the priority delivery charges in percentages 
         */
        public function getThePriorityDeliveryPercentageCharge(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['priority_delivery_in_percentage'];
            
            
        }
        
        
         /**
         * This is the function that retrieves the standard delivery charges in percentages 
         */
        public function getTheStandardDeliveryPercentageCharge(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['standard_delivery_in_percentage'];
            
            
        }
        
        
         /**
         * This is the function that retrieves the top priority delivery minimum amount 
         */
        public function getTheTopPriorityMinimumApplicableAmount(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['minimum_top_priority_delivery_amount'];
            
            
        }
        
        
        
        /**
         * This is the function that retrieves the priority delivery minimum amount 
         */
        public function getThePriorityMinimumApplicableAmount(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['minimum_priority_delivery_amount'];
            
            
        }
        
        
         /**
         * This is the function that retrieves the standard delivery minimum amount 
         */
        public function getTheStandardMinimumApplicableAmount(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['minimum_standard_delivery_amount'];
            
            
        }
        
        
        /**
         * This is the function that calculates the delivery charges for a transaction
         */
        public function getTheDeliveryChargeForThisTransaction($cart_amount,$delivery_type){
            if($delivery_type == 'none'){
                return 0;
            }else if($delivery_type == 'top'){
                $delivery_charges = $cart_amount * ($this->getTheTopPriorityDeliveryPercentageCharge())/100;
                if($delivery_charges>=$this->getTheTopPriorityMinimumApplicableAmount()){
                    return $delivery_charges;
                }else{
                    return $this->getTheTopPriorityMinimumApplicableAmount();
                }
            }else if($delivery_type == 'priority'){
                $delivery_charges = $cart_amount * ($this->getThePriorityDeliveryPercentageCharge())/100;
                if($delivery_charges>=$this->getThePriorityMinimumApplicableAmount()){
                    return $delivery_charges;
                }else{
                    return $this->getThePriorityMinimumApplicableAmount();
                }
                
            }else if($delivery_type == 'standard'){
                $delivery_charges = $cart_amount * ($this->getTheStandardDeliveryPercentageCharge())/100;
                if($delivery_charges>=$this->getTheStandardMinimumApplicableAmount()){
                    return $delivery_charges;
                }else{
                    return $this->getTheStandardMinimumApplicableAmount();
                }
            }
        }
        
       
        /**
         * This is the function that gets the maximum days before quotes submission
         */
        public function retrieveTheMaximumDaysBeforeQuoteSubmission(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['max_days_for_quote_submission_request'];
            
        }
        
        
         /**
         * This is the function that gets the maximum days before quotes submission
         */
        public function retrieveTheMaximumDaysBeforeQuoteAcceptance(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['max_days_for_quote_acceptance_request'];
            
        }
        
        
        /**
         * This is the function that determines if the monthly limit of a member had been exceeded  
         */
        public function isMonthlyLimitOfMemberNotReached($member_id,$total_amount_quoted){
            $model = new QuoteHasResponse;
            if($this->isThisAmountNotHigherThanMemberMonthlyLimit($member_id,$total_amount_quoted)){
                $total_amount_of_quote_handle = $model->getTheTotalAmountOfQuotesHandledByMemberInThisMonth($member_id);
                $new_total_amount_handled_after_this_one = $total_amount_of_quote_handle  + $total_amount_quoted;
                if($this->isThisAmountNotHigherThanMemberMonthlyLimit($member_id,$new_total_amount_handled_after_this_one)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that determines if a members daily limit is reached
         */
        public function isMemberWithinDailyTransactionLimited($member_id,$total_amount_quoted){
            $model = new QuoteHasResponse;
            $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
            if($this->isThisAmountNotHigherThanMemberDailyTransactionLimit($member_id,$total_amount_quoted)){
                $today_total_daily_transaction_handled = $model->getTheTotalAmountOfQuotesHandledByThisMemberToday($member_id,$today);
                $new_today_total_amount_handled_after_this_one = $today_total_daily_transaction_handled  + $total_amount_quoted;
                if($this->isThisAmountNotHigherThanMemberDailyTransactionLimit($member_id,$new_today_total_amount_handled_after_this_one)){
                    return true;
                }else{
                    return false;
                }
            }return false;
        }
        
        
        /**
         * This is the function that ensures that an amount is not higher than a members monthly limit
         */
        public function isThisAmountNotHigherThanMemberMonthlyLimit($member_id,$amount){
            $members_monthly_quotation_limit = $this->getThisMemberMonthlyQuotationLimit($member_id);
            if($members_monthly_quotation_limit>=$amount){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that gets a members subscription limit
         */
        public function getThisMemberMonthlyQuotationLimit($member_id){
            $model = new MembershipSubscription;
            $member_subscription_type = $model->getThisMemberMembershipType($member_id);
            
            $subscription_quotation_limit = $this->getThisSubscriptionMonthlyQuotationLimit($member_subscription_type);
            return $subscription_quotation_limit;
            
        }
        
        
        /**
         * This is the function that gets a subscription quotation monthly limit
         */
      public function getThisSubscriptionMonthlyQuotationLimit($member_subscription_type){
          
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                if($member_subscription_type == strtolower('business')){
                    return $settings['business_subscription_monthly_quotation_limit'];
                }else if ($member_subscription_type == strtolower('business_prime')){
                    return $settings['business_prime_subscription_monthly_quotation_limit'];
                }else if($member_subscription_type == strtolower('basic_prime')){
                    return $settings['basic_prime_subscription_monthly_quotation_limit'];
                }else{
                    return 0;
                }
      }
      
      
      /**
       * This is the function that confirms if a member has not exceeded daily quotation limit
       */
      public function isThisAmountNotHigherThanMemberDailyTransactionLimit($member_id,$amount){
          $members_daily_quotation_limit = $this->getThisMemberDailyQuotationLimit($member_id);
            if($members_daily_quotation_limit>=$amount){
                return true;
            }else{
                return false;
            }
      }
      
      
      /**
       * This is the function that gets a members daily transaction limit
       */
      public function getThisMemberDailyQuotationLimit($member_id){
           $model = new MembershipSubscription;
            $member_subscription_type = $model->getThisMemberMembershipType($member_id);
            
            $subscription_daily_quotation_limit = $this->getThisSubscriptionDailyQuotationLimit($member_subscription_type);
            return $subscription_daily_quotation_limit;
      }
      
      /**
       * This is the function that gets a members daily quotation limit
       */
      public function getThisSubscriptionDailyQuotationLimit($member_subscription_type){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                if($member_subscription_type == strtolower('business')){
                    return $settings['business_subscription_daily_quotation_limit'];
                }else if ($member_subscription_type == strtolower('business_prime')){
                    return $settings['business_prime_subscription_daily_quotation_limit'];
                }else if($member_subscription_type == strtolower('basic_prime')){
                    return $settings['basic_prime_subscription_daily_quotation_limit'];
                }else{
                    return 0;
                }
      }
      
      
      /**
         * This is the function that retrieves the escrow rate on the platform
         */
        public function getTheApplicableEscrowRate(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['escrow_rate_in_percentages'];
        }
        
        
         /**
         * This is the function that retrieves the minimum applicable escrow amount on the platform
         */
        public function getTheMinimumApplicableEscrowAmount(){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                //  $criteria->condition='id=:id';
                //  $criteria->params = array(':id'=>$fee_id);
                $settings= PlatformSettings::model()->find($criteria);
                
                return $settings['escrow_minimum_amount'];
        }
        
        
         /**
         * This is the function that retrieves the maximum product video size
         */
        public function getTheMaximumVideoSizeForThisService(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            //$criteria->condition='id=:id';
           // $criteria->params = array(':id'=>$id);
            $settings = PlatformSettings::model()->find($criteria);
            
            return $settings['product_maximum_video_size'];
        }
        
        
        /**
         * This is the function that retrieves the maximum amount allowed for cash transaction
         */
        public function getTheMaximumAllowableCashTransaction(){
             $criteria = new CDbCriteria();
            $criteria->select = '*';
            //$criteria->condition='id=:id';
           // $criteria->params = array(':id'=>$id);
            $settings = PlatformSettings::model()->find($criteria);
            
            return $settings['maximum_allowable_cash_transaction'];
        }
        
        /**
         * This is the function that retrieves the prevailing product padd length number
         */
        public function getThePrevailingProductCodePadLength(){
             $criteria = new CDbCriteria();
            $criteria->select = '*';
            //$criteria->condition='id=:id';
           // $criteria->params = array(':id'=>$id);
            $settings = PlatformSettings::model()->find($criteria);
            
            return $settings['product_code_pad_length'];
        }
        
}
