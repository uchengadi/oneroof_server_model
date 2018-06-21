<?php

/**
 * This is the model class for table "hamper_has_products".
 *
 * The followings are the available columns in table 'hamper_has_products':
 * @property string $hamper_id
 * @property string $product_id
 * @property string $date_product_was_added
 * @property integer $product_was_added_by
 *
 * The followings are the available model relations:
 * @property Product $hamper
 * @property Product $product
 */
class HamperHasProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hamper_has_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hamper_id, product_id', 'required'),
			array('product_was_added_by', 'numerical', 'integerOnly'=>true),
			array('hamper_id, product_id', 'length', 'max'=>10),
			array('date_product_was_added', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hamper_id, product_id, date_product_was_added, product_was_added_by', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hamper_id' => 'Hamper',
			'product_id' => 'Product',
			'date_product_was_added' => 'Date Product Was Added',
			'product_was_added_by' => 'Product Was Added By',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('date_product_was_added',$this->date_product_was_added,true);
		$criteria->compare('product_was_added_by',$this->product_was_added_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HamperHasProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that retrieves all products in a hamper
         */
        public function getAllProductsInThisHamper($hamper_id){
            
                $all_product = [];
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='hamper_id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $products= HamperHasProducts::model()->findAll($criteria);
                
                foreach($products as $product){
                    $all_product[] = $product['product_id'];
                }
                
                return $all_product;
                
                
                
        }
        
        /**
         * This is the function that determines if a product is in a hamper
         */
        public function isThisProductInThisHamper($hamper_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('hamper_has_products')
                    ->where("hamper_id = $hamper_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that adds a product to a hamper
         */
        public function isTheAdditionOfThisProductToHamperASuccess($hamper_id,$product_id,$quantity,$hamper_price_limit,$product_current_price){
             
            if($hamper_price_limit >=($quantity * $product_current_price )){
                if($hamper_price_limit >=$this->getTheTotalPriceOfItemsInAHamper($hamper_id)){
                    if($hamper_price_limit>=($this->getTheTotalPriceOfItemsInAHamper($hamper_id) + ($quantity * $product_current_price ))){
                        $cmd =Yii::app()->db->createCommand();
                        $result = $cmd->insert('hamper_has_products',
                         array( 
                             'hamper_id'=>$hamper_id,
                             'product_id'=>$product_id,
                             'quantity'=>$quantity,
                                'date_product_was_added'=>new CDbExpression('NOW()'),
                               'product_was_added_by'=>Yii::app()->user->id
                                
                           
                        )
                          
                     );
                 
                 if($result >0){
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
                
            }else{
               return false;  
            }
            
        }
        
        
        /**
         * This is the function that removes a product from a hamper
         */
        public function isTheRemovalOfThisProductFromThisHamperSuccessful($hamper_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('hamper_has_products', 'hamper_id=:hamperid and product_id=:productid', array(':hamperid'=>$hamper_id,':productid'=>$product_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that gets  the total price of items in a hamper
         */
        public function getTheTotalPriceOfItemsInAHamper($hamper_id){
            
            $model = new Product;
            //get all the products in this hamper
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='hamper_id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $all_hamper_products= HamperHasProducts::model()->findAll($criteria);
            
            $total_hamper_cost = 0;
            foreach($all_hamper_products as $product){
                $total_hamper_cost = $total_hamper_cost + ($model->getTheCurrentPrevailingRetailPriceOfThisPack($product['product_id']) * $product['quantity']);
                         
            }
            return $total_hamper_cost;
            
        }
        
        
        
        /**
         * This is the function that gets the quantity of a product in a hamper
         */
        public function getTheQuantityOfThisProductInTheHamper($hamper_id,$product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='hamper_id=:hamid and product_id=:prodid';
                $criteria->params = array(':hamid'=>$hamper_id,':prodid'=>$product_id);
                $hamper_product= HamperHasProducts::model()->find($criteria);
                
                return $hamper_product['quantity'];
        }
        
        
        /**
         * This is the function that adds contents from one platform hamper to  custom hampers
         */
        public function isTheContentOfTheOriginalHamperAddedToThisNewHamperSuccessfully($new_hamper_id,$original_hamper_id,$hamper_cost_limit){
            
            //get all the contents in the original hamper
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:hamid';
             $criteria->params = array(':hamid'=>$original_hamper_id);
             $products= HamperHasProducts::model()->findAll($criteria);
            
            //add this contents to the new hamper
            $counter = 0;
            foreach($products as $product){
                //get the current price of this product
                $product_current_price = $this->getTheUnitCostOfThisProduct($product['product_id']);
                if($this->isTheAdditionOfThisProductToHamperASuccess($new_hamper_id,$product['product_id'],$product['quantity'],$hamper_cost_limit,$product_current_price)){
                    
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
         * This is the function that retrieves the current price of a product
         */
        public function getTheUnitCostOfThisProduct($product_id){
            $model = new Product;
            return $model->getTheUnitCostOfThisProduct($product_id);
        }
        
        
        /**
         * This is the function that does the removal of all contents in a hamper
         */
        public function isTheRemovalOfAllContentsInThisHamperASuccess($hamper_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='hamper_id=:hamid';
             $criteria->params = array(':hamid'=>$hamper_id);
             $products= HamperHasProducts::model()->findAll($criteria);
            
             $counter = 0;
             foreach($products as $product){
                 if($this->isTheRemovalOfThisProductFromThisHamperSuccessful($hamper_id,$product['product_id'])){
                     $counter = $counter + 1;
                 }
             }
             if($this->isTheHamperContentCompletelyRemoved($hamper_id)){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that confirms if a hamper is empty
         */
        public function isTheHamperContentCompletelyRemoved($hamper_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('hamper_has_products')
                    ->where("hamper_id = $hamper_id");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the funtion that effects the change in the qunatity of a hamper item
         */
        public function isTheChangingInThisHamperItemASuccess($hamper_id,$product_id,$product_quantity_in_the_hamper){
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('hamper_has_products',
                                  array(
                                    'quantity'=>$product_quantity_in_the_hamper,
                                     
                                                             
                            ),
                     ("hamper_id=$hamper_id and product_id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
        }
        
        
}
