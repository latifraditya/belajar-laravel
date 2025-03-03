<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();

        Post::factory(50)->create();

        User::create([
          'name' => 'kenmaster',
          'username'=>'kenmaster',
          'email' => 'kenmaster@gmail.com',
          'password' => bcrypt('12345678'),
        ]);

        // User::create([
        //   'name' => 'Valezka',
        //   'email' => 'valezka@gmail.com',
        //   'password' => bcrypt('54321'),
        // ]);

        Category::create([
          'name' => 'Web Programming',
          'slug' => 'web-programming',
        ]);
        
        Category::create([
          'name' => 'Web Design',
          'slug' => 'web-design',
        ]);

        Category::create([
          'name' => 'Personal',
          'slug' => 'personal',
        ]);

        // Post::create([
        //   'category_id' => 1,
        //   'user_id' => 1,
        //   'title' => 'Judul Post Pertama',
        //   'slug' => 'judul-post-pertama',
        //   'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //   'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
        // ]);

        // Post::create([
        //   'category_id' => 1,
        //   'user_id' => 1,
        //   'title' => 'Judul Post Kedua',
        //   'slug' => 'judul-post-kedua',
        //   'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //   'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
        // ]);

        // Post::create([
        //   'category_id' => 2,
        //   'user_id' => 2,
        //   'title' => 'Judul Post Ketiga',
        //   'slug' => 'judul-post-ketiga',
        //   'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //   'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
        // ]);

        
        
    }
}
