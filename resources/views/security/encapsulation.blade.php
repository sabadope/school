@extends('layouts.master')
@section('title', 'Encapsulation Example')

@section('content')
<style>
    .encryption-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.9);
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 1000;
    }
    .card-body {
        position: relative;
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Encapsulation Example</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('setting/page') }}">Settings</a></li>
                            <li class="breadcrumb-item active">Encapsulation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- message --}}
        {!! Toastr::message() !!}

        {{-- Encryption Toggle --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Data Encryption</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="encryptionToggle">
                                <label class="form-check-label" for="encryptionToggle">Disable Encryption</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="student-group-form">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search by User ID ...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search by Name ...">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search by Email ...">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="search-student-btn">
                        <button type="btn" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table comman-shadow">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Registered Users</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-gray me-2 active">
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-gray me-2">
                                        <i class="fa fa-th" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                    <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key=>$user)
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>{{ $user->user_id }}</td>
                                        <td hidden class="id">{{ $user->id }}</td>
                                        <td hidden class="avatar">{{ $user->avatar }}</td>
                                        <td class="encryptable" data-original="{{ $user->name }}">
                                            {{ $user->name }}
                                        </td>
                                        <td class="encryptable" data-original="{{ $user->email }}">
                                            {{ $user->email }}
                                        </td>
                                        <td class="encryptable" data-original="{{ $user->role_name }}">
                                            {{ $user->role_name }}
                                        </td>
                                        <td class="encryptable" data-original="{{ $user->department }}">
                                            {{ $user->department }}
                                        </td>
                                        <td class="encryptable" data-original="{{ $user->position }}">
                                            {{ $user->position }}
                                        </td>
                                        <td>
                                            @if($user->status == 'Active')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="#" class="btn btn-sm bg-danger-light">
                                                    <i class="far fa-edit me-2"></i>
                                                </a>
                                                <a class="btn btn-sm bg-danger-light user_delete" data-bs-toggle="modal" data-bs-target="#userDelete">
                                                    <i class="far fa-trash-alt me-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- model user delete --}}
<div class="modal custom-modal fade" id="userDelete" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete User</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('user/delete') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" class="e_id" value="">
                            <input type="hidden" name="avatar" class="e_avatar" value="">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary continue-btn submit-btn" style="border-radius: 5px !important;">Delete</button>
                            </div>
                            <div class="col-6">
                                <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')

{{-- delete js --}}
<script>
    $(document).on('click','.user_delete',function()
    {
        var _this = $(this).parents('tr');
        $('.e_id').val(_this.find('.id').text());
        $('.e_avatar').val(_this.find('.avatar').text());
    });

    // Encryption Toggle Functionality
    $(document).ready(function() {
        // Initially encrypt all data
        $('.encryptable').each(function() {
            const originalText = $(this).data('original');
            const hash = CryptoJS.SHA256(originalText).toString();
            $(this).text(hash.substring(0, 16) + '...');
        });

        $('#encryptionToggle').change(function() {
            const isDecrypted = $(this).is(':checked');
            const $toggle = $(this);
            
            // Disable the toggle while processing
            $toggle.prop('disabled', true);
            
            // Show loading state
            $toggle.closest('.card-body').append('<div class="encryption-loading">Updating encryption...</div>');
            
            // Make AJAX call to update encryption status
            $.ajax({
                url: '{{ route("setting.toggle.encryption") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    enabled: isDecrypted
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        toastr.success(response.message);
                        // Reload the page to reflect changes
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        // Show error message from server
                        toastr.error(response.message || 'Error updating encryption status');
                        // Revert the toggle
                        $toggle.prop('checked', !isDecrypted);
                    }
                },
                error: function(xhr) {
                    console.error('Error toggling encryption:', xhr);
                    // Get error message from response if available
                    let errorMessage = 'Error updating encryption status';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing error response:', e);
                    }
                    
                    // Show error message
                    toastr.error(errorMessage);
                    // Revert the toggle
                    $toggle.prop('checked', !isDecrypted);
                },
                complete: function() {
                    // Re-enable the toggle
                    $toggle.prop('disabled', false);
                    // Remove loading state
                    $('.encryption-loading').remove();
                }
            });
        });
    });
</script>
@endsection

@endsection 