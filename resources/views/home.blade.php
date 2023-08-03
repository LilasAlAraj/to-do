@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col">
                <div class="container  d-flex justify-content-between">

                    <h1>Tasks List</h1>
                    <div style="display: flex; align-items: center;">
                        <button id="addNewCaseButton"class="btn" style="margin-right: 1em" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal">
                            Add new task
                        </button>
                    </div>
                </div>
                <hr>

                <table class="table table-bordered  table-striped " id='cases-table'>
                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description </th>
                            <th> Date</th>
                            <th> Priority</th>
                            <th> Operations </th>
                        </tr>

                    </thead>
                    <tbody id="table-body">
                        @foreach ($tasks as $task)
                            <tr>

                                <td style="font-weight: bold">{{ $loop->iteration }}</td>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->date }}</td>
                                <td>{{ $task->priority }}</td>

                                <td>
                                    <div class="actions">
                                        <form>
                                            <input type="hidden" name="ID" value='{{ $task->id }}'>

                                            <div class="form-check">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Mark as completed
                                                </label>
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault" @if ($task->status) checked @endif onclick='editTaskStatus()'>
                                            </div>
                                        </form>
                                        <form>
                                            <input type="hidden" name="id" value='{{ $task->id }}'>
                                            <button class="btn btn-danger btn-sm action" onclick="deleteTask()">
                                                Delete

                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--add new court Modal -->
    <div class="modal fade" id="addTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="height: fit-content; ">
            <div class="modal-content">
                <div class="modal-header" style=" background-color:var(--main-color)">
                    <h1 class="modal-title fs-5" id="addTaskModalLabel" style=" color:var(--bg-color);">
                        Add new task
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeModal()"></button>

                </div>
                <div class="container">
                    <form id='store-task-form' autocomplete='off'>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="name" class="important">{{ __('Task name') }}</label>

                                <div>
                                    <input id="name" type="name"
                                        class="form-control @error('name') is-invalid @enderror  " name="name"
                                        value="{{ old('name') }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="priority" class="important">{{ __('priority') }}</label>
                                <div>
                                    <select id="priority" name="priority"
                                        class="form-control @error('priority') is-invalid @enderror"
                                        value="{{ old('priority') }}"required>
                                        <option disabled selected hidden style="color: black" > Choose the priority</option>
                                        <option value='High' style="color: red"> Heigh</option>
                                        <option value='Middle' style="color: orange"> Middle</option>
                                        <option value='Low' style="color: greenyellow"> Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class=" col-12">
                                <label for="date" class="important">{{ __('Task date') }}</label>

                                <div>
                                    <input id="date" type="date"
                                        class="form-control @error('date') is-invalid @enderror" name="date"
                                        value="{{ old('date') }}" required>

                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="important">{{ __('description') }}</label>

                            <div>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                    style="max-height:8em;" required></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="modal-footer ">
                            <div class="w-100">
                                <button type="submit" class="btn w-100"onclick='store()'>
                                    {{ __('Add') }}
                                </button>
                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="js/tasks.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
