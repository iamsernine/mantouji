<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/update-jam.css') }}">
    <title>Update</title>
</head>
<body>
    <div class="container">
        <h2>Update Product</h2>
        <form action="{{ Route('updateProduct', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="input-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" id="image" value="{{ $product->image }}">
            </div>

            <div class="input-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" placeholder="Product name" value="{{ $product->name }}">
            </div>

            <button class="btn" type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>