<?php

/**
 * This is the model class for table "keywords".
 *
 * The followings are the available columns in table 'keywords':
 * @property string $id
 * @property string $product_id
 * @property string $keyword
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class Keywords extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'keywords';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id', 'required'),
			array('product_id', 'length', 'max'=>10),
			array('keyword', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, keyword', 'safe', 'on'=>'search'),
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
			'keyword' => 'Keyword',
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
		$criteria->compare('keyword',$this->keyword,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Keywords the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that registers a product's keyboard
         */
        public function registerThisProductKeywords($product_id,$keywords){
            $counter = 0;
            foreach($keywords as $keyword){
                if($this->registerThisKeywordForThisProduct($product_id,$keyword) == true){
                     $counter = $counter + 0;
                }
               
            }
            return $counter;
            
        }
        
        /**
         * This is the function that register a keyword for a product
         */
        public function registerThisKeywordForThisProduct($product_id,$keyword){
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('keywords',
                         array( 'product_id'=>$product_id,
                                 'keyword'=>$keyword,
                                
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        
        /**
         * This is the function that modifies product keyword values
         */
        public function modifyThisProductKeywords($product_id,$keywords){
        //confirm if this product already has keywords
            if($this->isThisProductWithKeywordsAlready($product_id)){
                 //delete all the keywords for this product 
                 if($this->isTheRemovalOfKeywordsForThisProductASuccess($product_id)){
                    //register the new keywords for this product
                    return $this->registerThisProductKeywords($product_id,$keywords);
                }else{
                    return 0;
                }
            }else{
                return $this->registerThisProductKeywords($product_id,$keywords);
            }
            
       
            
            
        }
        
        
        /**
         * This is the function that removes all keywords for a product
         */
        public function isTheRemovalOfKeywordsForThisProductASuccess($product_id){
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('keywords', 'product_id=:prodid', array(':prodid'=>$product_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if a product is already with leywords
         */
        public function isThisProductWithKeywordsAlready($product_id){
              $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('keywords')
                   ->where("product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result>0){
                    return true;
                }else{
                    return false;
                }
                
              
        }
}
