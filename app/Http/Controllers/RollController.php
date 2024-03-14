<?php

namespace App\Http\Controllers;

use App\Models\Roll;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class RollController extends Controller
{
    public function index(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');
        $sale = $request->sale ?? '';

        if ($sale == 'yes') {
            $rolls = Roll::orderBy('created_at', 'desc')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->has('sale')->get();
        } elseif ($sale == 'no') {
            $rolls = Roll::orderBy('created_at', 'desc')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->has('sale', 0)->get();
        } else{
            $rolls = Roll::orderBy('created_at', 'desc')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();
        }

        return view('pages.rolls.index', compact('rolls', 'start_date', 'end_date', 'sale'));
    }

    public function create()
    {
        return view('pages.rolls.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'size' => 'required|numeric',
            'weight' => 'required|numeric',
            'paper_weight' => 'required|numeric',
            'glue' => 'required|boolean',
        ]);

        Roll::create([
            'user_id'=> auth()->user()->id,
            'size'=> $request->size,
            'weight'=> $request->weight,
            'paper_weight'=> $request->paper_weight,
            'glue'=> $request->glue,
        ]);

        // 🛠Производство
        // 📦Товары: Рулон
        // 📐Формат: 104 см
        // 📏Плотность: 130 гр
        // 🔎Вес: 560 кг
        // ♻️Клей: Да
        // 📅 Дата: 9 фев 2024 15:07
        // 👨‍💻 Механик: Кодиржон Нурматов

        $text = "🛠Производство\n";
        $text .= "📦Товары: Рулон\n";
        $text .= "📐Формат: " . $request->size . " см\n";
        $text .= "📏Плотность: " . $request->paper_weight . " гр\n";
        $text .= "🔎Вес: " . $request->weight . " кг\n";
        $text .= "♻️Клей: " . ($request->glue ? 'Да' : 'Нет') . "\n";
        $text .= "📅 Дата: " . now()->format('j M Y H:i') . "\n";
        $text .= "👨‍💻 Механик: " . auth()->user()->fullname . "\n";

        TelegramService::sendChannel($text);

        flash('Рулон успешно создан', 'success');

        return redirect()->back();

    }

    public function show(Roll $roll)
    {
        return view('pages.rolls.show', compact('roll'));
    }

    public function edit(Roll $roll)
    {
        if ($roll->sale) {
            return back()->with('error','Рулон нельзя удалить, так как он участвует в продаже');
        }
        return view('pages.rolls.edit', compact('roll'));
    }

    public function update(Request $request, Roll $roll)
    {
        $request->validate([
            'size' => 'required|numeric',
            'weight' => 'required|numeric',
            'paper_weight' => 'required|numeric',
            'glue' => 'required|boolean',
        ]);

        return redirect()->route('rolls.index')->with('success','Рулон успешно обновлен');
    }

    public function destroy(Roll $roll)
    {
        if (time() - strtotime($roll->created_at) < 86400) {
            return redirect()->route('rolls.index')->with('error','Рулон можно удалить только через 24 часа после создания');
        }

        if ($roll->sale) {
            return back()->with('error','Рулон нельзя удалить, так как он участвует в продаже');
        }

        $roll->delete();
        return redirect()->route('rolls.index')->with('success','Рулон успешно удален');
    }
}
