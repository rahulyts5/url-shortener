<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            // SuperAdmin sees ALL urls
            $urls = ShortUrl::latest()->get();

        } elseif ($user->hasRole('admin')) {
            // Admin sees urls in their own company
            $urls = ShortUrl::where('company_id', $user->company_id)->latest()->get();

        } elseif ($user->hasRole('member')) {
            // Member sees only their own urls
            $urls = ShortUrl::where('user_id', $user->id)->latest()->get();
        }

        return view('urls.index', compact('urls'));
    }

    public function create()
    {
        // SuperAdmin cannot create
        if (auth()->user()->hasRole('superadmin')) {
            abort(403, 'SuperAdmin cannot create short URLs.');
        }

        return view('urls.create');
    }

    public function store(Request $request)
    {
        // SuperAdmin cannot create
        if (auth()->user()->hasRole('superadmin')) {
            abort(403, 'SuperAdmin cannot create short URLs.');
        }

        $request->validate([
            'original_url' => 'required|url',
        ]);

        ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code'   => Str::random(6),
            'user_id'      => auth()->id(),
            'company_id'   => auth()->user()->company_id,
        ]);

        return redirect('/urls')->with('success', 'Short URL created successfully.');
    }

    // Publicly resolvable
    public function resolve($code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();
        $shortUrl->increment('click_count');
        return redirect($shortUrl->original_url);
    }

    public function destroy($id)
    {
        $shortUrl = ShortUrl::where('id', $id)
                            ->where('user_id', auth()->id())
                            ->firstOrFail();
        $shortUrl->delete();
        return redirect('/urls')->with('success', 'Short URL deleted.');
    }
}
