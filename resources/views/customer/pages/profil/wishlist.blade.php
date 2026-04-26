@extends('customer.pages.profil.layout')

@section('profil-content')
<h2 class="profil-section-title">❤️ WISHLIST SAYA</h2>

@if($wishlists->isEmpty())
    <p style="text-align:center; padding:40px;">Wishlist masih kosong</p>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:20px;">
        @foreach($wishlists as $item)
        <div style="border:1px solid #eee; border-radius:8px; overflow:hidden;">
            <img src="{{ asset('storage/'.$item->product->image) }}" style="width:100%; height:150px; object-fit:cover;">
            <div style="padding:10px;">
                <h4>{{ $item->product->name }}</h4>
                <p>Rp {{ number_format($item->product->price,0,',','.') }}</p>
                <form action="{{ route('wishlist.destroy', $item) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-red" style="padding:5px 10px;">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
