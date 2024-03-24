<?php

namespace App\Http\Controllers;

use App\Models\Find;
use Illuminate\Http\Request;

class FindController extends Controller
{
    public function index()
    {
        $finds = Find::all();
        return view('pages.finds.index', compact('finds'));
    }

    public function create()
    {
        return view('pages.finds.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Find::create($request->all());

        return redirect()->route('finds.index')->with('success', 'Find успешно создан');
    }

    public function show(Find $find)
    {
        return view('pages.finds.show', compact('find'));
    }

    public function edit(Find $find)
    {
        return view('pages.finds.edit', compact('find'));
    }

    public function update(Request $request, Find $find)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $find->update($request->all());

        return redirect()->route('finds.index')->with('success', 'Find успешно обновлен');
    }

    public function destroy(Find $find)
    {
        $find->delete();
        return redirect()->route('finds.index')->with('success', 'Find успешно удален');
    }

}
