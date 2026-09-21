<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Member;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Author::factory(20)->create();
        Genre::factory(10)->create();
        Member::factory(15)->create();
        Book::factory(100)->create([
            'author_id' => fn () => Author::inRandomOrder()->first()->id,
        ]);
        Book::all()->each(function (Book $book) {
            $book->genres()->attach(Genre::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        });
        Loan::factory(50)->create([
            'book_id' => fn () => Book::inRandomOrder()->first()->id,
            'member_id' => fn () => Member::inRandomOrder()->first()->id,
        ]);
    }
}