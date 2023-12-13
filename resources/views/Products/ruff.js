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
    </script>

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
    </script>
