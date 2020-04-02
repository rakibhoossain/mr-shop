<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $roles = '';
        $count = 0;
        if( !empty($this->getRoleNames()) ){
            foreach ($this->getRoleNames() as $value) {
               $roles .="<label class='badge badge-success'>$value</label>";
               if($count > 1){
                $roles .= "<label class='badge badge-success'>...</label>";
                break;
               }
               $count++;
            }
        }

        $button_1 = "<li><a href=".route('admin.show', $this->id)."><i class='fa fa-eye' aria-hidden='true'></i></a></li>";
        $button_2 = "<li><a href=".route('admin.edit', $this->id)."><i class='fa fa-pencil-alt' aria-hidden='true'></i></a></li>";
        $button_3 = "<li><a href='#' data-url=".route('admin.destroy', $this->id)." class='sweet_confirm'><i class='fa fa-trash' aria-hidden='true'></i></a></li>";

        return[
          'name' => $this->name,
          'email' => $this->email,
          'roles' => $roles,
          'created_at' => \Carbon\Carbon::parse($this->created_at)->timestamp,
          'action' => "<ul class='nav tbl_btns'>".$button_1.$button_2.$button_3."</ul>",
        ];
    }
}