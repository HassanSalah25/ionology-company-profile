<?php
namespace App\Repositories\Eloquent;

use App\Models\CompanyInfo;
use App\Models\Service;
use App\Repositories\Contracts\CompanyInfoRepositoryInterface;

class EloquentCompanyInfoRepository implements CompanyInfoRepositoryInterface
{
    protected $model;

    public function __construct(CompanyInfo $company_info)
    {
        $this->model = $company_info;
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
        $company_info = $this->model->find($id);
        if ($company_info) {
            $company_info->update($data);
            return $company_info;
        }
        return null;
    }

    public function delete($id)
    {
        $company_info = $this->model->find($id);
        if ($company_info) {
            $company_info->delete();
            return true;
        }
        return false;
    }

    public function filter(array $filters = [])
    {
        $query = Service::query();

        if (isset($filters['name'])) {
            $query->whereTranslation('name', 'like', '%' . $filters['name'] . '%');
        }
        //'description', 'address', 'phone', 'email'
        if (isset($filters['description'])) {
            $query->whereTranslation('description', 'like', '%' . $filters['description'] . '%');
        }

        if (isset($filters['phone'])) {
            $query->where('phone', 'like', '%' . $filters['phone'] . '%');
        }

        if (isset($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        return $query->get();
    }
}
