<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">



</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h2 class="cat">Category</h2>
                <div class="form-group">
                    <form name="add_name" id="add_name" action="{{ route('Categories.store') }}" method="POST">
                        @csrf
                        <table class="table table-bordered table-hover" id="dynamic_field">
                            <tr>
                                <th>Name</th>
                                <th>Parent Category</th>
                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($Categories as $index => $company)
                                <tr id="row{{ $index }}">
                                    <td>
                                        <input type="text" name="name[]" value="{{ $company->name }}" placeholder="Enter your Name" class="form-control name_list" />
                                    </td>
                                    <td>
                                        <select name="parent_category[]" class="form-control">
                                            <option value="0">No Parent Category</option>
                                            @foreach ($Categories as $subCategory)
                                                <option value="{{ $subCategory->id }}" {{ $company->parent_category == $subCategory->id ? 'selected' : '' }}>
                                                    @if ($subCategory->id != 0)
                                                        {{ $subCategory->id }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" name="remove" id="{{ $index }}" class="btn btn-danger btn_remove">X</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <button type="button" name="add" id="add" class="btn btn-primary">Add More</button><br><br>
                        <input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit">
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
<script>






</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    var i = {{ count($Categories) }};
    var parentCategories = @json($Categories->pluck('id'));

    $("#add").click(function() {
        i++;
        var newRow = '<tr id="row' + i + '">';
        newRow += '<td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>';
        newRow += '<td><select name="parent_category[]" class="form-control">';
        newRow += '<option value="0">No Parent Category</option>';
        for (var id in parentCategories) {
            newRow += '<option value="' + parentCategories[id] + '">' + parentCategories[id] + '</option>';
        }
        newRow += '</select></td>';
        newRow += '<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td>';
        newRow += '</tr>';
        $('#dynamic_field').append(newRow);
    });



    $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $.ajax({
        url: '/Categories/' + button_id, // Note the uppercase 'Categories'
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result) {
            alert(result.message);
            $('#row' + button_id).remove();
        },
        error: function(xhr) {
            alert(xhr.responseJSON.message);
        }
    });
});




    $("#add_name").on('submit', function(event) {
        event.preventDefault();
        var formdata = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formdata,
            success: function(result) {
                alert(result);
                location.reload();
            }
        });
    });
});
</script>


</body>
</html>
