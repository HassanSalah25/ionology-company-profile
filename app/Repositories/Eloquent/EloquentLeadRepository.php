<?php
namespace App\Repositories\Eloquent;

use App\Models\Lead;
use App\Repositories\Contracts\LeadRepositoryInterface;

class EloquentLeadRepository implements LeadRepositoryInterface
{
    protected $model;

    public function __construct(Lead $lead)
    {
        $this->model = $lead;
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
        $lead = $this->model->find($id);
        if ($lead) {
            $lead->update($data);
            return $lead;
        }
        return null;
    }

    public function delete($id)
    {
        $lead = $this->model->find($id);
        if ($lead) {
            $lead->delete();
            return true;
        }
        return false;
    }

    public function filter(array $filters = [])
    {
        $query = Lead::query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['message'])) {
            $query->where('message', 'like', '%' . $filters['message'] . '%');
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
