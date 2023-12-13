@php
    use App\Helpers\CategoryHelper;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Form - Laravel 8 CRUD </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CKEditor script from CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <style>
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

        input:checked + .slider {
          background-color: #2196F3;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
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
                <div class="pull-left">
                    <h2>Edit Products</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('Products.index') }}">
                        Back</a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('Products.update', $Product->id) }}" method="POST" enctype="multipart/form-data"
            id="my-awesome-dropzone" class="dropzone">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> Name:</strong>
                        <input type="text" name="name" value="{{ $Product->name }}" class="form-control"
                            placeholder="Products name">
                        @error('name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> Description:</strong>
                        <div id="editor">{{ strip_tags($Product->description) }}</div>
                        <textarea name="description" style="display: none;"></textarea>
                        <!-- Hidden textarea for CKEditor content -->
                    </div>
                </div>


                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Products Status:</strong>
                        <label>
                            <input type="radio" name="status" value="0"
                                {{ $Product->status == '0' ? 'checked' : '' }}> Active
                        </label>
                        <label>
                            <input type="radio" name="status" value="1"
                                {{ $Product->status == '1' ? 'checked' : '' }}> Inactive
                        </label>
                    </div>
                </div> --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> Status:</strong>
                        <label class="switch">
                            <input type="checkbox" name="status" value="0" {{ $Product->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="">
                        <label><strong>Select Category :</strong></label><br />
                        <select class="selectpicker" multiple name="cat[]">
                            @php
                                $helper = new \App\Helpers\CategoryHelper();
                                echo $helper->generateDropdownOptions($nestedCategories, $selectedCategories);
                            @endphp
                        </select>
                    </div>
                </div>




                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Products images (Existing):</strong>
                        @foreach ($Product->images as $image)
                            <img src="{{ asset('images/' . $image->filename) }}" alt="Product Image"
                                class="img-thumbnail">
                        @endforeach
                    </div>
                </div> --}}

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> images (File Input):</strong>
                        <input type="file" name="file[]" multiple />
                    </div>
                </div>

                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Products images (Dropzone):</strong>
                        <div id="my-awesome-dropzone" class="dropzone"></div>
                    </div>
                </div> --}}


                <button type="submit" id="submitBtn" class="btn btn-primary ml-3">Update</button>
            </div>

        </form>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Dropzone JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

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
    {{-- <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var myDropzone = new Dropzone('#my-awesome-dropzone', {
                autoProcessQueue: false,
                url: "{{ route('Products.update', $Product->id) }}", // Change this to the appropriate route for uploading images
                paramName: "file", // Change this to match the name attribute of your file input
                // maxFilesize: 2, // Set the maximum file size in MB
                acceptedFiles: 'image/*', // Accept only image files
                addRemoveLinks: true, // Show remove links for uploaded images

                removedfile: function(file) {
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file
                        .previewElement) : void 0;
                },

                init: function() {
                    var existingImages = {!! json_encode($Product->images->pluck('filename')) !!};

                    // Display existing images
                    existingImages.forEach(function(filename) {
                        var mockFile = {
                            name: filename,
                            size: 12345
                        }; // Replace 12345 with the actual file size
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, "{{ asset('images') }}/" + filename);
                        this.emit("complete", mockFile);
                    }, this);

                    this.on('sending', function(file, xhr, formData) {
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('_method', 'PUT');
                    });
                    this.on('success', function(file, response) {
                        // Redirect to index page after successful submission
                        window.location.href = "{{ route('Products.index') }}";
                    });
                }
            });
        });
    </script> --}}

    {{-- <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var myDropzone = new Dropzone('#my-awesome-dropzone', {
                autoProcessQueue: false,
                url: "{{ route('Products.update', $Product->id) }}", // Change this to the appropriate route for uploading images
                paramName: "file", // Change this to match the name attribute of your file input
                // maxFilesize: 2, // Set the maximum file size in MB
                acceptedFiles: 'image/*', // Accept only image files
                addRemoveLinks: true, // Show remove links for uploaded images

                init: function() {
                    var existingImages = {!! json_encode($Product->images->pluck('filename')) !!};

                    // Display existing images
                    existingImages.forEach(function(filename) {
                        var mockFile = {
                            name: filename,
                            size: 12345
                        }; // Replace 12345 with the actual file size
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, "{{ asset('images') }}/" + filename);
                        this.emit("complete", mockFile);
                    }, this);

                    this.on('sending', function(file, xhr, formData) {
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('_method', 'PUT');
                    });

                    this.on('success', function(file, response) {
                        // Redirect to index page after successful submission
                        window.location.href = "{{ route('Products.index') }}";
                    });
                },


                // Handle the removal of files from Dropzone


                removedfile: function(file) {

                    var filename = file.name;
                    var _token = '{{ csrf_token() }}';

                    // Send an AJAX request to remove the image from the database
                    $.ajax({
                        url: "{{ route('removeProductImage') }}", // Change to your route for removing images
                        method: 'POST',
                        data: {
                            _token: _token,
                            filename: filename
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });

                    // Remove the file from the Dropzone interface
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                }
            });

            $("#submitBtn").click(function(e) {
                e.preventDefault();
                myDropzone.processQueue();
            });
        });
    </script> --}}
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var myDropzone = new Dropzone('#my-awesome-dropzone', {
                autoProcessQueue: false,
                url: "{{ route('Products.update', $Product->id) }}", // Change this to the appropriate route for uploading images
                paramName: "file", // Change this to match the name attribute of your file input
                // maxFilesize: 2, // Set the maximum file size in MB
                acceptedFiles: 'image/*', // Accept only image files
                addRemoveLinks: true, // Show remove links for uploaded images
                uploadMultiple:true,
                init: function() {
                    var existingImages = {!! json_encode($Product->images->pluck('filename')) !!};

                    // Display existing images
                    existingImages.forEach(function(filename) {
                        var mockFile = {
                            name: filename,
                            size: 12345
                        }; // Replace 12345 with the actual file size
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, "{{ asset('images') }}/" + filename);
                        this.emit("complete", mockFile);
                    }, this);
                    this.on('addedfile', function(file) {
                        console.log('File added:', file);
                    });

                    this.on('queuecomplete', function() {
                        console.log('Queue complete');
                    });

                    this.on('sending', function(file, xhr, formData) {
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('_method', 'PUT');
                    });

                    this.on('success', function(file, response) {
                        // Redirect to index page after successful submission
                        window.location.href = "{{ route('Products.index') }}";
                    });

                    // Handle the removal of files from Dropzone



                    this.on('removedfile', function(file) {
                        var filename = file.name;
                        var _token = '{{ csrf_token() }}';

                        // Send an AJAX request to remove the image from the database
                        $.ajax({
                            url: "{{ route('removeProductImage') }}", // Change to your route for removing images
                            method: 'POST',
                            data: {
                                _token: _token,
                                filename: filename
                            },
                            success: function(response) {
                                console.log(response);

                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });

                        // Remove the file from the Dropzone interface
                        // var _ref;
                        // return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    });


                },


            });

            $("#submitBtn").click(function(e) {
                e.preventDefault();
                myDropzone.processQueue();
            });
        });
    </script>

</body>

</html>
