<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = DB::table('posts')->get();
        $tags = DB::table('tags')->get();
        DB::table('post_tags')->truncate();
        foreach ($posts as $post) {
            DB::table('post_tags')->insert([
                'post_id' => $post->id,
                'tag_id' => $tags->random()->id,
                'created_at' => now()]);
            DB::table('post_tags')->insert([
                'post_id' => $post->id,
                'tag_id' => $tags->random()->id,
                'created_at' => now()]);
            DB::table('post_tags')->insert([
                'post_id' => $post->id,
                'tag_id' => $tags->random()->id,
                'created_at' => now()]);
        }
    }
}
