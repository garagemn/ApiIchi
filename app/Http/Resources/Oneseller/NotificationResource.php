<?php

namespace App\Http\Resources\Oneseller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'notificationid' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'isread' => $this->isread ? true : false,
            'date' => $this->created_at->format('Y-m-d')
        ];
    }
}
