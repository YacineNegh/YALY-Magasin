<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'admin' => auth()->user(),
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['password_confirmation']);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $request->user()->update($data);

        return back()->with('success', 'Settings updated.');
    }
}
