<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>To-Do</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
        }

        .card {
            border-radius: 1.5rem;
        }

        .list-group-item {
            transition: box-shadow 0.2s, background 0.2s;
        }

        .list-group-item:hover {
            box-shadow: 0 2px 12px rgba(80, 80, 200, 0.08);
            background: #f0f8ff;
        }

        .done .fw-medium {
            text-decoration: line-through;
            color: #888;
        }

        .icon-edit,
        .icon-delete,
        .iconEdit,
        .iconDelete {
            transition: background 0.2s, color 0.2s;
        }

        .icon-edit:hover,
        .iconEdit:hover {
            background: #e0eaff;
            color: #0d6efd;
        }

        .icon-delete:hover,
        .iconDelete:hover {
            background: #ffe0e0;
            color: #dc3545;
        }

        .iconDone:hover {
            background: #d1f7d6;
            color: #198754;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
        }
    </style>
</head>

<body>
    <div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg w-100 border-0" style="max-width: 500px; border-radius: 1.5rem;">
            <div class="card-body p-4">
                <section id="data_section" class="todo">
                    <div id="task_header" class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold mb-0 text-primary"><i class="bi bi-list-task"></i> To-Do List</h2>
                        <span id="task_count" class="badge bg-gradient-primary text-white px-3 py-2"
                            style="background: linear-gradient(90deg, #00CCE3FF 0%, #1616F6FF 100%);">{{ count($todos) }}
                            tasks</span>
                    </div>
                    <ul id="task_list" class="todo-list list-group list-group-flush">
                        @foreach ($todos as $todo)
                            @if($todo->status)
                                <li id="{{ $todo->id }}"
                                    class="list-group-item d-flex justify-content-between align-items-center bg-light done"
                                    style="border-radius: 0.75rem; margin-bottom: 0.5rem; opacity: 0.7;">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" onclick="taskDone({{ $todo->id }})"
                                            class="iconDone btn btn-sm btn-outline-success rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:32px; height:32px;" title="done">
                                            <i class="bi bi-check2"></i>
                                        </a>
                                        <span id="span{{$todo->id}}"
                                            class="ms-2 flex-grow-1 fw-medium">{{ $todo->title }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" onclick="editTask('{{ $todo->id }}', '{{ $todo->title }}')"
                                            class="icon-edit btn btn-sm btn-outline-primary rounded-circle" title="Edit"><i
                                                class="bi bi-pencil"></i></a>
                                        <a href="#" onclick="deleteTask('{{ $todo->id }}')"
                                            class="icon-delete btn btn-sm btn-outline-danger rounded-circle" title="Delete"><i
                                                class="bi bi-trash"></i></a>
                                    </div>
                                </li>
                            @else
                                <li id="{{ $todo->id }}"
                                    class="list-group-item d-flex justify-content-between align-items-center bg-white"
                                    style="border-radius: 0.75rem; margin-bottom: 0.5rem;">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" onclick="taskDone({{ $todo->id }})"
                                            class="iconDone btn btn-sm btn-outline-success rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:32px; height:32px;" title="done">
                                            <i class="bi bi-check2"></i>
                                        </a>
                                        <span id="span{{$todo->id}}"
                                            class="ms-2 flex-grow-1 fw-medium">{{ $todo->title }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" onclick="editTask('{{ $todo->id }}', '{{ $todo->title }}')"
                                            class="iconEdit btn btn-sm btn-outline-primary rounded-circle" title="Edit"><i
                                                class="bi bi-pencil"></i></a>
                                        <a href="#" onclick="deleteTask('{{ $todo->id }}')"
                                            class="iconDelete btn btn-sm btn-outline-danger rounded-circle" title="Delete"><i
                                                class="bi bi-trash"></i></a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </section>
                <section id="form_section" class="mt-4">
                    <form id="add_task" class="todo d-flex gap-2 bg-light p-3 rounded shadow-sm mb-2"
                        style="display: block;">
                        <input type="text" id="task_title" class="form-control" placeholder="Add a new task">
                        <button type="submit" class="btn btn-primary px-4">Add</button>
                    </form>
                    <form id="edit_task" class="todo d-flex gap-2 bg-warning bg-opacity-10 p-3 rounded shadow-sm"
                        style="display: none;">
                        <input type="hidden" id="edit_task_id">
                        <input type="text" id="edit_task_title" class="form-control" placeholder="Edit task">
                        <button type="submit" class="btn btn-warning px-4 text-white">Save</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('js/todo.js') }}"></script>
</body>

</html>