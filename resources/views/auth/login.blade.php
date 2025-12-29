<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Visticle') }}</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        h2 { text-align: center; }
        form { margin: 20px 0; }
        label { display: block; margin: 10px 0 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <h2>Login</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label>
            <input type="checkbox" name="remember"> Remember me
        </label>

        <button type="submit">Login</button>
    </form>

    <div class="link">
        Don't have an account? <a href="{{ route('register') }}">Register</a>
    </div>
</body>
</html>

