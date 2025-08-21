<?php

namespace App\Http\Resources\Warehouse\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarmodelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'groupid' => $this->id,
            'groupname' => $this->modelname,
            'manuid' => $this->manuid,
            'childrens' => $this->children->map(function($model) {
                return [
                    'modelid' => $model->modelid,
                    'modelname' => $model->modelname,
                    'yearstart' => $model->yearstart,
                    'yearend' => $model->yearend,
                    'groupid' => $model->groupid,
                    'imgurl' => $this->imgurl,
                ];
            }),
        ];
    }
}
