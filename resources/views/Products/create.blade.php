@php
    use App\Helpers\CategoryHelper;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 8 CRUD product </title>



    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <!-- CKEditor script from CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>


    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <style type="text/css">
        .dropdown-toggle {
            height: 40px;
            width: 400px !important;
        }

        .col-md-12 {
            margin-bottom: 15px;
        }

        .pull-right {
            text-align: right;
        }

        /* for switch button */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>

    <div class="container mt-2">

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2 class="text-center">Add Products</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('Products.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif


        <form action="{{ route('Products.store') }}" method="POST" enctype="multipart/form-data"
            id="my-awesome-dropzone" class="dropzone">
            @csrf

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Products Name">

                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> Description:</strong>
                        <div id="editor">This is some sample content.</div>
                        <textarea name="description" style="display: none;"></textarea> <!-- Hidden textarea for CKEditor content -->

                    </div>
                </div>
                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Products Status:</strong>
                        <label>
                            <input type="radio" name="status" value="0" checked> Active
                        </label>
                        <label>
                            <input type="radio" name="status" value="1"> Inactive
                        </label>
                    </div>
                </div> --}}
                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">
                        <strong> Status:</strong>
                        <label class="switch">
                            <input type="checkbox" name="status" value="1" checked>
                            <span class="slider round"></span>
                        </label>

                    </div>
                </div>




                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="">
                        <label><strong>Select Category :</strong></label><br />
                        <select class="selectpicker" multiple name="cat[]">
                            <?php
                                $categoryHelper = new \App\Helpers\CategoryHelper();
                                echo $categoryHelper->generateDropdownOptions($nestedCategories, $selectedCategories);
                            ?>
                        </select>
                    </div>
                </div>


                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="">
                        <label><strong>Select Category :</strong></label><br />
                        <select class="selectpicker" multiple data-live-search="true" name="cat[]">
                            <option value="php">PHP</option>
                            <option value="react">React</option>
                            <option value="jquery">JQuery</option>
                            <option value="javascript">Javascript</option>
                            <option value="angular">Angular</option>
                            <option value="vue">Vue</option>
                        </select>
                    </div>
                </div> --}}

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Image:</strong>

                        <input type="file" name="images[]" multiple />
                    </div>
                </div>



                {{-- <button type="submit" id="submitBtn" class="btn btn-primary ml-3">Submit</button> --}}


                <button type="submit" id="submitBtn" class="btn btn-primary ml-3">Submit</button>
            </div>

        </form>


    </div>
    <!-- Initialize the plugin -->

    <!-- Initialize the plugin: -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('select').selectpicker();
        });
    </script>


    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);

                // Update the hidden textarea with CKEditor content before form submission
                editor.model.document.on('change:data', () => {
                    document.querySelector('textarea[name="description"]').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var myDropzone = new Dropzone('#my-awesome-dropzone', {
                autoProcessQueue: false,
                url: "{{ route('Products.store') }}",
                // Other Dropzone options
                uploadMultiple: true,
                addRemoveLinks: true,
                init: function() {
                    this.on('success', function(file, response) {
                        // Redirect to index page after successful submission
                        window.location.href = "{{ route('Products.index') }}";
                    });
                }
            });

            $("#submitBtn").click(function(e) {
                e.preventDefault();
                myDropzone.processQueue();
            });
        });
    </script>


</body>

</html>
