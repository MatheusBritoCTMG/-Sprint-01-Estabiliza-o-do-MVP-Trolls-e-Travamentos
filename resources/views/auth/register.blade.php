@extends('layouts.app')

@section('title', 'Cadastro — FalaQ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm p-4">
            <h4 class="fw-bold mb-3">📝 Criar conta</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-secondary">Nome</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="form-control bg-dark text-white border-secondary" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-secondary">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-secondary">Senha</label>
                    <input type="password" name="password" id="password"
                           class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label text-secondary">Confirmar senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control bg-dark text-white border-secondary" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Cadastrar</button>
            </form>

            <p class="text-secondary small mt-3 mb-0">
                Já tem conta? <a href="{{ route('login') }}">Entrar</a>
            </p>
        </div>
    </div>
</div>
@endsection
