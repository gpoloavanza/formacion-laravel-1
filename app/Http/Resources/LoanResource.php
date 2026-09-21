<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\MemberResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'book' => new BookResource($this->whenLoaded('book')),
            'member' => new MemberResource($this->whenLoaded('member')),
            'borrow_date' => $this->borrow_date,
            'due_date' => $this->due_date,
            'returned_at' => $this->returned_at,
            'is_active' => is_null($this->returned_at),
        ];
    }
}
