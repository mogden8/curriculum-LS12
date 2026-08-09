@if($course->status !== 1)
    <td style="max-width: 450px;">
        @if(isset($showPermissionBadge) && $showPermissionBadge)
            @if($course->userPermission == 2)
                <span class="badge bg-info me-1">Editor</span>
            @elseif($course->userPermission == 3)
                <span class="badge bg-warning text-dark me-1">View</span>
            @endif
        @endif
        <a href="{{route('courseWizard.step1', $course->course_id)}}">{{$course->course_title}}</a>
    </td>
    <td>{{$course->course_code}} {{$course->course_num}}</td>
    <td>{{$course->year}} {{$course->semester}}</td>
    <td class="align-middle">
        @if ($progressBar[$course->course_id] == 0)
            <div class="bg-transparent position-relative" data-bs-toggle="tooltip" data-html="true" data-bs-placement="right" title="{{$progressBarMsg[$course->course_id]['statusMsg']}}">
                <p class="text-center mb-0">{{$progressBar[$course->course_id]}}%</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        @elseif ($progressBar[$course->course_id] == 100)
            <p class="text-center mb-0">{{$progressBar[$course->course_id]}}%</p>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width:{{$progressBar[$course->course_id]}}%;" aria-valuenow="{{$progressBar[$course->course_id]}}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        @else
            <div class="bg-transparent position-relative" data-bs-toggle="tooltip" data-html="true" data-bs-placement="right" title="{{$progressBarMsg[$course->course_id]['statusMsg']}}">
                <p class="text-center mb-0">{{$progressBar[$course->course_id]}}%</p>
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width:{{$progressBar[$course->course_id]}}%;" aria-valuenow="{{$progressBar[$course->course_id]}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        @endif
    </td>

    <td>
        <div class="row">
            <div class="d-flex justify-content-center">
                @if(count($coursesPrograms[$course->course_id]) > 0)
                    <div class="bg-transparent position-relative pe-2 ps-2" data-bs-toggle="tooltip" data-html="true" title="@foreach($coursesPrograms[$course->course_id] as $i => $courseProgram){{$i + 1}}. {{$courseProgram->program}}<br>@endforeach" data-bs-placement="right">
                        <i class="bi bi-map" style="font-size:x-large; text-align:center;"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
                            {{ count($coursesPrograms[$course->course_id]) }}
                        </span>
                    </div>
                @else
                <p style="text-align: center; display:inline-block; margin-left:-15px;"><i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right" title='To map a course to a program, you must first create a program from the "My Programs" section'> None</i></p>
                @endif
            </div>
        </div>
    </td>
@else
    <td style="max-width: 450px;">
        @if(isset($showPermissionBadge) && $showPermissionBadge)
            @if($course->userPermission == 1)
                <span class="badge bg-primary me-1">Owner</span>
            @elseif($course->userPermission == 2)
                <span class="badge bg-info me-1">Editor</span>
            @elseif($course->userPermission == 3)
                <span class="badge bg-warning text-dark me-1">View</span>
            @endif
        @endif
        <a href="{{route('courseWizard.step1', $course->course_id)}}">{{$course->course_title}}</a>
    </td>
    <td>{{$course->course_code}} {{$course->course_num}}</td>
    <td>{{$course->year}} {{$course->semester}}</td>
    <td class="align-middle">
        @if ($progressBar[$course->course_id] == 0)
            <div class="bg-transparent position-relative" data-bs-toggle="tooltip" data-html="true" data-bs-placement="right" title="{{$progressBarMsg[$course->course_id]['statusMsg']}}">
                <p class="text-center mb-0">{{$progressBar[$course->course_id]}}%</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        @elseif ($progressBar[$course->course_id] == 100)
            <p class="text-center mb-0">{{$progressBar[$course->course_id]}}%</p>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width:{{$progressBar[$course->course_id]}}%;" aria-valuenow="{{$progressBar[$course->course_id]}}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        @else
            <div class="bg-transparent position-relative" data-bs-toggle="tooltip" data-html="true" data-bs-placement="right" title="{{$progressBarMsg[$course->course_id]['statusMsg']}}">
                <p class="text-center mb-0">{{$progressBar[$course->course_id]}}%</p>
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width:{{$progressBar[$course->course_id]}}%;" aria-valuenow="{{$progressBar[$course->course_id]}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        @endif
    </td>

    <td>
        <div class="row">
            <div class="d-flex justify-content-center">
                @if(count($coursesPrograms[$course->course_id]) > 0)
                    <div class="bg-transparent position-relative pe-2 ps-2" data-bs-toggle="tooltip" data-html="true" title="@foreach($coursesPrograms[$course->course_id] as $i => $courseProgram){{$i + 1}}. {{$courseProgram->program}}<br>@endforeach" data-bs-placement="right">
                        <i class="bi bi-map" style="font-size:x-large; text-align:center;"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
                            {{ count($coursesPrograms[$course->course_id]) }}
                        </span>
                    </div>
                @else
                <p style="text-align: center; display:inline-block; margin-left:-15px;"><i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right" title='To map a course to a program, you must first create a program from the "My Programs" section'> None</i></p>
                @endif
            </div>
        </div>
    </td>
@endif
@if ($course->last_modified_user != NULL)
    <td><p data-bs-toggle="tooltip" data-html="true" data-bs-placement="top" title="Last updated by: {{$course->last_modified_user}}">{{$course->timeSince}}</p></td>
@else
    <td>{{$course->timeSince}}</td>
@endif
<td>
    <div class="btn-group">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-gear-fill"></i> </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('courseWizard.step1', $course->course_id)}}">Edit</a>
            <div class="dropdown-item collabIcon" style="cursor: pointer;" data-bs-toggle="tooltip" data-html="true" data-bs-placement="right" title="@foreach($courseUsers[$course->course_id] as $counter => $courseUser){{$counter + 1}}. {{$courseUser->name}}<br>@endforeach" data-modal="addCourseCollaboratorsModal{{$course->course_id}}">
                Collaborators
                <span class="badge rounded-pill bg-dark">
                    {{ count($courseUsers[$course->course_id]) }}
                </span>
            </div>
            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#duplicateCourseConfirmation{{$modalPrefix ?? ''}}{{$course->course_id}}">Duplicate</a>
            @if($course->userPermission == 1)
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteCourseConfirmation{{$modalPrefix ?? ''}}{{$course->course_id}}" href=#>Delete</a>
            @endif
        </div>
    </div>

    @php
        $modalPrefix = $modalPrefix ?? '';
    @endphp

    @if($course->userPermission == 1)
        <div class="modal fade show" id="deleteCourseConfirmation{{$modalPrefix}}{{$course->course_id}}" tabindex="-1" role="dialog" aria-labelledby="deleteCourseConfirmation{{$modalPrefix}}{{$course->course_id}}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Course Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                    Are you sure you want to delete course {{$course->course_code}} {{$course->course_num}} ?
                    </div>

                    <form action="{{route('courses.destroy', $course->course_id)}}" method="POST">
                        @csrf
                        {{method_field('DELETE')}}

                        <div class="modal-footer">
                            <button style="width:60px" type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button style="width:60px" type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="duplicateCourseConfirmation{{$modalPrefix}}{{$course->course_id}}" tabindex="-1" role="dialog" aria-labelledby="duplicateCourseConfirmation{{$modalPrefix}}{{$course->course_id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateCourseConfirmation{{$course->course_id}}">Duplicate Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('courses.duplicate', $course->course_id) }}" method="POST">
                    @csrf
                    {{method_field('POST')}}

                    <div class="modal-body">

                        <div class="row mb-3">
                            <label for="course_code" class="col-md-3 col-form-label text-md-right"><span class="requiredField">*</span>Course Code</label>
                            <div class="col-md-8">
                                <input id="course_code" type="text" pattern="[A-Za-z]+" minlength="1" maxlength="4" class="form-control @error('course_code') is-invalid @enderror" value="{{$course->course_code}}" name="course_code" required autofocus>
                                @error('course_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small id="helpBlock" class="form-text text-muted">
                                    Maximum of Four letter course code e.g. SUST, ASL, COSC etc.
                                </small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="course_num" class="col-md-3 col-form-label text-md-right"><span class="requiredField">*</span>Course Number</label>
                            <div class="col-md-8">
                                <input id="course_num" type="text" class="form-control @error('course_num') is-invalid @enderror" name="course_num" value="{{$course->course_num}}" required autofocus>
                                @error('course_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="course_title" class="col-md-3 col-form-label text-md-right"><span class="requiredField">*</span>Course Title</label>
                            <div class="col-md-8">
                                <input id="course_title" type="text" class="form-control @error('course_title') is-invalid @enderror" name="course_title" value="{{$course->course_title}} - Copy" required autofocus>
                                @error('course_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="course_section" class="col-md-3 col-form-label text-md-right">Course Section</label>
                            <div class="col-md-4">
                                <input id="course_section" type="text" class="form-control @error('course_section') is-invalid @enderror" name="course_section" autofocus value= {{$course->section}}>
                                @error('course_section')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button style="width:60px" type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button style="width:80px" type="submit" class="btn btn-success btn-sm">Duplicate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</td>

