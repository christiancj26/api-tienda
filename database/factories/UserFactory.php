<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Size;
use App\Type;
use App\User;
use App\Brand;
use App\Seller;
use App\Profile;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'discount' => $faker->randomElement([0, 10, 15]),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'verified' => $verified = $faker->randomElement([User::USER_VERIFIED, User::USER_NOT_VERIFIED]),
        'verification_token' => $verified == User::USER_VERIFIED ? null : User::generateVerificationToken(),
        'admin' => $faker->randomElement([User::USER_ADMIN, User::USER_REGULAR]),
    ];
});

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'surnames' => $faker->lastName,
        'address' => $faker->streetAddress,
        'postal_code' => $faker->postcode,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'rfc' => $faker->swiftBicNumber,
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $quantity = $faker->numberBetween(0, 24),
        'price' => $faker->numberBetween(150, 500),
        'status' => $quantity > 0 ? Product::PRODUCT_AVIALABLE : Product::PRODUCT_NOT_AVIALABLE,
        'image' => 'https://via.placeholder.com/500.png/aaa/fff',
        'seller_id' => User::all()->random()->id,
        'type_id' => Type::all()->random()->id,
        'size_id' => Size::all()->random()->id,
        'brand_id' => Brand::all()->random()->id,
    ];
});

/*$factory->define(Transaction::class, function (Faker $faker) {
	$seller = Seller::has('products')->get()->random();
	$buyer = User::all()->except($seller->id)->random();
    return [
        'quantity' => $faker->numberBetween(1, 3),
        'status' => $faker->randomElement(['pendiente', 'realizado', 'cancelado']),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});*/
