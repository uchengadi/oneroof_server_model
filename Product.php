<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $service_id
 * @property string $category_id
 * @property string $name
 * @property string $description
 * @property string $condition
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
 * @property integer $displayable_on_store
 * @property string $product_type_id
 * @property string $feature
 * @property string $specifications
 * @property integer $minimum_number_of_product_to_buy
 * @property string $whats_in_a_park
 * @property string $whats_product_per_item
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
 * @property integer $is_member_price_valid
 * @property integer $is_quotable
 * @property integer $is_available
 * @property integer $is_escrowable
 * @property integer $is_future_tradable
 * @property string $code
 * @property integer $is_custom_product
 * @property double $hamper_cost_limit
 * @property double $weight
 * @property integer $is_a_hamper
 * @property integer $is_with_video
 * @property string $video_for
 * @property string $video_filename
 * @property double $video_size
 * @property integer $is_payment_permitted_on_delivery
 * @property integer $hamper_container_id
 * @property string $feature_1
 * @property string $feature_2
 * @property string $feature_3
 * @property string $feature_4
 * @property integer $is_rentable
 * @property integer $is_paas
 * @property integer $is_optionable
 * @property integer $allowed_for_international_market
 * @property integer $allowed_for_inspection
 * @property double $discount_for_public_institutions
 * @property double $discount_for_students
 * @property double $discount_for_academia
 * @property double $discount_for_officers
 * @property string $regulatory_compliance
 * @property integer $has_free_shipping_promotion
 * @property integer $has_give_away_promotion
 * @property integer $has_percentage_off_promotion
 * @property integer $has_buy_one_get_one_promotion
 * @property integer $has_coupon
 * @property integer $is_the_middle_page_advert
 * @property double $rent_cost_per_day
 * @property integer $maximum_rent_quantity_per_cycle
 * @property integer $minimum_rent_duration
 * @property integer $minimum_rent_quantity_per_cycle
 * @property integer $is_faas
 * @property string $faas_stage
 * @property integer $faas_months_to_harvest
 * @property integer $faas_months_from_seedling
 * @property integer $faas_current_stage_to_harvest_position
 * @property integer $faas_maximum_number_of_stages_to_harvest
 * @property string $faas_next_stage
 * @property integer $faas_number_of_months_to_next_stage
 * @property integer $is_faas_insured
 * @property double $faas_total_insurance_value
 * @property integer $is_faas_tradable
 * @property double $faas_expected_total_produce
 * @property integer $faas_must_be_held_to_maturity
 * @property integer $faas_maximum_number_of_months_to_harvest
 * @property string $faas_region
 * @property integer $minimum_faas_duration
 * @property integer $maximum_faas_duration
 * @property integer $minimum_quantity_for_faas_subscription
 * @property integer $maximum_quantity_for_faas_subscription
 * @property double $cumulative_quantity
 * @property string $date_current_stage_started
 * @property string $faas_month_season_started
 * @property string $faas_year_season_started
 * @property integer $has_warranty
 * @property integer $months_of_warranty
 * @property integer $has_son_certification
 * @property integer $has_nafdac_certification
 * @property string $other_certifications
 * @property string $faas_stage_activities
 * @property string $faas_insurance_coverage
 * @property string $faas_insurance_institution
 * @property integer $maximum_rent_duration
 *
 * The followings are the available model relations:
 * @property Escrow[] $escrows
 * @property ExpendabilityLimitAdjuster[] $expendabilityLimitAdjusters
 * @property Members[] $members
 * @property HamperHasNonMemberBeneficiary[] $hamperHasNonMemberBeneficiaries
 * @property HamperHasProducts[] $hamperHasProducts
 * @property HamperHasProducts[] $hamperHasProducts1
 * @property Members[] $members1
 * @property Category $category
 * @property Service $service
 * @property ProductConstituents[] $productConstituents
 * @property ProductSpecification[] $productSpecifications
 * @property Quote[] $quotes
 * @property UndeliveredOrderedProducts[] $undeliveredOrderedProducts
 * @property Voucher[] $vouchers
 * @property Wallet[] $wallets
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, category_id, name, product_type_id, whats_product_per_item, code', 'required'),
			array('icon_size, image_size, maximum_portion, create_user_id, update_user_id, displayable_on_store, minimum_number_of_product_to_buy, product_right_side_view_size, product_front_view_size, product_top_view_size, product_inside_view_size, product_engine_view_size, product_back_view_size, product_left_side_view_size, product_bottom_view_size, product_dashboard_view_size, product_contents_or_booth_view_size, is_member_price_valid, is_quotable, is_available, is_escrowable, is_future_tradable, is_custom_product, is_a_hamper, is_with_video, is_payment_permitted_on_delivery, hamper_container_id, is_rentable, is_paas, is_optionable, allowed_for_international_market, allowed_for_inspection, has_free_shipping_promotion, has_give_away_promotion, has_percentage_off_promotion, has_buy_one_get_one_promotion, has_coupon, is_the_middle_page_advert, maximum_rent_quantity_per_cycle, minimum_rent_duration, minimum_rent_quantity_per_cycle, is_faas, faas_months_to_harvest, faas_months_from_seedling, faas_current_stage_to_harvest_position, faas_maximum_number_of_stages_to_harvest, faas_number_of_months_to_next_stage, is_faas_insured, is_faas_tradable, faas_must_be_held_to_maturity, faas_maximum_number_of_months_to_harvest, minimum_faas_duration, maximum_faas_duration, minimum_quantity_for_faas_subscription, maximum_quantity_for_faas_subscription, has_warranty, months_of_warranty, has_son_certification, has_nafdac_certification, maximum_rent_duration', 'numerical', 'integerOnly'=>true),
			array('prevailing_retail_selling_price, per_portion_price, discount_rate, discounted_amount, quantity, hamper_cost_limit, weight, video_size, discount_for_public_institutions, discount_for_students, discount_for_academia, discount_for_officers, rent_cost_per_day, faas_total_insurance_value, faas_expected_total_produce, cumulative_quantity', 'numerical'),
			array('service_id, category_id, product_type_id', 'length', 'max'=>10),
			array('name, icon, headline_image, whats_product_per_item, price_validity_period, product_front_view, product_right_side_view, product_top_view, product_inside_view, product_engine_view, product_back_view, product_left_side_view, product_bottom_view, product_dashboard_view, product_contents_or_booth_view', 'length', 'max'=>100),
			array('feature, feature_1, feature_2, feature_3, feature_4, faas_stage_activities, faas_insurance_coverage, faas_insurance_institution,other_certifications', 'length', 'max'=>250),
			array('brand, maker, origin, code, video_filename', 'length', 'max'=>200),
			array('video_for', 'length', 'max'=>19),
			array('faas_stage', 'length', 'max'=>7),
			array('faas_next_stage, faas_region', 'length', 'max'=>50),
			array('faas_month_season_started', 'length', 'max'=>9),
			array('faas_year_season_started', 'length', 'max'=>4),
			array('description, condition, create_time, update_time, specifications, whats_in_a_park, start_price_validity_period, end_price_validity_period, date_current_stage_started', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, service_id, category_id, name, description, condition, icon, headline_image, icon_size, image_size, prevailing_retail_selling_price, maximum_portion, per_portion_price, discount_rate, discounted_amount, quantity, create_time, create_user_id, update_time, update_user_id, displayable_on_store, product_type_id, feature, specifications, minimum_number_of_product_to_buy, whats_in_a_park, whats_product_per_item, price_validity_period, product_front_view, product_right_side_view, product_top_view, product_inside_view, product_engine_view, product_back_view, product_left_side_view, product_bottom_view, product_dashboard_view, product_contents_or_booth_view, product_right_side_view_size, product_front_view_size, product_top_view_size, product_inside_view_size, product_engine_view_size, product_back_view_size, product_left_side_view_size, product_bottom_view_size, product_dashboard_view_size, product_contents_or_booth_view_size, brand, maker, origin, start_price_validity_period, end_price_validity_period, is_member_price_valid, is_quotable, is_available, is_escrowable, is_future_tradable, code, is_custom_product, hamper_cost_limit, weight, is_a_hamper, is_with_video, video_for, video_filename, video_size, is_payment_permitted_on_delivery, hamper_container_id, feature_1, feature_2, feature_3, feature_4, is_rentable, is_paas, is_optionable, allowed_for_international_market, allowed_for_inspection, discount_for_public_institutions, discount_for_students, discount_for_academia, discount_for_officers, regulatory_compliance, has_free_shipping_promotion, has_give_away_promotion, has_percentage_off_promotion, has_buy_one_get_one_promotion, has_coupon, is_the_middle_page_advert, rent_cost_per_day, maximum_rent_quantity_per_cycle, minimum_rent_duration, minimum_rent_quantity_per_cycle, is_faas, faas_stage, faas_months_to_harvest, faas_months_from_seedling, faas_current_stage_to_harvest_position, faas_maximum_number_of_stages_to_harvest, faas_next_stage, faas_number_of_months_to_next_stage, is_faas_insured, faas_total_insurance_value, is_faas_tradable, faas_expected_total_produce, faas_must_be_held_to_maturity, faas_maximum_number_of_months_to_harvest, faas_region, minimum_faas_duration, maximum_faas_duration, minimum_quantity_for_faas_subscription, maximum_quantity_for_faas_subscription, cumulative_quantity, date_current_stage_started, faas_month_season_started, faas_year_season_started, has_warranty, months_of_warranty, has_son_certification, has_nafdac_certification, other_certifications, faas_stage_activities, faas_insurance_coverage, faas_insurance_institution, maximum_rent_duration', 'safe', 'on'=>'search'),
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
			'escrows' => array(self::HAS_MANY, 'Escrow', 'product_id'),
			'expendabilityLimitAdjusters' => array(self::HAS_MANY, 'ExpendabilityLimitAdjuster', 'product_id'),
			'members' => array(self::MANY_MANY, 'Members', 'product_has_vendor(product_id, vendor_id)'),
			'hamperHasNonMemberBeneficiaries' => array(self::HAS_MANY, 'HamperHasNonMemberBeneficiary', 'hamper_id'),
			'hamperHasProducts' => array(self::HAS_MANY, 'HamperHasProducts', 'hamper_id'),
			'hamperHasProducts1' => array(self::HAS_MANY, 'HamperHasProducts', 'product_id'),
			'members1' => array(self::MANY_MANY, 'Members', 'member_subscribed_to_products(product_id, member_id)'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			'productConstituents' => array(self::HAS_MANY, 'ProductConstituents', 'product_id'),
			'productSpecifications' => array(self::MANY_MANY, 'ProductSpecification', 'product_has_specifications(product_id, specification_id)'),
			'quotes' => array(self::HAS_MANY, 'Quote', 'product_id'),
			'undeliveredOrderedProducts' => array(self::HAS_MANY, 'UndeliveredOrderedProducts', 'product_id'),
			'vouchers' => array(self::MANY_MANY, 'Voucher', 'voucher_limited_to_products(product_id, voucher_id)'),
			'wallets' => array(self::MANY_MANY, 'Wallet', 'wallet_has_product_expendable_limit(product_id, wallet_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service_id' => 'Service',
			'category_id' => 'Category',
			'name' => 'Name',
			'description' => 'Description',
			'condition' => 'Condition',
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
			'displayable_on_store' => 'Displayable On Store',
			'product_type_id' => 'Product Type',
			'feature' => 'Feature',
			'specifications' => 'Specifications',
			'minimum_number_of_product_to_buy' => 'Minimum Number Of Product To Buy',
			'whats_in_a_park' => 'Whats In A Park',
			'whats_product_per_item' => 'Whats Product Per Item',
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
			'is_member_price_valid' => 'Is Member Price Valid',
			'is_quotable' => 'Is Quotable',
			'is_available' => 'Is Available',
			'is_escrowable' => 'Is Escrowable',
			'is_future_tradable' => 'Is Future Tradable',
			'code' => 'Code',
			'is_custom_product' => 'Is Custom Product',
			'hamper_cost_limit' => 'Hamper Cost Limit',
			'weight' => 'Weight',
			'is_a_hamper' => 'Is A Hamper',
			'is_with_video' => 'Is With Video',
			'video_for' => 'Video For',
			'video_filename' => 'Video Filename',
			'video_size' => 'Video Size',
			'is_payment_permitted_on_delivery' => 'Is Payment Permitted On Delivery',
			'hamper_container_id' => 'Hamper Container',
			'feature_1' => 'Feature 1',
			'feature_2' => 'Feature 2',
			'feature_3' => 'Feature 3',
			'feature_4' => 'Feature 4',
			'is_rentable' => 'Is Rentable',
			'is_paas' => 'Is Paas',
			'is_optionable' => 'Is Optionable',
			'allowed_for_international_market' => 'Allowed For International Market',
			'allowed_for_inspection' => 'Allowed For Inspection',
			'discount_for_public_institutions' => 'Discount For Public Institutions',
			'discount_for_students' => 'Discount For Students',
			'discount_for_academia' => 'Discount For Academia',
			'discount_for_officers' => 'Discount For Officers',
			'regulatory_compliance' => 'Regulatory Compliance',
			'has_free_shipping_promotion' => 'Has Free Shipping Promotion',
			'has_give_away_promotion' => 'Has Give Away Promotion',
			'has_percentage_off_promotion' => 'Has Percentage Off Promotion',
			'has_buy_one_get_one_promotion' => 'Has Buy One Get One Promotion',
			'has_coupon' => 'Has Coupon',
			'is_the_middle_page_advert' => 'Is The Middle Page Advert',
			'rent_cost_per_day' => 'Rent Cost Per Day',
			'maximum_rent_quantity_per_cycle' => 'Maximum Rent Quantity Per Cycle',
			'minimum_rent_duration' => 'Minimum Rent Duration',
			'minimum_rent_quantity_per_cycle' => 'Minimum Rent Quantity Per Cycle',
			'is_faas' => 'Is Faas',
			'faas_stage' => 'Faas Stage',
			'faas_months_to_harvest' => 'Faas Months To Harvest',
			'faas_months_from_seedling' => 'Faas Months From Seedling',
			'faas_current_stage_to_harvest_position' => 'Faas Current Stage To Harvest Position',
			'faas_maximum_number_of_stages_to_harvest' => 'Faas Maximum Number Of Stages To Harvest',
			'faas_next_stage' => 'Faas Next Stage',
			'faas_number_of_months_to_next_stage' => 'Faas Number Of Months To Next Stage',
			'is_faas_insured' => 'Is Faas Insured',
			'faas_total_insurance_value' => 'Faas Total Insurance Value',
			'is_faas_tradable' => 'Is Faas Tradable',
			'faas_expected_total_produce' => 'Faas Expected Total Produce',
			'faas_must_be_held_to_maturity' => 'Faas Must Be Held To Maturity',
			'faas_maximum_number_of_months_to_harvest' => 'Faas Maximum Number Of Months To Harvest',
			'faas_region' => 'Faas Region',
			'minimum_faas_duration' => 'Minimum Faas Duration',
			'maximum_faas_duration' => 'Maximum Faas Duration',
			'minimum_quantity_for_faas_subscription' => 'Minimum Quantity For Faas Subscription',
			'maximum_quantity_for_faas_subscription' => 'Maximum Quantity For Faas Subscription',
			'cumulative_quantity' => 'Cumulative Quantity',
			'date_current_stage_started' => 'Date Current Stage Started',
			'faas_month_season_started' => 'Faas Month Season Started',
			'faas_year_season_started' => 'Faas Year Season Started',
			'has_warranty' => 'Has Warranty',
			'months_of_warranty' => 'Months Of Warranty',
			'has_son_certification' => 'Has Son Certification',
			'has_nafdac_certification' => 'Has Nafdac Certification',
			'other_certifications' => 'Other Certifications',
			'faas_stage_activities' => 'Faas Stage Activities',
			'faas_insurance_coverage' => 'Faas Insurance Coverage',
			'faas_insurance_institution' => 'Faas Insurance Institution',
			'maximum_rent_duration' => 'Maximum Rent Duration',
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
		$criteria->compare('service_id',$this->service_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('condition',$this->condition,true);
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
		$criteria->compare('displayable_on_store',$this->displayable_on_store);
		$criteria->compare('product_type_id',$this->product_type_id,true);
		$criteria->compare('feature',$this->feature,true);
		$criteria->compare('specifications',$this->specifications,true);
		$criteria->compare('minimum_number_of_product_to_buy',$this->minimum_number_of_product_to_buy);
		$criteria->compare('whats_in_a_park',$this->whats_in_a_park,true);
		$criteria->compare('whats_product_per_item',$this->whats_product_per_item,true);
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
		$criteria->compare('is_member_price_valid',$this->is_member_price_valid);
		$criteria->compare('is_quotable',$this->is_quotable);
		$criteria->compare('is_available',$this->is_available);
		$criteria->compare('is_escrowable',$this->is_escrowable);
		$criteria->compare('is_future_tradable',$this->is_future_tradable);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('is_custom_product',$this->is_custom_product);
		$criteria->compare('hamper_cost_limit',$this->hamper_cost_limit);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('is_a_hamper',$this->is_a_hamper);
		$criteria->compare('is_with_video',$this->is_with_video);
		$criteria->compare('video_for',$this->video_for,true);
		$criteria->compare('video_filename',$this->video_filename,true);
		$criteria->compare('video_size',$this->video_size);
		$criteria->compare('is_payment_permitted_on_delivery',$this->is_payment_permitted_on_delivery);
		$criteria->compare('hamper_container_id',$this->hamper_container_id);
		$criteria->compare('feature_1',$this->feature_1,true);
		$criteria->compare('feature_2',$this->feature_2,true);
		$criteria->compare('feature_3',$this->feature_3,true);
		$criteria->compare('feature_4',$this->feature_4,true);
		$criteria->compare('is_rentable',$this->is_rentable);
		$criteria->compare('is_paas',$this->is_paas);
		$criteria->compare('is_optionable',$this->is_optionable);
		$criteria->compare('allowed_for_international_market',$this->allowed_for_international_market);
		$criteria->compare('allowed_for_inspection',$this->allowed_for_inspection);
		$criteria->compare('discount_for_public_institutions',$this->discount_for_public_institutions);
		$criteria->compare('discount_for_students',$this->discount_for_students);
		$criteria->compare('discount_for_academia',$this->discount_for_academia);
		$criteria->compare('discount_for_officers',$this->discount_for_officers);
		$criteria->compare('regulatory_compliance',$this->regulatory_compliance,true);
		$criteria->compare('has_free_shipping_promotion',$this->has_free_shipping_promotion);
		$criteria->compare('has_give_away_promotion',$this->has_give_away_promotion);
		$criteria->compare('has_percentage_off_promotion',$this->has_percentage_off_promotion);
		$criteria->compare('has_buy_one_get_one_promotion',$this->has_buy_one_get_one_promotion);
		$criteria->compare('has_coupon',$this->has_coupon);
		$criteria->compare('is_the_middle_page_advert',$this->is_the_middle_page_advert);
		$criteria->compare('rent_cost_per_day',$this->rent_cost_per_day);
		$criteria->compare('maximum_rent_quantity_per_cycle',$this->maximum_rent_quantity_per_cycle);
		$criteria->compare('minimum_rent_duration',$this->minimum_rent_duration);
		$criteria->compare('minimum_rent_quantity_per_cycle',$this->minimum_rent_quantity_per_cycle);
		$criteria->compare('is_faas',$this->is_faas);
		$criteria->compare('faas_stage',$this->faas_stage,true);
		$criteria->compare('faas_months_to_harvest',$this->faas_months_to_harvest);
		$criteria->compare('faas_months_from_seedling',$this->faas_months_from_seedling);
		$criteria->compare('faas_current_stage_to_harvest_position',$this->faas_current_stage_to_harvest_position);
		$criteria->compare('faas_maximum_number_of_stages_to_harvest',$this->faas_maximum_number_of_stages_to_harvest);
		$criteria->compare('faas_next_stage',$this->faas_next_stage,true);
		$criteria->compare('faas_number_of_months_to_next_stage',$this->faas_number_of_months_to_next_stage);
		$criteria->compare('is_faas_insured',$this->is_faas_insured);
		$criteria->compare('faas_total_insurance_value',$this->faas_total_insurance_value);
		$criteria->compare('is_faas_tradable',$this->is_faas_tradable);
		$criteria->compare('faas_expected_total_produce',$this->faas_expected_total_produce);
		$criteria->compare('faas_must_be_held_to_maturity',$this->faas_must_be_held_to_maturity);
		$criteria->compare('faas_maximum_number_of_months_to_harvest',$this->faas_maximum_number_of_months_to_harvest);
		$criteria->compare('faas_region',$this->faas_region,true);
		$criteria->compare('minimum_faas_duration',$this->minimum_faas_duration);
		$criteria->compare('maximum_faas_duration',$this->maximum_faas_duration);
		$criteria->compare('minimum_quantity_for_faas_subscription',$this->minimum_quantity_for_faas_subscription);
		$criteria->compare('maximum_quantity_for_faas_subscription',$this->maximum_quantity_for_faas_subscription);
		$criteria->compare('cumulative_quantity',$this->cumulative_quantity);
		$criteria->compare('date_current_stage_started',$this->date_current_stage_started,true);
		$criteria->compare('faas_month_season_started',$this->faas_month_season_started,true);
		$criteria->compare('faas_year_season_started',$this->faas_year_season_started,true);
		$criteria->compare('has_warranty',$this->has_warranty);
		$criteria->compare('months_of_warranty',$this->months_of_warranty);
		$criteria->compare('has_son_certification',$this->has_son_certification);
		$criteria->compare('has_nafdac_certification',$this->has_nafdac_certification);
		$criteria->compare('other_certifications',$this->other_certifications,true);
		$criteria->compare('faas_stage_activities',$this->faas_stage_activities,true);
		$criteria->compare('faas_insurance_coverage',$this->faas_insurance_coverage,true);
		$criteria->compare('faas_insurance_institution',$this->faas_insurance_institution,true);
		$criteria->compare('maximum_rent_duration',$this->maximum_rent_duration);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        
/**
         * This is the function that gets the amount of a product
         */
        public function getTheAmountOfThisProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $amount= Product::model()->find($criteria);
                
                return $amount['per_portion_price'];
            
        }
        
        
        /**
         * This is the function that retrieves the discount amount of a product
         */
        public function getTheDiscountAmountOfThisProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $amount= Product::model()->find($criteria);
                
                return $amount['discounted_amount'];
        }
        
        
        /**
         * This is the function that calculates the revenue amount from a particular product
         */
        public function getTheRevenueAmountFromThisProduct($product_id,$order_id){
            
           $model = new PlatformSettings;
           
           if($this->doesProductHaveConstituents($product_id)){
                 $amount = 0;
                //get all the constituents of this peoduct
                $constituents = $this->getAllProductConstituents($product_id);
                foreach($constituents as $constituent){
                    $amount = $amount + $this->getTheRevenueAmountFromThisConstituentProduct($constituent,$order_id);
                }
                $amount = $amount * $this->getThePortionOfThisProductInThisOrder($order_id,$product_id);
           }else{
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
                 $amount = $this->getThePortionOfThisProductInThisOrder($order_id,$product_id) * $this->getThisProductPriceInThisOrder($product_id,$order_id)*($management_fee_charges_in_percentage + $handling_charges_in_percentage + $shipping_charges_in_percentage);
                    
               
           }
            
            
            return $amount;
   
            
        }
        
        
        
        /**
         * This is the function that gets a products quantity of purchase in this order
         */
        public function getThePortionOfThisProductInThisOrder($order_id,$product_id){
            $model = new OrderHasProducts;
            return $model->getThePortionOfThisProductInThisOrder($order_id,$product_id);
        }
        
        
         /**
         * This is the function that gets a products price of in an order
         */
        public function getThisProductPriceInThisOrder($product_id,$order_id){
            $model = new OrderHasProducts;
            return $model->getThisProductPriceInThisOrder($product_id,$order_id);
        }
        
        /**
         * This is the function that determines if member order prices are still valid for member pricing
         */
        public function isOrderPriceStillValid($order_id,$product_id){
            $model = new OrderHasProducts;
            return $model->isOrderPriceStillValid($order_id,$product_id);
        }
        
        
        /**
         * This is the function that determines if a product has constituents
         */
        public function doesProductHaveConstituents($product_id){
            $model = new ProductConstituents;
            return $model->doesProductHaveConstituents($product_id);
        }
        
        
        /**
         * This is the function that retrieves all constituents of a product
         */
        public function getAllProductConstituents($product_id){
            
            $model = new ProductConstituents;
            
            return $model->getAllProductConstituents($product_id);
            
        }
        
        /**
         * This is th function that gets the revenue of a product constituent
         */
        public function getTheRevenueAmountFromThisConstituentProduct($constituent,$order_id){
            $model = new ProductConstituents;
            
            return $model->getTheRevenueAmountFromThisConstituentProduct($constituent,$order_id);
            
        }
        
        
        /**
         * This is the function that gets the vat amount for a product
         */
        public function getTheVatRateOfThisProductType($id,$order_id){
           $model = new ProductType;
           
           $criteria = new CDbCriteria();
           $criteria->select = '*';
           $criteria->condition='id=:id';
           $criteria->params = array(':id'=>$id);
           $product= Product::model()->find($criteria);
           
           return $model->getTheVatRateOfThisProductType($product['product_type_id'],$order_id,$product['id']);
           
        }
        
        
        /**
         * This is the function that gets the price of a portion of a product
         */
        public function getThePerPortionPriceOfThisProduct($product_id,$order_id){
            
            $model = new ProductConstituents;
            //confirm if this product has constituents
            if($model->doesProductHaveConstituents($product_id) == false){
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='id=:id';
                 $criteria->params = array(':id'=>$product_id);
                 $portion= Product::model()->find($criteria);
                 
                 return $portion['per_portion_price'];
                
            }else{
                return $model->totalPriceOfTheProductConstituents($product_id,$order_id);
            }
        }
        
        /**
         * This is the function that gets the per portion discount amount of a product
         */
        public function getThePerPortionDiscountAmountOfThisProduct($product_id,$order_id){
            
            $model = new ProductConstituents;
            //confirm if this product has constituents
            if($model->doesProductHaveConstituents($product_id) == false){
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='id=:id';
                 $criteria->params = array(':id'=>$product_id);
                 $portion= Product::model()->find($criteria);
                 
                 return $portion['discounted_amount'];
                
            }else{
                return $model->totalDiscountOfTheProductConstituents($product_id,$order_id);
            }
            
            
            
        }
        
        
        /**
         * This is the function that gets the name of a product
         */
        public function getThisProductName($product_id){
            
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='id=:id';
                 $criteria->params = array(':id'=>$product_id);
                 $product= Product::model()->find($criteria);
                 
                 return $product['name'];
        }
        
        
        
        /**
         * This is the function that updates the pack and returns the current prevailing retail price
         */
        public function updateThePrevailingRetailPriceOfThePack($product_id,$quantity_of_product_in_the_pack,$minimum_number_of_product_to_buy,$prevailing_retail_selling_price){
            
            //get the current prevailing retail prioe of this product(pack)
            $current_prevailing_retail_price = $this->getTheCurrentPrevailingRetailPriceOfThisPack($product_id);
            
            if($quantity_of_product_in_the_pack >=$minimum_number_of_product_to_buy){
                $new_prevailing_retail_price = $current_prevailing_retail_price + ($quantity_of_product_in_the_pack * $prevailing_retail_selling_price);
            }else{
                $new_prevailing_retail_price = $current_prevailing_retail_price + ($minimum_number_of_product_to_buy *$prevailing_retail_selling_price);
            }
           if($this->isUpdateThisPacksPrevailingRetailPriceSuccessful($product_id,$new_prevailing_retail_price)){
               return $this->getTheCurrentPrevailingRetailPriceOfThisPack($product_id);
           }else{
               return $current_prevailing_retail_price;
           }
            
        }
        
        
        
        /**
         * This is the function that updates the packs retail selling price
         */
        public function isUpdateThisPacksPrevailingRetailPriceSuccessful($product_id,$new_prevailing_retail_price){
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('product',
                                  array(
                                    'prevailing_retail_selling_price'=>$new_prevailing_retail_price,
                                     'update_time'=>new CDbExpression('NOW()'),
                                      'update_user_id'=>Yii::app()->user->id
                                                             
                            ),
                     ("id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
        }
        
        
         /**
         * This is the function that updates the pack and returns the current member only price
         */
        public function updateTheMemberOnlyPriceOfThePack($product_id,$quantity_of_product_in_the_pack,$minimum_number_of_product_to_buy,$per_portion_price){
            
            //get the current member only prioe of this product(pack)
            $current_member_only_price = $this->getTheCurrentMemberOnlyPriceOfThisPack($product_id);
            
            if($quantity_of_product_in_the_pack >=$minimum_number_of_product_to_buy){
                $new_member_only_price = $current_member_only_price + ($quantity_of_product_in_the_pack * $per_portion_price);
            }else{
                $new_member_only_price = $current_member_only_price + ($minimum_number_of_product_to_buy *$per_portion_price);
            }
           if($this->isUpdateThisPacksMemberOnlyPriceSuccessful($product_id,$new_member_only_price)){
               return $this->getTheCurrentMemberOnlyPriceOfThisPack($product_id);
           }else{
               return $current_member_only_price;
           }
            
        }
        
        
        
         /**
         * This is the function that updates the packs member only selling price
         */
        public function isUpdateThisPacksMemberOnlyPriceSuccessful($product_id,$new_member_only_price){
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('product',
                                  array(
                                    'per_portion_price'=>$new_member_only_price,
                                     'update_time'=>new CDbExpression('NOW()'),
                                      'update_user_id'=>Yii::app()->user->id
                                                             
                            ),
                     ("id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
        }
        
        
        /**
         * This is the function that gets the current prevailing retail selling price
         */
        public function getTheCurrentPrevailingRetailPriceOfThisPack($product_id){
            
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='id=:id';
                 $criteria->params = array(':id'=>$product_id);
                 $product= Product::model()->find($criteria);
                 
                 return $product['prevailing_retail_selling_price'];
        }
        
        
          /**
         * This is the function that gets the current prevailing retail selling price
         */
        public function getTheCurrentMemberOnlyPriceOfThisPack($product_id){
            
                 $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='id=:id';
                 $criteria->params = array(':id'=>$product_id);
                 $product= Product::model()->find($criteria);
                 
                 return $product['per_portion_price'];
        }
        
        
        
        /**
         * This is the function that confirms if product or pack prices were zerorised
         */
        public function isThisProductPricesZerorisedSuccessfully($product_id){
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('product',
                                  array(
                                    'per_portion_price'=>0,
                                     'prevailing_retail_selling_price'=>0, 
                                     'update_time'=>new CDbExpression('NOW()'),
                                      'update_user_id'=>Yii::app()->user->id
                                                             
                            ),
                     ("id=$product_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
        }
       
        
        /**
         * This is the function that gets a product code given the quote id
         */
        public function getThisQuoteProductCode($quote_id){
            
            $model = new Quote;
            //get the product id of this quote
            $product_id = $model->getTheProductIdOfThisQuote($quote_id);
            
            //get the product code of this product
            $product_code = $this->getThisProductCode($product_id);
            
            return $product_code;
        }
        
        
        /**
         * This is the function that retrieves a product code
         */
        public function getThisProductCode($product_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$product_id);
             $product= Product::model()->find($criteria);
             
             return $product['code'];
        }
        
        
        /**
         * This is the function that gets the last four digits of a product code
         */
        public function getTheLastFourDigitOfTheProductCode($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return substr($product['code'], -4); 
        }
        
        
        /**
         * This is the function that retrieves the product id given the product code
         */
        public function getTheProductIdOfThisProductGivenItsProductCode($product_code){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='code=:code';
                $criteria->params = array(':code'=>$product_code);
                $product= Product::model()->find($criteria);
                
                return $product['id'];
        }
        
        
        /**
         * This is the function that confirms if a product code is valid or not
         */
        public function isProductCodeValid($product_code){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("code = '$product_code'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that confirms if a product could be subscribed to 
         */
        public function isProductIdealforSubscription($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_quotable'] == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that determines if a product is tradable by a merchant
         */
        public function isProductTradable($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_quotable'] == 1){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that gets the minimum quantity of purchase of a product
         */
        public function getTheMinimumQuantityOfPurchaseFoThisProduct($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['minimum_number_of_product_to_buy'];
            
        }
        
        /**
         * This is the function that confirms if the su subscription qunatity is valid or not
         */
        public function isThisAValidSubscriptionQuantity($min_subscription_quantity,$subscription_quantity){
            
            if($subscription_quantity>=$min_subscription_quantity){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if a product is escroweable  or not
         */
        public function isProductEscrowable($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_escrowable'] == 1){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that confirms if a product is subscribable
         */
        public function isProductSubscribable($product_id){
            $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_quotable'] == 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function hat gets the price limit of a hamper
         */
        public function getThePriceLimitOfThisHamper($hamper_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['hamper_cost_limit'];
                
        }
        
        
        /**
         * This is the function that determines if a product could br added to a hamper
         */
        public function canThisProductBeAddedToHamper($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_quotable'] == 0){
                    if($product['is_escrowable'] == 0){
                        if($product['is_future_tradable'] == 0){
                            if($product['is_a_hamper']==0){
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
         * This is the function that gets the total weight of an hamper
         */
        public function getTheTotalWeightOfThisHamper($hamper_id){
            
            $model = new HamperContainer;
            //get the weight of all the products in the hamper
            $products_weight = $this->getTheWeightOfAllProductInTheHamper($hamper_id);
            
            //get the weight of the hamper containers for each beneficiary
            $weight_of_hamper_container = $model->getTheWeightOfThisHamperContainer($hamper_id);
            
            //get the total weight of the hamper 
            $hamper_total_weight = $products_weight + $weight_of_hamper_container;
            
            return $hamper_total_weight;
        }
        
        /**
         * This is the function that gets the weight of all products in a hamper
         */
        public function getTheWeightOfAllProductInTheHamper($hamper_id){
            $model = new HamperHasProducts;
            //get all the products in the hamper
            $products = $model->getAllProductsInThisHamper($hamper_id);
            $weight = 0;
            foreach($products as $product){
                $weight = $weight + $this->getTheWeightOfThisProduct($product);
            }
            return $weight;
        }
        
        /**
         * This is the function that gets the weight of a product
         */
        public function getTheWeightOfThisProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['weight'];
        }
        
        /**
         * This is the function that gets the unit cost of a product
         */
        public function getTheUnitCostOfThisProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['prevailing_retail_selling_price'];
            
        }
        
        
        /**
         * This is the that retrieves the icon of a product
         */
        public function getTheIconOfThisProduct($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['icon'];
        }
        
         /**
         * This is the that retrieves the headline image of a product
         */
        public function getThisProductHeadlineImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['headline_image'];
        }
        
        
         /**
         * This is the that retrieves the front view image of a product
         */
        public function getTheProductFrontViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_front_view'];
        }
        
         /**
         * This is the that retrieves the right side view image of a product
         */
        public function getTheProductRightSideViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_right_side_view'];
        }
        
        
         /**
         * This is the that retrieves the top view image of a product
         */
        public function getTheProductTopViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_top_view'];
        }
        
        
         /**
         * This is the that retrieves the inside view image of a product
         */
        public function getTheProductInsideViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_inside_view'];
        }
        
        
         /**
         * This is the that retrieves the back view image of a product
         */
        public function getTheProductBackViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_back_view'];
        }
        
        
        /**
         * This is the that retrieves the engine view image of a product
         */
        public function getTheProductEngineViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_engine_view'];
        }
        
        
        /**
         * This is the that retrieves the left side view image of a product
         */
        public function getTheProductLeftSideViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_left_side_view'];
        }
        
        
        /**
         * This is the that retrieves the bottom side view image of a product
         */
        public function getTheProductBottomViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_bottom_view'];
        }
        
        
        /**
         * This is the that retrieves the dashboard  side view image of a product
         */
        public function getTheProductDashboardViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_dashboard_view'];
        }
        
        
        /**
         * This is the that retrieves the content or booth view image of a product
         */
        public function getTheProductContentsOrBoothViewImage($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_contents_or_booth_view'];
        }
        
        
               
        
        /**
         * This is the function that gets the description of a product/hamper
         */
        public function getTheDescriptionOfThisProduct($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['description'];
        }
        
        
        /**
         * This is the function that gets the service id of a product
         */
        public function getTheServiceIdOfThisProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['service_id'];
        }
        
        
        /**
         * This is the function that gets the category id of a product
         */
        public function getTheCategoryIdOfThisProduct($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['category_id'];
        }
        
        
        /**
         * This is the function that gets the product type id of a product
         */
        public function getTheProductTypeIdOfThisProduct($product_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                return $product['product_type_id'];
        }
        
        
        /**
         * This is the function that retrieves the value of a hamper maximum limit
         */
        public function getThisHamperMaximumLimit($hamper_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['hamper_cost_limit'];
        }
     
        
        /**
         * This is the function that gets the total weight of an order
         */
        public function getTheTotalWeightOfThisOrder($order_id){
            
            $model = new OrderHasProducts;
            //get all the products in the hamper
            $products = $model->getAllProductsInThisOrder($order_id);
            $weight = 0;
            foreach($products as $product){
                if($model->isThisProductDeliveryCostApplicableInThisComputation($order_id,$product)){
                     $weight = $weight + $this->getTheWeightOfThisProduct($product);
                }
               
            }
            return $weight;
        }
        
        
        /**
         * This is the function that obtains the weight of the deliverable contents in an order
         */
        public function getTheTotalWeightOfDeliverableContentsInAnOrder($order_id,$wallet_id){
            
            $model = new OrderHasProducts;
            //get all the products in the hamper
            $products = $model->getAllProductsInThisOrder($order_id);
            $weight = 0;
            foreach($products as $product){
                if($model->isThisProductDeliveryCostApplicableInThisComputation($order_id,$product)){
                    if($this->isTheSettlementOfThisProductPossibleInThisWallet($wallet_id,$order_id,$product)){
                        $weight = $weight + $this->getTheWeightOfThisProduct($product);
                    }
                     
                }
               
            }
            return $weight;
        }
        
        
        /**
         * This is the function that confirms if a product can be settled in a wallet
         */
        public function isTheSettlementOfThisProductPossibleInThisWallet($wallet_id,$order_id,$product){
            $model = new Wallet;
            return $model->isTheSettlementOfThisProductPossibleInThisWallet($wallet_id,$order_id,$product);
        }
        
        
        /**
         * This is the function that determines if a product is payable on delivery
         */
        public function isProductPayableOnDelivery($product_id){
            if($this->isProductTradable($product_id)){
                return false;
            }else{
                if($this->isProductEscrowable($product_id)){
                    return false;
                }else{
                    if($this->isProductAHamper($product_id)){
                        return false;
                    }else{
                       if($this->isPaymentOnDeliveryPermittedOnProduct($product_id)){
                        return true;
                        }else{
                            return false;
                        }
                    }
                    
                }
            }
        }
        
        /**
         * This is the function that determines if payment on delivery is permitted on product
         */
        public function isPaymentOnDeliveryPermittedOnProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_payment_permitted_on_delivery'] == 1){
                    return true;
                }else{
                    return false;
                }
        }
        
        
         /**
         * This is the function that determines if product is a hamper
         */
        public function isProductAHamper($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_a_hamper'] == 1){
                    return true;
                }else{
                    return false;
                }
        }
        
        
         /**
         * This is the function that determines if a video is required
         */
        public function isVideoRequitredForThisProduct($product_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$product_id);
                $product= Product::model()->find($criteria);
                
                if($product['is_with_video'] == 1){
                    return true;
                }else{
                    return false;
                }
        }
        
        
         /**
         * This is the function that retrieves the purpose of a product video
         */
        public function getWhatAVideoIsFor($hamper_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['video_for'];
        }
        
        
         /**
         * This is the function that retrieves the name of a product video
         */
        public function getTheVideoFilenameOfThisProduct($hamper_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['video_filename'];
        }
        
        
         /**
         * This is the function that retrieves the feature of a product
         */
        public function getTheFeatureOfThisProduct($hamper_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['feature'];
        }
        
        
        /**
         * This is the function that retrieves the condition of a product
         */
        public function getTheConditionOfThisProduct($hamper_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['condition'];
        }
        
        
        /**
         * This is the function that retrieves the specification of a product
         */
        public function getTheSpecificationOfThisProduct($hamper_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['specifications'];
        }
        
        /**
         * This is the functioon that generates a product's code
         */
        public function generateAProductCode($service_id){
            $model = new Service;
            //get this service code
            $service_code = $model->getTheServiceCode($service_id);
           //get the next available service counter 
            $service_counter = $model->getTheNewIncrementedServiceCounterValue($service_id);
            $pad_length = (int)$this->getThePrevailingProductCodePadLength();
            //$pad_length = 16;
            
            if($service_code == strtolower('hampers')){
                $new_pad_length = $pad_length - 4;
                 //pad this number by 0s up to nine places
                $padded_number = str_pad((int)$service_counter, $new_pad_length, "0",STR_PAD_LEFT);
                
                 //get the product code
                $product_code = $service_code.$padded_number;
               return strtoupper($product_code);
            }else if($service_code == strtolower('share')){
                 $new_pad_length = $pad_length - 2;
                 //pad this number by 0s up to nine places
                $padded_number = str_pad((int)$service_counter, $new_pad_length, "0",STR_PAD_LEFT);
                
                 //get the product code
                $product_code = $service_code.$padded_number;
                return strtoupper($product_code);
            }else{
                //pad this number by 0s up to pad length places
                $padded_number = str_pad((int)$service_counter, $pad_length, "0",STR_PAD_LEFT);
                
                 //get the product code
                $product_code = $service_code.$padded_number;
               return strtoupper($product_code);
            }
           
            
           
        }
        
        /**
         * This is the function that gets the prevailing product code pad length
         */
        public function getThePrevailingProductCodePadLength(){
            $model = new PlatformSettings;
            return $model->getThePrevailingProductCodePadLength();
        }
        
        
        /**
         * This is the function that gets a hamper container is
         */
        public function getTheHamperContainerIdOfThisHamper($hamper_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$hamper_id);
                $product= Product::model()->find($criteria);
                
                return $product['hamper_container_id'];
        }
        
        
        /**
         * This is the function that updates a hamper container type of a hamper
         */
        public function isThisHamperContainerUpdatedSuccessfully($hamper_id,$hamper_container_id){
            
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('product',
                                  array(
                                    'hamper_container_id'=>$hamper_container_id
                                    
                                                             
                            ),
                     ("id=$hamper_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
        }
        
        
        /**
         * this is the function that effects the display of a hamper on the store
         */
        public function isHamperReadyToBeDisplayedOnTheStore($hamper_id,$hamper_container_id,$price_of_hamper){
            
            $model = new HamperContainer;
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('product',
                                  array(
                                    'hamper_container_id'=>$hamper_container_id,
                                      'prevailing_retail_selling_price'=>$price_of_hamper,
                                      'per_portion_price'=>$price_of_hamper,
                                      'hamper_cost_limit'=>$price_of_hamper,
                                      'displayable_on_store'=>1,
                                      'icon'=>$model->getTheHamperImageOfThisContainer($hamper_container_id)
                                    
                                                             
                            ),
                     ("id=$hamper_id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
        }
        
        
        /**
         * This is the function that obtains the next level of a lead's level within its family
         */
        public function getTheNextLevelNumberOfThisLeadTree($leadscode){
            
            $temp_highest_level = 0;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             //$criteria->condition='id=:id';
             //$criteria->params = array(':id'=>$hamper_id);
             $products= Product::model()->findAll($criteria);
             
             foreach($products as $product){
                 if($product['leadscode'] == $leadscode){
                    if($product['leads_level']>$temp_highest_level){
                          $temp_highest_level = $product['leads_level'];
                      }
                 }
                
             }
             return ($temp_highest_level + 1);
            
        }
        
        
        /**
         * This is the function that determines if a product is on promotion
         */
        public function isThisProductOnPromotion($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $product= Product::model()->find($criteria);
            
            
            if($product['has_free_shipping_promotion'] ==1){
                if($this->isThisPromotionStillActive($product['id'])){
                    return true;
                }
                
            }else if($product['has_give_away_promotion'] == 1){
                 if($this->isThisPromotionStillActive($product['id'])){
                    return true;
                }
            }else if($product['has_percentage_off_promotion']==1){
                 if($this->isThisPromotionStillActive($product['id'])){
                    return true;
                }
            }else if($product['has_buy_one_get_one_promotion']==1){
                if($this->isThisPromotionStillActive($product['id'])){
                    return true;
                }
            }else{
                return false;
            }
            
            
            
        }
        
        
        /**
         * This is the function that confirms if a promotion is still active or not
         */
        public function isThisPromotionStillActive($id){
            
            return true;
            
        }
        
        
        /**
         * This is the function that determines if the price of a product is less than 1000 naira
         */
        public function isThePriceOfThisProductLessThan1000Naira($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $product= Product::model()->find($criteria);
            
            if($product['prevailing_retail_selling_price']<=1000){
                if($product['is_quotable']==0){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that determines if a product is rentable
         */
        public function isTheProductRentable($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $product= Product::model()->find($criteria);
            
            if($product['is_rentable']==1){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that retrieves the total number of products that are equal to or less than 1000 naira
         */
        public function getTheTotalNumberOfProductsWithLessThanOrEqualTo1000NairaPriceTag(){
            
              
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("(prevailing_retail_selling_price<=1000 and is_quotable=0) and (displayable_on_store=1 and is_faas=0)");
                $result = $cmd->queryScalar();
                
               return $result;
           
            
        }
        
        
        /**
         * This is the function that gets the total number of products on sale
         */
        public function getTheTotalProductsOnSales(){
            
            $count =0;
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='displayable_on_store=:is_displayable and (is_faas=0 and is_quotable=0)';   
            $criteria->params = array(':is_displayable'=>1);
            $products = Product::model()->findAll($criteria);
            
            foreach($products as $product){
                if($this->isThisProductOnPromotion($product['id'])){
                    $count = $count + 1;
                }
            }
            
            return $count;
            
        }
        
        
        /**
         * This is the function that gets the total number of products that are rentable
         */
        public function getTheTotalNumberOfProductsThatAreRentable(){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("(is_rentable=1 and is_quotable=0) and (displayable_on_store=1 and is_faas=0)");
                $result = $cmd->queryScalar();
                
               return $result;
            
        }
        
        /**
         * This is the function that gets the total number of displayable nursery school books
         */
        public function getTheTotalNumberOfDisplayableNurseryBooks($type_id){
            
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("product_type_id=$type_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
         /**
         * This is the function that gets the total number of displayable primary school books
         */
        public function getTheTotalNumberOfDisplayablePrimaryBooks($type_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("product_type_id=$type_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
         /**
         * This is the function that gets the total number of displayable jss school books
         */
        public function getTheTotalNumberOfDisplayableJssBooks($type_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("product_type_id=$type_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        
         /**
         * This is the function that gets the total number of displayable sss school books
         */
        public function getTheTotalNumberOfDisplayableSssBooks($type_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("product_type_id=$type_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
    
         /**
         * This is the function that gets the total number of displayable secondary school books school books
         */
        public function getTheNumberOfDisplayableSecondarySchoolBooks($category_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("category_id=$category_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        /**
         * This is the function that returns the total number of tertiary books
         */
        public function getTheTotalNumberOfTertiarySchoolDisplaybleBooks($type_id){
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("product_type_id=$type_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
            
        }
        
        
        /**
         * This is the function that returns the total number of professional books
         */
        public function getTheTotalNumberOfProfessionalDisplaybleBooks($type_id){
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("product_type_id=$type_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
            
        }
        
        
         /**
         * This is the function that returns the total number of others books
         */
        public function getTheTotalNumberOfOtherDisplaybleBooks($type_id){
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("product_type_id=$type_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
            
        }
        
        /**
         * this is the function calculates the total number of displayable stationary products on the store
         */
        public function getTheTotalNumberOfStationaryDisplayableProducts($service_id){
            
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("service_id=$service_id and displayable_on_store=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        /**
         * This is the function that gets the total number of products displayable by middle page adverts
         */
        public function getTheTotalNumberOfProductsDisplayableByMiddleAdverts(){
            
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                   ->where("displayable_on_store=1 and is_the_middle_page_advert=1");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        
         /**
         * This is the function that gets the total number of products for a service
         */
        public function getTheTotalNumberOfProductsForThisService($id){
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("displayable_on_store=1 and service_id=$id");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        /**
         * This is the function that retruieves the total number of products for a category
         */
        public function getTheTotalNumberOfProductsForThisCategory($id){
              $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("displayable_on_store=1 and category_id=$id");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        
        /**
         * This is the function that gets the total number of products for a type
         */
        public function getTheTotalNumberOfProductsForThisType($id){
            
               $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("displayable_on_store=1 and product_type_id=$id");
                $result = $cmd->queryScalar();
                
               return $result;
            
        }
        
        /**
         * This is the function that gets the total number of faas product for a faas category
         */
        public function getTheTotalNumberOfProductsForThisFaasCategory($id){
            
               $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("displayable_on_store=1 and (category_id=$id and is_faas=1)");
                $result = $cmd->queryScalar();
                
               return $result;
            
            
        }
        
        /**
         * This is the function that gets the total number of products for a faas type
         */
        public function getTheTotalNumberOfProductsForThisFaasType($id){
            
               $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product')
                    ->where("displayable_on_store=1 and (product_type_id=$id and is_faas=1)");
                $result = $cmd->queryScalar();
                
               return $result;
            
        }
        
        /**
         * This is the function that retrieves a product code
         */
        public function retrieveTheCodeForThisProduct($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $product= Product::model()->find($criteria);
            
            return $product['code'];
            
        }
        
        
        /**
         * This is the function that gets the total number of products on the store
         */
        public function getTheToTalNumberOfProductsOnTheStore(){
            
              $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product');
                   // ->where("displayable_on_store=1 and (product_type_id=$id and is_faas=1)");
                $result = $cmd->queryScalar();
                
               return $result;
        }
        
        /**
         * This is the function that gets the products cumulative quantity
         */
        public function getTheProductCumulativeQuantity($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $product= Product::model()->find($criteria);
            return $product['cumulative_quantity'];
        }
        
        
        /**
         * This is the function that modifies quantity of a product in stock
         */
        public function isModificationOfTheProductStockSuccessful($id,$cumulative_quantity,$current_quanitity_in_stock){
            
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('product',
                                  array(
                                    'cumulative_quantity'=>$cumulative_quantity,
                                      'quantity'=>$current_quanitity_in_stock
                                                            
                            ),
                     ("id=$id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
            
        }
        
        
         /**
         * This is the function that modifies middle page advert placement status of a product
         */
        public function isTheModificationOfMiddlePageAdvertPlacementASuccess($id,$is_the_middle_page_advert){
            
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('product',
                                  array(
                                    'is_the_middle_page_advert'=>$is_the_middle_page_advert
                                                                                                  
                            ),
                     ("id=$id"));
                     if($result>0){
                         return true;
                     }else{
                         return false;
                     }
            
        }
        
        
        /**
         * This is the function that downloadable image file to its place
         */
        public function moveTheDownloadableImageFileToItsPathAndReturnTheItsName($model,$icon_filename){
            
            if(isset($_FILES['image_file_for_download']['name'])){
                        $tmpName = $_FILES['image_file_for_download']['tmp_name'];
                        $iconName = $_FILES['image_file_for_download']['name'];    
                        $iconType = $_FILES['image_file_for_download']['type'];
                        $iconSize = $_FILES['image_file_for_download']['size'];
                  
                   }
                    
                    if($iconName !== null) {
                        if($model->id === null){
                          //$iconFileName = $icon_filename;  
                          if($icon_filename != null){
                                $iconFileName = time().'_'.$icon_filename;  
                            }else{
                                $iconFileName = $icon_filename;  
                            }
                          
                           // upload the icon file
                        if($iconName !== null){
                            	$iconPath = Yii::app()->params['images'].$iconFileName;
				move_uploaded_file($tmpName,  $iconPath);
                                        
                        
                                return $iconFileName;
                        }else{
                            $iconFileName = $icon_filename;
                            return $iconFileName;
                        } // validate to save file
                        }else{
                            if($this->noNewProductDownloadableImageFileProvided($model->id,$icon_filename)){
                                $iconFileName = $icon_filename; 
                                return $iconFileName;
                            }else{
                             if($icon_filename != null){
                                 if($this->removeTheExistingDownloadableImageFile($model->id)){
                                 $iconFileName = time().'_'.$icon_filename; 
                                 //$iconFileName = time().$icon_filename;  
                                   $iconPath = Yii::app()->params['images'].$iconFileName;
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
         * This is the function to ascertain if a new downloadable image was provided or not
         */
        public function noNewProductDownloadableImageFileProvided($id,$icon_filename){
            
                $criteria = new CDbCriteria();
                $criteria->select = 'id, image_file_for_download';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['image_file_for_download']==$icon_filename){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        	 /**
         * This is the function that removes an existing product left side view file
         */
        public function removeTheExistingDownloadableImageFile($id){
            
            //retreve the existing image file from the database
            
            if($this->isTheDownloadableImageNotTheDefault($id)){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                //$directoryPath =  dirname(Yii::app()->request->scriptFile);
               $directoryPath = "/home/oneroof/public_html/admin.oneroof.com.ng/cobuy_images/images/";
               // $iconpath = '..\appspace_assets\icons'.$icon['icon'];
                $filepath =$directoryPath.$icon['image_file_for_download'];
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
         * This is the function that determines if  a product image file  is the default
         */
        public function isTheDownloadableImageNotTheDefault($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['image_file_for_download'] == null){
                    return false;
                }else{
                    return true;
                }
        }
        
        
        /**
         * This is the function that moves the footage file 
         */
        
       public function moveTheDownloadableFootageFileToItsPathAndReturnTheItsName($model,$video_filename){
            
            if(isset($_FILES['footage_file']['name'])){
                        $tmpName = $_FILES['footage_file']['tmp_name'];
                        $videoName = $_FILES['footage_file']['name'];    
                        $videoType = $_FILES['footage_file']['type'];
                        $videoSize = $_FILES['footage_file']['size'];
                  
                   }
                    
                    if($videoName !== null) {
                        if($model->id === null){
                          
                          if($video_filename != null){
                                $videoFileName = time().'_'.$video_filename;  
                            }else{
                                $videoFileName = $video_filename;  
                            }
                          
                           // upload the video file
                        if($videoName !== null){
                            	$videoPath = Yii::app()->params['footages'].$videoFileName;
				move_uploaded_file($tmpName,  $videoPath);
                                        
                        
                                return $videoFileName;
                        }else{
                            $videoFileName = $video_filename;
                            return $videoFileName;
                        } // validate to save file
                        }else{
                            if($this->noNewFootageFileProvided($model->id,$video_filename)){
                                $videoFileName = $video_filename; 
                                return $videoFileName;
                            }else{
                             if($video_filename != null){
                                 if($this->removeTheExistingDownloadableFootageFile($model->id)){
                                 $videoFileName = time().'_'.$video_filename; 
                                 $videoPath = Yii::app()->params['footages'].$videoFileName;
                                   move_uploaded_file($tmpName,$videoPath);
                                   return $videoFileName;
                                    
                                  
                                    
                             }
                             }
                                
                                
                            }
                          
                        }
                      
                     }else{
                         $videoFileName = $video_filename;
                         return $videoFileName;
                     }
					
                       
                               
        }
        
        
        	/**
         * This is the function to ascertain if a new downloadable footage was provided or not
         */
        public function noNewFootageFileProvided($id,$footage_filename){
            
                $criteria = new CDbCriteria();
                $criteria->select = 'id, footage_file';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['footage_file']==$footage_filename){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        	 /**
         * This is the function that removes an existing product left side view file
         */
        public function removeTheExistingDownloadableFootageFile($id){
            
            //retreve the existing image file from the database
            
            if($this->isTheDownloadableFootageNotTheDefault($id)){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                //$directoryPath =  dirname(Yii::app()->request->scriptFile);
               $directoryPath = "/home/oneroof/public_html/admin.oneroof.com.ng/cobuy_images/footages/";
               // $iconpath = '..\appspace_assets\icons'.$icon['icon'];
                $filepath =$directoryPath.$icon['footage_file'];
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
         * This is the function that determines if  a product image file  is the default
         */
        public function isTheDownloadableFootageNotTheDefault($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['footage_file'] == null){
                    return false;
                }else{
                    return true;
                }
        }
        
        
        
         /**
         * This is the function that moves the sound file 
         */
        
       public function moveTheDownloadableSoundFileToItsPathAndReturnTheItsName($model,$sound_filename){
            
            if(isset($_FILES['sound_file']['name'])){
                        $tmpName = $_FILES['sound_file']['tmp_name'];
                        $soundName = $_FILES['sound_file']['name'];    
                        $soundType = $_FILES['sound_file']['type'];
                        $soundSize = $_FILES['sound_file']['size'];
                  
                   }
                    
                    if($soundName !== null) {
                        if($model->id === null){
                          
                          if($sound_filename != null){
                                $soundFileName = time().'_'.$sound_filename;  
                            }else{
                                $soundFileName = $sound_filename;  
                            }
                          
                           // upload the sound file
                        if($soundName !== null){
                            	$soundPath = Yii::app()->params['sound'].$soundFileName;
				move_uploaded_file($tmpName,  $soundPath);
                                        
                        
                                return $soundFileName;
                        }else{
                            $soundFileName = $sound_filename;
                            return $soundFileName;
                        } // validate to save file
                        }else{
                            if($this->noNewSoundFileProvided($model->id,$sound_filename)){
                                $soundFileName = $sound_filename; 
                                return $soundFileName;
                            }else{
                             if($sound_filename != null){
                                 if($this->removeTheExistingDownloadableSoundFile($model->id)){
                                 $soundFileName = time().'_'.$sound_filename; 
                                 $soundPath = Yii::app()->params['sound'].$soundFileName;
                                   move_uploaded_file($tmpName,$soundPath);
                                   return $soundFileName;
                                    
                                  
                                    
                             }
                             }
                                
                                
                            }
                          
                        }
                      
                     }else{
                         $soundFileName = $sound_filename;
                         return $soundFileName;
                     }
					
                       
                               
        }
        
        
        	/**
         * This is the function to ascertain if a new downloadable sound was provided or not
         */
        public function noNewSoundFileProvided($id,$sound_filename){
            
                $criteria = new CDbCriteria();
                $criteria->select = 'id, sound_file';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['sound_file']==$sound_filename){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        	 /**
         * This is the function that removes an existing sound file
         */
        public function removeTheExistingDownloadableSoundFile($id){
            
            //retreve the existing image file from the database
            
            if($this->isTheDownloadableSoundNotTheDefault($id)){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                //$directoryPath =  dirname(Yii::app()->request->scriptFile);
               $directoryPath = "/home/oneroof/public_html/admin.oneroof.com.ng/cobuy_images/sound/";
               // $iconpath = '..\appspace_assets\icons'.$icon['icon'];
                $filepath =$directoryPath.$icon['sound_file'];
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
         * This is the function that determines if  a sound file  is the default
         */
        public function isTheDownloadableSoundNotTheDefault($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['sound_file'] == null){
                    return false;
                }else{
                    return true;
                }
        }
        
        
        /**
         * This is the function that moves the book preview file 
         */
        
       public function moveTheBookPreviewFileToItsPathAndReturnTheItsName($model,$preview_filename){
            
            if(isset($_FILES['book_preview_file']['name'])){
                        $tmpName = $_FILES['book_preview_file']['tmp_name'];
                        $previewName = $_FILES['book_preview_file']['name'];    
                        $previewType = $_FILES['book_preview_file']['type'];
                        $previewSize = $_FILES['book_preview_file']['size'];
                  
                   }
                    
                    if($previewName !== null) {
                        if($model->id === null){
                          
                          if($preview_filename != null){
                                $preview_filename = time().'_'.$preview_filename;  
                            }else{
                                $previewFileName = $preview_filename;  
                            }
                          
                           // upload the preview file
                        if($previewName !== null){
                            	$previewPath = Yii::app()->params['preview'].$previewFileName;
				move_uploaded_file($tmpName,  $previewPath);
                                        
                        
                                return $previewFileName;
                        }else{
                            $previewFileName = $preview_filename;
                            return $previewFileName;
                        } // validate to save file
                        }else{
                            if($this->noNewPreviewFileProvided($model->id,$preview_filename)){
                                $previewFileName = $preview_filename; 
                                return $previewFileName;
                            }else{
                             if($preview_filename != null){
                                 if($this->removeTheExistingPreviewFile($model->id)){
                                 $previewFileName = time().'_'.$preview_filename; 
                                 $previewPath = Yii::app()->params['preview'].$previewFileName;
                                   move_uploaded_file($tmpName,$previewPath);
                                   return $previewFileName;
                                    
                                  
                                    
                             }
                             }
                                
                                
                            }
                          
                        }
                      
                     }else{
                         $previewFileName = $preview_filename;
                         return $previewFileName;
                     }
					
                       
                               
        }
        
        
        	/**
         * This is the function to ascertain if a new book preview file  was provided or not
         */
        public function noNewPreviewFileProvided($id,$preview_filename){
            
                $criteria = new CDbCriteria();
                $criteria->select = 'id, book_preview_file';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['book_preview_file']==$preview_filename){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        	 /**
         * This is the function that removes an existing preview file
         */
        public function removeTheExistingPreviewFile($id){
            
            //retreve the existing preview file from the database
            
            if($this->isThePreviewNotTheDefault($id)){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                //$directoryPath =  dirname(Yii::app()->request->scriptFile);
               $directoryPath = "/home/oneroof/public_html/admin.oneroof.com.ng/cobuy_images/preview/";
               // $iconpath = '..\appspace_assets\icons'.$icon['icon'];
                $filepath =$directoryPath.$icon['book_preview_file'];
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
         * This is the function that determines if  a preview file  is the default
         */
        public function isThePreviewNotTheDefault($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['book_preview_file'] == null){
                    return false;
                }else{
                    return true;
                }
        }
        
        
        
        /**
         * This is the function that moves the book softcopy file 
         */
        
       public function moveTheBookSoftcopyToItsPathAndReturnTheItsName($model,$softcopy_filename){
            
            if(isset($_FILES['book_softcopy_file']['name'])){
                        $tmpName = $_FILES['book_softcopy_file']['tmp_name'];
                        $softcopyName = $_FILES['book_softcopy_file']['name'];    
                        $softcopyType = $_FILES['book_softcopy_file']['type'];
                        $softcopySize = $_FILES['book_softcopy_file']['size'];
                  
                   }
                    
                    if($softcopyName !== null) {
                        if($model->id === null){
                          
                          if($softcopy_filename != null){
                                $softcopy_filename = time().'_'.$softcopy_filename;  
                            }else{
                                $softcopyFileName = $softcopy_filename;  
                            }
                          
                           // upload the softcopy file
                        if($softcopyName !== null){
                            	$softcopyPath = Yii::app()->params['softcopy'].$softcopyFileName;
				move_uploaded_file($tmpName,  $softcopyPath);
                                        
                        
                                return $softcopyFileName;
                        }else{
                            $softcopyFileName = $softcopy_filename;
                            return $softcopyFileName;
                        } // validate to save file
                        }else{
                            if($this->noNewSoftcopyFileProvided($model->id,$softcopy_filename)){
                                $softcopyFileName = $softcopy_filename; 
                                return $softcopyFileName;
                            }else{
                             if($softcopy_filename != null){
                                 if($this->removeTheExistingSoftcopyFile($model->id)){
                                 $softcopyFileName = time().'_'.$softcopy_filename; 
                                 $softcopyPath = Yii::app()->params['softcopy'].$softcopyFileName;
                                   move_uploaded_file($tmpName,$softcopyPath);
                                   return $softcopyFileName;
                                    
                                  
                                    
                             }
                             }
                                
                                
                            }
                          
                        }
                      
                     }else{
                         $softcopyFileName = $softcopy_filename;
                         return $softcopyFileName;
                     }
					
                       
                               
        }
        
        
        	/**
         * This is the function to ascertain if a new softcopy book file  was provided or not
         */
        public function noNewSoftcopyFileProvided($id,$softcopy_filename){
            
                $criteria = new CDbCriteria();
                $criteria->select = 'id, book_softcopy_file';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['book_softcopy_file']==$softcopy_filename){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        	 /**
         * This is the function that removes an existing softcopy file
         */
        public function removeTheExistingSoftcopyFile($id){
            
            //retreve the existing preview file from the database
            
            if($this->isTheSoftcopyNotTheDefault($id)){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                //$directoryPath =  dirname(Yii::app()->request->scriptFile);
               $directoryPath = "/home/oneroof/public_html/admin.oneroof.com.ng/cobuy_images/softcopy/";
               // $iconpath = '..\appspace_assets\icons'.$icon['icon'];
                $filepath =$directoryPath.$icon['book_softcopy_file'];
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
         * This is the function that determines if  a softcopy file  is the default
         */
        public function isTheSoftcopyNotTheDefault($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Product::model()->find($criteria);
                
                if($icon['book_softcopy_file'] == null){
                    return false;
                }else{
                    return true;
                }
        }
        
        
        /**
         * This is the function that confirms if an image is the right one
         */
        public function isTheImageFileIInTheRightFormat($image_format){
            //get the mime type of this image format
            $mime_type = $this->getTheMimeTypeOfThisImageFormat($image_format);
            
             if(isset($_FILES['image_file_for_download']['name'])){
                $tmpName = $_FILES['image_file_for_download']['tmp_name'];
                $imageFileName = $_FILES['image_file_for_download']['name'];    
                $imageFileType = $_FILES['image_file_for_download']['type'];
                $imageFileSize = $_FILES['image_file_for_download']['size'];
            } 
            
            if(($imageFileType == $mime_type)){
                return true;
            }else if($imageFileType == 'image/jpeg' and $mime_type='image/jpg'){
                return true;
            }else{
                return false;
            }
            
        }
        
        /**
         * This is the function to determine the mime type of an image
         */
        public function getTheMimeTypeOfThisImageFormat($image_format){
            
            if($image_format == strtolower('jpg')){
                return 'image/jpg';
            }else if($image_format == strtolower('jpeg')){
                return 'image/jpeg';
            }else if($image_format == strtolower('png')){
                return 'image/png';
            }else if($image_format == strtolower('gif')){
                return 'image/gif';
            }else{
                return 0;
            }
        }
        
        
         /**
         * This is the function that confirms if a video footage is the right one
         */
        public function isTheFootageFileIInTheRightFormat($footage_format){
            //get the mime type of this image format
            $mime_type = $this->getTheMimeTypeOfThisFootageFormat($footage_format);
            
             if(isset($_FILES['footage_file']['name'])){
                $tmpName = $_FILES['footage_file']['tmp_name'];
                $footageFileName = $_FILES['footage_file']['name'];    
                $footageFileType = $_FILES['footage_file']['type'];
                $footageFileSize = $_FILES['footage_file']['size'];
            } 
            
            if(($footageFileType === $mime_type)){
                return true;
            }else{
                return false;
            }
            
        }
        
        
         /**
         * This is the function to determine the mime type of a footage
         */
        public function getTheMimeTypeOfThisFootageFormat($footage_format){
            
            if($footage_format == strtolower('mp4')){
                return 'video/mp4';
            }else if($footage_format == strtolower('avi')){
                return 'video/avi';
            }else if($footage_format == strtolower('avi')){
                return 'video/x-msvideo';
            }else if($footage_format == strtolower('wmv')){
                return 'video/x-ms-asf';
            }else if($footage_format == strtolower('flv')){
                return 'video/x-flv';
            }else if($footage_format == strtolower('mov')){
                return 'video/quicktime';
            }else { 
                return 0;
            }
        }
        
        
        
         /**
         * This is the function that confirms if a sound footage is the right one
         */
        public function isTheSoundFileIInTheRightFormat($sound_format){
            //get the mime type of this sound format
            $mime_type = $this->getTheMimeTypeOfThisSoundFormat($sound_format);
            
             if(isset($_FILES['sound_file']['name'])){
                $tmpName = $_FILES['sound_file']['tmp_name'];
                $soundFileName = $_FILES['sound_file']['name'];    
                $soundFileType = $_FILES['sound_file']['type'];
                $soundFileSize = $_FILES['sound_file']['size'];
            } 
            
            if($soundFileType == $mime_type){
                return true;
            }else if($soundFileType =='audio/mp3' and $mime_type == 'audio/mpeg3'){
                return true;
            }else{
                return false;
            }
            
        }
        
        
          /**
         * This is the function to determine the mime type of a sound
         */
        public function getTheMimeTypeOfThisSoundFormat($sound_format){
            
            if($sound_format == strtolower('mp3')){
                return 'audio/mpeg3';
            }else if($sound_format == strtolower('mp3')){
                return 'audio/x-mpeg-3';
            }else if($sound_format == strtolower('aac')){
                return 'audio/aac';
            }else if($sound_format == strtolower('3gp')){
                return 'audio/3gpp';
            }else if($sound_format == strtolower('aiff')){
                return 'audio/aiff';
            }else if($sound_format == strtolower('aiff')){
                return 'audio/x-aiff';
            }else if($sound_format == strtolower('gsm')){
                return 'audio/x-gsm';
            }else if($sound_format == strtolower('wma')){
                return 'audio/x-ms-wma';
            }else if($sound_format == strtolower('webm')){
              return 'audio/webm';
            }else { 
                return 0;
            }
        }
        
        
        
          /**
         * This is the function that confirms if a book preview format is the right one
         */
        public function isTheBookReviewFileIInTheRightFormat(){
           
             if(isset($_FILES['book_preview_file']['name'])){
                $tmpName = $_FILES['book_preview_file']['tmp_name'];
                $previewFileName = $_FILES['book_preview_file']['name'];    
                $previewFileType = $_FILES['book_preview_file']['type'];
                $previewFileSize = $_FILES['book_preview_file']['size'];
            } 
            
            if(($previewFileType ==='application/pdf' )){
                return true;
            }else{
                return false;
            }
            
        }
        
        
           /**
         * This is the function that confirms if a book softcopy format is the right one
         */
        public function isTheSoftcopyBookFileIInTheRightFormat(){
           
             if(isset($_FILES['book_softcopy_file']['name'])){
                $tmpName = $_FILES['book_softcopy_file']['tmp_name'];
                $softcopyFileName = $_FILES['book_softcopy_file']['name'];    
                $softcopyFileType = $_FILES['book_softcopy_file']['type'];
                $softcopyFileSize = $_FILES['book_softcopy_file']['size'];
            } 
            
            if(($softcopyFileType ==='application/pdf' )){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that registers keywords for a product
         */
        public function registerThisProductKeywords($product_id,$keyword){
            $model = new Keywords;
            return $model->registerThisProductKeywords($product_id,$keyword);
            
        }
        
        
         /**
         * This is the function that modifies keywords for a product
         */
        public function modifyThisProductKeywords($product_id,$keyword){
            $model = new Keywords;
            return $model->modifyThisProductKeywords($product_id,$keyword);
            
        }
}
