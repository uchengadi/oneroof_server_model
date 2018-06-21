<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Products[] $products1
 */
class Category extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name, description', 'length', 'max'=>200),
			array('icon', 'length', 'max'=>100),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, icon, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'category_id'),
			'products1' => array(self::HAS_MANY, 'Products', 'category_id'),
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
			'icon' => 'Icon',
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
		$criteria->compare('icon',$this->icon,true);
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
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
             
        /**
         * This is the function that gets a category name
         */
        public function getCategoryName($category_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$category_id);
            $category = Category::model()->find($criteria);
            
            return $category['name'];
        }
        
        
        /**
         * This is the function that retrieves a category code
         */
        public function getThisCategoryCode($id){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $category= Category::model()->find($criteria);
           
           return $category['code'];
        }
        
        
        /**
         * This is the function that returns the category id of the hampers service
         */
        public function getTheHamperCategoryId(){
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='code=:code';
           $criteria->params = array(':code'=>strtolower('hampers'));
           $category= Category::model()->find($criteria);
           
           return $category['id'];
        }
        
        
        /**
         * This is the function that gets the service id of a category
         */
        public function getTheServiceIdOfThisCategory($id){
            $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $category= Category::model()->find($criteria);
           
           return $category['service_id'];
           
        }
        
        
        /**
         * This is a function that confirms if a type category is in a service
         */
        public function isTypeCategoryInThisService($category_id,$service_id){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('category')
                    ->where("id = $category_id and service_id=$service_id");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
      
        
        /**
         * This is the function that retrieves the service code given its code
         */
        public function getThisCategoryIdGivenItsCode($code){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='code=:code';
           $criteria->params = array(':code'=>$code);
           $category= Category::model()->find($criteria);
           
           return $category['id'];
            
        }
        
        
         /**
         * This is the function that confirms if a product could be included in a filter
         */
        public function isThisProductIncludable($filter_para,$category_id){
            
            //get this category code
            $code = $this->getThisCategoryCode($category_id);
            
           if($filter_para =="email"){
               if($code =="NigeriaEmailOnlyLeads"){
                   return true;
               }else if ($code =="AfricaEmailOnlyLeads"){
                   return true;
               }else if($code == "EuropeEmailOnlyLeads"){
                   return true;
               }else if($code == "NorthAmericaEmailOnlyLeads"){
                   return true;
               }else if($code == "WorldEmailOnlyLeads"){
                   return true;
               }else if($code == "AsiaEmailOnlyLeads"){
                   return true;
               }else if($code == "SouthAmericaEmailOnlyLeads"){
                   return true;
               }else{
                   return false;
               }
           }else if($filter_para =="phone"){
               if($code =="NigeriaOnlyMobileLeads"){
                   return true;
               }else if ($code =="AfricaMobileLeads"){
                   return true;
               }else if($code == "EuropeMobileLeads"){
                   return true;
               }else if($code == "NorthAmericaMobileLeads"){
                   return true;
               }else if($code == "AsiaMobileLeads"){
                   return true;
               }else if($code == "SouthAmericaMobileLeads"){
                   return true;
               }else if($code == "WorldMobileLeads"){
                   return true;
               }else{
                   return false;
               }
               
               
           }else if($filter_para =="facebook"){
               if($code =="AfricaFacebookOnlyLeads"){
                   return true;
               }else if ($code =="EuropeFacebookOnlyLeads"){
                   return true;
               }else if($code == "NorthAmeriaFacebookOnlyLeads"){
                   return true;
               }else if($code == "WorldFacebookLeads"){
                   return true;
               }else if($code == "AsiaFacebookOnlyLeads"){
                   return true;
               }else if($code == "SouthAmericaFacebookLeads"){
                   return true;
               }else if($code == "NigeriaOnlyFacebookLeads"){
                   return true;
               }else{
                   return false;
               }
           }else if($filter_para =="twitter"){
               if($code =="NigeriaOnlyTwitterLeads"){
                   return true;
               }else if ($code =="AfricaTwitterLeads"){
                   return true;
               }else if($code == "EuropeTwitterLeads"){
                   return true;
               }else if($code == "NorthAmericaTwitterLeads"){
                   return true;
               }else if($code == "WorldTwitterLeads"){
                   return true;
               }else if($code == "AsiaTwitterLeads"){
                   return true;
               }else if($code == "SouthAmericaTwitterLeads"){
                   return true;
               }else{
                   return false;
               }
           }else if($filter_para =="product"){
               if($code =="NigeriaOnlyProductLeads"){
                   return true;
               }else if ($code =="EuropeProductLeads"){
                   return true;
               }else if($code == "NorthAmericaProductLeads"){
                   return true;
               }else if($code == "WorldProductLeads"){
                   return true;
               }else if($code == "AsiaProductLeads"){
                   return true;
               }else if($code == "SouthAmericaProductLeads"){
                   return true;
               }else if($code == "AfricaProductLeads"){
                   return true;
               }else{
                   return false;
               }
           }else if($filter_para =="location"){
               if($code =="WorldLocationLeads"){
                   return true;
               }else if ($code =="NigeriaOnlyLocationLeads"){
                   return true;
               }else if($code == "AfricaLocationLeads"){
                   return true;
               }else if($code == "EuropeLocationLeads"){
                   return true;
               }else if($code == "AsiaLocationLeads"){
                   return true;
               }else if($code == "SouthAmericaLocationLeads"){
                   return true;
               }else if($code == "NorthAmericaLocationLeads"){
                   return true;
               }else{
                   return false;
               }
               
           }else if($filter_para =="demography"){
               
               if($code =="NigeriaDemoLeads"){
                   return true;
               }else if ($code =="EuropeDemoLeads"){
                   return true;
               }else if($code == "SouthAmericaDemoLeads"){
                   return true;
               }else if($code == "AfricaDemoLeads"){
                   return true;
               }else if($code == "NorthAmericaDemoLeads"){
                   return true;
               }else if($code == "WorldDemoLeads"){
                   return true;
               }else if($code == "AsiaDemoLeads"){
                   return true;
               }else{
                   return false;
               }
           }else if($filter_para =="investment"){
               
               if($code =="NigeriaOnlyInvestmentLeads"){
                   return true;
               }else if ($code =="AsiaInvestmentLeads"){
                   return true;
               }else if($code == "AfricaInvestmentLeads"){
                   return true;
               }else if($code == "EuropeInvestmentLeads"){
                   return true;
               }else if($code == "NorthAmericaInvestmentLeads"){
                   return true;
               }else if($code == "WorldInvestmentLeads"){
                   return true;
               }else if($code == "SouthAmericaInvestmentLeads"){
                   return true;
               }else{
                   return false;
               }
           }else if($filter_para =="research"){
               
               if($code =="NigeriaOnlyResearchLeads"){
                   return true;
               }else if ($code =="NorthAmericaResearchLeads"){
                   return true;
               }else if($code == "SouthAmericaResearchLeads"){
                   return true;
               }else if($code == "EuropeResearchLeads"){
                   return true;
               }else if($code == "WorldResearchLeads"){
                   return true;
               }else if($code == "AsiaResearchLeads"){
                   return true;
               }else if($code == "AfricaResearchLeads"){
                   return true;
               }else{
                   return false;
               }
               
           }else if($filter_para =="industry"){
               
               if($code =="NorthAmericaIndustryLeads"){
                   return true;
               }else if ($code =="WorldIndustryLeads"){
                   return true;
               }else if($code == "AfricaIndustryLeads"){
                   return true;
               }else if($code == "EuropeIndustryLeads"){
                   return true;
               }else if($code == "AsiaIndustryLeads"){
                   return true;
               }else if($code == "SouthAmericaIndustryLeads"){
                   return true;
               }else if($code == "NigeriaOnlyIndustryLeads"){
                   return true;
               }else{
                   return false;
               }
           }else if($filter_para =="transaction"){
               
               if($code =="NigeriaTransactionalLeads"){
                   return true;
               }else if ($code =="AfricaTransactionalLeads"){
                   return true;
               }else if($code == "EuropeTransactionalLeads"){
                   return true;
               }else if($code == "NorthAmericaTransactionalLeads"){
                   return true;
               }else if($code == "WorldTransactionalLeads"){
                   return true;
               }else if($code == "AsiaTransactionalLeads"){
                   return true;
               }else if($code == "SouthAmericaTransactionalLeads"){
                   return true;
               }else{
                   return false;
               }
               
           }else{
               return false;
           }
           
           
        }
        
         /**
         * This is the function that gets the total number displayable categories in a service
         */
        public function getTheTotalNumberOfCategoriesForAService($id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('category')
                    ->where("is_available=1 and service_id=$id");
                $result = $cmd->queryScalar();
                
               return $result;
        }
       
        
        /**
         * This is the function that retrieves the total number of "farming as a service" products
         */
        public function getTheTotalNumberOfFaasProductsOnTheStore(){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('category')
                    ->where("is_available=1 and is_faas=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        /**
         * This is the function that retrieves the name of a faas region
         */
        public function getTheRegionOfThisFaaS($category_id){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$category_id);
           $category= Category::model()->find($criteria);
           
           return $category['name'];
        }
        
        
        /**
         * This is the function that gets the total category on the store
         */
        public function getTheTotalCategoryOnTheStore(){
            
               $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('category');
                   // ->where("displayable_on_store=1 and (product_type_id=$id and is_faas=1)");
                $result = $cmd->queryScalar();
                
               return $result;
        }
}
