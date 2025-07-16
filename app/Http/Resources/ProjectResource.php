<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_project' => $this->name,
            'deskripsi' => $this->description,
            'dibuat' => $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
