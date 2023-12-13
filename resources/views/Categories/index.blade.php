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
                            @foreach ($categories as $category)
                                <tr id="row{{ $category->id }}">
                                    <td>
                                        <input type="text" name="name[]" value="{{ $category->name }}"
                                            placeholder="Enter your Name" class="form-control name_list" />
                                    </td>
                                    <td>
                                        <select name="parent_category[]" class="form-control parent_category_select"
                                            data-selected-value="{{ $category->parent_category }}">
                                            <option value="0">No Parent Category</option>
                                            {!! $DropdownOptions[$category->id] !!}
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" name="edit" id="{{ $category->id }}"
                                            class="btn btn-primary btn_edit">Edit</button>
                                        <button type="button" name="remove" id="{{ $category->id }}"
                                            class="btn btn-danger btn_remove">X</button>
                                        <button type="button" name="save" id="{{ $category->id }}"
                                            class="btn btn-success btn_save" style="display: none;">Save</button>
                                        <button type="button" name="cancel" id="{{ $category->id }}"
                                            class="btn btn-secondary btn_cancel" style="display: none;">Cancel</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <button type="button" name="add" id="add" class="btn btn-primary">Add
                            More</button><br><br>
                        <input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit">
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var i = {{ count($categories) }};
            var categoriesData = @json($NestedCategories);

            function buildDropdownOptions(categories, indentation = '') {
                var options = '';

                categories.forEach(function(category) {
                    var hyphens = '&nbsp;&nbsp;&nbsp;&nbsp;'.repeat(category.depth);
                    options += '<option value="' + category.id + '">' + hyphens + '-- ' + category.name +
                        '</option>';

                    if (category.children && category.children.length > 0) {
                        options += buildDropdownOptions(category.children, '&nbsp;&nbsp;&nbsp;&nbsp;' +
                            hyphens);
                    }
                });

                return options;
            }


            $(".parent_category_select").each(function() {
                var selectedValue = $(this).data('selected-value');
                var dropdownOptions = buildDropdownOptions(categoriesData);
                $(this).html('<option value="0">No Parent Category</option>' + dropdownOptions);
                $(this).val(selectedValue);
            });


            // Define dropdownOptions variable
            var dropdownOptions = buildDropdownOptions(categoriesData);

            $("#add").click(function() {

                i++;
                var newRow = '<tr id="row' + i + '">';
                newRow +=
                    '<td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>';
                newRow += '<td><select name="parent_category[]" class="form-control">';
                newRow += '<option value="0">No Parent Category</option>';
                newRow += dropdownOptions; // Enclose the variable in quotes
                newRow += '</select></td>';
                newRow += '<td><button type="button" name="remove" id="' + i +
                    '" class="btn btn-danger btn_remove">X</button></td>';
                newRow += '</tr>';
                $('#dynamic_field').append(newRow);
            });
            // Set selected attribute for existing records
            $(".parent_category_select").each(function(index, element) {
                var selectedValue = $(element).data('selected-value');
                $(element).find('option[value="' + selectedValue + '"]').attr('selected', 'selected');
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

            $(".btn_edit").on("click", function() {
                var category_id = $(this).attr("id");
                var row = $("#row" + category_id);

                // Store original values
                var originalName = row.find("input[name='name[]']").val();
                var originalParent = row.find("select[name='parent_category[]']").val();

                // Hide edit button and show save and cancel buttons
                row.find(".btn_edit").hide();
                row.find(".btn_remove").hide();
                row.find(".btn_save").show();
                row.find(".btn_cancel").show();

                // Enable editing
                row.find("input[name='name[]']").prop("readonly", false);
                row.find("select[name='parent_category[]']").prop("disabled", false);

                // Cancel editing
                row.find(".btn_cancel").on("click", function() {
                    row.find("input[name='name[]']").val(originalName);
                    row.find("select[name='parent_category[]']").val(originalParent);

                    // Hide save and cancel buttons and show edit button
                    row.find(".btn_save").hide();
                    row.find(".btn_cancel").hide();
                    row.find(".btn_edit").show();
                    row.find(".btn_remove").show();

                    // Disable editing
                    row.find("input[name='name[]']").prop("readonly", true);
                    row.find("select[name='parent_category[]']").prop("disabled", true);
                });

                // Save changes
                row.find(".btn_save").on("click", function() {
                    var newName = row.find("input[name='name[]']").val();
                    var newParent = row.find("select[name='parent_category[]']").val();

                    // Send AJAX request to update data
                    $.ajax({
                        url: "/Categories/" + category_id,
                        type: "PUT",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: {
                            name: newName,
                            parent_category: newParent,
                        },
                        success: function(result) {

                            alert(result.message); // Display a success message

                            // Update the content in the row
                            row.find("input[name='name[]']").val(newName);
                            row.find("select[name='parent_category[]']").val(newParent);


                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.message);
                        },
                    });
                });
            });
        });
    </script>


</body>

</html>
