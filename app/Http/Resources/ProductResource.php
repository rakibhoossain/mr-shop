<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $brand = ($this->brand)? $this->brand->name : '';
    $image = ($this->image)? "<img src='".asset($this->image)."' width='50' height='50'>" : '';
    $button_1 = "<li><a href=".route('admin.product.show', $this->slug)."><i class='fa fa-eye' aria-hidden='true'></i></a></li>";
    $button_2 = ( auth()->user()->can('product-edit') )? "<li><a href=".route('admin.product.edit', $this->slug)."><i class='fa fa-pencil-alt' aria-hidden='true'></i></a></li>" : '';
    $button_3 = ( auth()->user()->can('product-delete') )? "<li><a href='#' data-url=".route('admin.product.destroy', $this->slug)." class='sweet_confirm'><i class='fa fa-trash' aria-hidden='true'></i></a></li>" : '';

    return[
      'code' => $this->code,
      'name' => $this->name,
      'image' => $image,
      'purchase_price' => $this->purchase_price,
      'sell_price' => $this->sell_price,
      'offer_price' => $this->price,
      'categories' => $this->categories->implode('name', ', '),
      'brand' => $brand,
      'type' => $this->type,
      'created_at' => \Carbon\Carbon::parse($this->created_at)->timestamp,
      'action' => "<ul class='nav tbl_btns'>".$button_1.$button_2.$button_3."</ul>",
    ];
  }
}