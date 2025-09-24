<form method="POST" action="{{ url('/register') }}">
    @csrf
    <label for="nisn">NISN</label>
    <input type="text" name="nisn" required>
    
    <label for="password">Password</label>
    <input type="password" name="password" required>
    
    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" required>
    
    <button type="submit">Daftar</button>
</form>
