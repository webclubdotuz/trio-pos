<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function index(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $papers = \App\Models\Paper::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('pages.papers.index', compact('papers', 'start_date', 'end_date'));
    }

    public function show($id)
    {
        $paper = \App\Models\Paper::find($id);

        return view('pages.papers.show', compact('paper'));
    }

    public function create()
    {
        $papers = \App\Models\Paper::orderBy('id', 'desc')->limit(10)->get();

        return view('pages.papers.create', compact( 'papers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'paket_id' => 'required',
            'quantity' => 'required',
        ]);

        $paper = \App\Models\Paper::create([
            'product_id' => $request->product_id,
            'paket_id' => $request->paket_id,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'user_amount' => 500 * $request->quantity,
        ]);

        return redirect()->route('papers.create')->with('success', 'Бумага успешно добавлена');
    }

    public function destroy($id)
    {
        $paper = \App\Models\Paper::find($id);

        //24 hours
        if (time() - strtotime($paper->created_at) > 86400) {
            return redirect()->route('papers.index')->with('error', 'Бумагу нельзя удалить, прошло больше 24 часов');
        }

        $paper->delete();

        return redirect()->route('papers.index')->with('success', 'Бумага успешно удалена');
    }
}
