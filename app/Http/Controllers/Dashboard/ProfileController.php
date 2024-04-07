<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('dashboard.profile.edit', [
            'user' => auth()->user(),
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'size:2']
        ]);
        $user = auth()->user();

        $user->profile->fill($request->all())->save();

        return redirect()->route('dashboard.profile.edit')->with('success', 'user profile updated successfully');

        ///////////////// Hints///////////////////
        // symfony intl => package for international countries and locals
        // put method must have param , patch didn't need to param most cases
    }
}
