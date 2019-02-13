
<div class="card">
    <ul class="list-group">
        @forelse($project->activities as $activity)
            <li class="list-group-item">{{ $activity->description .' '.$activity->subject->body }}
                <span class="text-grey"> {{ $activity->created_at->diffForHumans() }}</span>
            </li>

        @empty
            <li>No Project Activity Yet</li>
        @endforelse
    </ul>
</div>
