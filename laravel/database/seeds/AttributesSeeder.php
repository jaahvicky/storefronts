<?php

use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Attribute;

class AttributesSeeder extends Seeder
{
    
    protected $attributes = array (
        3 => 
        array (
          'id' => '3',
          'name' => 'Price Type',
          'slug' => 'price-type-custom',
          'type' => 'DROPDOWN',
          'options' => 'Amount,Contact for Price',
        ),
        4 => 
        array (
          'id' => '4',
          'name' => 'Condition',
          'slug' => 'condition-custom',
          'type' => 'DROPDOWN',
          'options' => ',New,Used',
        ),
        5 => 
        array (
          'id' => '5',
          'name' => 'Property Type',
          'slug' => 'property-type',
          'type' => 'DROPDOWN',
          'options' => ',Apartment,House or Villa,Townhouse,Other',
        ),
        9 => 
        array (
          'id' => '9',
          'name' => 'Clothing Type (Male/Female/Unisex)',
          'slug' => 'clothing-type',
          'type' => 'DROPDOWN',
          'options' => ',Male,Female,Unisex',
        ),
        10 => 
        array (
          'id' => '10',
          'name' => 'I am (Agency/Owner)',
          'slug' => 'property-i-am',
          'type' => 'DROPDOWN',
          'options' => ',Agency,Owner',
        ),
        11 => 
        array (
          'id' => '11',
          'name' => 'I am (Offering/Looking For)',
          'slug' => 'jobs-i-am',
          'type' => 'DROPDOWN',
          'options' => ',Offering,Looking For',
        ),
        12 => 
        array (
          'id' => '12',
          'name' => 'I am (Selling/Looking For)',
          'slug' => 'seller-buyer-custom',
          'type' => 'DROPDOWN',
          'options' => ',Selling,Looking For',
        ),
        14 => 
        array (
          'id' => '14',
          'name' => 'Square Meters',
          'slug' => 'square-meters',
          'type' => 'TEXT',
          'options' => '',
        ),
        15 => 
        array (
          'id' => '15',
          'name' => 'Furnished',
          'slug' => 'furnished-property',
          'type' => 'DROPDOWN',
          'options' => ',Yes,Partially,No',
        ),
        16 => 
        array (
          'id' => '16',
          'name' => 'Bathrooms',
          'slug' => 'bathrooms-property',
          'type' => 'DROPDOWN',
          'options' => ',0,1,2,3,4',
        ),
        17 => 
        array (
          'id' => '17',
          'name' => 'Bedrooms',
          'slug' => 'bedrooms-property',
          'type' => 'DROPDOWN',
          'options' => ',Studio or Bachelor Pad,1,1.5,2,2.5,3,3.5,4,4.5,5,5.5',
        ),
        18 => 
        array (
          'id' => '18',
          'name' => 'Pets (Y/N)',
          'slug' => 'pets-property',
          'type' => 'DROPDOWN',
          'options' => ',Yes,No',
        ),
        22 => 
        array (
          'id' => '22',
          'name' => 'Transmission',
          'slug' => 'transmissions-vehicles',
          'type' => 'DROPDOWN',
          'options' => ',Manual,Automatic',
        ),
        25 => 
        array (
          'id' => '25',
          'name' => 'Company Name',
          'slug' => 'company-name',
          'type' => 'TEXT',
          'options' => '',
        ),
        26 => 
        array (
          'id' => '26',
          'name' => 'Position Type',
          'slug' => 'job-type',
          'type' => 'DROPDOWN',
          'options' => ',Permanent,Contract,Part-Time,Casual',
        ),
        32 => 
        array (
          'id' => '32',
          'name' => 'Industry',
          'slug' => 'industry-jobs',
          'type' => 'DROPDOWN',
          'options' => ',Accounting and Finance,Advertising and Marketing,Childcare and Babysitting,Computing and IT,Construction and Skilled Trade,Customer Service,Engineering and Architecture,Farming and Veterinary,Gardening and Landscaping,Health and Beauty,Healthcare and Nursing,Hotel,Housekeeping and Cleaning,Human Resources,Legal,Logistics and Transportation,Manual Labour,Mining,Manufacturing,Office and Administration,Restaurant and Bar,Retail,Sales and Telemarketing,Sales and Telemarketing,Security,Sports Club,Teaching,Travel and Tourism,General',
        ),
        33 => 
        array (
          'id' => '33',
          'name' => 'Age',
          'slug' => 'age',
          'type' => 'TEXT',
          'options' => '',
        ),
        34 => 
        array (
          'id' => '34',
          'name' => 'Brand (Clothing & Shoes)',
          'slug' => 'brand-clothing-shoes',
          'type' => 'DROPDOWN',
          'options' => ',Adidas,Asics,Betty Basics,Caterpillar,Diesel,Gucci,Guess,Levi\'s,Nike,Puma,Quicksilver,Roxy,Skechers,Timberland,Wrangler,Other',
        ),
        35 => 
        array (
          'id' => '35',
          'name' => 'Make',
          'slug' => 'make',
          'type' => 'TEXT',
          'options' => '',
        ),
        36 => 
        array (
          'id' => '36',
          'name' => 'Colour',
          'slug' => 'colour-car',
          'type' => 'DROPDOWN',
          'options' => ',White,Silver,Gold,Green,Dark Green,Blue,Dark Blue,Brown,Black,Yellow,Red,Maroon,Purple,Pink,Orange,Grey,Dark Grey,Beige,Other',
        ),
        38 => 
        array (
          'id' => '38',
          'name' => 'TV Size',
          'slug' => 'tv-size',
          'type' => 'DROPDOWN',
          'options' => ',28â€,30â€,32â€,36â€,38â€,40â€,42â€,46â€,48â€,50â€,52â€,54â€,56â€,58â€,60â€,Larger than 60â€',
        ),
        39 => 
        array (
          'id' => '39',
          'name' => 'Clothing Type (Boys/Girls/Unisex)',
          'slug' => 'clothing-type-kids',
          'type' => 'DROPDOWN',
          'options' => ',Boys,Girls,Unisex',
        ),
        40 => 
        array (
          'id' => '40',
          'name' => 'Gender (Male/Female)',
          'slug' => 'gender-male-female',
          'type' => 'DROPDOWN',
          'options' => ',Male,Female',
        ),
        41 => 
        array (
          'id' => '41',
          'name' => 'Parking',
          'slug' => 'parking-property',
          'type' => 'DROPDOWN',
          'options' => ',Garage,Shaded,Open,Street,None',
        ),
        42 => 
        array (
          'id' => '42',
          'name' => 'Price Type for Sale',
          'slug' => 'price-type-sale',
          'type' => 'DROPDOWN',
          'options' => ',Amount,Negotiable,Contact for price',
        ),
        43 => 
        array (
          'id' => '43',
          'name' => 'Price Type Rentals',
          'slug' => 'price-type-rent',
          'type' => 'DROPDOWN',
          'options' => ',Amount,Negotiable,Contact for price',
        ),
        44 => 
        array (
          'id' => '44',
          'name' => 'Year',
          'slug' => 'year-vehicles',
          'type' => 'DROPDOWN',
          'options' => ',Older than 1975,1976 â€“ 1980,1981,1982,1983,1984,1985,1986,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015',
        ),
        45 => 
        array (
          'id' => '45',
          'name' => 'Age (Kids and Baby)',
          'slug' => 'age-kids-baby',
          'type' => 'DROPDOWN',
          'options' => ',Newborn,0 - 3 months,3 - 6 months,6-12 months,12-18 months,18-24 months,24+ months',
        ),
        46 => 
        array (
          'id' => '46',
          'name' => 'Make (Cellphone)',
          'slug' => 'makes-cellphone',
          'type' => 'DROPDOWN',
          'options' => ',BlackBerry,HTC,iPhone,LG,Motorola,Nokia,Samsung,Sony Ericsson,Microsoft,Accessories,Other',
        ),
        47 => 
        array (
          'id' => '47',
          'name' => 'Make (Gaming and Consoles)',
          'slug' => 'make-games',
          'type' => 'DROPDOWN',
          'options' => ',Game Boy,Nintendo DS,Playstation,Wii,WiiU,Xbox,Accessories,Other',
        ),
        48 => 
        array (
          'id' => '48',
          'name' => 'Make (TV, Audio and Visual)',
          'slug' => 'make-tv',
          'type' => 'DROPDOWN',
          'options' => ',Hitachi,LG,Panasonic,Philips,Samsung,Sharp,Sony,Technika,Toshiba,Logik,Other',
        ),
        49 => 
        array (
          'id' => '49',
          'name' => 'Make (Computers and Laptops)',
          'slug' => 'make-computers',
          'type' => 'DROPDOWN',
          'options' => ',Acer,Asus,Apple,AMD,Dell,Fujitsu,HP,Compaq,IBM,Lenovo,ICL,Intel,Sony,Toshiba,Other',
        ),
        50 => 
        array (
          'id' => '50',
          'name' => 'Make (Cameras)',
          'slug' => 'make-cameras',
          'type' => 'DROPDOWN',
          'options' => ',Canon,Case Logic,Fujifilm,JVC,Kodak,Nikon,Olympus,Panasonic,Pentax,Ricoh,Samsung,Sony,Sigma,Other',
        ),
        51 => 
        array (
          'id' => '51',
          'name' => 'Make (Tablets)',
          'slug' => 'make-tablets',
          'type' => 'DROPDOWN',
          'options' => ',Apple,Acer,Asus,Samsung,Other,Accessories',
        ),
        52 => 
        array (
          'id' => '52',
          'name' => 'Make (Computers Other)',
          'slug' => 'make-computers-other',
          'type' => 'TEXT',
          'options' => '',
        ),
        53 => 
        array (
          'id' => '53',
          'name' => 'Brand (Outdoors & Sports Equipment)',
          'slug' => 'brand-outdoor-sports',
          'type' => 'DROPDOWN',
          'options' => ',â€™47,2XU,Abu Garcia,Adams Golf,Adidas,Asics,Barska,Bates,Bauer,Body-Solid,Bowflex,Bridgestone Golf,Brooks,Callaway,CamelBak,Camp Chef,Carhartt,Cascade,Champion,Cleveland Golf,Coleman,DBX,DeMarini,Dunlop,Durango,Easton,Elite Hockey,Fitbit,Fitness Gear,GAIAM,Gatorade,Garmin,Giro,Glove It,GoPro,GORE-TEX,Grays,HEAD,Helly Hansen,Inov-8,JanSport,Jockey,Jordan,JUGS Sports,KEEN,Kijaro,Mizuno,New Balance,Nike,Nike Golf,Nikon,Oakley,O\'Brien,Pearl Izumi,ProForm,PUMA,Salomon,Saucony,Shimano Fishing,SKINS,Speedo,STOTT Pilates,Timberland,Tour Inline Hockey,Umbro,Worth',
        ),
        54 => 
        array (
          'id' => '54',
          'name' => 'Brand (Bicycles)',
          'slug' => 'brand-bicycles',
          'type' => 'DROPDOWN',
          'options' => ',AMR,Avanti,Bianchi,Cannondale,Centurion,Cervelo,Commencal,Ecos,Fatmodul,Felt,FireFox,Fuji,Gary Fisher,Giant,GT,Ideal,Merida,ProFlex,Rans,Rocky Mountain,Schwinn,Scott,Syncos,Trek,Yeto,Other',
        ),
        55 => 
        array (
          'id' => '55',
          'name' => 'Brand (Gym & Fitness)',
          'slug' => 'brand-gym-fitness',
          'type' => 'DROPDOWN',
          'options' => ',3G Cardio,AbCoaster,AbCore,Aeromats,All Pro,Balazs Boxing,BILT,Bionic,Bodybar,Bodyrev,Bodycraft,BOSU,CAP Industries,CrossCore,Cybex,DISQ,Dyna-Band,Ecore,Escali,Expresso Fitness,First Degree,FreeCross,FreeMotion,GRIPAD,Grip Master,Hampton,Harbinger,Health-o-Meter,Hoist,Humane,Hyperwear,iFit,Jacobs Ladder,JK Fitness,Polar,PowerBlock,PowerPlate,Prism,Schwinn,Super Mats,Teeter Hang Ups,Troy,TRX,USA,Other',
        ),
        56 => 
        array (
          'id' => '56',
          'name' => 'Brand (Prams, Cots & Equipment)',
          'slug' => 'brand-pram-cots',
          'type' => 'DROPDOWN',
          'options' => ',Apache,Chelino,Coyote,Baby Jogger,Baby Style,Bambino,Bugaboo,Bundleme,Comfort Bebe,Cosatto,Dooky,Dreambaby,Graco,Jeep,Mammas & Pappas,McClaren,Uppa Baby,Other',
        ),
        57 => 
        array (
          'id' => '57',
          'name' => 'Brand (Health, Beauty & Cosmetics)',
          'slug' => 'brand-health-beauty',
          'type' => 'DROPDOWN',
          'options' => ',Avon,Aveno,Biore,Bobbi Brown,Bourjois,Chanel,Christian Dior,Clarins,Clean & Clear,Clearasil,Clinique,Coty,Dermalogica,Dove,Elizabeth Arden,Estee Lauder,Eucerin,Johnsons,Kerastase,Kiehls,Kose,L\'Occitane,Lux,M.A.C,Maybelline,Neutrogena,Redken,Rexona,Rimmel,Schwarzkopf,Shiseido,The Body Shop,Vichy,Yves Saint Laurent,Other',
        ),
        58 => 
        array (
          'id' => '58',
          'name' => 'Brand (Jewellery & Accessories)',
          'slug' => 'brand-jewel',
          'type' => 'DROPDOWN',
          'options' => ',AdornMe,Affinity Diamonds,Azuni London,Boss Hugo Boss,Bulova,Cartier,Casio,Chanel,Citizen,Daisy London,DKNY,Fiorelli,Folli Follie,Fossil,G-Shock,Michael Kors,Omega,Pandora,Polar,Rolex,Rotary,Tag Huer,Tiffany,Breitling,Tiffany & Co,Tissot,Seiko,Skagen,Swatch,Van Cleef & Arpels,Other',
        ),
        59 => 
        array (
          'id' => '59',
          'name' => 'Brand (Toys & Dolls)',
          'slug' => 'brand-toys',
          'type' => 'DROPDOWN',
          'options' => ',Airfix,Barbie,Breyer,Brio,Chicco,Corgi,Corolle,Crayola,Disney,Dr Seuss,Fisher Price,Funskool,Galt,Hello Kitty,Hot Wheels,K Nex,Lego,Little Tikes,Mattell,Meccanno,Mega Bloks,Monopoly,Papo,Play-Doh,Playmobil,Play Skool,Thomas & Friends,Toy Story,Other',
        ),
        60 => 
        array (
          'id' => '60',
          'name' => 'Brand (Homeware & Appliances)',
          'slug' => 'brand-home',
          'type' => 'DROPDOWN',
          'options' => ',Admiral,Arkla,Amana,Avanti,Best,Bodum,Bosch,Broan,Broan NuTone,Cadet,Crosley,Dacor,Ducane Gas grills,Electrolux,Eurotech,Everpure,Ez-Flo,Fagore,Fiesta,Frigidaire,Gaggenau,Gibson,Haier,Hardwick,Hotpoint,Huebsch,insinkerator,Jenn-Air,Kelvinator,Kenmore,KitchenAid,Kuhn Rikon,Le Creuset,Magic Chef,Maytag,Miele,Napolean,Norge,Premier,Rainfresh,Roper,Samsung,Scotsman,Shmeg,Siemens,Sprayway,Summit,Sunbeam,Thermador,Thermos,Tupperware,VentAHood,Venmar,Waste King,Weber,West Bend,Whirlpool,Wilton,Wolf,Zephyr,Other',
        ),
        61 => 
        array (
          'id' => '61',
          'name' => 'Brand (Tools & DIY)',
          'slug' => 'brand-tools',
          'type' => 'DROPDOWN',
          'options' => ',3M Worldwide,Amana Tool,AGE,AirKing,AtlasCopco,Bosch,Bostitech,Black & Decker,CGW,Chicago Pneumatic,CLC,DeWalt,Dremel,Dynabrade,Dynapac,Edco,Facom,Generac,Hilti,Harris,Hitachi,Irwin,Ingersoll Rand,Jet,Lincoln Electric,Lista,MK,Magnum,Makita,Marshalltown,Multiquip,Porter Cable,Powermatic,Pressure-Pro,Proto,Reed,Rust-oleum,Skil,Stanley,Starrett,Stow,Timberline,Vermont American,Victor,Vidmar,Vise-Grip,Walter Meier,Wilton,Other',
        ),
        62 => 
        array (
          'id' => '62',
          'name' => 'NEW custom field',
          'slug' => 'new-custom-field',
          'type' => 'TEXT',
          'options' => '',
        ),
        63 => 
        array (
          'id' => '63',
          'name' => 'NEW custom field',
          'slug' => 'new-custom-field_1',
          'type' => 'TEXT',
          'options' => '',
        ),
        64 => 
        array (
          'id' => '64',
          'name' => 'NEW custom field',
          'slug' => 'new-custom-field_2',
          'type' => 'TEXT',
          'options' => '',
        ),
        65 => 
        array (
          'id' => '65',
          'name' => 'Available on Whatsapp',
          'slug' => 'whatsapp-custom-field',
          'type' => 'CHECKBOX',
          'options' => '0,1',
        ),
        66 => 
        array (
          'id' => '66',
          'name' => 'Mileage',
          'slug' => 'mileage',
          'type' => 'TEXT',
          'options' => '',
        ),
    );
    
    protected $attribute_categories = array (
        0 => 
        array (
          'category_id' => '96',
          'attribute_id' => '3',
        ),
        1 => 
        array (
          'category_id' => '97',
          'attribute_id' => '3',
        ),
        2 => 
        array (
          'category_id' => '98',
          'attribute_id' => '3',
        ),
        3 => 
        array (
          'category_id' => '99',
          'attribute_id' => '3',
        ),
        4 => 
        array (
          'category_id' => '100',
          'attribute_id' => '3',
        ),
        5 => 
        array (
          'category_id' => '101',
          'attribute_id' => '3',
        ),
        6 => 
        array (
          'category_id' => '102',
          'attribute_id' => '3',
        ),
        7 => 
        array (
          'category_id' => '103',
          'attribute_id' => '3',
        ),
        8 => 
        array (
          'category_id' => '104',
          'attribute_id' => '3',
        ),
        9 => 
        array (
          'category_id' => '105',
          'attribute_id' => '3',
        ),
        10 => 
        array (
          'category_id' => '106',
          'attribute_id' => '3',
        ),
        11 => 
        array (
          'category_id' => '111',
          'attribute_id' => '3',
        ),
        12 => 
        array (
          'category_id' => '112',
          'attribute_id' => '3',
        ),
        13 => 
        array (
          'category_id' => '113',
          'attribute_id' => '3',
        ),
        14 => 
        array (
          'category_id' => '115',
          'attribute_id' => '3',
        ),
        15 => 
        array (
          'category_id' => '116',
          'attribute_id' => '3',
        ),
        16 => 
        array (
          'category_id' => '117',
          'attribute_id' => '3',
        ),
        17 => 
        array (
          'category_id' => '118',
          'attribute_id' => '3',
        ),
        18 => 
        array (
          'category_id' => '119',
          'attribute_id' => '3',
        ),
        19 => 
        array (
          'category_id' => '120',
          'attribute_id' => '3',
        ),
        20 => 
        array (
          'category_id' => '121',
          'attribute_id' => '3',
        ),
        21 => 
        array (
          'category_id' => '122',
          'attribute_id' => '3',
        ),
        22 => 
        array (
          'category_id' => '123',
          'attribute_id' => '3',
        ),
        23 => 
        array (
          'category_id' => '124',
          'attribute_id' => '3',
        ),
        24 => 
        array (
          'category_id' => '125',
          'attribute_id' => '3',
        ),
        25 => 
        array (
          'category_id' => '126',
          'attribute_id' => '3',
        ),
        26 => 
        array (
          'category_id' => '127',
          'attribute_id' => '3',
        ),
        27 => 
        array (
          'category_id' => '128',
          'attribute_id' => '3',
        ),
        28 => 
        array (
          'category_id' => '129',
          'attribute_id' => '3',
        ),
        29 => 
        array (
          'category_id' => '130',
          'attribute_id' => '3',
        ),
        30 => 
        array (
          'category_id' => '131',
          'attribute_id' => '3',
        ),
        31 => 
        array (
          'category_id' => '132',
          'attribute_id' => '3',
        ),
        32 => 
        array (
          'category_id' => '133',
          'attribute_id' => '3',
        ),
        33 => 
        array (
          'category_id' => '134',
          'attribute_id' => '3',
        ),
        34 => 
        array (
          'category_id' => '135',
          'attribute_id' => '3',
        ),
        35 => 
        array (
          'category_id' => '137',
          'attribute_id' => '3',
        ),
        36 => 
        array (
          'category_id' => '138',
          'attribute_id' => '3',
        ),
        37 => 
        array (
          'category_id' => '139',
          'attribute_id' => '3',
        ),
        38 => 
        array (
          'category_id' => '140',
          'attribute_id' => '3',
        ),
        39 => 
        array (
          'category_id' => '141',
          'attribute_id' => '3',
        ),
        40 => 
        array (
          'category_id' => '142',
          'attribute_id' => '3',
        ),
        41 => 
        array (
          'category_id' => '143',
          'attribute_id' => '3',
        ),
        42 => 
        array (
          'category_id' => '144',
          'attribute_id' => '3',
        ),
        43 => 
        array (
          'category_id' => '145',
          'attribute_id' => '3',
        ),
        44 => 
        array (
          'category_id' => '146',
          'attribute_id' => '3',
        ),
        45 => 
        array (
          'category_id' => '147',
          'attribute_id' => '3',
        ),
        46 => 
        array (
          'category_id' => '148',
          'attribute_id' => '3',
        ),
        47 => 
        array (
          'category_id' => '149',
          'attribute_id' => '3',
        ),
        48 => 
        array (
          'category_id' => '150',
          'attribute_id' => '3',
        ),
        49 => 
        array (
          'category_id' => '151',
          'attribute_id' => '3',
        ),
        50 => 
        array (
          'category_id' => '152',
          'attribute_id' => '3',
        ),
        51 => 
        array (
          'category_id' => '153',
          'attribute_id' => '3',
        ),
        52 => 
        array (
          'category_id' => '154',
          'attribute_id' => '3',
        ),
        53 => 
        array (
          'category_id' => '155',
          'attribute_id' => '3',
        ),
        54 => 
        array (
          'category_id' => '157',
          'attribute_id' => '3',
        ),
        55 => 
        array (
          'category_id' => '159',
          'attribute_id' => '3',
        ),
        56 => 
        array (
          'category_id' => '160',
          'attribute_id' => '3',
        ),
        57 => 
        array (
          'category_id' => '161',
          'attribute_id' => '3',
        ),
        58 => 
        array (
          'category_id' => '162',
          'attribute_id' => '3',
        ),
        59 => 
        array (
          'category_id' => '163',
          'attribute_id' => '3',
        ),
        60 => 
        array (
          'category_id' => '164',
          'attribute_id' => '3',
        ),
        61 => 
        array (
          'category_id' => '165',
          'attribute_id' => '3',
        ),
        62 => 
        array (
          'category_id' => '166',
          'attribute_id' => '3',
        ),
        63 => 
        array (
          'category_id' => '167',
          'attribute_id' => '3',
        ),
        64 => 
        array (
          'category_id' => '168',
          'attribute_id' => '3',
        ),
        65 => 
        array (
          'category_id' => '169',
          'attribute_id' => '3',
        ),
        66 => 
        array (
          'category_id' => '171',
          'attribute_id' => '3',
        ),
        67 => 
        array (
          'category_id' => '172',
          'attribute_id' => '3',
        ),
        68 => 
        array (
          'category_id' => '188',
          'attribute_id' => '3',
        ),
        69 => 
        array (
          'category_id' => '190',
          'attribute_id' => '3',
        ),
        70 => 
        array (
          'category_id' => '203',
          'attribute_id' => '3',
        ),
        71 => 
        array (
          'category_id' => '97',
          'attribute_id' => '4',
        ),
        72 => 
        array (
          'category_id' => '98',
          'attribute_id' => '4',
        ),
        73 => 
        array (
          'category_id' => '99',
          'attribute_id' => '4',
        ),
        74 => 
        array (
          'category_id' => '100',
          'attribute_id' => '4',
        ),
        75 => 
        array (
          'category_id' => '101',
          'attribute_id' => '4',
        ),
        76 => 
        array (
          'category_id' => '103',
          'attribute_id' => '4',
        ),
        77 => 
        array (
          'category_id' => '105',
          'attribute_id' => '4',
        ),
        78 => 
        array (
          'category_id' => '106',
          'attribute_id' => '4',
        ),
        79 => 
        array (
          'category_id' => '111',
          'attribute_id' => '4',
        ),
        80 => 
        array (
          'category_id' => '112',
          'attribute_id' => '4',
        ),
        81 => 
        array (
          'category_id' => '113',
          'attribute_id' => '4',
        ),
        82 => 
        array (
          'category_id' => '115',
          'attribute_id' => '4',
        ),
        83 => 
        array (
          'category_id' => '116',
          'attribute_id' => '4',
        ),
        84 => 
        array (
          'category_id' => '117',
          'attribute_id' => '4',
        ),
        85 => 
        array (
          'category_id' => '118',
          'attribute_id' => '4',
        ),
        86 => 
        array (
          'category_id' => '119',
          'attribute_id' => '4',
        ),
        87 => 
        array (
          'category_id' => '120',
          'attribute_id' => '4',
        ),
        88 => 
        array (
          'category_id' => '124',
          'attribute_id' => '4',
        ),
        89 => 
        array (
          'category_id' => '125',
          'attribute_id' => '4',
        ),
        90 => 
        array (
          'category_id' => '134',
          'attribute_id' => '4',
        ),
        91 => 
        array (
          'category_id' => '135',
          'attribute_id' => '4',
        ),
        92 => 
        array (
          'category_id' => '137',
          'attribute_id' => '4',
        ),
        93 => 
        array (
          'category_id' => '138',
          'attribute_id' => '4',
        ),
        94 => 
        array (
          'category_id' => '139',
          'attribute_id' => '4',
        ),
        95 => 
        array (
          'category_id' => '140',
          'attribute_id' => '4',
        ),
        96 => 
        array (
          'category_id' => '141',
          'attribute_id' => '4',
        ),
        97 => 
        array (
          'category_id' => '142',
          'attribute_id' => '4',
        ),
        98 => 
        array (
          'category_id' => '143',
          'attribute_id' => '4',
        ),
        99 => 
        array (
          'category_id' => '144',
          'attribute_id' => '4',
        ),
        100 => 
        array (
          'category_id' => '145',
          'attribute_id' => '4',
        ),
        101 => 
        array (
          'category_id' => '146',
          'attribute_id' => '4',
        ),
        102 => 
        array (
          'category_id' => '147',
          'attribute_id' => '4',
        ),
        103 => 
        array (
          'category_id' => '148',
          'attribute_id' => '4',
        ),
        104 => 
        array (
          'category_id' => '149',
          'attribute_id' => '4',
        ),
        105 => 
        array (
          'category_id' => '150',
          'attribute_id' => '4',
        ),
        106 => 
        array (
          'category_id' => '151',
          'attribute_id' => '4',
        ),
        107 => 
        array (
          'category_id' => '152',
          'attribute_id' => '4',
        ),
        108 => 
        array (
          'category_id' => '153',
          'attribute_id' => '4',
        ),
        109 => 
        array (
          'category_id' => '154',
          'attribute_id' => '4',
        ),
        110 => 
        array (
          'category_id' => '169',
          'attribute_id' => '4',
        ),
        111 => 
        array (
          'category_id' => '155',
          'attribute_id' => '5',
        ),
        112 => 
        array (
          'category_id' => '157',
          'attribute_id' => '5',
        ),
        113 => 
        array (
          'category_id' => '162',
          'attribute_id' => '5',
        ),
        114 => 
        array (
          'category_id' => '163',
          'attribute_id' => '5',
        ),
        115 => 
        array (
          'category_id' => '118',
          'attribute_id' => '9',
        ),
        116 => 
        array (
          'category_id' => '96',
          'attribute_id' => '10',
        ),
        117 => 
        array (
          'category_id' => '155',
          'attribute_id' => '10',
        ),
        118 => 
        array (
          'category_id' => '157',
          'attribute_id' => '10',
        ),
        119 => 
        array (
          'category_id' => '159',
          'attribute_id' => '10',
        ),
        120 => 
        array (
          'category_id' => '160',
          'attribute_id' => '10',
        ),
        121 => 
        array (
          'category_id' => '161',
          'attribute_id' => '10',
        ),
        122 => 
        array (
          'category_id' => '162',
          'attribute_id' => '10',
        ),
        123 => 
        array (
          'category_id' => '163',
          'attribute_id' => '10',
        ),
        124 => 
        array (
          'category_id' => '108',
          'attribute_id' => '11',
        ),
        125 => 
        array (
          'category_id' => '109',
          'attribute_id' => '11',
        ),
        126 => 
        array (
          'category_id' => '110',
          'attribute_id' => '11',
        ),
        127 => 
        array (
          'category_id' => '128',
          'attribute_id' => '11',
        ),
        128 => 
        array (
          'category_id' => '129',
          'attribute_id' => '11',
        ),
        129 => 
        array (
          'category_id' => '130',
          'attribute_id' => '11',
        ),
        130 => 
        array (
          'category_id' => '131',
          'attribute_id' => '11',
        ),
        131 => 
        array (
          'category_id' => '132',
          'attribute_id' => '11',
        ),
        132 => 
        array (
          'category_id' => '133',
          'attribute_id' => '11',
        ),
        133 => 
        array (
          'category_id' => '188',
          'attribute_id' => '11',
        ),
        134 => 
        array (
          'category_id' => '190',
          'attribute_id' => '11',
        ),
        135 => 
        array (
          'category_id' => '203',
          'attribute_id' => '11',
        ),
        136 => 
        array (
          'category_id' => '96',
          'attribute_id' => '12',
        ),
        137 => 
        array (
          'category_id' => '97',
          'attribute_id' => '12',
        ),
        138 => 
        array (
          'category_id' => '98',
          'attribute_id' => '12',
        ),
        139 => 
        array (
          'category_id' => '99',
          'attribute_id' => '12',
        ),
        140 => 
        array (
          'category_id' => '100',
          'attribute_id' => '12',
        ),
        141 => 
        array (
          'category_id' => '101',
          'attribute_id' => '12',
        ),
        142 => 
        array (
          'category_id' => '103',
          'attribute_id' => '12',
        ),
        143 => 
        array (
          'category_id' => '104',
          'attribute_id' => '12',
        ),
        144 => 
        array (
          'category_id' => '105',
          'attribute_id' => '12',
        ),
        145 => 
        array (
          'category_id' => '106',
          'attribute_id' => '12',
        ),
        146 => 
        array (
          'category_id' => '111',
          'attribute_id' => '12',
        ),
        147 => 
        array (
          'category_id' => '112',
          'attribute_id' => '12',
        ),
        148 => 
        array (
          'category_id' => '113',
          'attribute_id' => '12',
        ),
        149 => 
        array (
          'category_id' => '115',
          'attribute_id' => '12',
        ),
        150 => 
        array (
          'category_id' => '116',
          'attribute_id' => '12',
        ),
        151 => 
        array (
          'category_id' => '117',
          'attribute_id' => '12',
        ),
        152 => 
        array (
          'category_id' => '118',
          'attribute_id' => '12',
        ),
        153 => 
        array (
          'category_id' => '119',
          'attribute_id' => '12',
        ),
        154 => 
        array (
          'category_id' => '120',
          'attribute_id' => '12',
        ),
        155 => 
        array (
          'category_id' => '121',
          'attribute_id' => '12',
        ),
        156 => 
        array (
          'category_id' => '122',
          'attribute_id' => '12',
        ),
        157 => 
        array (
          'category_id' => '123',
          'attribute_id' => '12',
        ),
        158 => 
        array (
          'category_id' => '124',
          'attribute_id' => '12',
        ),
        159 => 
        array (
          'category_id' => '125',
          'attribute_id' => '12',
        ),
        160 => 
        array (
          'category_id' => '126',
          'attribute_id' => '12',
        ),
        161 => 
        array (
          'category_id' => '127',
          'attribute_id' => '12',
        ),
        162 => 
        array (
          'category_id' => '134',
          'attribute_id' => '12',
        ),
        163 => 
        array (
          'category_id' => '135',
          'attribute_id' => '12',
        ),
        164 => 
        array (
          'category_id' => '137',
          'attribute_id' => '12',
        ),
        165 => 
        array (
          'category_id' => '138',
          'attribute_id' => '12',
        ),
        166 => 
        array (
          'category_id' => '139',
          'attribute_id' => '12',
        ),
        167 => 
        array (
          'category_id' => '140',
          'attribute_id' => '12',
        ),
        168 => 
        array (
          'category_id' => '141',
          'attribute_id' => '12',
        ),
        169 => 
        array (
          'category_id' => '142',
          'attribute_id' => '12',
        ),
        170 => 
        array (
          'category_id' => '143',
          'attribute_id' => '12',
        ),
        171 => 
        array (
          'category_id' => '144',
          'attribute_id' => '12',
        ),
        172 => 
        array (
          'category_id' => '145',
          'attribute_id' => '12',
        ),
        173 => 
        array (
          'category_id' => '146',
          'attribute_id' => '12',
        ),
        174 => 
        array (
          'category_id' => '147',
          'attribute_id' => '12',
        ),
        175 => 
        array (
          'category_id' => '148',
          'attribute_id' => '12',
        ),
        176 => 
        array (
          'category_id' => '149',
          'attribute_id' => '12',
        ),
        177 => 
        array (
          'category_id' => '150',
          'attribute_id' => '12',
        ),
        178 => 
        array (
          'category_id' => '151',
          'attribute_id' => '12',
        ),
        179 => 
        array (
          'category_id' => '152',
          'attribute_id' => '12',
        ),
        180 => 
        array (
          'category_id' => '153',
          'attribute_id' => '12',
        ),
        181 => 
        array (
          'category_id' => '154',
          'attribute_id' => '12',
        ),
        182 => 
        array (
          'category_id' => '155',
          'attribute_id' => '12',
        ),
        183 => 
        array (
          'category_id' => '157',
          'attribute_id' => '12',
        ),
        184 => 
        array (
          'category_id' => '159',
          'attribute_id' => '12',
        ),
        185 => 
        array (
          'category_id' => '160',
          'attribute_id' => '12',
        ),
        186 => 
        array (
          'category_id' => '161',
          'attribute_id' => '12',
        ),
        187 => 
        array (
          'category_id' => '162',
          'attribute_id' => '12',
        ),
        188 => 
        array (
          'category_id' => '163',
          'attribute_id' => '12',
        ),
        189 => 
        array (
          'category_id' => '164',
          'attribute_id' => '12',
        ),
        190 => 
        array (
          'category_id' => '165',
          'attribute_id' => '12',
        ),
        191 => 
        array (
          'category_id' => '166',
          'attribute_id' => '12',
        ),
        192 => 
        array (
          'category_id' => '167',
          'attribute_id' => '12',
        ),
        193 => 
        array (
          'category_id' => '168',
          'attribute_id' => '12',
        ),
        194 => 
        array (
          'category_id' => '169',
          'attribute_id' => '12',
        ),
        195 => 
        array (
          'category_id' => '170',
          'attribute_id' => '12',
        ),
        196 => 
        array (
          'category_id' => '96',
          'attribute_id' => '14',
        ),
        197 => 
        array (
          'category_id' => '155',
          'attribute_id' => '14',
        ),
        198 => 
        array (
          'category_id' => '157',
          'attribute_id' => '14',
        ),
        199 => 
        array (
          'category_id' => '159',
          'attribute_id' => '14',
        ),
        200 => 
        array (
          'category_id' => '160',
          'attribute_id' => '14',
        ),
        201 => 
        array (
          'category_id' => '161',
          'attribute_id' => '14',
        ),
        202 => 
        array (
          'category_id' => '162',
          'attribute_id' => '14',
        ),
        203 => 
        array (
          'category_id' => '163',
          'attribute_id' => '14',
        ),
        204 => 
        array (
          'category_id' => '155',
          'attribute_id' => '15',
        ),
        205 => 
        array (
          'category_id' => '157',
          'attribute_id' => '15',
        ),
        206 => 
        array (
          'category_id' => '160',
          'attribute_id' => '15',
        ),
        207 => 
        array (
          'category_id' => '161',
          'attribute_id' => '15',
        ),
        208 => 
        array (
          'category_id' => '162',
          'attribute_id' => '15',
        ),
        209 => 
        array (
          'category_id' => '163',
          'attribute_id' => '15',
        ),
        210 => 
        array (
          'category_id' => '155',
          'attribute_id' => '16',
        ),
        211 => 
        array (
          'category_id' => '157',
          'attribute_id' => '16',
        ),
        212 => 
        array (
          'category_id' => '160',
          'attribute_id' => '16',
        ),
        213 => 
        array (
          'category_id' => '161',
          'attribute_id' => '16',
        ),
        214 => 
        array (
          'category_id' => '162',
          'attribute_id' => '16',
        ),
        215 => 
        array (
          'category_id' => '163',
          'attribute_id' => '16',
        ),
        216 => 
        array (
          'category_id' => '155',
          'attribute_id' => '17',
        ),
        217 => 
        array (
          'category_id' => '157',
          'attribute_id' => '17',
        ),
        218 => 
        array (
          'category_id' => '162',
          'attribute_id' => '17',
        ),
        219 => 
        array (
          'category_id' => '163',
          'attribute_id' => '17',
        ),
        220 => 
        array (
          'category_id' => '155',
          'attribute_id' => '18',
        ),
        221 => 
        array (
          'category_id' => '157',
          'attribute_id' => '18',
        ),
        222 => 
        array (
          'category_id' => '162',
          'attribute_id' => '18',
        ),
        223 => 
        array (
          'category_id' => '163',
          'attribute_id' => '18',
        ),
        224 => 
        array (
          'category_id' => '111',
          'attribute_id' => '22',
        ),
        225 => 
        array (
          'category_id' => '115',
          'attribute_id' => '22',
        ),
        226 => 
        array (
          'category_id' => '116',
          'attribute_id' => '22',
        ),
        227 => 
        array (
          'category_id' => '109',
          'attribute_id' => '25',
        ),
        228 => 
        array (
          'category_id' => '110',
          'attribute_id' => '25',
        ),
        229 => 
        array (
          'category_id' => '108',
          'attribute_id' => '26',
        ),
        230 => 
        array (
          'category_id' => '109',
          'attribute_id' => '26',
        ),
        231 => 
        array (
          'category_id' => '110',
          'attribute_id' => '26',
        ),
        232 => 
        array (
          'category_id' => '108',
          'attribute_id' => '32',
        ),
        233 => 
        array (
          'category_id' => '109',
          'attribute_id' => '32',
        ),
        234 => 
        array (
          'category_id' => '110',
          'attribute_id' => '32',
        ),
        235 => 
        array (
          'category_id' => '121',
          'attribute_id' => '33',
        ),
        236 => 
        array (
          'category_id' => '122',
          'attribute_id' => '33',
        ),
        237 => 
        array (
          'category_id' => '126',
          'attribute_id' => '33',
        ),
        238 => 
        array (
          'category_id' => '172',
          'attribute_id' => '33',
        ),
        239 => 
        array (
          'category_id' => '118',
          'attribute_id' => '34',
        ),
        240 => 
        array (
          'category_id' => '142',
          'attribute_id' => '35',
        ),
        241 => 
        array (
          'category_id' => '166',
          'attribute_id' => '35',
        ),
        242 => 
        array (
          'category_id' => '111',
          'attribute_id' => '36',
        ),
        243 => 
        array (
          'category_id' => '113',
          'attribute_id' => '36',
        ),
        244 => 
        array (
          'category_id' => '115',
          'attribute_id' => '36',
        ),
        245 => 
        array (
          'category_id' => '145',
          'attribute_id' => '38',
        ),
        246 => 
        array (
          'category_id' => '147',
          'attribute_id' => '39',
        ),
        247 => 
        array (
          'category_id' => '121',
          'attribute_id' => '40',
        ),
        248 => 
        array (
          'category_id' => '122',
          'attribute_id' => '40',
        ),
        249 => 
        array (
          'category_id' => '126',
          'attribute_id' => '40',
        ),
        250 => 
        array (
          'category_id' => '172',
          'attribute_id' => '40',
        ),
        251 => 
        array (
          'category_id' => '155',
          'attribute_id' => '41',
        ),
        252 => 
        array (
          'category_id' => '157',
          'attribute_id' => '41',
        ),
        253 => 
        array (
          'category_id' => '160',
          'attribute_id' => '41',
        ),
        254 => 
        array (
          'category_id' => '161',
          'attribute_id' => '41',
        ),
        255 => 
        array (
          'category_id' => '162',
          'attribute_id' => '41',
        ),
        256 => 
        array (
          'category_id' => '163',
          'attribute_id' => '41',
        ),
        257 => 
        array (
          'category_id' => '111',
          'attribute_id' => '44',
        ),
        258 => 
        array (
          'category_id' => '113',
          'attribute_id' => '44',
        ),
        259 => 
        array (
          'category_id' => '115',
          'attribute_id' => '44',
        ),
        260 => 
        array (
          'category_id' => '116',
          'attribute_id' => '44',
        ),
        261 => 
        array (
          'category_id' => '117',
          'attribute_id' => '44',
        ),
        262 => 
        array (
          'category_id' => '99',
          'attribute_id' => '45',
        ),
        263 => 
        array (
          'category_id' => '146',
          'attribute_id' => '45',
        ),
        264 => 
        array (
          'category_id' => '147',
          'attribute_id' => '45',
        ),
        265 => 
        array (
          'category_id' => '167',
          'attribute_id' => '45',
        ),
        266 => 
        array (
          'category_id' => '171',
          'attribute_id' => '45',
        ),
        267 => 
        array (
          'category_id' => '139',
          'attribute_id' => '46',
        ),
        268 => 
        array (
          'category_id' => '145',
          'attribute_id' => '48',
        ),
        269 => 
        array (
          'category_id' => '141',
          'attribute_id' => '49',
        ),
        270 => 
        array (
          'category_id' => '140',
          'attribute_id' => '50',
        ),
        271 => 
        array (
          'category_id' => '144',
          'attribute_id' => '51',
        ),
        272 => 
        array (
          'category_id' => '150',
          'attribute_id' => '53',
        ),
        273 => 
        array (
          'category_id' => '148',
          'attribute_id' => '54',
        ),
        274 => 
        array (
          'category_id' => '149',
          'attribute_id' => '55',
        ),
        275 => 
        array (
          'category_id' => '146',
          'attribute_id' => '56',
        ),
        276 => 
        array (
          'category_id' => '119',
          'attribute_id' => '57',
        ),
        277 => 
        array (
          'category_id' => '120',
          'attribute_id' => '58',
        ),
        278 => 
        array (
          'category_id' => '171',
          'attribute_id' => '59',
        ),
        279 => 
        array (
          'category_id' => '153',
          'attribute_id' => '60',
        ),
        280 => 
        array (
          'category_id' => '154',
          'attribute_id' => '61',
        ),
        281 => 
        array (
          'category_id' => '96',
          'attribute_id' => '65',
        ),
        282 => 
        array (
          'category_id' => '97',
          'attribute_id' => '65',
        ),
        283 => 
        array (
          'category_id' => '98',
          'attribute_id' => '65',
        ),
        284 => 
        array (
          'category_id' => '99',
          'attribute_id' => '65',
        ),
        285 => 
        array (
          'category_id' => '100',
          'attribute_id' => '65',
        ),
        286 => 
        array (
          'category_id' => '101',
          'attribute_id' => '65',
        ),
        287 => 
        array (
          'category_id' => '102',
          'attribute_id' => '65',
        ),
        288 => 
        array (
          'category_id' => '103',
          'attribute_id' => '65',
        ),
        289 => 
        array (
          'category_id' => '104',
          'attribute_id' => '65',
        ),
        290 => 
        array (
          'category_id' => '105',
          'attribute_id' => '65',
        ),
        291 => 
        array (
          'category_id' => '106',
          'attribute_id' => '65',
        ),
        292 => 
        array (
          'category_id' => '108',
          'attribute_id' => '65',
        ),
        293 => 
        array (
          'category_id' => '109',
          'attribute_id' => '65',
        ),
        294 => 
        array (
          'category_id' => '110',
          'attribute_id' => '65',
        ),
        295 => 
        array (
          'category_id' => '111',
          'attribute_id' => '65',
        ),
        296 => 
        array (
          'category_id' => '112',
          'attribute_id' => '65',
        ),
        297 => 
        array (
          'category_id' => '113',
          'attribute_id' => '65',
        ),
        298 => 
        array (
          'category_id' => '115',
          'attribute_id' => '65',
        ),
        299 => 
        array (
          'category_id' => '116',
          'attribute_id' => '65',
        ),
        300 => 
        array (
          'category_id' => '117',
          'attribute_id' => '65',
        ),
        301 => 
        array (
          'category_id' => '118',
          'attribute_id' => '65',
        ),
        302 => 
        array (
          'category_id' => '119',
          'attribute_id' => '65',
        ),
        303 => 
        array (
          'category_id' => '120',
          'attribute_id' => '65',
        ),
        304 => 
        array (
          'category_id' => '121',
          'attribute_id' => '65',
        ),
        305 => 
        array (
          'category_id' => '122',
          'attribute_id' => '65',
        ),
        306 => 
        array (
          'category_id' => '123',
          'attribute_id' => '65',
        ),
        307 => 
        array (
          'category_id' => '124',
          'attribute_id' => '65',
        ),
        308 => 
        array (
          'category_id' => '125',
          'attribute_id' => '65',
        ),
        309 => 
        array (
          'category_id' => '126',
          'attribute_id' => '65',
        ),
        310 => 
        array (
          'category_id' => '127',
          'attribute_id' => '65',
        ),
        311 => 
        array (
          'category_id' => '128',
          'attribute_id' => '65',
        ),
        312 => 
        array (
          'category_id' => '129',
          'attribute_id' => '65',
        ),
        313 => 
        array (
          'category_id' => '130',
          'attribute_id' => '65',
        ),
        314 => 
        array (
          'category_id' => '131',
          'attribute_id' => '65',
        ),
        315 => 
        array (
          'category_id' => '132',
          'attribute_id' => '65',
        ),
        316 => 
        array (
          'category_id' => '133',
          'attribute_id' => '65',
        ),
        317 => 
        array (
          'category_id' => '134',
          'attribute_id' => '65',
        ),
        318 => 
        array (
          'category_id' => '135',
          'attribute_id' => '65',
        ),
        319 => 
        array (
          'category_id' => '136',
          'attribute_id' => '65',
        ),
        320 => 
        array (
          'category_id' => '137',
          'attribute_id' => '65',
        ),
        321 => 
        array (
          'category_id' => '138',
          'attribute_id' => '65',
        ),
        322 => 
        array (
          'category_id' => '139',
          'attribute_id' => '65',
        ),
        323 => 
        array (
          'category_id' => '140',
          'attribute_id' => '65',
        ),
        324 => 
        array (
          'category_id' => '141',
          'attribute_id' => '65',
        ),
        325 => 
        array (
          'category_id' => '142',
          'attribute_id' => '65',
        ),
        326 => 
        array (
          'category_id' => '143',
          'attribute_id' => '65',
        ),
        327 => 
        array (
          'category_id' => '144',
          'attribute_id' => '65',
        ),
        328 => 
        array (
          'category_id' => '145',
          'attribute_id' => '65',
        ),
        329 => 
        array (
          'category_id' => '146',
          'attribute_id' => '65',
        ),
        330 => 
        array (
          'category_id' => '147',
          'attribute_id' => '65',
        ),
        331 => 
        array (
          'category_id' => '148',
          'attribute_id' => '65',
        ),
        332 => 
        array (
          'category_id' => '149',
          'attribute_id' => '65',
        ),
        333 => 
        array (
          'category_id' => '150',
          'attribute_id' => '65',
        ),
        334 => 
        array (
          'category_id' => '151',
          'attribute_id' => '65',
        ),
        335 => 
        array (
          'category_id' => '152',
          'attribute_id' => '65',
        ),
        336 => 
        array (
          'category_id' => '153',
          'attribute_id' => '65',
        ),
        337 => 
        array (
          'category_id' => '154',
          'attribute_id' => '65',
        ),
        338 => 
        array (
          'category_id' => '155',
          'attribute_id' => '65',
        ),
        339 => 
        array (
          'category_id' => '157',
          'attribute_id' => '65',
        ),
        340 => 
        array (
          'category_id' => '159',
          'attribute_id' => '65',
        ),
        341 => 
        array (
          'category_id' => '160',
          'attribute_id' => '65',
        ),
        342 => 
        array (
          'category_id' => '161',
          'attribute_id' => '65',
        ),
        343 => 
        array (
          'category_id' => '162',
          'attribute_id' => '65',
        ),
        344 => 
        array (
          'category_id' => '163',
          'attribute_id' => '65',
        ),
        345 => 
        array (
          'category_id' => '164',
          'attribute_id' => '65',
        ),
        346 => 
        array (
          'category_id' => '165',
          'attribute_id' => '65',
        ),
        347 => 
        array (
          'category_id' => '166',
          'attribute_id' => '65',
        ),
        348 => 
        array (
          'category_id' => '167',
          'attribute_id' => '65',
        ),
        349 => 
        array (
          'category_id' => '168',
          'attribute_id' => '65',
        ),
        350 => 
        array (
          'category_id' => '169',
          'attribute_id' => '65',
        ),
        351 => 
        array (
          'category_id' => '170',
          'attribute_id' => '65',
        ),
        352 => 
        array (
          'category_id' => '171',
          'attribute_id' => '65',
        ),
        353 => 
        array (
          'category_id' => '172',
          'attribute_id' => '65',
        ),
        354 => 
        array (
          'category_id' => '111',
          'attribute_id' => '66',
        ),
        355 => 
        array (
          'category_id' => '113',
          'attribute_id' => '66',
        ),
        356 => 
        array (
          'category_id' => '115',
          'attribute_id' => '66',
        ),
        357 => 
        array (
          'category_id' => '116',
          'attribute_id' => '66',
        ),
        358 => 
        array (
          'category_id' => '117',
          'attribute_id' => '66',
        ),
    );



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Attribute
        foreach($this->attributes As $id => $attr) {
            
            //Exclude Price Type, I am (Agency/Owner), I am (Offering/Looking For), I am (Selling/Looking For), Available on Whatsapp
            if (!in_array($attr['id'], [3, 10, 11, 12, 65])) {
            
                $attribute = App\Models\Attribute::create([
                    'id' => $attr['id'],
                    'name' => $attr['name'],
                    'slug' => $attr['slug'],
                    'type' => $attr['type']
                ]);

                $values = explode(",", trim($attr['options'], ","));

                foreach($values As $i => $value) {

                    if (trim($value) !== "") {
                        $attributeValue = App\Models\AttributeValue::create([
                            'attribute_id' => $attribute->id,
                            'value' => $value
                        ]);
                    }
                }
                
            }
        } 
        
        //AttributeCategories
        foreach($this->attribute_categories As $id => $link) {
            
            //Exclude Price Type, I am (Agency/Owner), I am (Offering/Looking For), I am (Selling/Looking For), Available on Whatsapp
            if (!in_array($link['attribute_id'], [3, 10, 11, 12, 65])) {
            
                $category = Category::where('id', $link['category_id'])->first();
                $attribute = Attribute::where('id', $link['attribute_id'])->first();

                $category->addAttribute($attribute);
                
            }
        }
    }
}
