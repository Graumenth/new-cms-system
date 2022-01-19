<x-admin-master>
    @section('content')
        <h1>Edit a post</h1>
        <form method="post" action="{{route('admin.posts.update', [$post->id])}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" aria-describedby="" value="{{$post->title}}">
            </div>
            <div class="form-group row">
                <div class="col-sm-4 col-lg-3 col-xl-2">
                    <label for="file">File</label>
                    <input type="file" name="post_image" class="form-control-file" id="post_image">
                </div>
                <div class="col-lg-8">
                    Current image: <img src="{{$post->post_image}}" alt="" height="100px">
                </div>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea name="body" class="form-control" id="body" cols="30" rows="10" placeholder="Enter content">{{$post->body}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endsection
</x-admin-master>
