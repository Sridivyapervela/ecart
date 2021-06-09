<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartCountComposer
{
  /**
   * Bind data to the view.
   *
   * @param  \Illuminate\View\View  $view
   * @return void
   */
  public function compose(View $view)
  {
    if (Auth::user()) {
      $userId = Auth::user()->id;
      $count = Cart::where("user_id", $userId)->count();
      $view->with("count", $count);
    }
  }
}
