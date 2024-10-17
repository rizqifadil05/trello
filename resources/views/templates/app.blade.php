<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Toko Online</title>
    {{-- asset : memanggil file yg ada di folder public biasanya untuk css,js atau gambar/file tambahan --}}
    {{-- <link rel="icon" href="{{ asset('images/logo.jpg') }}"> --}}
    
    @stack('style')
</head>

<body>
    <main>
        <header>
            <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #025464">
              <div class="container">
                <a class="navbar-brand" href="#">Toko Online</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end gap-4" id="navbarSupportedContent">
                  <ul class="navbar-nav gap-4">
                    <li class="nav-item">
                      <a class="nav-link fs-5 active {{ Route::is('welcome') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link fs-5 {{ Route::is('data_obat') ? 'active' : '' }}" href="{{ route('data_obat.data') }}">Data Barang</a>
                    </li>
                  </ul>

                </div>
              </div>
            </nav>
          </header>

        {{-- yield : mengisi bagian content dinamis/bagian yg akan berubah-ubah di tiap halamannya --}}
        @yield('content-dinamis')

        <footer>
            
          </footer>

        {{-- CDN Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>

        {{-- stack : tidak wajib diisi oleh view yg extends nya (optional), kalau yield wajib diisi oleh view extends nya --}}
        @stack('script')
    </main>
</body>

</html>
