<?php
namespace App\Models;

use App\Enum\LeadStatus;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'message','user_name','service_id','status'];

    public function getType($value)
    {
        return LeadStatus::from($value);
    }

    public function setType($value)
    {
        if (!LeadStatus::tryFrom($value)) {
            throw new \InvalidArgumentException("Invalid state value: $value");
        }
        $this->attributes['type'] = $value;
    }

    public function service()
    {
        return $this->belongsTo(related: Service::class);
    }

    public function user()
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_name', ownerKey: 'name');
    }
}
