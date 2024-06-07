<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentLeadRepository;

class LeadController extends Controller
{
    //
    protected $leadRepository;

    public function __construct(EloquentLeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function index(Request $request)
    {
        // Retrieve filtered leads from the repository
        $leads = $this->leadRepository->filter($request->only(['name', 'email', 'phone', 'message']));

        return view('leads.index', compact('leads'));
    }
}
