<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Nahau\Stories;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function ids(): array
    {
        return array_values(array_unique(array_map('intval', (array) session('nahau_cart', []))));
    }

    public function add(Request $request, int $news)
    {
        $story = Stories::query()->where('news.id', $news)->first();
        abort_unless($story && (int) $story->price > 0, 404);

        $ids = $this->ids();
        if (! in_array($news, $ids, true)) {
            $ids[] = $news;
        }
        session(['nahau_cart' => $ids]);

        return response()->json(['count' => count($ids), 'cart_url' => route('nahau.cart'), 'message' => __('Added to cart')]);
    }

    public function remove(Request $request, int $news)
    {
        session(['nahau_cart' => array_values(array_diff($this->ids(), [$news]))]);

        return $request->expectsJson() ? response()->json(['count' => count($this->ids())]) : redirect()->route('nahau.cart');
    }

    public function index()
    {
        $ids = $this->ids();
        $items = $ids ? Stories::query()->whereIn('news.id', $ids)->get()->filter(fn ($s) => (int) $s->price > 0)->values() : collect();
        $total = $items->sum('price');

        return view('nahau.cart', compact('items', 'total'));
    }
}
