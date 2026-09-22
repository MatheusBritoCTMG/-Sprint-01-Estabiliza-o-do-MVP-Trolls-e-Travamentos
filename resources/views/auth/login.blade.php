@extends('layouts.app')

@section('title', 'Login — FalaQ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm p-4">
            <h4 class="fw-bold mb-3">🔐 Entrar</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-secondary">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="form-control bg-dark text-white border-secondary" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-secondary">Senha</label>
                    <input type="password" name="password" id="password"
                           class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label text-secondary">Lembrar-me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Entrar</button>
            </form>

            <p class="text-secondary small mt-3 mb-0">
                Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>
@endsection
