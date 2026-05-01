@extends('customer.pages.profil.layout')

@section('profil-content')
<h2 class="profil-section-title">👍 PRODUK YANG DISUKAI</h2>

@if($likedProducts->isEmpty())
    <p style="text-align:center; padding:40px;">Belum ada produk yang disukai</p>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:20px;">
        @foreach($likedProducts as $like)
        <div style="border:1px solid #eee; border-radius:8px; overflow:hidden;">
            <img src="{{ asset('storage/'.$like->product->image) }}" style="width:100%; height:150px; object-fit:cover;">
            <div style="padding:10px;">
                <h4>{{ $like->product->name }}</h4>
                <p>Rp {{ number_format($like->product->price,0,',','.') }}</p>
                <button onclick="unlike({{ $like->product->id }}, this)" class="btn-red" style="padding:5px 10px;">Batal Suka</button>
            </div>
        </div>
        @endforeach
    </div>
@endif

<script>
function unlike(productId, btn) {
    fetch(`/product/like/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => location.reload());
}
</script>
@endsection
