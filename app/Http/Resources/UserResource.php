<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $button_1 = "<li><a href=".route('user.show', $this->id)."><i class='fa fa-eye' aria-hidden='true'></i></a></li>";
        $button_2 = ( auth()->user()->can('user-edit') )? "<li><a href=".route('user.edit', $this->id)."><i class='fa fa-pencil-alt' aria-hidden='true'></i></a></li>" : '';
        $button_3 = ( auth()->user()->can('user-delete') )? "<li><a href='#' data-url=".route('user.destroy', $this->id)." class='sweet_confirm'><i class='fa fa-trash' aria-hidden='true'></i></a></li>" : '';
        return[
          'name' => $this->name,
          'email' => $this->email,
          'created_at' => \Carbon\Carbon::parse($this->created_at)->timestamp,
          'action' => "<ul class='nav tbl_btns'>".$button_1.$button_2.$button_3."</ul>",
        ];
    }
}
