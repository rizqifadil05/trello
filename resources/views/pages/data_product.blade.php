@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <form class="d-flex me-3" action="{{ route('data_obat.data') }}" method="GET">
                {{-- 1. tag form harus ada action sama method
                    2. value method GET/POST
                        - GET : form yg fungsinya untuk mencari
                        - POST : form yg fungsinya untuk menambah/menghapus/mengubah
                    3. input harus ada attr name, name => mengambil data dr isian input agar bisa di proses di controller
                    4. ada button/input yg type="submit"
                    5. action
                        - form untuk mencari : acu    tion ambil route yg menampilkan halaman blade ini (return view blade ini)
                        - form bukan mencari : action terpisah dengan route return view bladenya
                 --}}
                @if (Request::get('sort_stock') == 'stock')
                    <input type="hidden" name="sort_stock" value="stock">
                @endif
                <input type="text" name="cari" placeholder="Cari Nama Barang..." class="form-control me-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <form action="{{ route('data_obat.data') }}" method="GET" class="me-2">
                <input type="hidden" name="sort_stock" value="stock">
                <button type="submit" class="btn btn-primary">Urutkan Barang</button>
            </form>
            {{-- <button class="btn btn-success">+ Tambah</button> --}}

            <a href="{{ route('data_obat.tambah')}}" class="btn btn-success">+ Tambah</a>
        </div>

        @if(Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success')}}
        </div>
    @endif

        <table class="table table-stripped table-bordered mt-3 text-center">
            <thead>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                {{-- jika data obat kosong --}}
                @if (count($products) < 0)
                    <tr>
                        <td colspan="6">Data Obat Kosong</td>
                    </tr>
                @else
                {{-- $medicines : dari compact controller nya, diakses dengan loop karna data $medicines banyak (array) --}}
                    @foreach ($products as $index => $item)
                        <tr>
                            <td>{{ ($products->currentPage()-1) * ($products->perpage()) + ($index+1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}" style="cursor: pointer" onclick="showModalStock({{ $item['id']}}, {{ $item['stock']}})">{{ $item['stock'] }}</td>
                            {{-- $item['column_di_migration'] --}}
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('data_obat.ubah', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                {{-- showModalDelete mengirim data id untuk spesofok data yang dihapus, name untuk nama obat didalam modal--}}
                                {{-- $item dari foreach --}}
                                <button class="btn btn-danger" onclick="showModalDelete('{{ $item->id }}', '{{ $item->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- memanggil pagination --}}
        <div class="d-flex justify-content-end my-3">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="">
                @csrf
                {{-- menimpa method POST jadi delete sesuai web.php http-method --}}
                @method('DELETE')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">HAPUS DATA Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus Barang <b id="nama_product"></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Stock-->

    <div class="modal fade" id="modalEditStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="">
                @csrf
                {{-- menimpa method POST jadi delete sesuai web.php http-method --}}
                @method('PATCH')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Stock Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control">
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection



@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showModalDelete(id, name) {
        //memasukkan teks dari parameter ke html bagian id="nama_obat"
        $("#nama_product").text(name);
        let url = "{{ route('data_obat.hapus', ':id')}}";
        //isi path dinamis :id dari data parameter id
        url = url.replace(':id', id);
        // action="" di form diisi dengan url diatas
        $("form").attr("action", url);
        //memunculkan modal dengan id="exampleModal"
        $("#exampleModal").modal('show');
    }

    function showModalStock(id, stock) {
        //value iput id="stock"
        $("#stock").val(stock);
        let url = "{{ route('data_obat.ubah.stok', ':id')}}";
        url = url.replace(':id', id);
        $("form").attr('action', url);
        $("#modalEditStock").modal("show");

    }
    //jika error isset (ada with failed, modal jangan di close)
    //if menggunakan @ karna dia ngambil session (data dari bahasa php)
    @if(Session::get('failed'))
        //isi param id, stock di showModalStock ambil dari with controller updateStock
        $( document ).ready(function() {
            let id = "{{ Session::get('id') }}";
            let stock = "{{ Session::get('stock') }}";
            showModalStock(id, stock);
        })


    @endif
</script>
@endpush