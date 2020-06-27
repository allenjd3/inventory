
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Product Name: </label>
        <input type="text" id="name" class="form-control" name="name" value="{{old( 'name' )}}" />
        @error('name')
            <div class="text-danger">{{$message}}</div>
        @enderror

    </div>
    <div class="form-group">
        <label for="price">Cost of Product: </label>
        <input type="number" min="0.01" step="0.01" class="form-control" name="price" value="{{old('price')}}"/>
        @error('price')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="lawson_number">Lawson Number: </label>
        <input type="text" id="lawson_number" class="form-control" name="lawson_number" value="{{old('lawson_number')}}"/>
        @error('lawson_number')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-dark">Create New Product</button>

</form>
