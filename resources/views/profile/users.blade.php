<head><style>
    .action-btn {
    color: #5e72e4;
    text-decoration: none;
    transition: color 0.3s ease;
}

.action-btn.delete {
    color: black;
}

.action-btn.delete:hover {
    color: #ff0000;
}

</style></head>
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
     <!-- Flash Messages - Hidden, will be handled by SweetAlert -->
     <div class="container mt-2" style="display: none;">
        <div id="success-message" data-message="{{ session('success') }}"></div>
        <div id="error-message" data-message="{{ session('error') }}"></div>
        <div id="validation-errors" data-errors="{{ json_encode($errors->all()) }}"></div>
    </div>
    <!-- End Flash Messages -->
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Users</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Register a new User</button>
                </div>
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Register New User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="max-height: 540px;">
                                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="position-relative">
                                                <label for="user-image" style="cursor: pointer; margin-bottom: 0;">
                                                    <img id="preview-image" src="{{ asset('img/avatar.jpg') }}" alt="User Image" 
                                                        class="avatar avatar-xl rounded-circle mb-2" 
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    
                                                </label>
                                                <input type="file" name="image" id="user-image" class="d-none" accept="image/*" onchange="previewImage(this)">
                                            </div>
                                        </div>
                                        <small class="text-muted">Click on the image to upload a photo</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstname" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" id="role" name="role_id" required>
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Register User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Preview Script (Register new user) -->   
                <script>
                    function previewImage(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            
                            reader.onload = function(e) {
                                document.getElementById('preview-image').src = e.target.result;
                            }
                            
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Create Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                @if($user->image)
                                                    <img src="{{ asset('storage/' . $user->image) }}" class="avatar me-3" alt="user image">
                                                @else
                                                    <img src="{{ asset('img/avatar.jpg') }}" class="avatar me-3" alt="default image">
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->username }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->role->name ?? 'No Role' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="#" class="text-sm font-weight-bold cursor-pointer me-3" 
                                            data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}"
                                            style="color: #5e72e4; text-decoration: none; transition: color 0.3s ease;">Edit</a>
                                            
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-sm font-weight-bold cursor-pointer bg-transparent border-0 p-0"
                                                        style="color: #f5365c; transition: color 0.3s ease;"
                                                        onmouseover="this.style.color='#ff0000'"
                                                        onmouseout="this.style.color='#f5365c'"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Edit User Modals -->
                @foreach($users as $user)
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User: {{ $user->username }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3 text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="position-relative">
                                                <label for="user-image-{{ $user->id }}" style="cursor: pointer; margin-bottom: 0;">
                                                    <img id="preview-image-{{ $user->id }}" 
                                                         src="{{ $user->image ? asset('storage/' . $user->image) : asset('img/avatar.jpg') }}" 
                                                         alt="User Image" 
                                                         class="avatar avatar-xl rounded-circle mb-2" 
                                                         style="width: 5px; height: 5px; object-fit: cover;">
                                                </label>                                                
                                                <input type="file" name="image" id="user-image-{{ $user->id }}" class="d-none" accept="image/*" 
                                                onchange="previewEditImage(this, '{{ $user->id }}')">
                                            </div>
                                        </div>
                                        <small class="text-muted">Click on the image to upload a new photo</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username-{{ $user->id }}" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username-{{ $user->id }}" name="username" 
                                            value="{{ $user->username }}" required>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstname-{{ $user->id }}" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstname-{{ $user->id }}" name="firstname" 
                                                value="{{ $user->firstname }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastname-{{ $user->id }}" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastname-{{ $user->id }}" name="lastname" 
                                                value="{{ $user->lastname }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email-{{ $user->id }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email-{{ $user->id }}" name="email" 
                                                value="{{ $user->email }}" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="role-{{ $user->id }}" class="form-label">Role</label>
                                            <select class="form-select" id="role-{{ $user->id }}" name="role_id" required>
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password-{{ $user->id }}" class="form-label">New Password (leave blank to keep current)</label>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation-{{ $user->id }}" class="form-label">Confirm New Password</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            
                                            <input type="password" class="form-control" id="password-{{ $user->id }}" name="password">
                                           
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            
                                            <input type="password" class="form-control" id="password_confirmation-{{ $user->id }}" name="password_confirmation">
                                        </div>
                                    </div>
                                    <small class="text-muted">Only fill this if you want to change the password</small>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Image Preview Script (Edit user) -->
    <script>
        function previewEditImage(input, userId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('preview-image-' + userId).src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Handle success message
        const successMessage = document.getElementById('success-message').dataset.message;
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: successMessage,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
        }

        // Handle error message
        const errorMessage = document.getElementById('error-message').dataset.message;
        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
        }

        // Handle validation errors
        const validationErrors = document.getElementById('validation-errors').dataset.errors;
        if (validationErrors && validationErrors !== '[]') {
            const errors = JSON.parse(validationErrors);
            let errorHtml = '<ul style="text-align: left; padding-left: 20px;">';
            errors.forEach(error => {
                errorHtml += `<li>${error}</li>`;
            });
            errorHtml += '</ul>';
            
            Swal.fire({
                icon: 'warning',
                title: 'Please check the form for errors',
                html: errorHtml,
                timer: 5000,
                timerProgressBar: true,
                position: 'top',
                showConfirmButton: true
            });
        }
    });

    </script>
    @include('layouts.footers.auth.footer')
@endsection