<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property integer $icon_size
 * @property string $container_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 * @property string $code
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Container $container
 */
class Service extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, container_id, code', 'required'),
			array('icon_size, create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name, icon', 'length', 'max'=>60),
			array('description', 'length', 'max'=>150),
			array('container_id', 'length', 'max'=>10),
			array('code', 'length', 'max'=>200),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, icon, icon_size, container_id, create_time, create_user_id, update_time, update_user_id, code', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'service_id'),
			'container' => array(self::BELONGS_TO, 'Container', 'container_id'),
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
			'icon_size' => 'Icon Size',
			'container_id' => 'Container',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
			'code' => 'Code',
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
		$criteria->compare('icon_size',$this->icon_size);
		$criteria->compare('container_id',$this->container_id,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Service the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that gets the general service icon
         */
        public function getTheGeneralServiceIcon(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='name=:name';
            $criteria->params = array(':name'=>'Cobuy General');
            $service = Service::model()->find($criteria);
            
            return $service['icon'];
        }
        
        
         /**
         * This is the function that gets the share service icon
         */
        public function getTheSharedServiceIcon(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='name=:name';
            $criteria->params = array(':name'=>'Cobuy Share');
            $service = Service::model()->find($criteria);
            
            return $service['icon'];
        }
        
        
         /**
         * This is the function that gets the business service icon
         */
        public function getTheBusinessServiceIcon(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='name=:name';
            $criteria->params = array(':name'=>'Cobuy Business');
            $service = Service::model()->find($criteria);
            
            return $service['icon'];
        }
        
        
        /**
         * This is the function that retrieves a service code
         */
        public function getTheServiceCode($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $service = Service::model()->find($criteria);
            
            return $service['code'];
        }
        
        /**
         * This is the function that gets the service name
         */
        public function getServiceName($service_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$service_id);
            $service = Service::model()->find($criteria);
            
            return $service['name'];
        }
        
        
        
         /**
         * This is the function that retrieves a service code
         */
        public function getThisServiceCode($id){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $service= Service::model()->find($criteria);
           
           return $service['code'];
        }
        
        
        /**
         * This is the function that returns the service id of the hampers service
         */
        public function getTheHamperServiceId(){
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='code=:code';
           $criteria->params = array(':code'=>strtolower('hampers'));
           $service= Service::model()->find($criteria);
           
           return $service['id'];
        }
        
        
        /**
         * This is the function that gets the incremented incrementer of a service 
         */
        public function getTheNewIncrementedServiceCounterValue($service_id){
            //get the current incrementer of this service
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$service_id);
            $service= Service::model()->find($criteria);
            $new_incrementer = $service['incrementer'] + 1;
            
            if($this->incrementThisServiceCounter($service_id,$new_incrementer)){
                return $new_incrementer;
            }else{
                return 0;
            }
            
        }
        
        
        /**
         * This is the function that increments the service counter
         */
        public function incrementThisServiceCounter($service_id,$new_incrementer){
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('service',
                                  array(
                                    'incrementer'=>$new_incrementer,
                                                       
                            ),
                     ("id=$service_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
        }
        
        
        /**
         * This is the function that retrieves the service code given its code
         */
        public function getThisServiceIdGiveItsCode($code){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='code=:code';
           $criteria->params = array(':code'=>$code);
           $service= Service::model()->find($criteria);
           
           return $service['id'];
            
        }
        
        
        
        /**
         * This is the function that determines if a service is in the beauty or fashion section
         */
        public function isThisServiceInTheFashionAndBeautySection($id){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $service= Service::model()->find($criteria);
           
           
           if($service['code'] == 'APPAREL'){
               return true;
           }else if($service['code'] == 'BEAUTY'){
               return true;
           }else if($service['code'] == 'SHOES'){
               return true;
           }else if($service['code'] == 'JEWELRY'){
               return true;
           }else{
               return false;
           }
           
        }
        
        
        
        /**
         * This is the function that determines if a service is in the wholesale  or commodities section
         */
        public function isThisServiceInTheWholesaleAndCommoditiesSection($id){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $service= Service::model()->find($criteria);
           
           
           if($service['code'] == 'MINERALCOMMODITY'){
               return true;
           }else if($service['code'] == 'AGRICCOMMODITY'){
               return true;
           }else if($service['code'] == 'WHOLESALE'){
               return true;
           }else if($service['code'] == 'PEARLCOMMODITY'){
               return true;
           }else if($service['code'] == 'HYDROCARBOMCOMMODITY'){
               return true;
           }else{
               return false;
           }
           
        }
       
        
        /**
         * This is the function that gets the stationary service id
         */
        public function getTheStationaryServiceIdOnTheStore(){
            
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='code=:code and (is_available=1 and display_category_on_store=1)';
           $criteria->params = array(':code'=>'LEARNINGTOOLS');
           $service= Service::model()->find($criteria);
           
           if(is_numeric($service['id'])){
               return $service['id'];
           }else{
               return -1;
           }
           
           
        }
        
        /**
         * This is the function that gets the total number of products for an application service
         */
        public function getTheTotalNumberOfStationaryDisplayableProducts(){
            $model = new Product;
            return $model->getTheTotalNumberOfStationaryDisplayableProducts($this->getTheStationaryServiceIdOnTheStore());
        }
        
        
        /**
         * This is the function that gets the total number of available and displayable sevices on the store
         */
        public function getTheTotalNumberOfDisplayableAndAvailableServices(){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('service')
                   ->where("is_available=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        
        /**
         * this is the function that gets the to number of services on the store
         */
        public function getTheTotalServiceOnTheStore(){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('service');
                   //->where("is_available=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
       
}
