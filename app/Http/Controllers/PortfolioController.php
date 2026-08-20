<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\PortfolioProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $profile = PortfolioProfile::query()->first()
            ?? new PortfolioProfile(PortfolioProfile::defaultAttributes());

        return view('portfolio', [
            'portfolio' => $profile->toPortfolioData(),
        ]);
    }

    public function contact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($validated);

        return redirect()
            ->to(url()->previous() . '#contact')
            ->with('status', 'Message received. I will get back to you soon.');
    }
}
