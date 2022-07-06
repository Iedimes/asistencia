<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Help::class, static function (Faker\Generator $faker) {
    return [
        'ci' => $faker->randomNumber(5),
        'name' => $faker->firstName,
        'user' => $faker->sentence,
        'dependency' => $faker->sentence,
        'fone' => $faker->sentence,
        'problem' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\State::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Category::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Category::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Assist::class, static function (Faker\Generator $faker) {
    return [
        'heritage' => $faker->randomNumber(5),
        'id_user' => $faker->randomNumber(5),
        'date' => $faker->date(),
        'id_state' => $faker->randomNumber(5),
        'id_category' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DetailAssist::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DetailAssist::class, static function (Faker\Generator $faker) {
    return [
        'id_assist' => $faker->randomNumber(5),
        'id_user' => $faker->randomNumber(5),
        'id_state' => $faker->randomNumber(5),
        'solution' => $faker->sentence,
        'date' => $faker->date(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SIG008::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DetailHelp::class, static function (Faker\Generator $faker) {
    return [
        'assist_id' => $faker->randomNumber(5),
        'user_id' => $faker->randomNumber(5),
        'state_id' => $faker->randomNumber(5),
        'solution' => $faker->sentence,
        'date' => $faker->date(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DetailHelp::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DetailHelp::class, static function (Faker\Generator $faker) {
    return [
        'help_id' => $faker->randomNumber(5),
        'user_id' => $faker->randomNumber(5),
        'state_id' => $faker->randomNumber(5),
        'solution' => $faker->sentence,
        'date' => $faker->date(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DetailHelp::class, static function (Faker\Generator $faker) {
    return [
        'help_id' => $faker->randomNumber(5),
        'user_id' => $faker->randomNumber(5),
        'state_id' => $faker->randomNumber(5),
        'solution' => $faker->sentence,
        'date' => $faker->date(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'category_id' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\RHM006::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\RHM0066::class, static function (Faker\Generator $faker) {
    return [
        'FuncNro' => $faker->randomNumber(5),
        'FuncNom' => $faker->sentence,
        'FUsuCod' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Functionary::class, static function (Faker\Generator $faker) {
    return [
        'ci' => $faker->randomNumber(5),
        'full_name' => $faker->sentence,
        'user_name' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
