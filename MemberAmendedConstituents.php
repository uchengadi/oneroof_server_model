<?php

/**
 * This is the model class for table "member_amended_constituents".
 *
 * The followings are the available columns in table 'member_amended_constituents':
 * @property string $member_id
 * @property string $constituent_id
 * @property integer $selected_quantity
 */
class MemberAmendedConstituents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_amended_constituents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, constituent_id, selected_quantity', 'required'),
			array('selected_quantity', 'numerical', 'integerOnly'=>true),
			array('member_id, constituent_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, constituent_id, selected_quantity', 'safe', 'on'=>'search'),
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
			'member_id' => 'Member',
			'constituent_id' => 'Constituent',
			'selected_quantity' => 'Selected Quantity',
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

		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('constituent_id',$this->constituent_id,true);
		$criteria->compare('selected_quantity',$this->selected_quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberAmendedConstituents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that confirms if a constituent was amended by member
         */
        public function isConstituentQuantityAmendedByMember($constituent_id,$member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_amended_constituents')
                    ->where("member_id = $member_id and constituent_id = $constituent_id");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that determines if a member has an amended constituent
         */
        public function isConstituentQuantityActuallyAmendedByMember($constituent_id,$member_id){
            $model = new Order;
            if($this->isConstituentQuantityAmendedByMember($constituent_id,$member_id)){
                return true;
            }else{
                if($model->isMemberWithOpenOrder($member_id)){
                    //get the member open order
                    $order_id = $model->getTheOpenOrderInitiatedByMember($member_id);
                    if($this->isConstituentNotAlreadyInTheCart($order_id,$constituent_id)== false){
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
         * this is the function that confirms if constituents is in an order
         */
        public function isConstituentNotAlreadyInTheCart($order_id,$product_id){
            
            $model = new OrderHasConstituents;
            return $model->isConstituentNotAlreadyInTheCart($order_id,$product_id);
        }
        
        /**
         * This is the function that retrieves the amended quantity from the temporary table
         */
        public function getTheAmendedQuantity($constituent_id,$member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='member_id=:memberid and constituent_id=:constituentid';
                $criteria->params = array(':memberid'=>$member_id,':constituentid'=>$constituent_id);
                $quantity= MemberAmendedConstituents::model()->find($criteria);
                
                return $quantity['selected_quantity'];
        }
        
        
        /**
         * This is the function that confirms if constituent is accepted by member
         */
        public function isConstituentAcceptedbyMember($constituent_id,$member_id){
            
            if($this->isConstituentQuantityAmendedByMember($constituent_id,$member_id)){
                if($this->isConstituentQuantityNonZero($constituent_id,$member_id)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
        }
        
        
        /**
         * This is the function that determines if constituent is non zero
         */
        public function isConstituentQuantityNonZero($constituent_id,$member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='member_id=:memberid and constituent_id=:constituentid';
                $criteria->params = array(':memberid'=>$member_id,':constituentid'=>$constituent_id);
                $quantity= MemberAmendedConstituents::model()->find($criteria);
                
                if($quantity['selected_quantity']>0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that ensures that a constituent is removed from the pack for a member
         */
        public function isThisConstituentSuccessfullyRemovedFromThePack($constituent_id,$member_id){
            
            if($this->isConstituentQuantityAmendedByMember($constituent_id,$member_id)){
                if($this->isUpdateOfPackAmendmentSuccessful($constituent_id,$member_id)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
               if($this->isNewAmendmentOfThePackSucessful($constituent_id,$member_id)){
                   return true;
               }else{
                   return false;
               } 
            }
            
            
        }
        
        
        /**
         * This is the function that effects  changes to the quantity in the pack of a customer
         */
        public function isThisConstituentSuccessfullyModifiedInThePack($constituent_id,$primary_product_id,$member_id,$quantity_of_product_in_the_pack,$prevailing_retail_selling_price_per_item,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period){
            
            if($this->isConstituentQuantityAmendedByMember($constituent_id,$member_id)){
                if($this->isUpdateOfQuantityInThePackAmendmentSuccessful($constituent_id,$member_id,$quantity_of_product_in_the_pack,$prevailing_retail_selling_price_per_item,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period)){
                   return true;
                }else{
                    return false;
                }
                
            }else{
               if($this->isNewQuantityAmendmentOfThisPackSucessful($constituent_id,$member_id,$quantity_of_product_in_the_pack,$prevailing_retail_selling_price_per_item,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period)){
                   return true;
                  
               }else{
                   return false;
               } 
            }
            
            
        }
        
        
        /**
         * This is the function that recalculates both the prevailing selling price and the member-only selling price for the primary product after constituents update
         */
        public function isPrimaryProductUpdateSuccessful($primary_product_id,$member_id){
            $model = new OrderHasProducts;
            
            return $model->isPrimaryProductUpdateSuccessful($primary_product_id,$member_id);
        }
        
        
         /**
         * This is the function that inserts new pack amendment 
         */
        public function isNewQuantityAmendmentOfThisPackSucessful($constituent_id,$member_id,$quantity_of_product_in_the_pack,$prevailing_retail_selling_price_per_item,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period){
            
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('member_amended_constituents',
                         array('member_id'=>$member_id,
                                'constituent_id' =>$constituent_id,
                                 'selected_quantity'=>$quantity_of_product_in_the_pack,
                                 'prevailing_retail_selling_price_per_item_at_purchase'=>$prevailing_retail_selling_price_per_item,
                                 'cobuy_member_price_per_item_at_purchase'=>$cobuy_member_price_per_item,
                                 'start_price_validity_period'=>$start_price_validity_period,
                                 'end_price_validity_period'=>$end_price_validity_period
                                 
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        /**
         * This is the function that update already existing pack amendment
         */
        public function isUpdateOfQuantityInThePackAmendmentSuccessful($constituent_id,$member_id,$quantity_of_product_in_the_pack,$prevailing_retail_selling_price_per_item,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('member_amended_constituents',
                         array('selected_quantity'=>$quantity_of_product_in_the_pack,
                           'prevailing_retail_selling_price_per_item_at_purchase'=>$prevailing_retail_selling_price_per_item,
                           'cobuy_member_price_per_item_at_purchase'=>$cobuy_member_price_per_item,
                           'start_price_validity_period'=>$start_price_validity_period,
                           'end_price_validity_period'=>$end_price_validity_period
                             
                        ),
                        ("member_id=$member_id and constituent_id=$constituent_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
         /**
         * This is the function that update already existing pack amendment
         */
        public function isUpdateOfPackAmendmentSuccessful($constituent_id,$member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('member_amended_constituents',
                         array('selected_quantity'=>0,
                             
                        ),
                        ("member_id=$member_id and constituent_id=$constituent_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that inserts new pack amendment at removal
         */
        public function isNewAmendmentOfThePackSucessful($constituent_id,$member_id){
            
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('member_amended_constituents',
                         array('member_id'=>$member_id,
                                'constituent_id' =>$constituent_id,
                                 'selected_quantity'=>0,
                                 
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        /**
         * This is the function that retrieves the member quantity for a constituent
         */
        public function getThisMemberAmendedQuantity($constituent_id,$member_id){
            
            if($this->isConstituentAcceptedbyMember($constituent_id,$member_id)){
                $quantity = $this->retrieveTheAmendedQuantity($constituent_id,$member_id);
                return $quantity;
                
            }else{
                return 0;
            }
            
        }
        
        
        
        /**
         * This is the function that gets a members constituents amended quantity
         */
        public function getThisMemberAmendedConstituentQuantity($constituent_id,$member_id){
            $model = new OrderHasConstituents;

            //get this member amended quantity
            $quantity = $this->getThisMemberAmendedQuantity($constituent_id,$member_id);
            if($quantity == 0 || $quantity == null){
                if($this->isMemberWithOpenOrder($member_id)){
                    //get the member open order
                    $order_id = $this->getTheOpenOrderInitiatedByMember($member_id);
                    //retrieve the new value for the cart
                    $quantity = $model->getTheNewConstituentQuantityFromTheCart($order_id,$constituent_id);
                    return $quantity;
                }else{
                    return $quantity;
                }
                
            }else{
                return $quantity;
            }
            
        }
        
        
        
        /**
         * This is the function that confirms if a member has an open order
         */
        public function isMemberWithOpenOrder($member_id){
            $model = new Order;
            return $model->isMemberWithOpenOrder($member_id);
        }
        
        
        /**
         * this is the function that gets the open order for a member
         */
        public function getTheOpenOrderInitiatedByMember($member_id){
            $model = new Order;
            return $model->getTheOpenOrderInitiatedByMember($member_id);
        }
        
        /**
         * This is the function that retrieves the amended quantity
         */
        public function retrieveTheAmendedQuantity($constituent_id,$member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='member_id=:memberid and constituent_id=:constituentid';
                $criteria->params = array(':memberid'=>$member_id,':constituentid'=>$constituent_id);
                $quantity= MemberAmendedConstituents::model()->find($criteria);
                
                return $quantity['selected_quantity'];
        }
        
        
       
        /**
         * This is the function that retrieves all already removed constituent from a product
         */
        public function getAllRemovedConstituentsByThisMember($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='member_id=:memberid and selected_quantity=:selected';
                $criteria->params = array(':memberid'=>$member_id,':selected'=>0);
                $constituents= MemberAmendedConstituents::model()->findAll($criteria);
                
                $selected = [];
                foreach($constituents as $constituent){
                    $selected[] = $constituent['constituent_id'];
                }
                return $selected;
        }
        
        
        /**
         * This is the function that effects item restoration to a pack
         */
        public function isThisConstituentSuccessfullyRestoredToThePack($constituent_id,$member_id,$min_item_quantity_for_purchase){
            
            if($this->isConstituentQuantityAmendedByMember($constituent_id,$member_id)){
                if($this->isConstituentQuantityNonZero($constituent_id,$member_id) == false){
                    if($this->isUpdateOfThisQuantityInThePackAmendmentSuccessful($constituent_id,$member_id,$min_item_quantity_for_purchase)){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        
        
         /**
         * This is the function that update already existing pack amendment
         */
        public function isUpdateOfThisQuantityInThePackAmendmentSuccessful($constituent_id,$member_id,$min_item_quantity_for_purchase){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('member_amended_constituents',
                         array('selected_quantity'=>$min_item_quantity_for_purchase,
                        /**   'prevailing_retail_selling_price_per_item_at_purchase'=>$prevailing_retail_selling_price_per_item,
                           'cobuy_member_price_per_item_at_purchase'=>$cobuy_member_price_per_item,
                           'start_price_validity_period'=>$start_price_validity_period,
                           'end_price_validity_period'=>$end_price_validity_period
                         * 
                         */
                             
                        ),
                        ("member_id=$member_id and constituent_id=$constituent_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that determines if a constituents is available for computation for a member
         */
        public function isConstituentAvailableForComputation($constituent_id){
            $member_id = Yii::app()->user->id;
            if($this->isThisConstituentAvailableForComputation($member_id,$constituent_id)){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if a constituent is available for computation
         */
        public function isThisConstituentAvailableForComputation($member_id,$constituent_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='member_id=:memberid and constituent_id=:constituent';
                $criteria->params = array(':memberid'=>$member_id,':constituent'=>$constituent_id);
                $constituent= MemberAmendedConstituents::model()->find($criteria);
                
                if($constituent['selected_quantity'] == 0){
                    return false;
                }else{
                    return true;
                }
            
        }
        
        
        /**
         * This is the function that ensures the removal of all constituents amendments from the database
         */
        public function isRemovalOfConstituentsAmendmentsByThisUserSuccessful($member_id){
            
            //delete all specifications assigned to this product type
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('member_amended_constituents', 'member_id=:id', array(':id'=>$member_id ));
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        
        /**
         * This is the function that ensures the removal of a particular constituents amendments from the database
         */
        public function isRemovalOfTheAmendedConstituentSuccessful($constituent_id,$member_id){
            
            //delete all specifications assigned to this product type
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('member_amended_constituents', 'member_id=:id and constituent_id=:constituent', array(':id'=>$member_id,':constituent'=>$constituent_id));
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
}
