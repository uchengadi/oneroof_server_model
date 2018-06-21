<?php

/**
 * This is the model class for table "hamper_has_beneficiary".
 *
 * The followings are the available columns in table 'hamper_has_beneficiary':
 * @property string $hamper_id
 * @property string $beneficiary_id
 * @property string $status
 * @property integer $delivery_is_redirectable
 * @property string $name_of_actual_receiver_of_the_hamper
 * @property string $place_of_delivery
 * @property string $courier_delivery_comment
 * @property string $beneficiary_delivery_comment
 * @property string $reason_for_hamper_return
 * @property string $date_hamper_was_delivered
 * @property string $date_hamper_was_returned
 * @property integer $delivery_was_made_to
 * @property integer $hamper_was_deliveryed_by
 * @property integer $hamper_was_returned_by
 */
class HamperHasBeneficiary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hamper_has_beneficiary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hamper_id, beneficiary_id, status', 'required'),
			array('delivery_is_redirectable, delivery_was_made_to, hamper_was_deliveryed_by, hamper_was_returned_by', 'numerical', 'integerOnly'=>true),
			array('hamper_id, beneficiary_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('name_of_actual_receiver_of_the_hamper, place_of_delivery, courier_delivery_comment, beneficiary_delivery_comment, reason_for_hamper_return', 'length', 'max'=>200),
			array('date_hamper_was_delivered, date_hamper_was_returned', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hamper_id, beneficiary_id, status, delivery_is_redirectable, name_of_actual_receiver_of_the_hamper, place_of_delivery, courier_delivery_comment, beneficiary_delivery_comment, reason_for_hamper_return, date_hamper_was_delivered, date_hamper_was_returned, delivery_was_made_to, hamper_was_deliveryed_by, hamper_was_returned_by', 'safe', 'on'=>'search'),
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
			'hamper_id' => 'Hamper',
			'beneficiary_id' => 'Beneficiary',
			'status' => 'Status',
			'delivery_is_redirectable' => 'Delivery Is Redirectable',
			'name_of_actual_receiver_of_the_hamper' => 'Name Of Actual Receiver Of The Hamper',
			'place_of_delivery' => 'Place Of Delivery',
			'courier_delivery_comment' => 'Courier Delivery Comment',
			'beneficiary_delivery_comment' => 'Beneficiary Delivery Comment',
			'reason_for_hamper_return' => 'Reason For Hamper Return',
			'date_hamper_was_delivered' => 'Date Hamper Was Delivered',
			'date_hamper_was_returned' => 'Date Hamper Was Returned',
			'delivery_was_made_to' => 'Delivery Was Made To',
			'hamper_was_deliveryed_by' => 'Hamper Was Deliveryed By',
			'hamper_was_returned_by' => 'Hamper Was Returned By',
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

		$criteria->compare('hamper_id',$this->hamper_id,true);
		$criteria->compare('beneficiary_id',$this->beneficiary_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('delivery_is_redirectable',$this->delivery_is_redirectable);
		$criteria->compare('name_of_actual_receiver_of_the_hamper',$this->name_of_actual_receiver_of_the_hamper,true);
		$criteria->compare('place_of_delivery',$this->place_of_delivery,true);
		$criteria->compare('courier_delivery_comment',$this->courier_delivery_comment,true);
		$criteria->compare('beneficiary_delivery_comment',$this->beneficiary_delivery_comment,true);
		$criteria->compare('reason_for_hamper_return',$this->reason_for_hamper_return,true);
		$criteria->compare('date_hamper_was_delivered',$this->date_hamper_was_delivered,true);
		$criteria->compare('date_hamper_was_returned',$this->date_hamper_was_returned,true);
		$criteria->compare('delivery_was_made_to',$this->delivery_was_made_to);
		$criteria->compare('hamper_was_deliveryed_by',$this->hamper_was_deliveryed_by);
		$criteria->compare('hamper_was_returned_by',$this->hamper_was_returned_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HamperHasBeneficiary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that adds a member as a hamper beneficoary
         */
        public function isTheAdditionOfThisMemberAsHamperBeneficiaryASuccess($hamper_id,$beneficiary_id,$number_of_hampers_delivered,$city_id,$state_id,$country_id,$place_of_delivery,$delivery_address_option,$delivery_is_redirectable,$delivery_type,$hamper_container_id){
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->insert('hamper_has_beneficiary',
                         array('hamper_id'=>$hamper_id,
                                'beneficiary_id' =>$beneficiary_id,
                                'status'=>'pending',
                                 'number_of_hampers_delivered'=>$number_of_hampers_delivered,
                                 'city_id'=>$city_id,
                                 'state_id'=>$state_id,
                                 'country_id'=>$country_id,
                                 'place_of_delivery'=>$place_of_delivery,
                                 'delivery_address_option'=>$delivery_address_option,
                                 'delivery_is_redirectable'=>$delivery_is_redirectable,
                                 'delivery_type'=>$delivery_type,
                                 'hamper_container_id'=>$hamper_container_id
                                                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        
        /**
         * This is the function that updates a member as a hamper beneficoary
         */
        public function isTheUpdateOfThisMemberAsHamperBeneficiaryASuccess($hamper_id,$beneficiary_id,$number_of_hampers_delivered,$city_id,$state_id,$country_id,$place_of_delivery,$delivery_address_option,$delivery_is_redirectable,$delivery_type,$hamper_container_id){
             
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('hamper_has_beneficiary',
                        array('status'=>'pending',
                                 'number_of_hampers_delivered'=>$number_of_hampers_delivered,
                                 'city_id'=>$city_id,
                                 'state_id'=>$state_id,
                                 'country_id'=>$country_id,
                                 'place_of_delivery'=>$place_of_delivery,
                                 'delivery_address_option'=>$delivery_address_option,
                                 'delivery_is_redirectable'=>$delivery_is_redirectable,
                                 'delivery_type'=>$delivery_type,
                                 'hamper_container_id'=>$hamper_container_id
                                                           
                        ),
                        ("hamper_id=$hamper_id and beneficiary_id=$beneficiary_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
            
          
        }
        
        
        /**
         * This is th function that confirms if a member is already a beneficiary of a hamper
         */
        public function isThisMemberAlreadyABeneficiaryOfTheHamper($beneficiary_id,$hamper_id){
            
           $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('hamper_has_beneficiary')
                    ->where("hamper_id = $hamper_id and beneficiary_id=$beneficiary_id");
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
        public function isTheRemovalOfBeneficiaryFromHamperListASuccess($hamper_id,$beneficiary_id){
            
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('hamper_has_beneficiary', 'hamper_id=:hamperid and beneficiary_id=:beneid', array(':hamperid'=>$hamper_id,':beneid'=>$beneficiary_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that gets the total number of beneficiaries of a hamper
         */
        public function getTheNumberOfTotalMemberBeneficiariesForThisHamper($hamper_id){
            
            $sum = 0;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 $sum = $sum + 1;
             }
             
             return $sum;
            
        }
        
        /**
         * This is the function that gets the total number of a hamper for delivery
         */
        public function getTheTotalNumberOfThisHamperForDelivery($hamper_id){
            $model = new HamperHasNonMemberBeneficiary;
            
           //get the total number of hampers for members delivery 
            $total_number_of_hamper_for_members_delivery = $this->getTheTotalNumberOfHampersForMembersDelivery($hamper_id);
            
            //get the total number of hampers for non members delivery
            $total_number_of_hamper_for_non_members_delivery = $model->getTheTotalNumberOfHampersForNonMembersDelivery($hamper_id);
            
            //the total number of hampers for delivery is:
            $total_hampers_for_delivery = $total_number_of_hamper_for_members_delivery + $total_number_of_hamper_for_non_members_delivery;
            
            return $total_hampers_for_delivery;
        }
        
        
        /**
         * This is the function that gets the total number of hampers for delivery to members
         */
        public function getTheTotalNumberOfHampersForMembersDelivery($hamper_id){
            
            $sum = 0;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 $sum = $sum + $hamper['number_of_hampers_delivered'];
             }
             
             return $sum;
        }
        
        
        /**
         * This is the function that gets the average price of beneficiaries hamper container
         */
        public function getTheAveragePriceOfBeneficiaryHamperContainer($hamper_id){
            
            $model = new HamperHasNonMemberBeneficiary;
            
            //get the average container price for members
            $average_members_container_price = $this->getTheAverageMembersContainerPrice($hamper_id);
            
            //get the average non member container price
            $average_non_members_container_price = $model->getTheAverageNonMembersContainerPrice($hamper_id);
            
            $average_container_price = $average_members_container_price + $average_non_members_container_price;
            
            return $average_container_price;
            
        }
        
        
        /**
         * This is the functioon that gets the average member container price
         */
        public function getTheAverageMembersContainerPrice($hamper_id,$cost_of_hamper_items){
            $model = new HamperContainer;
            
            $sum = 0;
            $total_member_beneficiary = $this->getTheNumberOfTotalMemberBeneficiariesForThisHamper($hamper_id);
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 $sum = $sum + $model->getThePriceOfThisHamperContainer($hamper['hamper_container_id'],$cost_of_hamper_items) ;
             }
             if($total_member_beneficiary>0){
                 $average_member_container_price = $sum/$total_member_beneficiary;
             }else{
                 $average_member_container_price = 0;
             }
             
             return $average_member_container_price;
  
        }
        
        
        /**
         * This is the function that retrieves the average cost of hamper delivery
         */
        public function getTheAverageCostOfHamperDelivery($hamper_id){
            
            $model = new HamperHasNonMemberBeneficiary;
            
            //get the total cost of members' hamper delivery
            $cost_of_members_hamper_delivery = $this->getTheTotalCostOfMembersHamperDelivery($hamper_id);
            
            //get the total cost of  non members hampers delivery
            $cost_of_non_members_hamper_delivery = $model->getTheTotalCostOfNonMembersHamperDelivery($hamper_id);
            
            //get the total number of member beneficiaries of this hamper
            $total_number_of_member_hamper_beneficiary = $this->getTheNumberOfTotalMemberBeneficiariesForThisHamper($hamper_id);
            
            //get the total number of non member beneficiaries of this hamper
            $total_number_of_non_member_hamper_beneficiary = $model->getTheNumberOfTotalNonMemberBeneficiariesForThisHamper($hamper_id);
            
            //get the total cost of delivery
            $total_cost_of_delivery = $cost_of_members_hamper_delivery + $cost_of_non_members_hamper_delivery;
            
            //total number of hamper beneficiaries
            $total_number_of_hamper_beneficiaries = $total_number_of_member_hamper_beneficiary + $total_number_of_non_member_hamper_beneficiary;
            
            if($total_number_of_hamper_beneficiaries>0){
                $average_cost_of_hamper_delivery  = $total_cost_of_delivery/$total_number_of_hamper_beneficiaries;
            }else{
                $average_cost_of_hamper_delivery = 0;
            }
            
            
            return $average_cost_of_hamper_delivery;
            
        }
        
        
        
        /**
         * This is the function that gets the total cost of delivery for members
         */
        public function getTheTotalCostOfMembersHamperDelivery($hamper_id){
            $model = new City;
            
            $sum = 0;
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 //get the total number of beneficiaries in this city
                $city_beneficiaries = $this->getTheTotalNumberOfHampersToBeDeliveredInThisCityForMemberBeneficiaries($hamper_id,$hamper['city_id']);
                //$city_beneficiaries = -1;
                if($city_beneficiaries <$model->getTheMinimumBeneficiaryNumberRequiredForMassDeliveryDiscountForThisCity($hamper['city_id'],$hamper['delivery_type'])){
                  $sum = $sum + $model->getTheCostOfHamperDeliveryToThisCity($hamper_id,$hamper['city_id'],$hamper['delivery_type']);
                    // return $sum ;
                 }else{
                     //get the city delivery discount rate
                     $city_discount_rate = $model->getThisCityMassDeliveryDiscountRate($hamper['city_id'],$hamper['delivery_type']);
                     $sum = $sum - ($sum * $city_discount_rate);
                     //return $sum;
                 }
             }
            return $sum;
            
            
        }
        
        /**
         * This is the function that gets the total number of hamper beneficiaries from a city
         */
        public function getTheTotalNumberOfHampersToBeDeliveredInThisCityForMemberBeneficiaries($hamper_id,$city_id){
            $model = new City;
            
             $counter = 0;
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 if($this->willThisBeneficiaryHamperBeDeliveredInThisCity($hamper_id,$hamper['beneficiary_id'],$city_id)){
                     $counter = $counter + 1;
                 }
             }
             return $counter;
            
        }
        
        /**
         * This is the functon that determines if beneficiary hamper will be delivered in a city
         */
        public function willThisBeneficiaryHamperBeDeliveredInThisCity($hamper_id,$beneficiary_id,$city_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id and beneficiary_id=:beneid';
             $criteria->params = array(':id'=>$hamper_id, ':beneid'=>$beneficiary_id);
             $hamper= HamperHasBeneficiary::model()->find($criteria);
             
             if($hamper['city_id'] == $city_id){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that gets the container id of a hamper
         * 
         */
        public function getTheContainerForThisHamper($hamper_id,$beneficiary_id){
            $model = new HamperHasNonMemberBeneficiary;
            if($model->doesHamperHasANonMemberBeneficiary($hamper_id)){
                return $model->getTheContainerIdOfThisHamperForNonMember($hamper_id);
            }else{
                return $this->getTheContainerIdForThisHamperForThisBeneficiary($hamper_id,$beneficiary_id);
            }
        }
        
        
        /**
         * This is the function that retrieves container id for hamper beneficiaries
         */
        public function getTheContainerIdForThisHamperForThisBeneficiary($hamper_id,$beneficiary_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id and beneficiary_id=:beneid';
             $criteria->params = array(':id'=>$hamper_id,':beneid'=>$beneficiary_id);
             $beneficiary_id= HamperHasBeneficiary::model()->find($criteria);
             
             return $beneficiary_id['hamper_container_id'];
            
        }
        
        
        /**
         * This is the function that retrieves all the containers used for member beneficiaries for an hamper
         */
        public function getAllTheContainersUsedForMembersBeneficiariesForThisHamper($hamper_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasBeneficiary::model()->findAll($criteria);
             
             $containers = [];
             
             foreach($hampers as $hamper){
                 $containers[] = $hamper['hamper_container_id'];
             }
             
             return $containers;
        }
        
        
        /**
         * This is the function that gets the total cost of a hamper
         */
        public function getTheTotalCostOfThisHamper($hamper_id){
            $model = new HamperHasProducts;

            //get the unit price of the hamper
            $hamper_and_containers_cost = $model->getTheTotalPriceOfItemsInAHamper($hamper_id) + $this->getTheCostOfContainerInThisHamper($hamper_id,$model->getTheTotalPriceOfItemsInAHamper($hamper_id)) ;
            
            //get the number of hampers delivered to memeber beneficiaries
            $member_beneficiaries = $this->getTheTotalNumberOfHampersForMembersDelivery($hamper_id);
            
             //get the number of hampers delivered to non memeber beneficiaries
            $nonmember_beneficiaries = $this->getTheTotalNumberOfHampersForNonMembersDelivery($hamper_id);
            
            //get the total hamper delivered to both members and non members
            $total_hamper_delivered = $member_beneficiaries + $nonmember_beneficiaries;
            
            //get the total cost of hamper
            $total_cost = $hamper_and_containers_cost * $total_hamper_delivered;
            
            return $total_cost;
        }
        
        
       
        
        
        /**
         * This is the function that gets the total number of non member beneficiaries
         */
        public function getTheNumberOfTotalNonMemberBeneficiariesForThisHamper($hamper_id){
            $model = new HamperHasNonMemberBeneficiary;
            return $model->getTheNumberOfTotalNonMemberBeneficiariesForThisHamper($hamper_id);
        }
        
         /**
         * This is the function that gets the total number of hamperd delivered to non member beneficiaries
         */
        public function getTheTotalNumberOfHampersForNonMembersDelivery($hamper_id){
            $model = new HamperHasNonMemberBeneficiary;
            return $model->getTheTotalNumberOfHampersForNonMembersDelivery($hamper_id);
        }
        
        
       
        
        /**
         * This is the function that gets the unit cost of a product in a hamper
         */
        public function getTheUnitCostOfThisProduct($product_id){
            $model = new Product;
            return $model->getTheUnitCostOfThisProduct($product_id);
        }
        
        
        /**
         * This is the function that gets the total cost of hamper delivery
         */
        public function getTheTotalCostOfDeliveryOfThisHamper($hamper_id){
            
            $model = new HamperHasNonMemberBeneficiary;
            
            //get the total cost of members' hamper delivery
            $cost_of_members_hamper_delivery = $this->getTheTotalCostOfMembersHamperDelivery($hamper_id);
            
            //get the total cost of  non members hampers delivery
            $cost_of_non_members_hamper_delivery = $model->getTheTotalCostOfNonMembersHamperDelivery($hamper_id);
            
                     
            //get the total cost of delivery
            $total_cost_of_delivery = $cost_of_members_hamper_delivery + $cost_of_non_members_hamper_delivery;
            
            return $total_cost_of_delivery;
            
        }
        
        /**
         * This is the function that gets a number of hampers for a member
         */
        public function getTheNumberOfHampersForDelivery($hamper_id,$beneficiary_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:hamperid and beneficiary_id=:beneid';
             $criteria->params = array(':hamperid'=>$hamper_id,':beneid'=>$beneficiary_id);
             $hamper= HamperHasBeneficiary::model()->find($criteria);
             
             return $hamper['number_of_hampers_delivered'];
            
        }
        
        /**
         * This is the function that generates the invoice for a hamper redirect
         */
        public function generateTheHamperRedirectInvoiceNumber($hamper_id,$beneficiary_id){
            $model = new Product;
            //get the hamper code
            $hamper_code = $model->getThisProductCode($hamper_id);
            
            //get the four last letters a the benefioiary member code
            $beneciary_number = $this->getTheLastFourDigitsOfThisMemberMembershipNumber($beneficiary_id);
            
            $invoice_number = $hamper_code.$beneciary_number;
            
            return $invoice_number;
        }
             
        
        /**
         * This is the function that gets the four last letters a beneficiary mrmbership number
         */
        public function getTheLastFourDigitsOfThisMemberMembershipNumber($beneficiary_id){
            $model = new Members;
            return $model->getTheLastFourDigitsOfThisMemberMembershipNumber($beneficiary_id);
        }
        
        
        /**
         * This is the function that confirms if hamper redirection is a success
         */
        public function isTheRedirectionOfThisHamperASuccess($hamper_id,$beneficiary_id,$delivery_type,$country_id,$state_id,$city_id,$place_of_delivery,$delivery_charges){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('hamper_has_beneficiary',
                        array('city_id'=>$city_id,
                                 'state_id'=>$state_id,
                                 'country_id'=>$country_id,
                                 'place_of_delivery'=>$place_of_delivery,
                                 'delivery_type'=>$delivery_type,
                                 'is_redirected'=>1,
                                 'amount_paid_for_redirection'=>$delivery_charges,
                                 'date_hamper_was_redirected'=>new CDbExpression('NOW()'),
                                 'hamper_was_redirected_by'=>Yii::app()->user->id
                                                           
                        ),
                        ("hamper_id=$hamper_id and beneficiary_id=$beneficiary_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        /**
         * This is the function that gets the scheduled initail delivery type of a hamper
         */
        public function getTheInitaiDeliveryTypeOfThisHamper($hamper_id,$beneficiary_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:hamperid and beneficiary_id=:beneid';
             $criteria->params = array(':hamperid'=>$hamper_id,':beneid'=>$beneficiary_id);
             $hamper= HamperHasBeneficiary::model()->find($criteria);
             
             return $hamper['delivery_type'];
        }
        
        
        
         /**
         * This is the function that gets the hamper container price
         */
        public function getTheCostOfContainerInThisHamper($hamper_id,$cost_of_hamper_items){
            $model = new HamperContainer;
            
            $sum = 0;
                      
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:id';
             $criteria->params = array(':id'=>$hamper_id);
             $hampers= HamperHasBeneficiary::model()->findAll($criteria);
             
             foreach($hampers as $hamper){
                 $sum = $sum + $model->getThePriceOfThisHamperContainer($hamper['hamper_container_id'],$cost_of_hamper_items) ;
             }
            
             
             return $sum;
  
        }
      
}
