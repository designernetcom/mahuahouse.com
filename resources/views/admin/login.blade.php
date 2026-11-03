<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Mahua House</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#033631 0%,#07554D 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;}
.login-card{background:#fff;border-radius:20px;padding:40px 36px;width:100%;max-width:400px;box-shadow:0 20px 60px rgba(0,0,0,.25);}
.login-logo{text-align:center;margin-bottom:28px;}
.login-logo img{max-height:56px;max-width:200px;}
.login-title{font-size:20px;font-weight:700;color:#033631;text-align:center;margin-bottom:4px;}
.login-sub{font-size:13px;color:#888;text-align:center;margin-bottom:28px;}
.form-label{font-size:13px;font-weight:600;color:#444;}
.form-control{border-radius:10px;border-color:#dde5dd;font-size:14px;padding:10px 14px;}
.form-control:focus{border-color:#033631;box-shadow:0 0 0 3px rgba(3,54,49,.1);}
.btn-login{background:#033631;color:#fff;border:none;width:100%;padding:12px;border-radius:10px;font-size:14px;font-weight:700;letter-spacing:.3px;cursor:pointer;transition:all .2s;}
.btn-login:hover{background:#044a43;}
.input-group-text{border-radius:10px 0 0 10px;border-color:#dde5dd;background:#f8faf8;}
</style>
</head>
<body>
<div class="login-card">
  <div class="login-logo">
    <img src="/site/assets/images/logo/Mahua-House-Logo.png" alt="Mahua House" onerror="this.src='/site/assets/images/favicon.png'">
  </div>
  <h4 class="login-title">Admin Panel</h4>
  <p class="login-sub">Sign in to manage your website content</p>

  @if($errors->any())
  <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:13px;border-radius:10px;">
    {{ $errors->first() }}
  </div>
  @endif

  <form method="POST" action="{{ route('admin.login.post') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" placeholder="admin@mahuahouse.com" value="{{ old('email') }}" required autofocus>
    </div>
    <div class="mb-4">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter password" required>
    </div>
    <button type="submit" class="btn-login">Sign In <i class="ms-1">→</i></button>
  </form>

  <p class="text-center mt-4 mb-0" style="font-size:12px;color:#aaa;">
    Mahua House Content Management System
  </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
