<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg w-100" style="max-width: 500px;">
            <div class="card-body">
                <section id="data_section" class="todo">
                    <ul class="todo-controls list-unstyled mb-4 d-flex align-items-center gap-2">
                        <li>
                            <h3 class="mb-0"><i class="fa-solid fa-plus text-primary"></i></h3><span
                                class="ms-2 fw-bold">Add task</span>
                        </li>
                    </ul>
                    <ul id="task_list" class="todo-list list-group">
                        @foreach ($todos as $todo)
                            @if($todo->status)
                                <li id="{{ $todo->id }}" class="done"
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <span id="span{{$todo->id}}"
                                            class="ms-2 flex-grow-1 fw-medium">{{ $todo->title }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" onclick="editTask('{{ $todo->id }}', '{{ $todo->title }}')"
                                            class="icon-edit btn btn-sm btn-outline-primary" title="Edit">Edit
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="#" onclick="deleteTask('{{ $todo->id }}')"
                                            class="icon-delete btn btn-sm btn-outline-danger" title="Delete">Delete
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </li>
                            @else
                                <li id="{{ $todo->id }}"
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" onclick="taskDone({{ $todo->id }})" class="iconDone"
                                            class="toggle btn btn-sm btn-outline-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width:32px; height:32px;">
                                            <i class="bi bi-check-square">Done</i>
                                        </a>
                                        <span id="span{{$todo->id}}"
                                            class="ms-2 flex-grow-1 fw-medium">{{ $todo->title }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" onclick="editTask('{{ $todo->id }}', '{{ $todo->title }}')"
                                            class="iconEdit btn btn-sm btn-outline-primary" title="Edit">Edit
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="#" onclick="deleteTask('{{ $todo->id }}')"
                                            class="iconDelete btn btn-sm btn-outline-danger" title="Delete">Delete
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </section>
                <section id="form_section" class="mt-4">
                    <form id="add_task" class="todo d-flex gap-2" style="display: block;">
                        <input type="text" id="task_title" class="form-control" placeholder="Add a new task">
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </form>
                    <form id="edit_task" class="todo d-flex gap-2" style="display: block;">
                        <input type="hidden" id="edit_task_id">
                        <input type="text" id="edit_task_title" class="form-control" placeholder="Edit task">
                        <button type="submit" class="btn btn-primary">Edit Changes</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('assets/js/todo.js')}}"></script>

    <script>
        function taskDone(id) {
            $.get('/done/' + id, function (data) {
                if (data == 'OK') {
                    $('#' + id).addClass('done');
                }
            })
        }

        function deleteTask(id) {
            $.get('/delete/' + id, function (data) {
                if (data == 'OK') {
                    var target = $('#' + id);
                    target.hide('slow', function () {
                        target.remove();
                    });
                }
            })
        }
        function showForm(formID) {
            $('form').hide();
            $('#' + formID).show('slow');
        }
        
        function editTask(id, title) {
            $('#edit_task_id').val(id);
            $('#edit_task_title').val(title);
            showForm('edit_task');
        }

        $('#add_task').submit(function (event){
            event.preventDefault();
            var title= $('#task_title').val();
            if(title){
                $.post('/add', {title: title}).done(function (data){
                    $('#add_task').hide('slow');
                    $('#task_list').append('<li id="' + data.id + '">' + data.title + '</li>');
                    $('#task_title').val('');
                })
            }else{
                alert('Please enter a task title');
            }

        })

    </script>
</body>

</html>