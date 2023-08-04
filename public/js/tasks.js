
function store() {

    $('#store-task-form').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
            priority: {
                required: true
            },
            date: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter a name of task"
            },
            description: {
                required: "Please enter a description of task"
            },
            priority: {
                required: "Please select a priority of task"
            },
            date: {
                required: "Please select date of task"
            },
        },
        submitHandler: function (form) {

            name = $('#name').val();
            description = $('#description').val();
            priority = $('#priority').val();
            date = $('#date').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/store',
                type: "post",
                data: {
                    'description': description,
                    'priority': priority,
                    'date': date,
                    'name': name,

                },
                success: function (response) {

                    console.log(response)
                    console.log(response.status)
                    console.log(response.message)
                    if (response.status === 'success') {

                        showSuccess('Your task has been added successfully.', 'success');
                        closeModal();
                         $('#name').val('');
                         $('#description').val('');
                        $('#priority').val('Choose the priority');
                        $('#date').val('');

                        $('#addTaskModal').modal('hide');
                        body = document.getElementById('table-body');


                        // Create the HTML content to append

                        idDel = document.createElement('input')
                        idDel.type = 'hidden'
                        idDel.name = 'ID';
                        idDel.value = response.id;

                        idEdit = document.createElement('input')
                        idEdit.type = 'hidden'
                        idEdit.name = 'ID';
                        idEdit.value = response.id;


                        formCheck = document.createElement('div');
                        formCheck.classList.add('form-check');

                        formCheckLabel = document.createElement('label');
                        formCheckLabel.classList.add('form-check-label')
                        formCheckLabel.for = 'flexCheckDefault'
                        formCheckLabel.innerHTML = 'Mark as completed';

                        formCheckInput = document.createElement('input');
                        formCheckInput.classList.add('form-check-input');
                        formCheckInput.type = 'checkbox';
                        formCheckInput.onclick = function () {
                            editTaskStatus();
                        }
                        formCheck.append(formCheckLabel, formCheckInput);
                        editForm = document.createElement('form');
                        editForm.append(idEdit, formCheck)

                        buttonDelete = document.createElement('button');
                        buttonDelete.classList.add('btn', 'btn-danger', 'btn-sm', 'action');
                        buttonDelete.onclick = function () { deleteTask() };
                        buttonDelete.innerHTML = 'Delete';

                        deleteForm = document.createElement('form');
                        deleteForm.append(idDel, buttonDelete);
                        actions = document.createElement('div')
                        actions.append(editForm, deleteForm);



                        // Append the HTML content to the operations element
                        row = document.createElement('tr');
                        countCol = document.createElement('td');
                        countCol.innerHTML = body.childNodes.length

                        nameCol = document.createElement('td');
                        nameCol.innerHTML = name

                        descriptionCol = document.createElement('td');
                        descriptionCol.innerHTML = description

                        dateCol = document.createElement('td');
                        dateCol.innerHTML = date

                        priorityCol = document.createElement('td');
                        priorityCol.innerHTML = priority

                        row.append(countCol, nameCol, descriptionCol, dateCol, priorityCol, actions)

                        body.append(row);

                    } else {

                        showError('Message field should not be empty.');

                    }
                },

                error: function (response) {
                    console.log(response)

                    $('.error').html(response.message);

                }
            });


        }
    });

}

// Helper function to show error modal
function showError(errorMessage) {
    Swal.fire({
        title: 'Error!',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: 'OK',

    });
}

// Helper function to show success modal
function showSuccess(successMessage, icon) {
    Swal.fire({
        title: 'Success!',
        text: successMessage,
        icon: icon,
        showConfirmButton: false,
        timer: 2000
    });


    console.log(icon);

}

function closeModal() {

    $('.error').html('');

    sessionStorage.clear();
}

function deleteTask() {

    event.preventDefault();
    id = -1;
    row = null

    child = event.srcElement;

    id = (child.parentNode.children[0]).value
    row = child.parentNode.parentNode.parentNode

    if (row.tagName === 'TD')
        row = row.parentNode
    console.log(row)
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/destroy',
        type: "delete",
        data: {
            'id': id,


        },
        success: function (response) {

            console.log(response)
            console.log(response.status)
            console.log(response.message)
            if (response.status === 'success') {

                showSuccess('Your task has been deleted successfully.', 'success');
                row.remove();
                updateTheOrder()


            } else {

                showError('your task has been failed to delete .');

            }
        },

        error: function (response) {
            console.log(response)

            showError('your task has been failed to delete .');

        }

    });

}



function editTaskStatus() {


    id = (event.srcElement.parentNode.parentNode.children[0]).value

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/update',
        type: "put",
        data: {
            'id': id,

        },
        success: function (response) {

            console.log(response)
            console.log(response === true)
            if (response === true) {

                showSuccess('Your task has been completed.', 'success');

            } else {

                showSuccess('Your task has been incompleted.', 'error');

            }

        },

        error: function (response) {
            console.log(response)

            showError('your task has been failed to update .');

        }

    });

}


function updateTheOrder() {
    var rows = $('#table-body tr');

    // Loop through each row and edit the first cell content
    rows.each(function (index, row) {
        // Find the first cell (td) in the row
        var firstCell = $(row).find('td').first();

        // Edit the content of the first cell
        firstCell.text((index + 1));
    })
};
