<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;


class HouseController extends Controller
{
     public function index()
    {
        $houses = auth()->user()->houses; // ログインユーザーに関連する家を取得
        return view('houses.index', compact('houses'));
    }

    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'building' => 'required|in:平屋,２階建て,３階建て',
            'interior' => 'required|in:モダン,ナチュラル,その他',
            'budget' => 'required|in:1000万未満,3000万未満,5000万未満,1億未満,その他',
            'hobby' => 'required|string',
        ]);

        auth()->user()->houses()->create($request->all());

        return redirect()->route('houses.index')->with('success', '家の情報が登録されました。');
    }

    public function edit(House $house)
    {
        return view('houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        $request->validate([
            'building' => 'required|in:平屋,２階建て,３階建て',
            'interior' => 'required|in:モダン,ナチュラル,その他',
            'budget' => 'required|in:1000万未満,3000万未満,5000万未満,1億未満,その他',
            'hobby' => 'required|string',
        ]);

        $house->update($request->all());

        return redirect()->route('houses.index')->with('success', '家の情報が更新されました。');
    }

    public function destroy(House $house)
    {
        $house->delete();

        return redirect()->route('houses.index')->with('success', '家の情報が削除されました。');
    }
}
