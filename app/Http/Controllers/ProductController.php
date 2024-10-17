<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //menampilkan data dari model yg menyimpan data obat
        // all() -> mengambil semua data dari table medicines model Medicine
        // orderBy('nama_kolom', 'asc/desc') -> mengurutkan data berdasarkan kolom tertentu
        // asc (ascending) -> urutkan data dari kecil ke besar (a-z/0-9)
        // desc (descending) ->  urutkan data dari besar ke kecil (z-a/9-0)
        // all() -> tanpa proses filter apapun
        // filter -> mengambil get()/paginate()/simpalePaginate()
        // simplePaginate(angka) -> mengambil data dengan pagination per halamannya jumlah data disimpan di kurung (5)
        // where('nama_kolom', 'operator', 'nilai') -> mencari data berdasarkan kolom tertentu dan isi tertentu (isinya yg dr input)
        // operator where : =, <, >, <=, >=, <>, LIKE
        // mengambil isi input : $request->name_input

        $orderBy = $request->sort_stock ? 'stock' : 'name';
        // appends : menambahkan/membawa request pagination (data-data pagination tidak berubah meskipun ada request)
        $products = product::where('name', 'LIKE', '%'.$request->cari.'%')->orderBy($orderBy, 'ASC')->simplePaginate(5)->appends($request->all());
        // compact() -> mengirimkan data ($) agar data $nya bisa dipake di blade
        return view('pages.data_obat', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);

        product::create($request->all());


        return redirect()->back()->with('success', 'Berhasil Menambah Barang!');
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = product::find($id);
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
            'price' => 'required|numeric'
        ],);

        product::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price
        ]);

        return redirect()->route('data_obat.data')->with('success', 'Berhasil Mengubah Barang!');
    }

    public function updateStock(Request $request, $id)
    {
        //karna nanti submit form stock tidak menggunakan ajax, jadi untuk mendeteksi old (riwayat isi) ketika input dikosongkan, pengecekan required menggunakan isset
        if (isset($request->stock) == FALSE) {
            $productBefore = product::find($id);
            return redirect()->back()->with(['failed' => 'Stock tidak boleh kosong!', 'id' => $id, 'stock' => $productBefore['stock']
            ]);
        }
        // jika tidak kosong, proses update
        product::where('id', $id)->update(['stock' => $request->stock ]);
        return redirect()->back()->with('success', 'Berhasil mengubah data stock!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //cari (where), lalu hapus (delete)
        product::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Barang!');
    }
}
