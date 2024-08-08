<?php

namespace Database\Factories;

use App\Models\Category;
use App\Helpers\MakeAlias;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    use MakeAlias;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $title =  $faker->words(10, true);

        return [
            'name' => $title,
            'alias' => $this->stringToAlias($title),
        ];
    }

}
