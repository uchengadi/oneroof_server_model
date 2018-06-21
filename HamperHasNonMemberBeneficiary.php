<?php

/**
 * This is the model class for table "hamper_has_non_member_beneficiary".
 *
 * The followings are the available columns in table 'hamper_has_non_member_beneficiary':
 * @property string $id
 * @property string $hamper_id
 * @property string $beneficiary
 * @property string $status
 * @property integer $number_of_hampers_delivered
 * @property string $name_of_actual_receiver_of_the_hamper
 * @property string $place_of_delivery
 * @property string $courier_delivery_comment
 * @property string $beneficiary_delivery_comment
 * @property string $reason_for_hamper_return
 * @property string $date_hamper_was_delivered
 * @property string $date_hamper_was_returned
 * @property integer $delivery_was_made_to
 * @property integer $hamper_was_delivered_by
 * @property integer $hamper_was_returned_by
 * @property string $country_id
 * @property string $state_id
 * @property string $city_id
 *
 * The followings are the available model relations:
 * @property Product $hamper
 */
class HamperHasNonMemberBeneficiary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hamper_has_non_member_beneficiary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hamper_id, status, country_id, state_id, city_id', 'required'),
			array('number_of_hampers_delivered, delivery_was_made_to, hamper_was_delivered_by, hamper_was_returned_by', 'numerical', 'integerOnly'=>true),
			array('hamper_id, country_id, state_id, city_id', 'length', 'max'=>10),
			array('beneficiary, name_of_actual_receiver_of_the_hamper, place_of_delivery, courier_delivery_comment, beneficiary_delivery_comment, reason_for_hamper_return', 'length', 'max'=>200),
			array('status', 'length', 'max'=>9),
			array('date_hamper_was_delivered, date_hamper_was_returned', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hamper_id, beneficiary, status, number_of_hampers_delivered, name_of_actual_receiver_of_the_hamper, place_of_delivery, courier_delivery_comment, beneficiary_delivery_comment, reason_for_hamper_return, date_hamper_was_delivered, date_hamper_was_returned, delivery_was_made_to, hamper_was_delivered_by, hamper_was_returned_by, country_id, state_id, city_id', 'safe', 'on'=>'search'),
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
			'hamper' => array(self::BELONGS_TO, 'Product', 'hamper_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hamper_id' => 'Hamper',
			'beneficiary' => 'Beneficiary',
			'status' => 'Status',
			'number_of_hampers_delivered' => 'Number Of Hampers Delivered',
			'name_of_actual_receiver_of_the_hamper' => 'Name Of Actual Receiver Of The Hamper',
			'place_of_delivery' => 'Place Of Delivery',
			'courier_delivery_comment' => 'Courier Delivery Comment',
			'beneficiary_delivery_comment' => 'Beneficiary Delivery Comment',
			'reason_for_hamper_return' => 'Reason For Hamper Return',
			'date_hamper_was_delivered' => 'Date Hamper Was Delivered',
			'date_hamper_was_returned' => 'Date Hamper Was Returned',
			'delivery_was_made_to' => 'Delivery Was Made To',
			'hamper_was_delivered_by' => 'Hamper Was Delivered By',
			'hamper_was_returned_by' => 'Hamper Was Returned By',
			'country_id' => 'Country',
			'state_id' => 'State',
			'city_id' => 'City',
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
		$criteria->compare('hamper_id',$this->hamper_id,true);
		$criteria->compare('beneficiary',$this->beneficiary,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('number_of_hampers_delivered',$this->number_of_hampers_delivered);
		$criteria->compare('name_of_actual_receiver_of_the_hamper',$this->name_of_actual_receiver_of_the_hamper,true);
		$criteria->compare('place_of_delivery',$this->place_of_delivery,true);
		$criteria->compare('courier_delivery_comment',$this->courier_delivery_comment,true);
		$criteria->compare('beneficiary_delivery_comment',$this->beneficiary_delivery_comment,true);
		$criteria->compare('reason_for_hamper_return',$this->reason_for_hamper_return,true);
		$criteria->compare('date_hamper_was_delivered',$this->date_hamper_was_delivered,true);
		$criteria->compare('date_hamper_was_returned',$this->date_hamper_was_returned,true);
		$criteria->compare('delivery_was_made_to',$this->delivery_was_made_to);
		$criteria->compare('hamper_was_delivered_by',$this->hamper_was_delivered_by);
		$criteria->compare('hamper_was_returned_by',$this->hamper_was_returned_by);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('state_id',$this->state_id,true);
		$criteria->compare('city_id',$this->city_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HamperHasNonMemberBeneficiary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * This is th function that confirms if a member is already a beneficiary of a hamper
         */
        public function isThisMemberAlreadyABeneficiaryOfTheHamper($id){
            
           $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('hamper_has_non_member_beneficiary')
                    ->where("id = $id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that removes a beneficiay from the hamper's list
         */
        public function isTheRemovalOfBeneficiaryFromHamperListASuccess($id){
            
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('hamper_has_non_member_beneficiary', 'id=:id', array(':id'=>$id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that gets the total number of non member beneficiary of a hamper
         */
        public function getTheNumberOfTotalNonMemberBeneficiariesForThisHamper($hamper_id){
            
             $sum = 0;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:hamperid';
             $criteria->params = array(':hamperid'=>$hamper_id);
             $hampers= HamperHasNonMemberBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 $sum = $sum + 1;
             }
             
             return $sum;
        }
        
        /**
         * This is the function that gets the total number of hamper for non members delivery
         */
        public function getTheTotalNumberOfHampersForNonMembersDelivery($hamper_id){
            $sum = 0;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:hamperid';
             $criteria->params = array(':hamperid'=>$hamper_id);
             $hampers= HamperHasNonMemberBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 $sum = $sum + $hamper['number_of_hampers_delivered'];
             }
             
             return $sum;
        }
        
        /**
         * This is the function that gets the container price used for non members
         */
        public function getTheAverageNonMembersContainerPrice($hamper_id){
            
             $model = new HamperContainer;
            
            $sum = 0;
            $total_non_member_beneficiary = $this->getTheNumberOfTotalNonMemberBeneficiariesForThisHamper($hamper_id);
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasNonMemberBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 $sum = $sum + $model->getThePriceOfThisHamperContainer($hamper['hamper_container_id']);
             }
             if($total_non_member_beneficiary>0){
                  $average_non_member_container_price = $sum/$total_non_member_beneficiary;
             }else{
                 $average_non_member_container_price = 0;
             }
            
             return $average_non_member_container_price;
        }
        
        
         /**
         * This is the function that gets the total cost of delivery for non members
         */
        public function getTheTotalCostOfNonMembersHamperDelivery($hamper_id){
            $model = new City;
            
            $sum = 0;
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasNonMemberBeneficiary::model()->findAll($criteria);
             
            foreach($hampers as $hamper){
                 //get the total number of beneficiaries in this city
                 $city_beneficiaries = $this->getTheTotalNumberOfHampersToBeDeliveredInThisCityForNonMemberBeneficiaries($hamper_id,$hamper['city_id']);
                // $city_beneficiaries = -1; 
                if($city_beneficiaries <$model->getTheMinimumBeneficiaryNumberRequiredForMassDeliveryDiscountForThisCity($hamper['city_id'],$hamper['delivery_type'])){ 
                 $sum = $sum + $model->getTheCostOfHamperDeliveryToThisCity($hamper_id,$hamper['city_id'],$hamper['delivery_type']);
                
                    // return $sum;
                 }else{
                     //get the city delivery discount rate
                     $city_discount_rate = $model->getThisCityMassDeliveryDiscountRate($hamper['city_id'],$hamper['delivery_type']);
                     $sum = $sum - ($sum * $city_discount_rate);
                     //return $discounted_sum;
                 }
             }
             return $sum;
            
        }
        
        
        /**
         * This is the function that gets the total number of hampers to be delivered in a city
         */
        public function getTheTotalNumberOfHampersToBeDeliveredInThisCityForNonMemberBeneficiaries($hamper_id,$city_id){
          
             $counter = 0;
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasNonMemberBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 if($this->willThisBeneficiaryHamperBeDeliveredInThisCity($hamper['id'],$city_id)){
                     $counter = $counter + 1;
                 }
             }
             return $counter;
        }
        
        
         /**
         * This is the functon that determines if beneficiary hamper will be delivered in a city
         */
        public function willThisBeneficiaryHamperBeDeliveredInThisCity($id,$city_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $hamper= HamperHasNonMemberBeneficiary::model()->find($criteria);
             
             if($hamper['city_id'] == $city_id){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that gets all the containerss used for non member beneficiaries for a hamper
         */
        public function getAllTheContainersUsedForNonMembersBeneficiariesForThisHamper($hamper_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasNonMemberBeneficiary::model()->findAll($criteria);
             
             $containers = [];
             
             foreach($hampers as $hamper){
                 $containers[] = $hamper['hamper_container_id'];
             }
             
             return $containers;
            
        }
        
}
