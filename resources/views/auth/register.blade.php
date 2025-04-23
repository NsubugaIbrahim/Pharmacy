<head>
<style>
    .backdrop-filter {
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
    }
    
    .bg-white\/30 {
        background-color: rgba(255, 255, 255, 0.3);
    }
    
    .card.backdrop-filter {
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }
    .page-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-image: url('/img/register-bg.jpg');
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        
        /* Center the card */
        .card-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 400px;
        }
        
        .card {
        backdrop-filter: blur(10px);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.2) 100%);
        border-radius: 15px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
        .backdrop-blur-lg {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 20px;
}

</style>

<head>
@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <body>
    <main class="main-content">
        <div class="page-header"></div>
        <div class="container" >
            <div class="card-container backdrop-blur-lg bg-white/30 shadow-lg rounded-lg p-4" style="margin-top: 40px;">
                <div class="card shadow-lg" style = "background: linear-gradient(135deg, rgba(173, 250, 255, 0.7) 0%, rgba(230, 245, 255, 0.5) 100%); border-radius: 10px;">
                    <div class="text-center pt-4">
                        <h5>Register</h5>
                    </div>
                    <div class="card-body" style="background: linear-gradient(135deg, rgba(240, 250, 255, 0.7) 0%, rgba(230, 245, 255, 0.5) 100%); border-radius: 10px; padding: 20px;">
                            <form method="POST" action="{{ route('register.perform') }}">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terms" id="terms">
                                    <label class="form-check-label" for="terms"> I agree to the <a href="#">Terms and Conditions</a> </label>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-dark w-100">Sign up</button>
                                </div>
                                <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    @include('layouts.footers.guest.footer')
@endsection
