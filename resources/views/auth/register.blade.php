<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'Visticle') }}</title>
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
    <h2>Register</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Register</button>
    </form>

    <div class="link">
        Already have an account? <a href="{{ route('login') }}">Login</a>
    </div>
</body>
</html>

