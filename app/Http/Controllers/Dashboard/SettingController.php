<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repositories\Eloquent\EloquentSettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingsRepository;

    public function __construct(EloquentSettingRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function index()
    {
        $data['settings'] = $this->settingsRepository->all();
        $data['title'] = 'General Settings';
        $data['parentPageTitle'] = 'Settings';
        return view('dashboard.settings.index', $data);
    }

    public function update(Request $request)
    {
        $settings = $request->input('settings');

        foreach ($settings as $key => $data) {
            $this->settingsRepository->update($key, $data['value']);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }

    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'key' => 'required|unique:settings',
            'name' => 'required|string|max:255',
            'options' => 'nullable',
        ]);

        $value_type = $this->settingsRepository->mergeValueType($validate_data['name'],$validate_data['options']);

        $data['key'] = $validate_data['key'];
        $data['value_type'] = $value_type;

        $this->settingsRepository->create($data);

        return redirect()->route('settings.index')->with('success', 'Setting added successfully.');
    }



}
