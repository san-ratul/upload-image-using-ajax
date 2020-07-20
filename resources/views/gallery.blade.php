
<div class="card mt-4">
    <div class="card-body">
        @if(isset($images) && count($images) > 0)
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    @foreach($images as $image)
                    <div class="col-md-3 wrapper" data-target = "{{ $image->title }}" >
                        <a href="{{ asset($image->image) }}" data-toggle="lightbox" data-gallery="example-gallery" class="img-container">
                            <img src="{{ asset($image->image) }}" class="img-single">
                        </a>
                        <p class="img-title">{{ $image->title }}</p>
                        <a href="{{ route('image.delete',$image->id) }}" class="text-danger img-link"> <i class="fa fa-trash-o"></i> Remove Image</a>
                    </div>
                    @endforeach
                    <div class="alert alert-danger alert-no-image d-none col-12">No image found</div>
                </div>
            </div>
        </div>
        @else
            <div class="alert alert-danger">No images added yet!</div>
        @endif
    </div>
</div>


