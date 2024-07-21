<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Departemen;


class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $query = Departemen::query();
        $query->select('*');
        if(!empty($nama_dept)){
            $query->where('nama_dept', 'like', '%'.$nama_dept.'%');
        }
        $departemen = $query->get();
        //$departemen = DB::table('departemen')->orderBy('kode_dept')->get();
        return view('departemen.index', compact('departemen'));
    }

    public function store(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        $data = [
            'kode_dept' => $kode_dept,
            'nama_dept' => $nama_dept
        ];
        $simpan = DB::table('departemen')->insert($data);
        if($simpan){
            return redirect()->back()->with('success', 'Data Berhasil Disimpan');
        }else{
            return redirect()->back()->with('error', 'Data Gagal Disimpan');
        }
    }

    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departemen')->where('kode_dept', $kode_dept)->first();
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $kode_dept = $request->kode_dept;
        $data = [
            'nama_dept' => $nama_dept
        ];
        
        $update = DB::table('departemen')->where('kode_dept', $kode_dept)->update($data);
        if($update){
            return redirect()->back()->with('success', 'Data Berhasil Di Update');
        }else{
            return redirect()->back()->with('warning', 'Data Gagal Di Update');
        }
    }

    public function delete(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $delete = DB::table('departemen')->where('kode_dept', $kode_dept)->delete();
        if($delete){
            return redirect()->back()->with('success', 'Data Berhasil Di Hapus');
        }else{
            return redirect()->back()->with('warning', 'Data Gagal Di Hapus');
        }
    }
}
