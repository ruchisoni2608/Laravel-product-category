<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 8 CRUD</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .pull-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="container mt-2">

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2 class="text-center">Products List</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('Products.create') }}"> Create Product</a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-bordered ">
            <tr>
                <th>No.</th>
                <th>Product Image</th>
                <th>Product Name</th>
                {{-- <th>Product Description</th> --}}

                <th>Product Status</th>
                <th>Product Categories</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($Products as $Product)
                <tr>
                    <td>{{ $Product->id }}</td>
                    <td>
                        @if ($Product->images->count() > 0)
                            <div class="product-images">
                                @foreach ($Product->images as $image)
                                    <img src="{{ asset('images/' . $image->filename) }}" alt="Product Image" width="100px" height="100px">
                                @endforeach
                            </div>
                        @endif


                    </td>
                    <td>{{ $Product->name }}</td>
                    {{-- <td>{{ strip_tags( $Product->description) }}</td> --}}


                    <td>
                        @if ($Product->status)
                           Active
                        @else
                            Inactive
                        @endif
                    </td>
                    {{-- <td>
                        @foreach ($Product->categories as $category)
                            {{ $category->name }}
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td> --}}
                    <td>
                        <ul>
                            @foreach ($Product->categories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('Products.destroy', $Product->id) }}" method="Post">

                            <a class="btn btn-primary" href="{{ route('Products.edit', $Product->id) }}">Edit</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $Products->links() !!}

</body>

</html>
