<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Module extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Module')
            ->setDescriptionForEvent(fn (string $eventName) => "has been {$eventName} a module")
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }

    public function parent()
    {
        return $this->belongsTo(Module::class, 'parent_module_id');
    }

    public function children()
    {
        return $this->hasMany(Module::class, 'parent_module_id');
    }

    public function permission(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}
