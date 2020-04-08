<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

    $button_1 = "<li><a href=".route('admin.order.show', $this->code)."><i class='fa fa-eye' aria-hidden='true'></i></a></li>";
    $button_2 = ( auth()->user()->can('order-edit') )? "<li><a href=".route('admin.order.edit', $this->code)."><i class='fa fa-pencil-alt' aria-hidden='true'></i></a></li>" : '';
    $button_3 = ( auth()->user()->can('order-delete') )? "<li><a href='#' data-url=".route('admin.order.destroy', $this->code)." class='sweet_confirm'><i class='fa fa-trash' aria-hidden='true'></i></a></li>" : '';
    
    return[
      'code' => $this->code,
      'name' => $this->user->name,
      'price' => number_format((float)($this->total_price), 2, '.', ''),
      'charge' => number_format((float)($this->charge), 2, '.', ''),
      'status' => \Helper::getLabelByStatus($this->status, 'badge'),
      'payment_status' => \Helper::getLabelByStatus($this->payment_status, 'badge'),
      'created_at' => \Carbon\Carbon::parse($this->created_at)->timestamp,
      'action' => "<ul class='nav tbl_btns'>".$button_1.$button_2.$button_3."</ul>",
    ];
    }
}
