@extends('customer.pages.profil.layout')

@section('profil-content')
<h2 class="profil-section-title">❤️ WISHLIST SAYA</h2>

@if($wishlists->isEmpty())
    <p style="text-align:center; padding:40px;">Wishlist masih kosong</p>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:20px;">
        @foreach($wishlists as $item)
        @php
            $product = $item->product;
            
            // LOGIC GAMBAR SAMA KAYAK DI MENU
            $imgRaw = $product->image;
            if ($imgRaw && str_starts_with($imgRaw, 'images/')) {
                $imgSrc = asset($imgRaw);
            } elseif ($imgRaw) {
                $imgSrc = asset('storage/' . $imgRaw);
            } else {
                $fallback = ['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg'];
                $imgSrc = asset('images/products/' . $fallback[$product->id % count($fallback)]);
            }
        @endphp
        <div style="border:1px solid #eee; border-radius:8px; overflow:hidden; background:white;">
            <a href="{{ route('customer.product.show', $product->id) }}" style="text-decoration:none; color:inherit;">
                <img src="{{ $imgSrc }}" 
                     style="width:100%; height:150px; object-fit:cover;"
                     onerror="this.src='{{ asset('images/products/1.jpg') }}'">
                <div style="padding:10px;">
                    <h4 style="margin:0 0 5px 0; font-size:14px; color:#333;">{{ $product->name }}</h4>
                    <p style="margin:0 0 10px 0; font-size:16px; font-weight:bold; color:#e74c3c;">
                        Rp {{ number_format($product->price,0,',','.') }}
                    </p>
                </div>
            </a>
            <div style="padding:0 10px 10px 10px;">
                <form action="{{ route('wishlist.destroy', $item) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" style="width:100%; padding:8px; background:#e74c3c; color:white; border:none; border-radius:5px; cursor:pointer;" onclick="return confirm('Hapus dari wishlist?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection