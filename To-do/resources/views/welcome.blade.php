<!DOCTYPE html>
<html>
<head>
    <title>Laravel To-Do</title>

    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (we use it for AJAX requests) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="p-5">
    <div class="container">
        <h1 class="mb-4">To-Do List</h1>

        <!-- Input and button to add a new task -->
        <div class="input-group mb-3">
            <!-- User types task here -->
            <input type="text" id="taskTitle" class="form-control" placeholder="New task...">
            <!-- Clicking this sends the task to Laravel -->
            <button id="addTask" class="btn btn-primary">Add</button>
        </div>

        <!-- Where all tasks will be listed -->
        <ul id="taskList" class="list-group"></ul>
    </div>

    <script>
        // -----------------------------
        // Function: Load all tasks from Laravel
        // -----------------------------
        function loadTasks() {
            $.get("/tasks", function(data) { // GET request to Laravel
                $("#taskList").empty(); // Clear old list

                // Loop through tasks returned from Laravel
                data.forEach(task => {
                    $("#taskList").append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <!-- Strike through text if completed -->
                            <span style="text-decoration:${task.completed ? 'line-through' : 'none'}">${task.title}</span>
                            <div>
                                <!-- Complete button -->
                                <button class="btn btn-success btn-sm me-2 complete" data-id="${task.id}">✔</button>
                                <!-- Delete button -->
                                <button class="btn btn-danger btn-sm delete" data-id="${task.id}">🗑</button>
                            </div>
                        </li>
                    `);
                });
            });
        }

        // -----------------------------
        // Add task when "Add" button is clicked
        // -----------------------------
        $(document).on("click", "#addTask", function() {
            let title = $("#taskTitle").val(); // Get text from input

            if (title.trim() === "") return; // Stop if empty

            // POST request to Laravel to save task
            $.post("/tasks", { title: title, _token: "{{ csrf_token() }}" }, function() {
                $("#taskTitle").val(""); // Clear input after adding
                loadTasks(); // Refresh list
            });
        });

        // -----------------------------
        // Mark a task as complete
        // -----------------------------
        $(document).on("click", ".complete", function() {
            let id = $(this).data("id"); // Get task ID

            // PUT request to update task in Laravel
            $.ajax({
                url: /tasks/${id},
                type: "PUT",
                data: { completed: true, _token: "{{ csrf_token() }}" },
                success: loadTasks // Refresh list after update
            });
        });

        // -----------------------------
        // Delete a task
        // -----------------------------
        $(document).on("click", ".delete", function() {
            let id = $(this).data("id"); // Get task ID

            // DELETE request to remove task in Laravel
            $.ajax({
                url: /tasks/${id},
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: loadTasks // Refresh list after delete
            });
        });

        // -----------------------------
        // Load all tasks when the page first opens
        // -----------------------------
        loadTasks();
    </script>
</body>
</html>