<?php

use Illuminate\Database\Seeder;

class CityAndSuburbTableSeeder extends Seeder
{

	protected $cities = [

		[
		'name' => 'Beitbridge', 
		'suburb' => [
				'CBD', 'Dulibadzimu'
			]
		],

		[
		'name' => 'Bindura', 
		'suburb' => [
				'Aerodrome', 'Bindura Suburb', 'CBD', 'Chipadze', 'Chiwaridzo', 'Garikai'
			]
		],

		[
		'name' => 'Bulawayo',
		'suburb' => [
				'Ascot', 'Barbour Fields', 'Barham Green', 'Beacon Hill', 'Bellevue', 'Belmont', 'Belmont Industrial Area', 'Bradfield', 'Burnside', 'Cement', 'City Center', 'Cowdray park', 'Donnington', 'Donnington West', 'Douglasdale', 'Eloana', 'Emakhandeni', 'Emganwini', 'Enqameni', 'Enqanemi', 'Enqotsheni', 'Entumbane', 'Fagadola', 'Famona', 'Fortunes Gate', 'Four Winds', 'Glencoe', 'Glengarry', 'Glengary', 'Glenville', 'Granite Park', 'Greenhill', 'Gwabalanda', 'Harrisvale', 'Helenvale', 'Highmount', 'Hillcrest', 'Hillside', 'Hillside South', 'Hume Park', 'Hyde Park', 'Ilanda', 'Iminyela', 'Intini', 'Jacaranda', 'Kelvin', 'Kenilworth', 'khumalo', 'Khumalo North', 'Kilallo', 'Killarney', 'Kingsdale', 'Kumalo', 'Lakeside', 'Lobengula', 'Lobenvale', 'Lochview', 'Luveve', 'Mabuthweni', 'Mabutweni', 'Magwegwe', 'Magwegwe North', 'Magwegwe West', 'Mahatshula', 'Makokoba', 'Malindela', 'Manningdale', 'Marlands', 'Matsheumhlope', 'Matshobana', 'Montgomery', 'Montrose', 'Morningside', 'Mpopoma', 'Munda', 'Mzilikazi', 'New Luveve', 'Newsmansford', 'Newton', 'Newton West', 'Nguboyenja', 'Njube', 'Nketa', 'Nkulumane', 'North End', 'North Lynne', 'North Trenance', 'Northlea', 'Northvale', 'Ntaba Moyo', 'Orange Grove', 'Paddonhurst', 'Parklands', 'Parkview', 'Pelandaba', 'Pumula', 'Pumula South', 'Queen Park East', 'Queens Park', 'Queens Park West', 'Queensdale', 'Rangemore', 'Raylton', 'Richmond', 'Ricmond', 'Riverside', 'Romney Park', 'Sauerstown', 'Selbourne Park ', 'Sizinda', 'Southdale', 'Souththwold', 'Southwold', 'Steeldale', 'Suburbs', 'Sunninghill', 'Sunnyside', 'Tegela', 'The Jungle ', 'Thorngrove', 'Trenance', 'Tshabalala', 'Tshabalala Extension', 'Umguza estate', 'Upper Rangemore', 'Waterford', 'Waterlea', 'West Somerton', 'Westgate', 'Westondale', 'Willsgrove', 'Windsor Park', 'Woodlands', 'Woodville', 'Woodville Park'
			]
		],

		[
		'name' => 'Chegutu', 
		'suburb' => [
				'CBD', 'Chegutu Location', 'Chestgate', 'HintonVille', 'Kaguvi', 'Mvovo', 'Pfupajena', 'Rifle range', 'ZMDC'
			]
		],

		[
		'name' => 'Chinhoyi', 
		'suburb' => [
			'Brundish', 'CBD', 'Chikonohono', 'Cold Stream', 'Gazema', 'Gunhill', 'Hunyani', 'Mupata Section', 'Muzare', 'Orange Groove', 'Ruvimbo'
			]
		],

		[
		'name' => 'Chipinge', 
		'suburb' => [
				'CBD', 'Gaza Township', 'Low Density', 'Medium Density', 'Usanga'
			]
		],

		[
		'name' => 'Chiredzi', 
		'suburb' => [
				'Buffalo Range', 'CBD', 'Hippo Valley', 'Malilangwe', 'Mukwasini', 'Nandi', 'Town', 'Triangle', 'Tshovhani', 'ZSA'
			]
		],

		[
		'name' => 'Chitungwiza', 
		'suburb' => [
				'Makoni', 'Manyame Park', 'Mayambara', 'Nyatsime', 'Rockview', 'Seke', 'Seke Rural', 'St Mary\'s', 'Zengeza', 'Ziko'
			]
		],

		[
		'name' => 'Gwanda', 
		'suburb' => [
				'CBD', 'Geneva', 'Jacaranda', 'Jahunda', 'Marriage', 'Phakama', 'Spitzkop', 'Ultra High'
			]
		],

		[
		'name' => 'Gweru', 
		'suburb' => [
				'Ascot', 'Athlone', 'Brackenhurst', 'CBD', 'Christmas Gift', 'Clifton Park', 'Daylesford', 'Enfield', 'Gweru East', 'Harben Park', 'Hertfordshire', 'Ivene', 'Kopje', 'Lundi Park', 'Mambo', 'Mkoba', 'Mtapa', 'Mtausi Park', 'Munhumutapa', 'Nashville', 'Nehosho', 'Northgate Park', 'Northlea', 'Ridgemond', 'Riverside', 'Rundolf Park', 'Senga', 'Senga/Nehosho', 'Shamrock Park', 'Sithabile Park', 'Southdowns', 'Southview', 'St Annes Drive', 'Windsor Park', 'Woodlands'
			]
		],

		[
		'name' => 'Harare', 
		'suburb' => [
			'Adylinn', 'Alexandra Park', 'Amby', 'Arcadia', 'Ardbennie', 'Arlingon', 'Ashbrittle', 'Ashdown Park', 'Aspindale Park', 'Athlone', 'Avenues', 'Avondale', 'Avondale West', 'Avonlea', 'Ballantyne Park', 'Belgravia', 'Belvedere', 'Beverley', 'Beverley West', 'Bloomingdale', 'Bluff Hill', 'Borrowdale', 'Borrowdale Brooke', 'Borrowdale West', 'Braeside', 'Brooke Ridge', 'Budiriro', 'Carrick Creagh', 'Chadcombe', 'Chikurubi', 'Chipukutu', 'Chiremba Park', 'Chisipiti', 'Chisipitie', 'Chizhanje', 'City Centre', 'Civic Centre', 'Cold Comfort', 'Colne Valley', 'Colray', 'Coronation Park', 'Cotswold Hills', 'Cranbourne Park', 'Crowborough', 'Damofalls', 'Dawn Hill', 'Donnybrook', 'Dzivarasekwa', 'Dzivaresekwa', 'Eastlea', 'Eastlea North', 'Eastlea South', 'Eastview', 'Emerald Hill', 'Epworth', 'Gevstein Park', 'Glaudina', 'Glen Lorne', 'Glen Norah', 'Glen View', 'Glenwood', 'Grange', 'Graniteside', 'Green Grove', 'Greencroft', 'Greendale', 'Greystone Park', 'Grobbie Park', 'Groombridge', 'Gun Hill', 'Haig Park', 'Hatcliffe', 'Hatfield', 'Helensvale', 'Highfield', 'Highlands', 'Hillside', 'Hogerty Hill', 'Hopley', 'Houghton Park', 'Induna', 'Kambanje', 'Kambuzuma', 'Kensington', 'Kopje', 'Kutsaga', 'Kuwadzana', 'Letombo Park', 'Lewisam', 'Lichendale', 'Lincoln Green', 'Little Norfolk', 'Lochinvar', 'Logan Park', 'Lorelei', 'Luna', 'Mabelreign', 'Mabvuku', 'Mainway Meadows', 'Malvern', 'Mandara', 'Manidoda Park', 'Manresa', 'Marimba Park', 'Marlborough', 'Mayfield Park', 'Mbare', 'Meyrick Park', 'Midlands', 'Milton Park', 'Mondora', 'Monovale', 'Mount Hampden', 'Mount Pleasant', 'Msasa', 'Msasa Park', 'Mufakose', 'Mukuvisi', 'Mukuvisi Park', 'New Ridgeview', 'Newlands', 'Nkwisi Park', 'Northwood', 'Old Forest', 'Park Meadowlands', 'Parktown', 'Philadelphia', 'Pomona', 'Prospect', 'Prospect Park', 'Queensdale', 'Quinnington', 'Rhodesville', 'Ridgeview', 'Rietfontein', 'Ringley', 'Rolf Valley', 'Rugare', 'Runniville', 'Ryelands', 'Sanganai Park', 'Science Park', 'Sentosa', 'Shawasha Hills', 'Sherwood Park', 'Shortson', 'Southerton', 'St. Andrews Park', 'St. Martins', 'Strathaven', 'Sunningdale', 'Sunridge', 'Sunrise', 'Sunway City', 'Tafara', 'The Grange', 'Tynwald', 'Umwimsidale', 'Umwinsidale', 'Uplands', 'Vainona', 'Valencedene', 'Ventersburg', 'Warren Park', 'Waterfalls', 'Westgate', 'Westwood', 'Willowvale', 'Wilmington Park', 'Workington', 'Zimre Park'
			]
		],

		[
		'name' => 'Kadoma', 
		'suburb' => [
				'CBD', 'Chakari', 'Cotton Research', 'Eastview', 'Eiffel Flats', 'Ingezi', 'Mornington', 'Patchway', 'Rimuka', 'Rio Tinto', 'Waverly', 'Westview'
			]
		],

		[
		'name' => 'Kariba', 
		'suburb' => [
				'Aerial Hill', 'Baobab Ridge', 'Batonga', 'Boulder Ridge', 'CBD', 'Heights', 'Hospital Hill', 'Mica Point', 'Nyamhunga'
			]
		],

		[
		'name' => 'Karoi', 
		'suburb' => [
				'CBD', 'Chiedza', 'Chikangwe', 'Flamboyant'
			]
		],

		[
		'name' => 'Kwekwe', 
		'suburb' => [
				'Amaveni', 'CBD', 'Fitchley', 'Gaika', 'Glenhood', 'Golden Acres', 'Masasa', 'Mbizo', 'New Town', 'Redcliff', 'Rutendo', 'Towhood', 'Westend'
			]
		],

		[
		'name' => 'Marondera', 
		'suburb' => [
				'1st Street', '2nd Street', '4th Street', 'CBD', 'Cherima/Rujeko', 'Cherutombo', 'Dombotombo', 'Garikai/Elveshood', 'Lendy Park', 'Morningside', 'Nyameni', 'Paradise', 'Rusike', 'Ruvimbo park', 'Ruware Park', 'Ruzawi Park', 'Wiston Park', 'Yellow City'
			]
		],

		[
		'name' => 'Masvingo', 
		'suburb' => [
				'Buffalo Range', 'CBD', 'Clipsharm Park', 'Eastville', 'Four 1 Infantry Battalion', 'Morningside', 'Mucheke', 'Rhodene', 'Rujeko', 'Runyararo'
			]
		],

		[
		'name' => 'Mutare', 
		'suburb' => [
				'Avenues', 'Bordervale', 'CBD', 'Chikanga', 'Chikanga Extension', 'Dangamvura', 'Darlington', 'Fairbridge Park', 'Fern Valley', 'Florida', 'Garikai Hlalani Kuhle', 'Gimboki', 'Greenside', 'Greenside Extension', 'Hobhouse', 'Mai Maria', 'Morningside', 'Murambi', 'Natview Park', 'Palmerston', 'Sakubva', 'St Josephs', 'Tiger\'s Kloof', 'Toronto', 'Utopia', 'Weirmouth', 'Westlea', 'Yeovil', 'Zimta', 'Zimunya'
			]
		],

		[
		'name' => 'Nyanga', 
		'suburb' => [
				'CBD', 'Depe park', 'Mangondoza', 'Nyamuka', 'Nyangani', 'Rochdale'
			]
		],

		[
		'name' => 'Plumtree',
		'suburb' => [
				'CBD', 'Dingumuzi', 'Hebron', 'Kariba', 'Lakeview', 'Madubes', 'Mathendele', 'Matiwaza', 'Medium Density', 'Rangiore', 'ZBS'
			]
		],

		[
		'name' => 'Rusape', 
		'suburb' => [
				'Castle Base', 'CBD', 'Chingaira', 'Crocodile', 'Gopal', 'Lisapi', 'Mabvazuva', 'Magamba', 'Mbuyanehanda', 'Nyanga Drive', 'Off Nyanga Drive', 'Silverpool', 'Tsanzaguru', 'Vengere'
			]
		],

		[
		'name' => 'Shurugwi', 
		'suburb' => [
				'CBD', 'Dark City', 'Ironside', 'Makusha', 'Peakmine', 'Railway Block', 'Tebekwe', 'ZBS'
			]
		],

		[
		'name' => 'Victoria Falls', 
		'suburb' => [
				'Aerodrome', 'CBD', 'Chinotimba', 'Mkhosana', 'Suburbs'
			]
		],

		[
		'name' => 'Zvishavane', 
		'suburb' => [
				'CBD', 'Eastview', 'Highlands', 'Kandodo', 'Mabula', 'Maglas', 'Makwasha', 'Mandava', 'Neil', 'Novel', 'Platinum Park',
			]
		]

	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$key = 1;

		// for each city, insert the key as id and add name
		foreach($this->cities as $city) {
			DB::table('cities')->insert([
				'id' => $key, 'name' => $city['name']
			]);

			// for each suburb of the city, add the key as city_id and the suburb's name
			foreach($city['suburb'] as $suburb) {
				DB::table('suburbs')->insert([
					'city_id' => $key, 'name' => $suburb
				]);
			}

			$key += 1;
		}

    }
}
