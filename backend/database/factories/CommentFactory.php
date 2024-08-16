<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use App\Models\Comment;
use App\Helpers\MakeAlias;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    use MakeAlias;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $description =  $faker->words(10, true);

        return [
            'news_id' => News::factory(),
            'user_id' => User::factory(),
            'description' => $description,
        ];
    }

}
