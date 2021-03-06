<?php

use App\User;
use App\Product;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * @var Faker
     */
    protected $faker;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var User
     */
    protected $user;

    /**
     * Type.
     *
     * @var array
     */
    protected $type = [
        'old', 'new'
    ];

    /**
     * Status.
     *
     * @var array
     */
    protected $status = [
        'published', 'drafted', 'completed'
    ];

    /**
     * Sales.
     *
     * @var array
     */
    protected $sales = [
        '10', '15', '20', '25', '30', '35', '40', '50', '55', '60', '65', '70', '75'
    ];

    /**
     * ProductsTableSeeder constructor.
     * @param Product $product
     * @param Faker $faker
     * @param User $user
     */
    public function __construct(
        Product $product, 
        Faker $faker, 
        User $user
    )
    {
        $this->instance = $product;
        $this->faker = $faker->create();
        $this->user = $user;
        $this->count = rand(1, 3);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->deleteTable();

        $this->user->all()->each(function ($user) {

            if(count($user->vendors)) {
                $user->vendors->each(function($vendor) use ($user){
                    for ($i = 0; $i < $this->count; $i++) {
                        $this->instance->create([
                            'vendor_id' => $vendor->id,
                            'name' => $this->faker->sentence($this->faker->numberBetween(2, 4)),
                            'price' => $this->faker->randomFloat(2, 300, 5000),
                            'sale' => $this->sales[array_rand($this->sales, 1)],
                            'count' => $this->faker->numberBetween(10, 100),
                            'type' => $this->type[array_rand($this->type, 1)],
                            'status' => $this->status[array_rand($this->status, 1)],
                            'published_date' => $this->faker->date('Y-m-d H:i:s'),
                            'expiration_date' => $this->faker->date('Y-m-d H:i:s')
                        ]);
                    }
                });
            }
        });
    }
}