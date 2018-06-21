<?php

/**
 * This is the model class for table "website_services".
 *
 * The followings are the available columns in table 'website_services':
 * @property string $id
 * @property string $introduction
 * @property string $service_general
 * @property string $service_share
 * @property string $service_business
 * @property string $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $image_header_1
 * @property string $image_header_2
 * @property string $image_header_3
 * @property string $image_header_4
 * @property string $image_header_5
 * @property string $products_on_sales
 * @property string $less_than_1000
 * @property string $for_rent
 * @property string $for_options
 * @property string $baby_products
 * @property string $groceries
 * @property string $fashion_and_beauty
 * @property string $office_products
 * @property string $books_and_learning
 * @property string $smartphones
 * @property string $computers
 * @property string $wholesales_and_commodity
 * @property string $home_services
 * @property string $advert_mini_header
 * @property string $primary_books_and_learning
 * @property string $secondary_books_and_learning
 * @property string $tertiary_books_and_learning
 * @property string $professional_books_and_learning
 * @property string $other_books_and_learning
 * @property string $learning_tools_and_learning
 */
class WebsiteServices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'website_services';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>8),
			array('image_header_1, image_header_2, image_header_3, image_header_4, image_header_5, products_on_sales, less_than_1000, for_rent, for_options, baby_products, groceries, fashion_and_beauty, office_products, books_and_learning, smartphones, computers, wholesales_and_commodity, home_services, advert_mini_header, primary_books_and_learning, secondary_books_and_learning, tertiary_books_and_learning, professional_books_and_learning, other_books_and_learning, learning_tools_and_learning', 'length', 'max'=>200),
			array('introduction, service_general, service_share, service_business, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, introduction, service_general, service_share, service_business, status, create_time, update_time, create_user_id, update_user_id, image_header_1, image_header_2, image_header_3, image_header_4, image_header_5, products_on_sales, less_than_1000, for_rent, for_options, baby_products, groceries, fashion_and_beauty, office_products, books_and_learning, smartphones, computers, wholesales_and_commodity, home_services, advert_mini_header, primary_books_and_learning, secondary_books_and_learning, tertiary_books_and_learning, professional_books_and_learning, other_books_and_learning, learning_tools_and_learning', 'safe', 'on'=>'search'),
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
			'introduction' => 'Introduction',
			'service_general' => 'Service General',
			'service_share' => 'Service Share',
			'service_business' => 'Service Business',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_user_id' => 'Create User',
			'update_user_id' => 'Update User',
			'image_header_1' => 'Image Header 1',
			'image_header_2' => 'Image Header 2',
			'image_header_3' => 'Image Header 3',
			'image_header_4' => 'Image Header 4',
			'image_header_5' => 'Image Header 5',
			'products_on_sales' => 'Products On Sales',
			'less_than_1000' => 'Less Than 1000',
			'for_rent' => 'For Rent',
			'for_options' => 'For Options',
			'baby_products' => 'Baby Products',
			'groceries' => 'Groceries',
			'fashion_and_beauty' => 'Fashion And Beauty',
			'office_products' => 'Office Products',
			'books_and_learning' => 'Books And Learning',
			'smartphones' => 'Smartphones',
			'computers' => 'Computers',
			'wholesales_and_commodity' => 'Wholesales And Commodity',
			'home_services' => 'Home Services',
			'advert_mini_header' => 'Advert Mini Header',
			'primary_books_and_learning' => 'Primary Books And Learning',
			'secondary_books_and_learning' => 'Secondary Books And Learning',
			'tertiary_books_and_learning' => 'Tertiary Books And Learning',
			'professional_books_and_learning' => 'Professional Books And Learning',
			'other_books_and_learning' => 'Other Books And Learning',
			'learning_tools_and_learning' => 'Learning Tools And Learning',
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
		$criteria->compare('introduction',$this->introduction,true);
		$criteria->compare('service_general',$this->service_general,true);
		$criteria->compare('service_share',$this->service_share,true);
		$criteria->compare('service_business',$this->service_business,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('image_header_1',$this->image_header_1,true);
		$criteria->compare('image_header_2',$this->image_header_2,true);
		$criteria->compare('image_header_3',$this->image_header_3,true);
		$criteria->compare('image_header_4',$this->image_header_4,true);
		$criteria->compare('image_header_5',$this->image_header_5,true);
		$criteria->compare('products_on_sales',$this->products_on_sales,true);
		$criteria->compare('less_than_1000',$this->less_than_1000,true);
		$criteria->compare('for_rent',$this->for_rent,true);
		$criteria->compare('for_options',$this->for_options,true);
		$criteria->compare('baby_products',$this->baby_products,true);
		$criteria->compare('groceries',$this->groceries,true);
		$criteria->compare('fashion_and_beauty',$this->fashion_and_beauty,true);
		$criteria->compare('office_products',$this->office_products,true);
		$criteria->compare('books_and_learning',$this->books_and_learning,true);
		$criteria->compare('smartphones',$this->smartphones,true);
		$criteria->compare('computers',$this->computers,true);
		$criteria->compare('wholesales_and_commodity',$this->wholesales_and_commodity,true);
		$criteria->compare('home_services',$this->home_services,true);
		$criteria->compare('advert_mini_header',$this->advert_mini_header,true);
		$criteria->compare('primary_books_and_learning',$this->primary_books_and_learning,true);
		$criteria->compare('secondary_books_and_learning',$this->secondary_books_and_learning,true);
		$criteria->compare('tertiary_books_and_learning',$this->tertiary_books_and_learning,true);
		$criteria->compare('professional_books_and_learning',$this->professional_books_and_learning,true);
		$criteria->compare('other_books_and_learning',$this->other_books_and_learning,true);
		$criteria->compare('learning_tools_and_learning',$this->learning_tools_and_learning,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WebsiteServices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        
        /**
         * This is the function that confirms if the existing service content is deactivated successfully
         */
        public function isTheExistingServiceContentStatusDeactivated(){
            
            if($this->isThereAnActivatedServiceContent()){
                if($this->isServiceContentDeactivationSuccessful()){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
        }
        
        
        /**
         * This is the function that confirms the availability of an active service content
         */
        public function isThereAnActivatedServiceContent(){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('website_services')
                    ->where("status='active'");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that deatctivates an active service content
         */
        public function isServiceContentDeactivationSuccessful(){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('website_services',
                                  array(
                                    'status'=>'inactive',
                                                             
                            ),
                     ("status='active'"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
}
