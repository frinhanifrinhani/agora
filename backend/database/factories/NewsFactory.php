<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use App\Helpers\MakeAlias;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    use MakeAlias;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    protected $model = News::class;
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
            'title' => $title,
            'body' => $faker->text(200),
            'alias' => $this->stringToAlias($title),
            'open_to_comments' => true ,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'user_id' => User::factory(),
        ];
    }

}

