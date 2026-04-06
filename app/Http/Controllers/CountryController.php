<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(){
        $countries = Country::all();
        return view('admin.countries.index', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries',
        ]);

        Country::create($validated);

        return redirect()->back()->with('success', 'Country added successfully!');
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
        ]);

        $country->update($validated);

        return redirect()->back()->with('success', 'Country updated!');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->back()->with('success', 'Country deleted!');
    }
}
