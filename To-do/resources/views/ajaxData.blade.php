@foreach ($todos as $todo)
    <li id="{{ $todo->id }}" class="list-group-item d-flex justify-content-between align-items-center bg-white"
        style="border-radius: 0.75rem; margin-bottom: 0.5rem;">
        <div class="d-flex align-items-center gap-2">
            <a href="#" onclick="taskDone({{ $todo->id }})"
                class="iconDone btn btn-sm btn-outline-success rounded-circle d-flex align-items-center justify-content-center"
                style="width:32px; height:32px;" title="done">
                <i class="bi bi-check2"></i>
            </a>
            <span id="span{{$todo->id}}" class="ms-2 flex-grow-1 fw-medium">{{ $todo->title }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="#" onclick="editTask('{{ $todo->id }}', '{{ $todo->title }}')"
                class="iconEdit btn btn-sm btn-outline-primary rounded-circle" title="Edit"><i class="bi bi-pencil"></i></a>
            <a href="#" onclick="deleteTask('{{ $todo->id }}')"
                class="iconDelete btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                <i class="bi bi-trash"></i></a>
        </div>
    </li>
@endforeach