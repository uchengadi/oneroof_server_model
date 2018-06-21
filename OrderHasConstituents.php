<?php

/**
 * This is the model class for table "order_has_constituents".
 *
 * The followings are the available columns in table 'order_has_constituents':
 * @property string $order_id
 * @property string $constituent_id
 * @property integer $number_of_portion
 * @property string $date_ordered
 * @property string $date_last_update
 * @property integer $ordered_by
 * @property integer $updated_by
 */
class OrderHasConstituents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_has_constituents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, constituent_id', 'required'),
			array('number_of_portion, ordered_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('order_id, constituent_id', 'length', 'max'=>10),
			array('date_ordered, date_last_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, constituent_id, number_of_portion, date_ordered, date_last_update, ordered_by, updated_by', 'safe', 'on'=>'search'),
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
			'constituent_id' => 'Constituent',
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
		$criteria->compare('constituent_id',$this->constituent_id,true);
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
	 * @return OrderHasConstituents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that gets the number of portion of a constituent ordered for
         */
        public function getThePortionOfThisConstituentInThisOrder($order_id,$constituent_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='order_id=:orderid and constituent_id=:constituentid';
                $criteria->params = array(':orderid'=>$order_id,':constituentid'=>$constituent_id);
                $constituent= OrderHasConstituents::model()->find($criteria);
                
                return $constituent['number_of_portion'];
        }
        
        
        /**
         * This is the function that adds products constituents to cart
         */
        public function isAddingProductConstituentsToCartASuccess($order_id,$product_id){
            $model = new ProductConstituents;
            //get all product constituents
            $constituents = $model->getAllProductConstituents($product_id);
            $counter = 0;
            foreach($constituents as $constituent){
                //add constituents to a shadow cart
                if($model->isAddingThisConstituentToCartASuccess($order_id,$constituent)){
                    $counter = $counter + 1;
                }
            }
            if($counter >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that adds product constituent to order
         */
        public function isAddingThisConstituentToCartASuccess($order_id,$constituent,$amount_saved_per_item,$prevailing_retail_selling_price_per_item,$quantity,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period){
            
            if($this->isConstituentNotAlreadyInTheCart($order_id,$constituent)){
                if($this->isAdditionOfThisConstituentSuccessful($order_id,$constituent,$amount_saved_per_item,$prevailing_retail_selling_price_per_item,$quantity,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return false;
            }
        }
        
        
        
        /**
         * This is the function that confirms if product is not already in the cart
         */
        public function isConstituentNotAlreadyInTheCart($order_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('order_has_constituents')
                    ->where("order_id= $order_id and constituent_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that adds constituents to cart
         */
        public function isAdditionOfThisConstituentSuccessful($order_id,$constituent_id,$amount_saved_per_item,$prevailing_retail_selling_price_per_item,$quantity,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period){
            
            $cmd =Yii::app()->db->createCommand();
                 $result = $cmd->insert('order_has_constituents',
                         array('order_id'=>$order_id,
                                'constituent_id' =>$constituent_id,
                                 'number_of_portion'=>$quantity,
                                 'amount_saved_per_item_on_this_order'=>$amount_saved_per_item,
                                 'prevailing_retail_selling_price_per_item_at_purchase'=>$prevailing_retail_selling_price_per_item,
                                 'cobuy_member_price_per_item_at_purchase'=>$cobuy_member_price_per_item,
                                 'start_price_validity_period'=>$start_price_validity_period,
                                  'end_price_validity_period'=>$end_price_validity_period,
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
         * This is the function that removes a product constituent from the cart
         */
        public function isRemovalOfThisConstituentSuccessful($order_id,$constituent_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('order_has_constituents', 'order_id=:orderid and constituent_id=:constituentid', array(':orderid'=>$order_id,':constituentid'=>$constituent_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that recalculates the prevailing retail selling price for a pack
         */
        public function getThePackNewPrevailingRetailSellingPrice($order_id,$primary_product_id){
            
            $model = new ProductConstituents;
            //get all the constituents in this order
            
            $all_constituents = $this->getAllConstituentsInThisOrder($order_id);
            
           $pack_prevailing_retailing_selling_price = 0;
            
            foreach($all_constituents as $constituent){
                if($model->isThisConstituentInThisProductPack($constituent,$primary_product_id)){
                   
                         $pack_prevailing_retailing_selling_price = $pack_prevailing_retailing_selling_price + $this->getThePrevailingRetailSellingPriceForThisConstituent($order_id,$constituent);
                 
                   
                }
            }
            return $pack_prevailing_retailing_selling_price;
        }
        
        
        /**
         * This is the function that gets the member price selling price of a constituent
         */
        public function getTheMemberNewPackSellingPrice($order_id,$primary_product_id){
            
             $model = new ProductConstituents;
            //get all the constituents in this order
            
            $all_constituents = $this->getAllConstituentsInThisOrder($order_id);
            
           $pack_member_selling_price = 0;
            
            foreach($all_constituents as $constituent){
                if($model->isThisConstituentInThisProductPack($constituent,$primary_product_id)){
                  
                        $pack_member_selling_price = $pack_member_selling_price + $this->getTheMemberSellingPriceForThisConstituent($order_id,$constituent);
                  
                    
                }
            }
            return $pack_member_selling_price;
            
        }
        
        
        
        /**
         * This is the function that determines if constituents are available for computation
         */
        public function isConstituentAvailableForComputation($constituent_id){
            
            $model = new MemberAmendedConstituents;
            
            return $model->isConstituentAvailableForComputation($constituent_id);
        }
        
        /**
         * This is the function that gets all constituents in an order
         */
        public function getAllConstituentsInThisOrder($order_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='order_id=:orderid';
                $criteria->params = array(':orderid'=>$order_id);
                $constituents= OrderHasConstituents::model()->findAll($criteria);
                
                $pack_constituents = [];
                
                foreach($constituents as $constituent){
                    $pack_constituents[] = $constituent['constituent_id'];
                }
                return $pack_constituents;
                
        }
        
        
        /**
         * This is the function that gets the prevailing selling price for this constituent
         */
        public function getThePrevailingRetailSellingPriceForThisConstituent($order_id,$constituent_id){
            
                $model = new MemberAmendedConstituents;
                $member_id = Yii::app()->user->id;
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='order_id=:orderid and constituent_id=:constituentid';
                $criteria->params = array(':orderid'=>$order_id,':constituentid'=>$constituent_id);
                $constituent= OrderHasConstituents::model()->find($criteria);
                
                if($model->isConstituentQuantityAmendedByMember($constituent_id,$member_id)){
                    //get the amended quantity
                    $amended_quantity = $model->getTheAmendedQuantity($constituent_id,$member_id);
                    return ($constituent['prevailing_retail_selling_price_per_item_at_purchase'] * $amended_quantity);
                }else{
                    return ($constituent['prevailing_retail_selling_price_per_item_at_purchase'] * $constituent['number_of_portion']);
                }
                
                
            
        }
        
        
        /**
         * This is the function that gets the member selling price of a constituent
         */
        public function getTheMemberSellingPriceForThisConstituent($order_id,$constituent_id){
                $model = new MemberAmendedConstituents;
                 $member_id = Yii::app()->user->id;
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='order_id=:orderid and constituent_id=:constituentid';
                $criteria->params = array(':orderid'=>$order_id,':constituentid'=>$constituent_id);
                $constituent= OrderHasConstituents::model()->find($criteria);
                
                if($model->isConstituentQuantityAmendedByMember($constituent_id,$member_id)){
                    //get the amended quantity
                    $amended_quantity = $model->getTheAmendedQuantity($constituent_id,$member_id);
                    return ($constituent['cobuy_member_price_per_item_at_purchase'] * $amended_quantity);
                }else{
                    return ($constituent['cobuy_member_price_per_item_at_purchase'] * $constituent['number_of_portion']);
                }
        }
        
        
       
         /**
         * This is the function that gets the retail selling price from an order
         */
        public function getTheRetailSellingPriceFromThisOrder($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and constituent_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasConstituents::model()->find($criteria);
             
             return $orders['prevailing_retail_selling_price_per_item_at_purchase'];
            
        }
        
        
        
         /**
         * This is the function that gets the member selling price from an order
         */
        public function getTheMemberSellingPriceFromThisOrder($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and constituent_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasConstituents::model()->find($criteria);
             
             return $orders['cobuy_member_price_per_item_at_purchase'];
            
        }
        
        
        
         /**
         * This is the function that gets the start price validity period
         */
        public function getThisOrderStartPriceValidityDate($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and constituent_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasConstituents::model()->find($criteria);
             
             return getdate(strtotime($orders['start_price_validity_period']));
            
        }
        
        
        /**
         * This is the function that gets the end price validity period
         */
        public function getThisOrderEndPriceValidityDate($order_id,$product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and constituent_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$product_id);
             $orders= OrderHasConstituents::model()->find($criteria);
             
             return getdate(strtotime($orders['end_price_validity_period']));
            
        }
        
        
        
        /** 
         * This is the function that effects constituent modificayions of a product after the pack changes
         */
        public function isProductConstituentsModificationSuccessful($product_id,$order_id){
            $model = new ProductConstituents;
            
            $member_id = Yii::app()->user->id;
            $counter = 0;
            if($model->doesProductHaveConstituents($product_id)){
                //get all of the product constituent
                $constituents = $model->getAllProductConstituents($product_id);
                
                foreach($constituents as $constituent){
                    if($this->isConstituentQuantityAmendedByMember($constituent,$member_id)){
                        //update the quantity of the constituent in the cart
                       if($this->isTheUpdateOfThisConstituentInThePackSuccessful($constituent,$order_id,$member_id)){
                           //remove the amended quantity of the constituent
                           if($this->isRemovalOfTheAmendedConstituentSuccessful($constituent,$member_id)){
                               $counter = $counter + 1;
                           }
                       }
                    }else{
                        $counter = $counter + 1;
                    }
                }
                
                
            }else{
                $counter = $counter + 1;
            }
            if($counter>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        
        /**
         * This is the function that determines if a constituent quantity had been amended
         */
        public function isConstituentQuantityAmendedByMember($constituent,$member_id){
            $model = new MemberAmendedConstituents;
            return $model->isConstituentQuantityAmendedByMember($constituent,$member_id);
        }
        
        
        /**
         * This is the function that updates constituent quantity in the cart
         */
        public function isTheUpdateOfThisConstituentInThePackSuccessful($constituent_id,$order_id,$member_id){
             
            $model = new MemberAmendedConstituents;
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('order_has_constituents',
                                  array(
                                    'number_of_portion'=>$model->getTheAmendedQuantity($constituent_id,$member_id),
                                     'date_last_update'=>new CDbExpression('NOW()'),
                                      'updated_by'=>$member_id,
                                                             
                            ),
                     ("order_id=$order_id and constituent_id=$constituent_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that removes the amended constituent from the temporary table
         */
        public function isRemovalOfTheAmendedConstituentSuccessful($constituent,$member_id){
            $model = new MemberAmendedConstituents;
            return $model->isRemovalOfTheAmendedConstituentSuccessful($constituent,$member_id);
            
        }
        
        
        
        /**
         * This is the function that retrieves the number of portion(quantity) of a constituent  
         **/
        public function getTheNewConstituentQuantityFromTheCart($order_id,$constituent_id){
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:orderid and constituent_id=:productid';
             $criteria->params = array(':orderid'=>$order_id,':productid'=>$constituent_id);
             $order= OrderHasConstituents::model()->find($criteria);
             
             return $order['number_of_portion'];
        }
        
        
        
       /**
         * This is the function that determines if order dates are still valid for a constituent's price
         */
        public function isOrderPriceStillValidForThisConstituent($order_id,$constituent_id){
            
            $model = new Order; 
            
            $start_date = $this->getThisOrderStartPriceValidityDate($order_id,$constituent_id); 
            
            $end_date = $this->getThisOrderEndPriceValidityDate($order_id,$constituent_id); 
            
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
         * This is the function that gets a product price in an order
         */
        public function getThisProductConstituentPriceInThisOrder($constituent_id,$order_id){
            
            $model = new Order;
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='order_id=:id and constituent_id=:productid';
             $criteria->params = array(':id'=>$order_id,':productid'=>$constituent_id);
             $order= OrderHasConstituents::model()->find($criteria);
             
             $order_start_price_validity_date = $this->getThisOrderStartPriceValidityDate($order['order_id'],$order['constituent_id']); 
            
            $order_end_price_validity_date = $this->getThisOrderEndPriceValidityDate($order['order_id'],$order['constituent_id']); 
            
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
     
}
