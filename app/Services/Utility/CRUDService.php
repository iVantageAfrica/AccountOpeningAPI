<?php

namespace App\Services\Utility;

use App\Enum\ModelClassEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CRUDService
{
    public static function create(array $data, ModelClassEnum $modelClassEnum): Model | true
    {
        $modelClass = $modelClassEnum->value;
        return $modelClass::create($data);
    }

    public static function get(ModelClassEnum $modelClassEnum, array $conditions = []): Collection
    {
        $modelClass = $modelClassEnum->value;
        return $modelClass::where($conditions)->get();
    }

    public static function update(ModelClassEnum $modelClassEnum, mixed $primaryKey, array $data, string $primaryColumn = 'id'): Model|bool
    {
        $model = $modelClassEnum->value::where($primaryColumn, $primaryKey)->first();
        if (!$model) {
            return false;
        }
        $model->fill(array_filter($data, fn ($v) => $v !== null && $v !== ''))->save();
        return $model;
    }

    public static function delete(ModelClassEnum $modelClassEnum, mixed $primaryKey, string $primaryColumn = 'id'): bool
    {
        return (bool) $modelClassEnum->value::where($primaryColumn, $primaryKey)->delete();
    }
}
