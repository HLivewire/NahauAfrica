<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\NahauFavorite;
use App\Nahau\Stories;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /** Add or remove a story from the signed-in reader's favourites. */
    public function toggle(Request $request, int $news)
    {
        $user = auth('maanuser')->user();
        if (! $user) {
            return response()->json(['login' => true, 'message' => __('Please log in to save favourites.')], 401);
        }
        if (! Stories::query()->where('news.id', $news)->exists()) {
            abort(404);
        }

        $row = NahauFavorite::where('maanuser_id', $user->id)->where('news_id', $news)->first();
        if ($row) {
            $row->delete();
            $on = false;
        } else {
            NahauFavorite::create(['maanuser_id' => $user->id, 'news_id' => $news]);
            $on = true;
        }

        return response()->json(['favorite' => $on]);
    }

    public function index()
    {
        $user = auth('maanuser')->user();
        if (! $user) {
            return redirect(nroute('home'))->with('message', __('Please log in to see your favourites.'))->with('type', 'warning');
        }
        $ids = NahauFavorite::where('maanuser_id', $user->id)->latest()->pluck('news_id');
        $stories = $ids->isEmpty() ? collect() : Stories::query()->whereIn('news.id', $ids)->get()->sortBy(fn ($s) => $ids->search($s->id))->values();

        return view('nahau.favorites', compact('stories'));
    }
}
