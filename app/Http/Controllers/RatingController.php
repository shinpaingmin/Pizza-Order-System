<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // direct to review page
    public function reviewList() {
        $ratings = Rating::when(request('searchKey'), function($query) {
                            $query->orWhere('users.username', 'like', '%' . request('searchKey') . '%')
                                    ->orWhere('products.product_name', 'like', '%' . request('searchKey') . '%')
                                    ->orWhere('rating_count', 'like', '%' . request('searchKey') . '%');
                        })
                            ->select('ratings.*', 'users.username', 'products.product_name')
                            ->join('users', 'users.id', 'ratings.user_id')
                            ->join('products', 'products.id', 'ratings.product_id')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);

        return view('admin.review.list', compact('ratings'));
    }
}
