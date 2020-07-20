<!-- Adding a script for dropzone -->
<script>
    Dropzone.autoDiscover = false;
    // Dropzone.options.image-upload = false;	
    let token = $('meta[name="csrf-token"]').attr('content');
    $(function() {
    var myDropzone = new Dropzone("div#dropzoneDragArea", { 
        paramName: "file",
        url: "{{ route('image.store') }}",
        previewsContainer: 'div.dropzone-previews',
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,
        acceptedFiles: '.png',
        maxFilesize: 5,
        "error": function(file, message, xhr) {
            if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
            alert(message);
            },
        params: {
            _token: token
        },
         // The setting up of the dropzone
        init: function() {
            var myDropzone = this;
            //form submission code goes here
            $("form[name='image-upload']").submit(function(event) {
                //Make sure that the form isn't actully being sent.
                event.preventDefault();
                URL = $("#image-upload").attr('action');
                formData = $('#image-upload').serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('data.store') }}",
                    data: formData,
                    success: function(result){
                        if(result.status == "success"){
                            // fetch the useid 
                            var imageid = result.image_id;
                            $("#imageid").val(imageid); // inseting imageid into hidden input field
                            //process the queue
                            //update image gallery
                            myDropzone.processQueue();
                        }else{
                            console.log("error");
                        }
                    }
                });
            });
            //Gets triggered when we submit the image.
            this.on('sending', function(file, xhr, formData){
                //fetch the image id from hidden input field and send that imageid with our image
                let imageid = document.getElementById('imageid').value;
                formData.append('imageid', imageid);
            });
            
            this.on("success", function (file, response) {
                //reset the form
                $('#image-upload')[0].reset();
                //reset dropzone
                $('.dropzone-previews').empty();
            });
            this.on("queuecomplete", function (file) {
                
            });
            
            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
              // Gets triggered when the form is actually being sent.
              // Hide the success button or the complete form.
            });
            
            this.on("successmultiple", function(files, response) {
              // Gets triggered when the files have successfully been sent.
              // Redirect image or notify of success.
            });
            
            this.on("errormultiple", function(files, response) {
              // Gets triggered when there was an error sending the files.
              // Maybe show form again, and notify image of error
            });
            this.on("complete", function (file) {
                $.ajax({
                    type: 'get',
                    url: "{{ route('index') }}",
                    success: function(data){
                        $('.image-gallery-container').html(data);
                    }
                });
                myDropzone.removeFile(file);
            });
        }
        });
    });

    $('.image-gallery-container').on('click','.img-link', function(e){
        e.preventDefault();
        url = $(this).attr('href');
        let _token = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {_token : _token},
                    success: function(data){
                        $('.image-gallery-container').html(data);
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            }
        })

    })

    $(document).ready(function(){
        $.ajax({
            type: 'get',
            url: "{{ route('index') }}",
            success: function(data){
                $('.image-gallery-container').html(data);
            }
        });

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

        $('#search-text').on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".image-gallery-container .wrapper").filter(function() {
                return $(this).toggle($(this).data('target').toLowerCase().indexOf(value) > -1);
            });
            var $hiddenDiv = $(".image-gallery-container .wrapper:hidden").length;
            var $noOfDiv = $(".image-gallery-container .wrapper").length;
            if($hiddenDiv == $noOfDiv){
                if($('.alert-no-image').hasClass('d-none')){
                    $('.alert-no-image').removeClass('d-none');
                }
                
            }else{
                if($('.alert-no-image').hasClass('d-none')){

                }else{
                    $('.alert-no-image').addClass('d-none');
                }
            }
        });
    });
</script>