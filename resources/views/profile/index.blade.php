@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'User Profile'])

<div class="container-fluid py-4">
    <div class="row">
        <!-- Left Column: Preview -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Edit Profile</h6>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Username</label>
                                <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" class="form-control @error('username') is-invalid @enderror">
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control @error('email') is-invalid @enderror">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" class="form-control @error('firstname') is-invalid @enderror">
                                @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" class="form-control @error('lastname') is-invalid @enderror">
                                @error('lastname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Address</label>
                                <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}" class="form-control @error('address') is-invalid @enderror">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>City</label>
                                <input type="text" name="city" value="{{ old('city', auth()->user()->city) }}" class="form-control @error('city') is-invalid @enderror">
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Country</label>
                                <input type="text" name="country" value="{{ old('country', auth()->user()->country) }}" class="form-control @error('country') is-invalid @enderror">
                                @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Postal Code</label>
                                <input type="text" name="postal" value="{{ old('postal', auth()->user()->postal) }}" class="form-control @error('postal') is-invalid @enderror">
                                @error('postal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>About Me</label>
                                <textarea name="about" class="form-control @error('about') is-invalid @enderror" rows="3">{{ old('about', auth()->user()->about) }}</textarea>
                                @error('about') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Profile Preview</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if(auth()->user()->image)
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                                 class="avatar me-3" 
                                 alt="user image" 
                                 style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                        @else
                            <img src="{{ asset('img/avatar.jpg') }}" 
                                 class="avatar me-3" 
                                 alt="default image" 
                                 style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                        @endif
                    </div>                    
                    <h5>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h5>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <p class="text-bold">{{ auth()->user()->about }}</p>
                    <hr>
                    <ul class="list-unstyled text-center">
                        <li>
                            <strong>Username:</strong> {{ auth()->user()->username }}
                        </li>
                        <li>
                            <strong>Address:</strong> {{ auth()->user()->address }}
                        </li>
                        <li>
                            <strong>City:</strong> {{ auth()->user()->city }}
                        </li>
                        <li>
                            <strong>Country:</strong> {{ auth()->user()->country }}
                        </li>
                        <li>
                            <strong>Postal Code:</strong> {{ auth()->user()->postal }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
@endsection
