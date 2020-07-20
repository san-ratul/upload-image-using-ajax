@extends('layout.app')

@section('content')
    <div class="content-fluid">
        <h2 class="mt-5">Image Upload with drag and drop using Laravel and jQuery-Ajax</h2>
        <h4 class="mt-3 mb-3">Your Images:</h4>
        <!-- Large modal -->
        <div class="form-inline">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".image-upload-container">Upload Image</button>
            <div class="col-8">
                <label class="sr-only" for="search-text">Search</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                  </div>
                  <input type="text" class="form-control" id="search-text" placeholder="Search">
                </div>
            </div>
        </div>
        

        <div class="image-gallery-container">

        </div>

        <div class="modal fade image-upload-container" tabindex="-1" role="dialog" aria-labelledby="imageUploadContainer" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container mt-3 mb-3">
                    <form class="mb-2 dropzone" action="{{ route('data.store') }}" method="post" enctype="multipart/form-data" id="image-upload" name="image-upload">
                        @csrf
                        <input type="hidden" name="imageid" id="imageid">
                        <div class="form-group">
                            <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                <span>Upload file</span>
                            </div>
                            <div class="dropzone-previews"></div>
                        </div>
                        <div class="form-inline">
                            <div class="form-group">
                                <label class="mr-3" for="image-tile"> Image Title</label>
                                <input class="form-control mr-3" type="text" name="image_title" id="image-tile">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Upload file</button>
                        </div>
                    </form>

                    <img src="" alt="" class="image d-none">

                    <!-- Progress Bar -->
                    <div class="progress mt-4">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <!-- Upload Finished -->
                    <div class="js-upload-finished d-none">
                        <h3>Processed files</h3>
                        <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-success"><span class="badge alert-success pull-right">Success</span>image-01.jpg</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

</div>
@endsection