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

    public function update($id, array $data)
    {
        $setting = $this->model->find($id);
        if ($setting) {
            $setting->update($data);
            return $setting;
        }
        return null;
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
}
