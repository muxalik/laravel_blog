<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Marketing', 'SEO', 'Digital Agency', 'Blogging', 'Video Tuts', 'Teamwork', 'Coding', 'Books', 'Frontend', 'Backend', 'HTML', 'CSS', 'JavaScript', 'Python', 'PHP', 'C#', 'Java', 'Game Development'];
        foreach ($tags as $tag) 
        {
            Tag::create(['title' => $tag]);
        }
    }
}
