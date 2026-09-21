<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowDate = fake()->dateTimeBetween('-2 months', 'now');
        $dueDate = (clone $borrowDate)->modify('+2 weeks');
        
        return [
            'book_id' => Book::factory(),
            'member_id' => Member::factory(),
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'returned_at' => fake()->optional()->dateTimeBetween($borrowDate, 'now'),
        ];
    }
}
