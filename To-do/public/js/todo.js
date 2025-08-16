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
    $('#' + formID);
}

function editTask(id, title) {
    $('#edit_task_id').val(id);
    $('#edit_task_title').val(title);
    showForm('edit_task');
}

$('#add_task').submit(function (event) {
    event.preventDefault();
    var title = $('#task_title').val();
    if (title) {
        $.post('/add', { title: title }).done(function (data) {
            $('#task_list').append(data);
            $('#task_title').val('');
            setInterval(function () {
                $("#task_header").load(location.href + " #task_header > *");
            }, 3000);
        })
    } else {
        alert('Please enter a task title');
    }

})
$('#edit_task').submit(function (event) {
    event.preventDefault();
    var taskID = $('#edit_task_id').val();
    var title = $('#edit_task_title').val();
    var currentTitle = $('#span' + taskID).text();
    var newTitle = currentTitle.replace(currentTitle, title);
    if (title) {
        $.post('/update/' + taskID, { title: title }).done(function (data) {
            $('#span' + taskID).text(newTitle);
            $('#edit_task_title').val('');
        })
    } else {
        alert('Please enter a task title');
    }
    setTimeout(function () {
        $("#task_list").load(location.href + " #task_list");
        $("#task_count").load(location.href + " #task_count");
    }, 4000);
})

