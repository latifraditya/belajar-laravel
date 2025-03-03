@extends('layouts.main')

@section('container')

<div class="row justify-content-center">
  <div class="col-lg-5">
    <main class="form-registration w-100 m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>
      <form action="/register" method="post">
        @csrf
        <div class="form-floating mb-3">
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="your name" value="{{ old('name') }}" autofocus required>
          <label for="floatingInput">Name</label>
          @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <div class="form-floating mb-3">
          <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="username" required value="{{ old('username') }}">
          <label for="floatingInput">Username</label>
          @error('username')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <div class="form-floating mb-3">
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
          <label for="name">Email address</label>
          @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="password" required>
          <label for="floatingPassword">Password</label>
          @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
      </form>
      <small class="d-block text-center mt-3">If you already have an account? <a href="/login">Login</a></small>
    </main>
  </div>
</div>


@endsection