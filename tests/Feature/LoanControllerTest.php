<?php

namespace Tests\Feature;

use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_return_a_book(): void
    {
        $loan = Loan::factory()->create(['returned_at' => null]);

        $response = $this->patchJson("/api/loans/{$loan->id}/return");

        $response->assertStatus(200);
        $response->assertJsonPath('data.is_active', false);
        $this->assertDatabaseMissing('loans', ['id' => $loan->id, 'returned_at' => null]);
    }

    public function test_it_can_filter_active_loans(): void
    {
        Loan::factory()->create(['returned_at' => null]);
        Loan::factory()->create(['returned_at' => now()]);

        $response = $this->getJson('/api/loans?active=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_it_can_filter_loans_by_member(): void
{
        $member = \App\Models\Member::factory()->create();
        Loan::factory()->create(['member_id' => $member->id]);
        Loan::factory()->create();

        $response = $this->getJson("/api/loans?member_id={$member->id}");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }
}