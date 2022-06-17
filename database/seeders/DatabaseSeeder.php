<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1000)->create();

        $categories = Category::factory(100)->create();

        $articles = Article::factory(9000)->create();

        foreach($articles as $article) {
            $category = Category::find(rand(1, Category::count()));
            $article->categories()->attach($category);
        }
    }
}
