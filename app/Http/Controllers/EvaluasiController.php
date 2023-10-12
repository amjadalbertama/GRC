<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluasiController extends Controller
{
    public function getView()
    {
        $evaluasi = DB::table('evaluasi')->paginate(20);
        return view('pages.governance.evaluasi.index', ['evaluasi' => $evaluasi]);
    }

    public function add(Request $request)
    {

        DB::table('evaluasi')->insert([

            'title' => $request->title,
            'description' => $request->description,
            'owner' => $request->owner,
            'date' => $request->date,
            'name_org' => $request->name_org,
            'status' => $request->status,
        ]);

        return redirect('evaluasi')->with('addorg', 'Data Capabilites berhasil ditambahkan.');
    }

    public function delete($id)
    {
        DB::table('evaluasi')->where('id', $id)->delete();
        return redirect('evaluasi')->with('delete', 'Data Capabilites berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        DB::table('evaluasi')->where('id', $id)->update([

            'title' => $request->title,
            'description' => $request->description,
            'owner' => $request->owner,
            'date' => $request->date,
            'name_org' => $request->name_org,
            'status' => $request->status,
        ]);

        return redirect('evaluasi')->with('update', 'Data Capabilites berhasil diperbarui.');
    }
}
