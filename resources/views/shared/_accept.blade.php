@can('accept', $answer)
    <a title="Mark this answer as best answer" 
        class="{{ $model->status }} mt-2"
        onClick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();"
        >
        <i class="fas fa-check fa-2x"></i>
    </a>
    <form id="accept-answer-{{ $model->id }}" action="{{ route('answers.accept', $model->id) }}" method="POST" style="display:none;">
        @csrf
    </form>
@else
    @if($answer->is_best)
    <a title="The question owner accepted this answer as best answer" 
        class="{{ $model->status }} mt-2">
        <i class="fas fa-check fa-2x"></i>
    </a>
    @endif
@endcan 