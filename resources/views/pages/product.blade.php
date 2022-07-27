@extends('layouts.master')
@section('content')
<div class="row">
        @if(!empty($data))
                <div class="col l-12 m-12 c-12">
                    <div class="grid wide container">
                    <div class="row">
                    
                    @foreach($data as $cloth)
                        <div class='col l-3 m-6 c-12 product-card-item'>
                            <div class="product-container">
                            <img class="product-img" src="{{ url('storage/images/'.$cloth->image) }}" alt="dress"></a>
                                <div class="bg-hover"> 
                                    <button type="submit" class="add-cart-btn">Add to cart</button>
                                    <div class="img-bg-wrap"></div>
                                    </div>
                                    </div>
                                    <div class="product-info">
                
                                    <p class="product-name">{{$cloth->name}}</p>
            <p class="product-price">{{$cloth->price}}</p>
            </div>
            </div>

@endforeach
</div>
</div>
@endif
</div>
@endsection
