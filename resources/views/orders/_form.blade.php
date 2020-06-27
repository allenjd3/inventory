<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{$product->id}}"/>
    <div class="form-group">
        <label for="quantity">Quantity: </label>
        <input id="quantity" type="number" min="1" step="1" name="quantity" value="{{old('quantity')}}" class="form-control" />
        @error('quantity')
         <div class="text-danger"> {{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="due_date">Due Date: </label>
        <input type="date" id="due_date" name="due_date" value="{{old('due_date')}}" class="form-control" />
        @error('due_date')
         <div class="text-danger"> {{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="requisition">Requisition #: </label>
        <input type="text" id="requisition" name="requisition" value="{{old('requisition')}}" class="form-control" />
        @error('requistion')
         <div class="text-danger"> {{ $message }}</div>
        @enderror
    </div>
    <button class="btn btn-dark" type="submit">New Order</button>
</form>

