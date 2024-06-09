<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentLeadRepository;
use Illuminate\Http\Request;

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

        return view('dashboard.leads.index', compact('leads'));
    }
}
