<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ListingController extends Controller implements HasMiddleware
{
    //__middleware to check if the user is logged in and verified before accessing the routes__
    public static function middleware()
    {
        return [
            new Middleware(
                ['auth', 'verified', NotSuspended::class],
                except: ['index', 'show']
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $Listings = Listing::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user')
            //check  if the listing is approved first before the next query
            ->where('approved', true)
            ->filter(request(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('Home', [
            'listings' => $Listings,
            'searchTerm' => request('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);

        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Listing::class);

        //__convert the tags to an array__
        // $newTags = explode(',', $request->tags);
        //__remove any empty tags__
        // $newTags = array_map('trim', $newTags);
        // $newTags = array_filter($newTags);
        //__remove the duplicates__
        // $newTags = array_unique($newTags);
        //__convert the array back to a string__
        // $newTags = implode(',', $newTags);

        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'desc' => ['required'],
            'tags' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpg,jpeg,png,wepb'],
        ]);

        if ($request->hasFile('image')) {
            $fields['image'] = Storage::disk('public')->put('images/listing', $request->file('image'));
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));

        $request->user()->listings()->create($fields);

        return redirect()->route('dashboard')->with('status', 'Listing created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);

        return Inertia::render('Listing/Show', [
            'listing' => $listing,
            'user' => $listing->user->only('name', 'id'),
            'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        return Inertia::render('Listing/Edit', [
            'listing' => $listing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('modify', $listing);

        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'desc' => ['required'],
            'tags' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpg,jpeg,png,wepb'],
        ]);

        //differece between the store method = need to check if the image has requested to be updated
        if ($request->hasFile('image')) {

            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }

            $fields['image'] = Storage::disk('public')->put('images/listing', $request->file('image'));
        } else {
            $fields['image'] = $listing->image;
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));

        //update the listing and make it unapproved again in case the user wants to update the listing with the bad way
        $listing->update([...$fields, 'approved' => false]);

        return redirect()->route('dashboard')->with('status', 'Listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage. + check if got image attached then have to delete the image from db
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }

        $listing->delete();

        return redirect()->route('dashboard')->with('status', 'Listing deleted successfully.');
    }
}
