<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Http\Resources\LoanResource;
use App\Http\Requests\ReturnBookRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $loans = Loan::with(['book', 'member'])
            ->when($request->has('member_id'), fn ($query) => $query->where('member_id', $request->member_id))
            ->when($request->has('active'), fn ($query) => $query->whereNull('returned_at'))
            ->paginate(15);

        return LoanResource::collection($loans);
    }

    /**
     * Mark a loan as returned.
     */
    public function returnBook(ReturnBookRequest $request, Loan $loan)
    {
        $loan->returned_at = now();
        $loan->save();
        
        return new LoanResource($loan);
    }
}
