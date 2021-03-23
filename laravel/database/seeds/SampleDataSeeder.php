<?php

use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$store = App\Models\Store::where('slug', '=', 'benjamin')->first();
		if (!$store) {
			$store = App\Models\Store::create([
				'name' => 'Benjamin\'s Lightsabers',
				'slug' => 'benjamin',
                'store_type_id' => 1,
                'store_delivery_method_id' => 1,
                'store_status_type_id' => 2,
				'logo' => 'images/samples/sample-store-logo.png',
				
			]);
		}

		$storeAbout = App\Models\StoreAbout::where('store_id', '=', $store->id)->first();
		if (!$storeAbout) {
			$storeAbout = \App\Models\StoreAbout::create([
				'store_id'     => $store->id,
				'exerpt'       => 'Payoff Line - Lorem ipsum dolor sit amet.',
				'description'  => '<p>Description paragraph</p>'
			]);
		}

		$storeDetails = App\Models\StoreDetail::where('store_id', '=', $store->id)->first();
		if (!$storeDetails) {
			$storeDetails = \App\Models\StoreDetail::create([
				'store_id'          => $store->id,
				'street_address_1'  => '2 Chaperone Street',
				'city_id'   		=> 11,
				'country_id' 		=> 1,
                "suburb_id" => 233,
				'email' 		    => 'agalagade@methys.com',
				'phone' 		    => '775047022',
				'collection_hours'  => 'Mon - Fri: 9am - 5pm, Sat and Sun: Closed'
			]);


		}

        $storeContactDetails = \App\Models\StoreContactDetail::create([
            'store_id'          => $store->id,
            'street_address_1'  => '2 Chaperone Street',
            'city_id'           => 11,
            'country_id'        => 1,
            'email'             => 'ben@test.co.za',
            'phone'             => '775047022'
        ]);

		$storeWarranty = App\Models\StoreWarranty::where('store_id', '=', $store->id)->first();
		if (!$storeWarranty) {
			$storeWarranty = \App\Models\StoreWarranty::create([
				'store_id'      => $store->id,
				'warranty'		=> '<h3>Section 1</h3><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>'
			]);
		}

		$storeBanner = App\Models\StoreBanner::where('store_id', '=', $store->id)->first();
		if (!$storeBanner) {
			$storeBanner = \App\Models\StoreBanner::create([
				'store_id' => $store->id,
				'filename' => 'images/samples/sample-store-banner.jpg',
				'order' => 0
			]);
		}

	                
        $category = \App\Models\Category::first();

		$product = \App\Models\Product::where('store_id', '=', $store->id)->first();
		if (!$product) {
			$product = \App\Models\Product::create([
				'store_id' => $store->id,
				'title' => 'Obi Wan\'s Lightsaber',
				'description' => 'Replica of the lightsaber used by Obi Wan',
				'slug' => 'obi-wan-lightsaberdf',
                'platform'=>'storefront',
				'price' => 5000,
				'currency_id' => 1,
				'product_status_id' => 2, //visible
				'product_type_id' => 2, //simple
				'category_id' => $category->id,
                		'product_moderation_type_id' => 2, //Approved
            		]);
       		 }

        //store and user connect  StoreUser
	     	 
	   $store_user = \App\Models\StoreUser::where('store_id', '=', $store->id)->first();
        if(!$store_user){
            $store_user = \App\Models\StoreUser::create([
                'store_id' => $store->id,
              'user_id' =>1,
            ]);
        }

        $productImage = \App\Models\ProductImage::where('product_id', '=', $product->id)->first();
        if (!$productImage) {
            $productImage = \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'filename' => 'product_sample_01.jpg',
                'original_upload' => 'product_sample_01.jpg',
            ]);
           $productImage = \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'filename' => 'product_sample_02.jpg',
                'original_upload' => 'product_sample_02.jpg',
            ]);
            $productImage = \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'filename' => 'product_sample_03.jpg',
                'original_upload' => 'product_sample_03.jpg',
            ]);
            $productImage = \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'filename' => 'product_sample_04.jpg',
                'original_upload' => 'product_sample_04.jpg',
            ]);
        }

        $tier3Cat = \App\Models\CategoriesCustom::create([
            'store_id' => 1,
            'parent_id' => 201,
            'name' => 'My Third Tier Category',
            'slug' => '123456'
        ]);


        $variants = \App\Models\AttributeVariant::create([
            'name'=> 'Size'
        ]);
        $variants = \App\Models\AttributeVariant::create([
            'name'=> 'Color'
        ]);


        $variantsvalue = \App\Models\AttributeVariantValue::create([
            'data'=> json_encode([
                'variant_ids'=> [['id'=>1],['id'=>2]],
                'data_values'=>[
                    ['value'=>'small',
                        'options'=>[
                            ['value'=>'black', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                    ['value'=>'small',
                        'options'=>[
                            ['value'=>'red', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                    ['value'=>'small',
                        'options'=>[
                            ['value'=>'green', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                    ['value'=>'large',
                        'options'=>[
                            ['value'=>'green', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                    ['value'=>'large',
                        'options'=>[
                            ['value'=>'red', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                   ['value'=>'large',
                        'options'=>[
                            ['value'=>'black', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                    ['value'=>'medium',
                        'options'=>[
                            ['value'=>'black', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                    ['value'=>'medium',
                        'options'=>[
                            ['value'=>'red', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],
                    ['value'=>'medium',
                        'options'=>[
                            ['value'=>'green', 'options'=>['available'=>1,'hidden'=>0, 'delete'=>0]],
                        ]
                    ],

                ],
                'elements'=>[
                    ['id'=>1, 'values'=> 'small,large,medium'],
                    ['id'=>2, 'values'=> 'green,red,black']

                ]
            ]),
            'product_id'=>$product->id

        ]);

        $tier3Cat = \App\Models\EcocashTransaction::create([
            'store_id' => 1,
            'msiadn' => '784536125',
            'status' => 'pending',
            'amount' => '50',
            'paid_on' =>date('Y-m-d h:m:s'),
            'response_data'=>'{"id":70313,"version":0,"clientCorrelator":"{B318F8D1-7AC6-B228-DF46-6FEDB63E6394}","endTime":null,"startTime":1486982081339,"notifyUrl":"http://ownai_cron_live.anthonyg.55.dev/ecocash_listener.php?tid=672539","referenceCode":"17391","endUserId":"784536125","serverReferenceCode":"1302201712344133976550","transactionOperationStatus":"PENDING SUBSCRIBER VALIDATION","paymentAmount":{"id":70314,"version":0,"charginginformation":{"id":70316,"version":0,"amount":1,"currency":"USD","description":""},"chargeMetaData":{"id":70315,"version":0,"channel":"WEB","purchaseCategoryCode":"","onBeHalfOf":"tengai","serviceId":null},"totalAmountCharged":null},"ecocashReference":"MP170213.1234.A00019","merchantCode":"00440","merchantPin":"1234","merchantNumber":"773077080","notificationFormat":null,"serviceId":null,"originalServerReferenceCode":null}',
            'correlator'=>'{B318F8D1-7AC6-B228-DF46-6FEDB63E6394}'
        ]);

        $ecocashconfig = \App\Models\EcocashConfig::create([
            'ecocash_endpoint'=>'https://payonline.econet.co.zw/ecocashGateway-preprod/payment/v1/transactions/amount',
            'ecocash_endpoint_query'=>'https://payonline.econet.co.zw/ecocashGateway-preprod/payment/v1/%s/transactions/amount/%s',
            'ecocash_endpoint_query_user'=>'https://payonline.econet.co.zw/ecocashGateway-preprod/payment/v1/%s/transactions',
            'ecocash_channel'=>'WEB',
            'ecocash_merchant_code'=>'00440',
            'ecocash_merchant_pin'=>'1234',
            'ecocash_merchant_number'=>'773077080',
            'ecocash_username'=>'tengai',
            'ecocash_password'=>'t3ngA1',
        ]);
    }

}
