<?php

/**
 * This is the model class for table "hamper_container".
 *
 * The followings are the available columns in table 'hamper_container':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property double $amount
 * @property string $code
 * @property string $icon
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property double $service_charge_in_percentages
 * @property double $minimum_service_charge
 * @property double $weight
 */
class HamperContainer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hamper_container';
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
			array('amount, service_charge_in_percentages, minimum_service_charge, weight', 'numerical'),
			array('name, code', 'length', 'max'=>200),
			array('icon', 'length', 'max'=>100),
			array('description, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, amount, code, icon, create_time, update_time, create_user_id, update_user_id, service_charge_in_percentages, minimum_service_charge, weight', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'amount' => 'Amount',
			'code' => 'Code',
			'icon' => 'Icon',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_user_id' => 'Create User',
			'update_user_id' => 'Update User',
			'service_charge_in_percentages' => 'Service Charge In Percentages',
			'minimum_service_charge' => 'Minimum Service Charge',
			'weight' => 'Weight',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('service_charge_in_percentages',$this->service_charge_in_percentages);
		$criteria->compare('minimum_service_charge',$this->minimum_service_charge);
		$criteria->compare('weight',$this->weight);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HamperContainer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
    
        
        /**
         * This is the function that gets the weight of a hamper container
         */
        public function getTheWeightOfThisHamperContainer($hamper_id){
            
             $model = new HamperHasBeneficiary;
             
             //get all the containers used for memeber beneficiaries for this hamper
             $member_containers = $model->getAllTheContainersUsedForMembersBeneficiariesForThisHamper($hamper_id);
             
              //get all the containers used for non memeber beneficiaries for this hamper
             $nonmember_containers = $this->getAllTheContainersUsedForNonMembersBeneficiariesForThisHamper($hamper_id);
             
             $weight = 0;
             
             foreach($member_containers as $for_member){
                 $weight = $weight + $this->getTheWeightOfThisContainer($for_member);
             }
             
              foreach($nonmember_containers as $for_nonmember){
                 $weight = $weight + $this->getTheWeightOfThisContainer($for_nonmember);
             }
                                   
             return $weight;
        }
        
        
        /**
         * This is the function that gets all the containers used for this hamper for non member beneficiaries
         */
        public function getAllTheContainersUsedForNonMembersBeneficiariesForThisHamper($hamper_id){
            $model = new HamperHasNonMemberBeneficiary;
            
           return $model->getAllTheContainersUsedForNonMembersBeneficiariesForThisHamper($hamper_id);
        }
        
        /**
         * This is the function that gets the weight of a container
         */
        public function getTheWeightOfThisContainer($container_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$container_id);
             $container= HamperContainer::model()->find($criteria);
             
             return $container['weight'];
        }
        
        /**
         * This is the function that gets the name of a hamper
         */
        public function getThisExistingHamperContainerName($id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $container= HamperContainer::model()->find($criteria);
             
             return $container['name'];
        }
        
        
          /**
        * Provide icon when unavailable
	 */
	public function provideHamperContainerIconWhenUnavailable()
	{
		return 'hamper_container_unavailable.png';
	}
        
        
        /**
         * This is the function that retrieves the previous icon of the task in question
         */
        public function retrieveThePreviousIconName($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';   
            $criteria->params = array(':id'=>$id);
            $icon = HamperContainer::model()->find($criteria);
            
            
            return $icon['icon'];
            
            
        }
        
        
        	/**
         * This is the function that moves icons to its directory
         */
        public function moveTheIconToItsPathAndReturnTheIconName($model,$icon_filename){
            
            if(isset($_FILES['icon']['name'])){
                        $tmpName = $_FILES['icon']['tmp_name'];
                        $iconName = $_FILES['icon']['name'];    
                        $iconType = $_FILES['icon']['type'];
                        $iconSize = $_FILES['icon']['size'];
                  
                   }
                    
                    if($iconName !== null) {
                        if($model->id === null){
                          //$iconFileName = $icon_filename;  
                          if($icon_filename != 'hamper_container_unavailable.png'){
                                $iconFileName = time().'_'.$icon_filename;  
                            }else{
                                $iconFileName = $icon_filename;  
                            }  
                          
                           // upload the icon file
                        if($iconName !== null){
                            	$iconPath = Yii::app()->params['icons'].$iconFileName;
				move_uploaded_file($tmpName,  $iconPath);
                                        
                        
                                return $iconFileName;
                        }else{
                            $iconFileName = $icon_filename;
                            return $iconFileName;
                        } // validate to save file
                        }else{
                            if($this->noNewIconFileProvided($model->id,$icon_filename)){
                                $iconFileName = $icon_filename; 
                                return $iconFileName;
                            }else{
                            if($icon_filename != 'hamper_container_unavailable.png'){
                                if($this->removeTheExistingIconFile($model->id)){
                                 $iconFileName = time().'_'.$icon_filename; 
                                 //$iconFileName = time().$icon_filename;  
                                   $iconPath = Yii::app()->params['icons'].$iconFileName;
                                   move_uploaded_file($tmpName,$iconPath);
                                   return $iconFileName;
                                    
                                   // $iconFileName = time().'_'.$icon_filename;  
                                    
                             }
                                
                            }
                                
                                
                            }
                            
                            //$iconFileName = $icon_filename; 
                                              
                            
                        }
                      
                     }else{
                         $iconFileName = $icon_filename;
                         return $iconFileName;
                     }
					
                       
                               
        }
        
        
        	 /**
         * This is the function that removes an existing video file
         */
        public function removeTheExistingIconFile($id){
            
            //retreve the existing zip file from the database
            
            if($this->isTheIconNotTheDefault($id)){
                
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= HamperContainer::model()->find($criteria);
                
                //$directoryPath =  dirname(Yii::app()->request->scriptFile);
               $directoryPath = "c:\\xampp\htdocs\cobuy_images\\icons\\";
               // $iconpath = '..\appspace_assets\icons'.$icon['icon'];
                $filepath =$directoryPath.$icon['icon'];
                //$filepath = $directoryPath.$iconpath;
                
                if(unlink($filepath)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
                
            
            
        }
        
	
        /**
         * This is the function that determines if  a category icon is the default
         */
        public function isTheIconNotTheDefault($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= HamperContainer::model()->find($criteria);
                
                if($icon['icon'] == 'hamper_container_unavailable.png' || $icon['icon'] ===NULL){
                    return false;
                }else{
                    return true;
                }
        }
		
		
		
		/**
         * This is the function to ascertain if a new icon was provided or not
         */
        public function noNewIconFileProvided($id,$icon_filename){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= HamperContainer::model()->find($criteria);
                
                if($icon['icon']==$icon_filename){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
       /**
        * This is the function that retrieves the cost of the hamper container and its processing cost
        */
        public function getTheTotalCostOfAnHamper($hamper_id,$total_cost_of_hamper_items){
            $model = new Product;
            
            //get the hamper container id
            $hamper_container_id = $model->getTheHamperContainerIdOfThisHamper($hamper_id);
            
            $total_cost_of_hamper = 0;
            
            $hamper_total_cost_less_service_charge = 0;
            
            if($hamper_container_id>0){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_container_id);
                $hamper= HamperContainer::model()->find($criteria);
            
                $hamper_total_cost_less_service_charge = $total_cost_of_hamper_items + $hamper['amount'];
            
                $service_charge = $hamper_total_cost_less_service_charge * $hamper['service_charge_in_percentages']/100;
            
                if($service_charge>$hamper['minimum_service_charge']){
                    $total_cost_of_hamper = $hamper_total_cost_less_service_charge + $service_charge;
                }else{
                    $total_cost_of_hamper = $hamper_total_cost_less_service_charge + $hamper['minimum_service_charge'];
                }
                return $total_cost_of_hamper;
                
            }else{
                return $total_cost_of_hamper_items;
            }
            
            
            
        }
        
        
        
        /**
        * This is the function that retrieves the cost of the hamper container and its processing cost
        */
       public function getThePriceOfThisHamperContainer($hamper_container_id,$cost_of_hamper_items){
            $model = new Product;
            
            $total_container_cost = 0;
            
            $hamper_total_cost_less_service_charge = 0;
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_container_id);
                $hamper= HamperContainer::model()->find($criteria);
            
                $hamper_total_cost_less_service_charge = $cost_of_hamper_items + $hamper['amount'];
            
                $service_charge = $hamper_total_cost_less_service_charge * $hamper['service_charge_in_percentages']/100;
            
                if($service_charge>$hamper['minimum_service_charge']){
                    $total_container_cost = $hamper['amount'] + $service_charge;
                }else{
                    $total_container_cost = $hamper['amount'] + $hamper['minimum_service_charge'];
                }
                return $total_container_cost;
                
          
            
        }
    
        
        
        /**
         * This is the function that retrieves a container's image
         */
        public function getTheHamperImageOfThisContainer($hamper_container_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_container_id);
                $hamper= HamperContainer::model()->find($criteria);
                
                return $hamper['icon'];
        }
        
}
