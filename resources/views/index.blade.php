@extends('layouts.plantilla')

@section('title', 'Nuestros productos | Tienda de productos')


@section('content')
<section class="jumbotron text-center">
    <div class="container">
        <h1 class="display-4 jumbotron-heading">Nuestros productos</h1>
    </div>
</section>  
<div class="container">
    <div class="row">
        @if (count($products) > 0)
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="https://place-hold.it/300x400" alt="{{ $product->name }}">
                        <div class="card-body">
                            <p class="card-text">
                                {{ $product->name }} <strong>{{ number_format($product->price, 2) }}€</strong>
                            </p>
                            @if ($product->description)
                                <p class="card-text">{{ $product->description }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View More</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        <div class="col-md-12">
            <div class="alert alert-warning">Sin productos por el momento :(</div>  
        </div>
            
        @endif
    </div>
</div>
@endsection