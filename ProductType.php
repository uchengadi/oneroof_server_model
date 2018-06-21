<?php

/**
 * This is the model class for table "product_type".
 *
 * The followings are the available columns in table 'product_type':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $code
 * @property double $vat_rate
 * @property double $sales_tax_rate
 * @property string $vat_rate_commencement_date
 * @property string $sales_tax_rate_commencement_date
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property ProductSpecification[] $productSpecifications
 */
class ProductType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('vat_rate, sales_tax_rate', 'numerical'),
			array('name, description, code', 'length', 'max'=>200),
			array('vat_rate_commencement_date, sales_tax_rate_commencement_date, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, code, vat_rate, sales_tax_rate, vat_rate_commencement_date, sales_tax_rate_commencement_date, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'productSpecifications' => array(self::MANY_MANY, 'ProductSpecification', 'producttype_has_specifications(product_type_id, specification_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'code' => 'Code',
			'vat_rate' => 'Vat Rate',
			'sales_tax_rate' => 'Sales Tax Rate',
			'vat_rate_commencement_date' => 'Vat Rate Commencement Date',
			'sales_tax_rate_commencement_date' => 'Sales Tax Rate Commencement Date',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('vat_rate',$this->vat_rate);
		$criteria->compare('sales_tax_rate',$this->sales_tax_rate);
		$criteria->compare('vat_rate_commencement_date',$this->vat_rate_commencement_date,true);
		$criteria->compare('sales_tax_rate_commencement_date',$this->sales_tax_rate_commencement_date,true);
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
	 * @return ProductType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that gets the vat amount from a product type
         */
        public function getTheVatRateOfThisProductType($id,$order_id,$product_id){
            
           $model = new Order;  
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $vat= ProductType::model()->find($criteria);
           
           if($this->isVatRateCurrentlyApplicable($vat['vat_rate_commencement_date'],$order_id,$product_id)){
               return $vat['vat_rate'];
           }else{
               return $model->theCountryDefaultVatRate($order_id);
           }
           
            
        }
        
        
        /**
         * This is the function that determines if vat rate is currently applicable
         */
        public function isVatRateCurrentlyApplicable($vat_rate_commencement_date,$order_id,$product_id){
            $model = new Order;
            
            return $model->isVatRateCurrentlyApplicable($vat_rate_commencement_date,$order_id,$product_id);
            
        }
        
        
        /**
         * This is the function that gets the name of a product type
         */
        public function getTheNameOfThisProductType($id){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $type= ProductType::model()->find($criteria);
           
           return $type['name'];
            
        }
        
        
        /**
         * This is the function that retrieves a product type code
         */
        public function getThisProductTypeCode($id){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $type= ProductType::model()->find($criteria);
           
           return $type['code'];
        }
        
        
        /**
         * This is the function that returns the category id of the hampers service
         */
        public function getTheHamperProductTypeId(){
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='code=:code';
           $criteria->params = array(':code'=>strtolower('hampers'));
           $type= ProductType::model()->find($criteria);
           
           return $type['id'];
        }
        
        
         /**
         * This is the function that retrieves the type id given its code
         */
        public function getThisTypeIdGivenItsCode($code){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='code=:code';
           $criteria->params = array(':code'=>$code);
           $type= ProductType::model()->find($criteria);
           
           return $type['id'];
            
        }
        
        
         /**
         * This is the function that determines if a product could be subscriped to
         */
        public function isTheProductAvailableForAService($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $product= ProductType::model()->find($criteria);
            
            if($product['is_paas']==1){
                return true;
            }else{
                return false;
            }
            
        }
        
        
         /**
        * This is the function that determines if a book is part of the nursery or primary school curruculum
        */
        public function isThisBookForNurseryOrPrimarySchool($id,$code){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $type= ProductType::model()->find($criteria);
            
            if($type['code'] == 'BOOKNURSERY'){
                return true;
            }else if($type['code'] == 'BOOKPRIMARY'){
                return true;
            }else{
                return false;
            }
            
        }
        
        
       /**
        * This is the function that determines if a book is part of the secondary school curruculum
        */
        public function isThisBookForSecondarySchool($id,$code){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $type= ProductType::model()->find($criteria);
            
            if($type['code'] == 'BOOKJSS'){
                return true;
            }else if($type['code'] == 'BOOKSSS'){
                return true;
            }else{
                return false;
            }
            
        }
        
        /**
         * This is the function that determines if a book is for tertiary institutions
         */
        public function isThisBookForTertiaryInstitutions($id,$code){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $type= ProductType::model()->find($criteria);
            
            if($type['code'] == 'BOOKTERTIARY'){
                return true;
            }else{
                return false;
            }
            
        }
        
        /**
         * This is the function that determines if a book is for professional
         */
        public function isThisBookForProfessionals($id,$code){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $type= ProductType::model()->find($criteria);
            
            if($type['code'] == 'BOOKPROFESSIONAL'){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that determines if a book is for other category
         */
        public function isThisBookInOthersSections($id,$code){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $type= ProductType::model()->find($criteria);
            
            if($type['code'] == 'BOOKOTHERS'){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that retrieves the paas subscription cost
         */
        public function getThePaasSubscriptionCost($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $paas= ProductType::model()->find($criteria);
            
            return $paas['monthly_paas_subscription_cost'];
        }
        
        
        
         /**
         * This is the function that retrieves the paas subscription minimum quantity required
         */
        public function getTheMinimumQuantityRequiredForPaasSubscription($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $paas= ProductType::model()->find($criteria);
            
            return $paas['minimum_quantity_for_paas_subscription'];
        }
        
        
           /**
         * This is the function that retrieves the paas subscription maximum quantity allowed
         */
        public function getTheMaximumQuantityForThisPaasSubscription($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $paas= ProductType::model()->find($criteria);
            
            return $paas['maximum_quantity_for_paas_subscription'];
        }
        
        
        /**
         * This is the function taht gets the minimum duration for paas
         */
        public function getTheMinimumNumberOfPaasDuration($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $paas= ProductType::model()->find($criteria);
            
            return $paas['minimum_paas_duration'];
        }
       
        
        /**
         * This is the function that gets the maximum allowable duratioon value
         */
        public function getTheMaximumNumberOfPaasDuration($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $paas= ProductType::model()->find($criteria);
            
            return $paas['maximum_paas_duration'];
        }
        
        /**
         * This is the function that gets the total number of displayable buckets in the store
         */
        public function getTheTotalNumberOfPaasBuckets(){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product_type')
                    ->where("is_paas=1 and is_available=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        
        /**
         * This is the function that retrieves the the type id of nursery school books
         */
        public function getTheProductTypeIdOfNurserySchoolBooks(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKNURSERY');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
        }
        
        
         /**
         * This is the function that retrieves the the type id of primary school books
         */
        public function getTheProductTypeIdOfPrimarySchoolBooks(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKPRIMARY');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
        }
        
        
          /**
         * This is the function that retrieves the the type id of junior secondary school books
         */
        public function getTheProductTypeIdOfJssSchoolBooks(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKJSS');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
        }
        
        
         /**
         * This is the function that retrieves the the type id of senior secondary school books
         */
        public function getTheProductTypeIdOfSssSchoolBooks(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSSS');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
        }
        
        
         /**
         * This is the function that retrieves the the type id of tertiary school books
         */
        public function getTheProductTypeIdOfTertiarySchoolBooks(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKTERTIARY');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
        }
        
        
        /**
         * This is the function that retrieves the the type id of professional books
         */
        public function getTheProductTypeIdOfProfessionalSchoolBooks(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKPROFESSIONAL');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
        }
        
        
        
         /**
         * This is the function that retrieves the the type id of other books
         */
        public function getTheProductTypeIdOfOtherBooks(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKOTHERS');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
        }
        
        
        /**
         * This is the function that retrieves the totsl number of displayable nursery and primary school books
         */
        public function getTheTotalNumberOfBothNurseryAndPrimarySchoolDisplaybleBooks(){
            
                    
             $model = new Product;
            
            $category_id = $this->getTheCategoryIdOfNurserySchoolBooks();
          
            $displayable_book_from_basic_category = $model->getTheTotalNumberOfProductsForThisCategory($category_id);
            
                      
            return $displayable_book_from_basic_category;
            
      }
        
       
        
        
        /**
         * This is the function that retrieves the total number of displayable jss and sss school books
         */
        public function getTheTotalNumberOfBothJssAndSssSchoolDisplaybleBooks(){
            
            $model = new Product;
            
            $category_id = $this->getTheSecondarySchoolCategoryId();
          
            $displayable_book_from_sec_category = $model->getTheTotalNumberOfProductsForThisCategory($category_id);
            
                      
            return $displayable_book_from_sec_category;
        }
        
       
        
          /**
         * This is the function that gets the total number of displayable tertiary school books
         */
        public function getTheTotalNumberOfTertiarySchoolDisplaybleBooks(){
            
            $model = new Product;
            
            $category_id = $this->getTheCategoryIdOfTertiarySchoolBooks();
            $displayable_sum = $model->getTheTotalNumberOfProductsForThisCategory($category_id);
            return $displayable_sum;
          
        }
        
        
          /**
         * This is the function that gets the total number of displayable professional school books
         */
        public function getTheTotalNumberOfProfessionalDisplaybleBooks(){
            
            $model = new Product;
            
             $category_id = $this->getTheCategoryIdOfProfessionalSchoolBooks();
             $displayable_sum = $model->getTheTotalNumberOfProductsForThisCategory($category_id);
            return $displayable_sum;
           
        }
        
        
             /**
         * This is the function that gets the total number of displayable other books
         */
        public function getTheTotalNumberOfOtherDisplaybleBooks(){
            $model = new Product;
            $category_id = $this->getTheCategoryIdOfOtherBooks();
            $displayable_sum = $model->getTheTotalNumberOfProductsForThisCategory($category_id);
            return $displayable_sum;
          
        }
        
       /**
        * This is the function that gets the totral number of types for a category
        */
        public function getTheTotalNumberOfTypesForThisCategory($id){
              $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product_type')
                    ->where("is_available=1 and category_id=$id");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        /**
         * This is the function that gets the total number of types for a paas category
         */
        public function getTheTotalNumberOfTypesForThisFaasCategory($id){
               $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product_type')
                    ->where("category_id=$id and (is_available=1 and is_faas=1)");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        /**
         * This is the function that gets the faas name
         */
        public function getTheFaasNameGivenItsID($type_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$type_id);
            $type= ProductType::model()->find($criteria);
            
            return $type['name'];
        }
        
        
        /**
         * This is the function that gets the total product type on the store
         */
        public function getTheTotalProductTypeOnTheStore(){
            
               $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product_type');
                   // ->where("displayable_on_store=1 and (product_type_id=$id and is_faas=1)");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        
        /**
         * This is the function that gets the jss series 1 bucket type id
         */
        public function getTheJSSBucketSeries1TypeId(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSJSSSERIES1BUCKET');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
            
        }
        
        
         /**
         * This is the function that gets the jss series 2 bucket type id
         */
        public function getTheJSSBucketSeries2TypeId(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSJSSSERIES2BUCKET');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
            
        }
        
         /**
         * This is the function that gets the jss series 3 bucket type id
         */
        public function getTheJSSBucketSeries3TypeId(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSJSSSERIES3BUCKET');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
            
        }
        
        
         /**
         * This is the function that gets the sss series 1 bucket type id
         */
        public function getTheSSSBucketSeries1TypeId(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSSSSSERIES1BUCKET');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
            
        }
        
        
          /**
         * This is the function that gets the sss series 2 bucket type id
         */
        public function getTheSSSBucketSeries2TypeId(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSSSSSERIES2BUCKET');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
            
        }
        
        
           /**
         * This is the function that gets the sss series 3 bucket type id
         */
        public function getTheSSSBucketSeries3TypeId(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSSSSSERIES3BUCKET');
            $type= ProductType::model()->find($criteria);
            
           return $type['id'];
            
        }
        
        /**
         * This is the function that gets the category id of a senior secondary school boocks
         */
        public function getTheSecondarySchoolCategoryId(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSSS');
            $type= ProductType::model()->find($criteria);
            
           return $type['category_id'];
            
        }
        
        
        /**
         * This is the function that gets the category id of tertiary institution books 
         */
        public function getTheCategoryIdOfTertiarySchoolBooks(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKSTERTIARY');
            $type= ProductType::model()->find($criteria);
            
           return $type['category_id'];
            
        }
        
         /**
         * This is the function that gets the category id of professional books 
         */
        public function getTheCategoryIdOfProfessionalSchoolBooks(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKPROFESSIONAL');
            $type= ProductType::model()->find($criteria);
            
           return $type['category_id'];
            
        }
        
        
         /**
         * This is the function that gets the category id of other books 
         */
        public function getTheCategoryIdOfOtherBooks(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKOTHERS');
            $type= ProductType::model()->find($criteria);
            
           return $type['category_id'];
            
        }
        
        
         /**
         * This is the function that gets the category id of primary books 
         */
        public function getTheCategoryIdOfNurserySchoolBooks(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='code=:code';
            $criteria->params = array(':code'=>'BOOKNURSERY');
            $type= ProductType::model()->find($criteria);
            
           return $type['category_id'];
            
        }
}  


         
