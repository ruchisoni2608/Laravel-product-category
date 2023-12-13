<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .cat{
      text-align:center;
      margin-top:15px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
      <h2 class="cat">Category</h2>
      <div class="form-group">
        <form name="add_name" id="add_name">
          <table class="table table-bordered table-hover" id="dynamic_field">
            <tr>
              <td>
                <input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" />
              </td>
              <td>
                <select name="category[]" class="form-control">
                  <option value="category1">Category 1</option>
                  <option value="category2">Category 2</option>
                  <option value="category3">Category 3</option>
                  <!-- Add more options as needed -->
                </select>
              </td>

              <td>
                <button type="button" name="remove" id="1" class="btn btn-danger btn_remove">X</button>
              </td>
            </tr>
          </table>
          <button type="button" name="add" id="add" class="btn btn-primary">Add More</button><br><br>
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

  var i = 1;

  $("#add").click(function() {
    i++;
    $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><select name="category[]" class="form-control"><option value="category1">Category 1</option><option value="category2">Category 2</option><option value="category3">Category 3</option></select></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
  });

  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
  });

  $("#submit").on('click', function(event) {
    var formdata = $("#add_name").serialize();
    event.preventDefault();

    $.ajax({
      url: window.location.href,
      type: "POST",
      data: formdata,
      cache: false,
      success: function(result) {
        alert(result);
        $("#add_name")[0].reset();
      }
    });

  });
});
</script>
</body>
</html>
