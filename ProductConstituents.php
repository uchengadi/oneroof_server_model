<?php

/**
 * This is the model class for table "product_constituents".
 *
 * The followings are the available columns in table 'product_constituents':
 * @property string $id
 * @property string $product_id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $headline_image
 * @property integer $icon_size
 * @property integer $image_size
 * @property double $prevailing_retail_selling_price
 * @property integer $maximum_portion
 * @property double $per_portion_price
 * @property double $discount_rate
 * @property double $discounted_amount
 * @property double $quantity
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 * @property string $condition
 * @property integer $displayable_on_store
 * @property string $whats_product_per_item
 * @property string $whats_in_a_park
 * @property integer $minimum_number_of_product_to_buy
 * @property string $feature
 * @property string $specifications
 * @property string $price_validity_period
 * @property string $product_front_view
 * @property string $product_right_side_view
 * @property string $product_top_view
 * @property string $product_inside_view
 * @property string $product_engine_view
 * @property string $product_back_view
 * @property string $product_left_side_view
 * @property string $product_bottom_view
 * @property string $product_dashboard_view
 * @property string $product_contents_or_booth_view
 * @property integer $product_right_side_view_size
 * @property integer $product_front_view_size
 * @property integer $product_top_view_size
 * @property integer $product_inside_view_size
 * @property integer $product_engine_view_size
 * @property integer $product_back_view_size
 * @property integer $product_left_side_view_size
 * @property integer $product_bottom_view_size
 * @property integer $product_dashboard_view_size
 * @property integer $product_contents_or_booth_view_size
 * @property string $brand
 * @property string $maker
 * @property string $origin
 * @property string $start_price_validity_period
 * @property string $end_price_validity_period
 *
 * The followings are the available model relations:
 * @property ProductSpecification[] $productSpecifications
 * @property Members[] $members
 * @property Order[] $orders
 * @property Product $product
 */
class ProductConstituents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_constituents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, name, whats_product_per_item, brand, maker, origin', 'required'),
			array('icon_size, image_size, maximum_portion, create_user_id, update_user_id, displayable_on_store, minimum_number_of_product_to_buy, product_right_side_view_size, product_front_view_size, product_top_view_size, product_inside_view_size, product_engine_view_size, product_back_view_size, product_left_side_view_size, product_bottom_view_size, product_dashboard_view_size, product_contents_or_booth_view_size', 'numerical', 'integerOnly'=>true),
			array('prevailing_retail_selling_price, per_portion_price, discount_rate, discounted_amount, quantity', 'numerical'),
			array('product_id', 'length', 'max'=>10),
			array('name, icon, headline_image, whats_product_per_item, price_validity_period, product_front_view, product_right_side_view, product_top_view, product_inside_view, product_engine_view, product_back_view, product_left_side_view, product_bottom_view, product_dashboard_view, product_contents_or_booth_view', 'length', 'max'=>100),
			array('brand, maker, origin', 'length', 'max'=>200),
			array('description, create_time, update_time, condition, whats_in_a_park, feature, specifications, start_price_validity_period, end_price_validity_period', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, name, description, icon, headline_image, icon_size, image_size, prevailing_retail_selling_price, maximum_portion, per_portion_price, discount_rate, discounted_amount, quantity, create_time, create_user_id, update_time, update_user_id, condition, displayable_on_store, whats_product_per_item, whats_in_a_park, minimum_number_of_product_to_buy, feature, specifications, price_validity_period, product_front_view, product_right_side_view, product_top_view, product_inside_view, product_engine_view, product_back_view, product_left_side_view, product_bottom_view, product_dashboard_view, product_contents_or_booth_view, product_right_side_view_size, product_front_view_size, product_top_view_size, product_inside_view_size, product_engine_view_size, product_back_view_size, product_left_side_view_size, product_bottom_view_size, product_dashboard_view_size, product_contents_or_booth_view_size, brand, maker, origin, start_price_validity_period, end_price_validity_period', 'safe', 'on'=>'search'),
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
			'productSpecifications' => array(self::MANY_MANY, 'ProductSpecification', 'constituent_has_specifications(constituent_id, specification_id)'),
			'members' => array(self::MANY_MANY, 'Members', 'member_amended_constituents(constituent_id, member_id)'),
			'orders' => array(self::MANY_MANY, 'Order', 'order_has_constituents(constituent_id, order_id)'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'name' => 'Name',
			'description' => 'Description',
			'icon' => 'Icon',
			'headline_image' => 'Headline Image',
			'icon_size' => 'Icon Size',
			'image_size' => 'Image Size',
			'prevailing_retail_selling_price' => 'Prevailing Retail Selling Price',
			'maximum_portion' => 'Maximum Portion',
			'per_portion_price' => 'Per Portion Price',
			'discount_rate' => 'Discount Rate',
			'discounted_amount' => 'Discounted Amount',
			'quantity' => 'Quantity',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
			'condition' => 'Condition',
			'displayable_on_store' => 'Displayable On Store',
			'whats_product_per_item' => 'Whats Product Per Item',
			'whats_in_a_park' => 'Whats In A Park',
			'minimum_number_of_product_to_buy' => 'Minimum Number Of Product To Buy',
			'feature' => 'Feature',
			'specifications' => 'Specifications',
			'price_validity_period' => 'Price Validity Period',
			'product_front_view' => 'Product Front View',
			'product_right_side_view' => 'Product Right Side View',
			'product_top_view' => 'Product Top View',
			'product_inside_view' => 'Product Inside View',
			'product_engine_view' => 'Product Engine View',
			'product_back_view' => 'Product Back View',
			'product_left_side_view' => 'Product Left Side View',
			'product_bottom_view' => 'Product Bottom View',
			'product_dashboard_view' => 'Product Dashboard View',
			'product_contents_or_booth_view' => 'Product Contents Or Booth View',
			'product_right_side_view_size' => 'Product Right Side View Size',
			'product_front_view_size' => 'Product Front View Size',
			'product_top_view_size' => 'Product Top View Size',
			'product_inside_view_size' => 'Product Inside View Size',
			'product_engine_view_size' => 'Product Engine View Size',
			'product_back_view_size' => 'Product Back View Size',
			'product_left_side_view_size' => 'Product Left Side View Size',
			'product_bottom_view_size' => 'Product Bottom View Size',
			'product_dashboard_view_size' => 'Product Dashboard View Size',
			'product_contents_or_booth_view_size' => 'Product Contents Or Booth View Size',
			'brand' => 'Brand',
			'maker' => 'Maker',
			'origin' => 'Origin',
			'start_price_validity_period' => 'Start Price Validity Period',
			'end_price_validity_period' => 'End Price Validity Period',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('headline_image',$this->headline_image,true);
		$criteria->compare('icon_size',$this->icon_size);
		$criteria->compare('image_size',$this->image_size);
		$criteria->compare('prevailing_retail_selling_price',$this->prevailing_retail_selling_price);
		$criteria->compare('maximum_portion',$this->maximum_portion);
		$criteria->compare('per_portion_price',$this->per_portion_price);
		$criteria->compare('discount_rate',$this->discount_rate);
		$criteria->compare('discounted_amount',$this->discounted_amount);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('condition',$this->condition,true);
		$criteria->compare('displayable_on_store',$this->displayable_on_store);
		$criteria->compare('whats_product_per_item',$this->whats_product_per_item,true);
		$criteria->compare('whats_in_a_park',$this->whats_in_a_park,true);
		$criteria->compare('minimum_number_of_product_to_buy',$this->minimum_number_of_product_to_buy);
		$criteria->compare('feature',$this->feature,true);
		$criteria->compare('specifications',$this->specifications,true);
		$criteria->compare('price_validity_period',$this->price_validity_period,true);
		$criteria->compare('product_front_view',$this->product_front_view,true);
		$criteria->compare('product_right_side_view',$this->product_right_side_view,true);
		$criteria->compare('product_top_view',$this->product_top_view,true);
		$criteria->compare('product_inside_view',$this->product_inside_view,true);
		$criteria->compare('product_engine_view',$this->product_engine_view,true);
		$criteria->compare('product_back_view',$this->product_back_view,true);
		$criteria->compare('product_left_side_view',$this->product_left_side_view,true);
		$criteria->compare('product_bottom_view',$this->product_bottom_view,true);
		$criteria->compare('product_dashboard_view',$this->product_dashboard_view,true);
		$criteria->compare('product_contents_or_booth_view',$this->product_contents_or_booth_view,true);
		$criteria->compare('product_right_side_view_size',$this->product_right_side_view_size);
		$criteria->compare('product_front_view_size',$this->product_front_view_size);
		$criteria->compare('product_top_view_size',$this->product_top_view_size);
		$criteria->compare('product_inside_view_size',$this->product_inside_view_size);
		$criteria->compare('product_engine_view_size',$this->product_engine_view_size);
		$criteria->compare('product_back_view_size',$this->product_back_view_size);
		$criteria->compare('product_left_side_view_size',$this->product_left_side_view_size);
		$criteria->compare('product_bottom_view_size',$this->product_bottom_view_size);
		$criteria->compare('product_dashboard_view_size',$this->product_dashboard_view_size);
		$criteria->compare('product_contents_or_booth_view_size',$this->product_contents_or_booth_view_size);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('maker',$this->maker,true);
		$criteria->compare('origin',$this->origin,true);
		$criteria->compare('start_price_validity_period',$this->start_price_validity_period,true);
		$criteria->compare('end_price_validity_period',$this->end_price_validity_period,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductConstituents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * This is the function that determines if a product has constituents
         */
        public function doesProductHaveConstituents($product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product_constituents')
                    ->where("product_id = $product_id");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that retrieves  a product's constituent
         */
        public function getAllProductConstituents($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='product_id=:id';
                $criteria->params = array(':id'=>$product_id);
                $products= ProductConstituents::model()->findAll($criteria);
                
                $all_products = [];
                
                foreach($products as $product){
                    $all_products[] = $product['id'];
                }
                return $all_products;
        }
        
        /**
         * This is the function that gets the amount of a product constitutent
         */
        public function getTheRevenueAmountFromThisConstituentProduct($constituent_id,$order_id){
           $model = new PlatformSettings; 
           $amount = 0;
              if($model->isManagementFeesIncluded()){
                    $management_fee_charges_in_percentage = ($model->getTheManagementFees()/100);
                }else{
                    $management_fee_charges_in_percentage = 0;
                }
                if($model->isHandlingChargesIncluded()){
                    $handling_charges_in_percentage = ($model->getTheHandingCharges()/100);
                }else{
                    $handling_charges_in_percentage = 0;
                }
                if($model->isShippingChargesIncluded()){
                    $shipping_charges_in_percentage = ($model->getTheShippingCharges()/100);
                }else{
                    $shipping_charges_in_percentage = 0;
                }
              //  if($this->isOrderPriceStillValidForThisConstituent($order_id,$constituent_id)){
                    $amount = $this->getThePortionOfThisConstituentInThisOrder($order_id,$constituent_id) * $this->getThisProductConstituentPriceInThisOrder($constituent_id,$order_id)*($management_fee_charges_in_percentage + $handling_charges_in_percentage + $shipping_charges_in_percentage);
              /**  }else{
                    $amount = $this->getThePrevailingRetailSellingPriceOfThisConstituent($constituent_id)*($management_fee_charges_in_percentage + $handling_charges_in_percentage + $shipping_charges_in_percentage);
                }
               * 
               */
                
                return $amount;
        }
        
        
        /**
         * This is the function that gets the portion of a constituent in an order
         */
        public function getThePortionOfThisConstituentInThisOrder($order_id,$constituent_id){
            $model = new OrderHasConstituents;
            return $model->getThePortionOfThisConstituentInThisOrder($order_id,$constituent_id);
        }
        
        
         /**
         * This is the function that gets the applicable price for a constituent in an order
         */
        public function getThisProductConstituentPriceInThisOrder($constituent_id,$order_id){
            $model = new OrderHasConstituents;
            return $model->getThisProductConstituentPriceInThisOrder($constituent_id,$order_id);
        }
        
        
        /**
         * This is the function that determines the validity of a constituent price in an order
         */
        public function isOrderPriceStillValidForThisConstituent($order_id,$constituent_id){
            $model = new OrderHasConstituents;
            return $model->isOrderPriceStillValidForThisConstituent($order_id,$constituent_id);
        }
        
        
              
        /**
         * This is the function that retrieves the amount of a product
         */
        public function getTheAmountOfThisProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $amount= ProductConstituents::model()->find($criteria);
                
                return $amount['per_portion_price'];
            
        }
        
        
       /**
        * This is the function that gets the total price of all constituents of a product
        */
        public function totalPriceOfTheProductConstituents($product_id,$order_id){
            $model = new OrderHasConstituents;

            //get all the constituents of this product
            $constituents = $this->getAllProductConstituents($product_id);
            
            $sum = 0;
            
            foreach($constituents as $constituent){
                //get the portion of the constituent that was bought
                $number_of_portion = $model->getThePortionOfThisConstituentInThisOrder($order_id,$constituent);
                $sum = $sum + ($this->getTheAmountOfThisProduct($constituent) * $number_of_portion);
            }
            return $sum;
        } 
        
        
        
        /**
         * This is the function that gets the total discount of a constituent
         */
        public function totalDiscountOfTheProductConstituents($product_id,$order_id){
            
            $model = new OrderHasConstituents;

            //get all the constituents of this product
            $constituents = $this->getAllProductConstituents($product_id);
            
            $sum = 0;
            
            foreach($constituents as $constituent){
                //get the portion of the constituent that was bought
                $number_of_portion = $model->getThePortionOfThisConstituentInThisOrder($order_id,$constituent);
                $sum = $sum + ($this->getTheDiscountAmountOfThisConctituentt($constituent) * $number_of_portion);
            }
            return $sum;
            
        }
        
        
        /**
         * This is the function that gets the discount of a constituent
         */
       
        public function getTheDiscountAmountOfThisConctituentt($constituent_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$constituent_id);
                $discount= ProductConstituents::model()->find($criteria);
                
                return $discount['discounted_amount'];
            
        }
        
        
        /**
         * This is the function that confirms if a product constituent is added successfully
         */
        public function isAddingThisConstituentToCartASuccess($order_id,$constituent){
            $member_id = Yii::app()->user->id;
            if($this->isConstituentQuantityAmendedByMember($constituent,$member_id)){
                if($this->isAddingTheAmendedConstituentToCartASuccess($order_id,$constituent,$member_id)){
                    //delete data in the temporary table
                    if($this->isRemovalOfTheConstituentAmendedDataASuccess($member_id,$constituent)){
                        return true;
                    }
                    return true;
                }else{
                    return false;
                }
            }else{
                if($this->isAddingTheUnamendedConstituentToCartASuccess($order_id,$constituent)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        
        /**
         * This is the function that removes the amended constituents parameters from the temporary table
         */
        public function isRemovalOfTheConstituentAmendedDataASuccess($member_id,$constituent_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('member_amended_constituents', 'member_id=:memberid and constituent_id=:consituentid', array(':memberid'=>$member_id,':consituentid'=>$constituent_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        
        /**
         * This is the function that confirms if this cinstituent parameters was amended by member
         */
        public function isConstituentQuantityAmendedByMember($constituent,$member_id){
            $model = new MemberAmendedConstituents;
            
            return $model->isConstituentQuantityAmendedByMember($constituent,$member_id);
        }
        
        
        /**
         * This is the function that adds the amended constituent to cart
         */
        public function isAddingTheAmendedConstituentToCartASuccess($order_id,$constituent,$member_id){
            $model = new OrderHasConstituents;
            //get the new amended quantity
            $amended_quantity = $this->getTheAmendedQuantity($constituent,$member_id);
            
            $cobuy_member_price_per_item = $this->getThePricePerItemForThisConstituent($constituent);
            $prevailing_retail_selling_price_per_item = $this->getThePrevailingRetailSellingPriceOfThisConstituent($constituent);
            
            $amount_saved_per_item = $prevailing_retail_selling_price_per_item  - $cobuy_member_price_per_item;
            
             $start_price_validity_period = $this->getTheMemberPriceStartPriceValidityPeriod($constituent);
            
            $end_price_validity_period = $this->getTheMemberPriceEndPriceValidityPeriod($constituent);
            
            if($model->isAddingThisConstituentToCartASuccess($order_id,$constituent,$amount_saved_per_item,$prevailing_retail_selling_price_per_item,$amended_quantity,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period)){
                return true;
            }else{
                return false;
            }
            
            
        }
        
        /**
         * This is the function that gets the amended quantity
         */
        public function getTheAmendedQuantity($constituent,$member_id){
            $model = new MemberAmendedConstituents;
            
            return $model->getTheAmendedQuantity($constituent,$member_id);
        }
        
        /**
         * This is the function that adds an unamended constituent to cart
         */
        public function isAddingTheUnamendedConstituentToCartASuccess($order_id,$constituent){
            $model = new OrderHasConstituents;
            //get the constituent parameters
            $min_quantity = $this->getTheMinimumQuantityForPurchaseOfThisConstituent($constituent);
            $cobuy_member_price_per_item = $this->getThePricePerItemForThisConstituent($constituent);
            $prevailing_retail_selling_price_per_item = $this->getThePrevailingRetailSellingPriceOfThisConstituent($constituent);
            
            $amount_saved_per_item = $prevailing_retail_selling_price_per_item  - $cobuy_member_price_per_item;
            
            $start_price_validity_period = $this->getTheMemberPriceStartPriceValidityPeriod($constituent);
            
            $end_price_validity_period = $this->getTheMemberPriceEndPriceValidityPeriod($constituent);
            
            
            
            if($model->isAddingThisConstituentToCartASuccess($order_id,$constituent,$amount_saved_per_item,$prevailing_retail_selling_price_per_item,$min_quantity,$cobuy_member_price_per_item,$start_price_validity_period,$end_price_validity_period)){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that gets the end price validity period
         */
        public function getTheMemberPriceEndPriceValidityPeriod($constituent_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$constituent_id);
                $constituent= ProductConstituents::model()->find($criteria);
                
                return $constituent['end_price_validity_period'];
            
        }
        
        
         /**
         * This is the function that gets the start price validity period
         */
        public function getTheMemberPriceStartPriceValidityPeriod($constituent_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$constituent_id);
                $constituent= ProductConstituents::model()->find($criteria);
                
                return $constituent['start_price_validity_period'];
            
        }
        
        
        /**
         * This is the function that retrieves the minimum quantity required for purchase of a constituent
         */
        public function getTheMinimumQuantityForPurchaseOfThisConstituent($constituent_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$constituent_id);
                $constituent= ProductConstituents::model()->find($criteria);
                
                return $constituent['minimum_number_of_product_to_buy'];
            
        }
        
        
        /**
         * This is the function retrieves the cobuy member price per item of a constituent
         */
        public function getThePricePerItemForThisConstituent($constituent_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$constituent_id);
                $constituent= ProductConstituents::model()->find($criteria);
                return $constituent['per_portion_price'];
        }
        
        
        /**
         * This is the function that retrieves the prevailing retaiing selling price for this constituent
         */
        public function getThePrevailingRetailSellingPriceOfThisConstituent($constituent_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$constituent_id);
                $constituent= ProductConstituents::model()->find($criteria);
                
                return $constituent['prevailing_retail_selling_price'];
        }
        
        
        /**
         * This is the function that returns the name of a constituent
         */
        public function getTheNameOfThisConstituent($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $constituent= ProductConstituents::model()->find($criteria);
                
                return $constituent['name'];
            
        }
        
        
        /**
         * This is the function that determines if a constiruent is in a product pack
         */
        public function isThisConstituentInThisProductPack($constituent_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product_constituents')
                    ->where("product_id = $product_id and id=$constituent_id");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that retrieves the minimum quantity of purchase for a constituent
         */
        public function getTheMiniumItemRequiredForPurchase($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $constituent= ProductConstituents::model()->find($criteria);
                
                return $constituent['minimum_number_of_product_to_buy'];
        }
        
        
        
      
}
