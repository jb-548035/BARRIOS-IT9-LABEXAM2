<?php

namespace App\Http\Controllers;

use App\Models\RiceItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiceItemController extends Controller
{
    public function index(): View
    {
        $riceItems = RiceItem::orderBy('name')->get();

        return view('menu.index', compact('riceItems'));
    }

    public function create(): View
    {
        return view('menu.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_available' => 'sometimes|boolean',
        ]);

        $data['is_available'] = $request->has('is_available');

        RiceItem::create($data);

        return redirect()->route('menu.index')
            ->with('success', 'Rice product added successfully.');
    }

    public function show(RiceItem $riceItem): View
    {
        // Ensure the rice item exists
        if (!$riceItem) {
            abort(404, 'Rice product not found.');
        }

        return view('menu.show', compact('riceItem'));
    }

    public function edit(RiceItem $riceItem): View
    {
        // Ensure the rice item exists
        if (!$riceItem) {
            abort(404, 'Rice product not found.');
        }

        return view('menu.edit', compact('riceItem'));
    }

    public function update(Request $request, RiceItem $riceItem): RedirectResponse
    {
        // Ensure the rice item exists
        if (!$riceItem) {
            return redirect()->route('menu.index')
                ->with('error', 'Rice product not found.');
        }

        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price_per_kg' => 'required|numeric|min:0',
                'stock_quantity' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'is_available' => 'sometimes|boolean',
            ]);

            $data['is_available'] = $request->has('is_available');

            $riceItem->update($data);

            return redirect()->route('menu.index')
                ->with('success', 'Rice product updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Menu update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update rice product. Please try again.');
        }
    }

    public function destroy(RiceItem $riceItem): RedirectResponse
    {
        // Ensure the rice item exists
        if (!$riceItem) {
            return redirect()->route('menu.index')
                ->with('error', 'Rice product not found.');
        }

        $riceItem->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Rice product deleted successfully.');
    }
}