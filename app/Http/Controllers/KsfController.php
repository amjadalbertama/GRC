<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KsfController extends Controller
{
    public function getView()
    {
        $ksf = DB::table('ksf')->paginate(20);
        return view('pages.governance.ksf.index',  ['ksf' => $ksf]);
    }

    public function add(Request $request)
    {

        DB::table('ksf')->insert([

            'title' => $request->title,
            'description' => $request->description,
            'owner' => $request->owner,
            'date' => $request->date,
            'name_org' => $request->name_org,
            'status' => $request->status,
        ]);

        return redirect('ksf')->with('addorg', 'Data ksf berhasil ditambahkan.');
    }

    public function delete($id)
    {
        DB::table('ksf')->where('id', $id)->delete();
        return redirect('ksf')->with('delete', 'Data ksf berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        DB::table('ksf')->where('id', $id)->update([

            'title' => $request->title,
            'description' => $request->description,
            'owner' => $request->owner,
            'date' => $request->date,
            'name_org' => $request->name_org,
            'status' => $request->status,
        ]);

        return redirect('ksf')->with('update', 'Data ksf berhasil diperbarui.');
    }
}
