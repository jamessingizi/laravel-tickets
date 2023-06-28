<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $content
 * @property string $subject
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $status
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
       return [
           'id' => $this->id,
           'subject' => $this->subject,
           'content' => $this->content,
           'name' => $this->name,
           'email' => $this->email,
           'status' => $this->status,
           'created_at' => $this->created_at,
           'updated_at' => $this->updated_at,
       ];
    }
}
