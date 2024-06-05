<?php
namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;

class EloquentSettingRepository implements SettingRepositoryInterface
{
    protected $model;

    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($key, $value)
    {
        Setting::where('key', $key)->update(['value' => $value]);
    }

    public function delete($id)
    {
        $setting = $this->model->find($id);
        if ($setting) {
            $setting->delete();
            return true;
        }
        return false;
    }

    public function mergeValueType($name, $options)
    {
        $data['name'] = $name;
        $data['options'] = $options;
        return json_encode($data);
    }
}
