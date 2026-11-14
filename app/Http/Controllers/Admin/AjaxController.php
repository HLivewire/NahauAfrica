<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Company;
use App\Models\Footer;
use App\Models\Header;
use App\Models\Menu;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Photogallery;
use App\Models\Settings;
use App\Models\Theme;
use App\Models\Videogallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function maanPublishStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'statustext' => 'required|string|max:60',
            'status' => 'required|integer|in:0,1',
        ]);

        $id = (int) $validated['id'];
        $status = (int) $validated['status'];
        $statustext = $validated['statustext'];

        switch ($statustext) {
            case 'Blog':
                Blog::where('id', $id)->update(['status' => $status]);
                break;
            case 'Video':
                Videogallery::where('id', $id)->update(['status' => $status]);
                break;
            case 'Photo':
                Photogallery::where('id', $id)->update(['status' => $status]);
                break;
            case 'News':
                News::where('id', $id)->update(['status' => $status]);
                break;
            case 'Breaking News':
                News::where('id', $id)->update(['breaking_news' => $status]);
                break;
            case 'Contact Us':
                Company::where('id', $id)->update(['status' => $status]);
                break;
            case 'News Category':
                Newscategory::where('id', $id)->update(['menu_publish' => $status]);
                break;
            case 'Footer Status':
                Footer::where('id', $id)->update(['status' => $status]);
                break;
            case 'Menu':
                Menu::where('id', $id)->update(['status' => $status]);
                break;
            case 'Header':
                Header::where('id', $id)->update(['status' => $status]);
                break;
            case 'Header Active':
                Header::where('id', '<>', $id)->update(['is_active' => 0]);
                Header::where('id', $id)->update(['is_active' => $status]);
                break;
            case 'Menu Active':
                Menu::where('id', '<>', $id)->update(['is_active' => 0]);
                Menu::where('id', $id)->update(['is_active' => $status]);
                break;
            case 'Footer Active':
                Footer::where('id', '<>', $id)->update(['is_active' => 0]);
                Footer::where('id', $id)->update(['is_active' => $status]);
                break;
            case 'Theme Active':
                Theme::where('id', '<>', $id)->update(['is_active' => 0]);
                Theme::where('id', $id)->update(['is_active' => $status]);
                break;
            default:
                return response()->json(['error' => 'Invalid status action.'], 422);
        }

        return response()->json([
            'status' => $status,
            'id' => $id,
            'statustext' => $statustext,
        ]);
    }

    public function maanPublishThemeColor(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'theme_color' => 'required|string|max:60|regex:/^[a-zA-Z0-9_\-]+$/',
        ]);

        $settings = Settings::latest('id')->first();
        if ($settings) {
            Settings::where('id', $settings->id)->update(['theme_color' => $validated['theme_color']]);
        }

        return response()->json([
            'status' => 1,
            'theme_color' => $validated['theme_color'],
        ]);
    }
}
