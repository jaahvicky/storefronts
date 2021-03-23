<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Role::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'label' => $faker->word
    ];
});

$factory->define(App\Models\Permission::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'label' => $faker->word
    ];
});

$factory->define(App\Models\Store::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'store_status_type_id' => 2
    ];
});

$factory->define(App\Models\StoreDetail::class, function(Faker\Generator $faker) {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    return [
        'street_address_1' => $faker->word,
        //'street_address_2' => $faker->word,
        'city' => $faker->city,
        'suburb' => $faker->word,
        'country_id' => 1,
        'email' => $faker->email,
        'phone' => $faker->word,
        'collection_hours' => $faker->sentence
    ];
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
});

$factory->define(App\Models\StoreContactDetail::class, function(Faker\Generator $faker) {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    return [
        'firstname' => $faker->name,
        'lastname' => $faker->name,
         'street_address_1' => $faker->word,
        'street_address_2' => $faker->word,
        'city' => $faker->city,
        'suburb' => $faker->word,
        'country_id' => 1,
        'email' => $faker->email,
        'phone' => $faker->word
    ];
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
});

$factory->define(App\Models\StoreAbout::class, function(Faker\Generator $faker) {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    return [
        'exerpt' => $faker->sentence,
        'description' => $faker->paragraph
    ];
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
});

$factory->define(App\Models\StoreWarranty::class, function(Faker\Generator $faker) {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    return [
        'warranty' => $faker->paragraph
    ];
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
});

$factory->define(App\Models\Product::class, function(Faker\Generator $faker) {
    
    $categories = App\Models\Category::get();
    foreach($categories As $category) {
        $cat_ids[] = $category->id;
    }
    
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    return [
        'title' => $faker->word,
        'description' => $faker->sentence,
        'slug' => $faker->slug,
        'price' => rand(1, 10000),
        'currency_id' => 1,
        'product_status_id' => rand(1, 3), //visible
        'product_type_id' => rand(1, 2), //simple
        'category_id' => $cat_ids[rand(0, count($cat_ids)-1)],
        'product_moderation_type_id' => rand(1, 3), //Approved
    ];
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
});