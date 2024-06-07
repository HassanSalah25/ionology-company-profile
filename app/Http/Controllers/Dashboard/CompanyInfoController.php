<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentCompanyInfoRepository;

class CompanyInfoController extends Controller
{
    //
    protected $companyInfoRepository;

    public function __construct(EloquentCompanyInfoRepository $companyInfoRepository)
    {
        $this->companyInfoRepository = $companyInfoRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'description', 'address', 'phone', 'email']);
        // Retrieve filtered company info from the repository
        $companyInfos = $this->companyInfoRepository->filter($filters);

        return view('company_infos.index', compact('companyInfos'));
    }

    public function create()
    {
        return view('company_infos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name.*' => 'required|string|max:255',
            'description.*' => 'required|string',
            'address.*' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        $companyInfo = $this->companyInfoRepository->create($data);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image')) {
            $companyInfo->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return redirect()->route('company_infos.index')->with('success', 'Company info created successfully.');
    }

    public function edit($id)
    {
        $companyInfo = $this->companyInfoRepository->find($id);

        return view('company_infos.edit', compact('companyInfo'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name.*' => 'required|string|max:255',
            'description.*' => 'required|string',
            'address.*' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);



        $companyInfo = $this->companyInfoRepository->find($id);
        $companyInfo->update($data);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image')) {
            $companyInfo->clearMediaCollection('images');
            $companyInfo->addMedia($request->file('image'))->toMediaCollection('images');
        }


        return redirect()->route('company_infos.index')->with('success', 'Company info updated successfully.');
    }

    public function destroy($id)
    {
        $this->companyInfoRepository->delete($id);

        return redirect()->route('company_infos.index')->with('success', 'Company info deleted successfully.');
    }

    public function destroyImage($id)
    {
        $companyInfo = $this->companyInfoRepository->find($id);

        $companyInfo->clearMediaCollection('images');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Image deleted successfully.'
        ]);
    }


}
