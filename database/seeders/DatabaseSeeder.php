<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();

        foreach (User::all() as $key => $user) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->username = explode(" ", $user->name)[0];
            $profile->save();
        }

        $categoryAr = [
            "Tech News",
            "Science",
            "Geography",
            "Political"
        ];
        foreach ($categoryAr as $key => $category) {
            $categoryM = new Category();
            $categoryM->name = $category;
            $categoryM->save();
        }

        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->title = fake()->realText(50);
            $post->content = fake()->paragraphs(1)[0];
            $post->category_id = rand(1, 4);
            $post->save();
        }

        for ($i = 0; $i < 100; $i++) {
            $post = new Comment();
            $post->comment = fake()->realText(50);
            $post->comment_type = Profile::class;
            $post->comment_id = rand(1, 20);
            $post->save();

            $post = new Comment();
            $post->comment = fake()->realText(50);
            $post->comment_type = Profile::class;
            $post->comment_id = rand(1, 20);
            $post->save();
        }

        $courses = [
            "Mastering SDSA Basics",
            "SD Strategies and Techniques",
            "SDSA Fundamentals Online",
            "SD Approaches and Applications",
            "Essential SDSA Skills"
        ];
        foreach ($courses as $key => $courseName) {
            $course = new Course();
            $course->name = $courseName;
            $course->duration = rand(1, 5) . " Month";
            $course->save();
        }

        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [1, 1]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [1, 2]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [1, 3]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [2, 1]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [3, 4]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [3, 1]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [3, 1]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [5, 1]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [5, 2]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [5, 3]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [4, 1]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [4, 2]);
        DB::insert('INSERT INTO `course_user` (`user_id`, `course_id`) VALUES (?, ?);', [6, 1]);
    }
}
