<div class="form-group">
    <label for="title" class="text-info">Title:</label><br>
    <input type="text" name="title" id="title" class="form-control" value="{{ $project->title }}">
</div>
<div class="form-group">
    <label for="description" class="text-info">Description:</label><br>
    <textarea name="description" rows="10" cols="155"> {{ $project->description }}</textarea>
</div>

<button type="submit" id="register-link" class="btn btn-success text-right">{{ $buttonText }}</button>
<a href="{{ route('show.project', $project) }}" id="register-link" class="btn btn-danger text-right">Cancel</a>


@if ($errors->any())
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
@endif

