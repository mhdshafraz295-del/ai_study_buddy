<?php
include '../../config/db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if ($password === $user['password']) {
            // Start session and set user data
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            header('Location:index.php');
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('No account found with that email. Please register.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Study Buddy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: #e0e7ff;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --text-muted: #9ca3af;
            --bg-body: #f9fafb;
            --bg-card: #ffffff;
            --border: #e5e7eb;
            --success: #10b981;
            --error: #ef4444;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: var(--bg-card);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 48px 40px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 10px 30px -5px rgba(99, 102, 241, 0.4);
        }

        .logo-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .logo p {
            font-size: 14px;
            color: var(--text-light);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            font-size: 15px;
            border: 2px solid var(--border);
            border-radius: 12px;
            outline: none;
            transition: all 0.2s;
            background: var(--bg-body);
        }

        .form-group input:focus {
            border-color: var(--primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--primary-light);
        }

        .form-group input:focus + svg,
        .input-wrapper:focus-within svg {
            color: var(--primary);
        }

        .form-group input::placeholder {
            color: var(--text-muted);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-me span {
            color: var(--text-light);
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: var(--primary-hover);
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px -3px rgba(99, 102, 241, 0.5);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(99, 102, 241, 0.5);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 28px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            padding: 0 16px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .social-login {
            display: flex;
            gap: 12px;
        }

        .social-btn {
            flex: 1;
            padding: 14px 16px;
            background: var(--bg-card);
            border: 2px solid var(--border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            position: relative;
            overflow: hidden;
        }

        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .social-btn:hover {
            border-color: var(--primary);
            background: var(--bg-card);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px -6px rgba(99, 102, 241, 0.3);
        }

        .social-btn:hover::before {
            opacity: 1;
        }

        .social-btn:active {
            transform: translateY(0) scale(0.98);
            box-shadow: none;
        }

        .social-btn:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
        }

        .social-btn:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .social-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .social-btn svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .social-btn .btn-text {
            position: relative;
            z-index: 1;
        }

        /* Google specific hover */
        .social-btn.google:hover {
            border-color: #4285F4;
            box-shadow: 0 6px 20px -6px rgba(66, 133, 244, 0.3);
        }

        /* Facebook specific hover */
        .social-btn.facebook:hover {
            border-color: #1877F2;
            box-shadow: 0 6px 20px -6px rgba(24, 119, 242, 0.3);
        }

        .signup-link {
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
            color: var(--text-light);
        }

        .signup-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .signup-link a:hover {
            color: var(--primary-hover);
        }

        .created-by {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-muted);
        }

        .created-by span {
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Floating shapes background */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: -1;
        }

        .bg-shapes::before,
        .bg-shapes::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .bg-shapes::before {
            width: 300px;
            height: 300px;
            background: white;
            top: -100px;
            right: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .bg-shapes::after {
            width: 200px;
            height: 200px;
            background: white;
            bottom: -50px;
            left: -50px;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 30px); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 16px;
                align-items: flex-start;
                padding-top: 40px;
                padding-bottom: 40px;
            }

            .login-card {
                padding: 28px 20px;
            }

            .logo {
                margin-bottom: 24px;
            }

            .logo-icon {
                width: 56px;
                height: 56px;
                border-radius: 14px;
                margin-bottom: 12px;
            }

            .logo-icon svg {
                width: 28px;
                height: 28px;
            }

            .logo h1 {
                font-size: 22px;
                margin-bottom: 4px;
            }

            .logo p {
                font-size: 13px;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-group label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .form-group input {
                padding: 12px 14px 12px 42px;
                font-size: 14px;
                border-radius: 10px;
            }

            .input-wrapper svg {
                width: 18px;
                height: 18px;
                left: 14px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 20px;
            }

            .remember-me {
                font-size: 13px;
            }

            .remember-me input {
                width: 16px;
                height: 16px;
            }

            .forgot-password {
                font-size: 13px;
                align-self: flex-start;
            }

            .login-btn {
                padding: 14px;
                font-size: 15px;
                border-radius: 10px;
            }

            .divider {
                margin: 20px 0;
            }

            .divider span {
                font-size: 12px;
                padding: 0 12px;
            }

            .social-login {
                flex-direction: column;
                gap: 10px;
            }

            .social-btn {
                padding: 12px;
                font-size: 13px;
                border-radius: 10px;
            }

            .social-btn svg {
                width: 18px;
                height: 18px;
            }

            .signup-link {
                margin-top: 20px;
                font-size: 13px;
            }

            .bg-shapes::before {
                width: 200px;
                height: 200px;
            }

            .bg-shapes::after {
                width: 150px;
                height: 150px;
            }
        }

        /* Extra small devices */
        @media (max-width: 360px) {
            .login-card {
                padding: 24px 16px;
            }

            .logo h1 {
                font-size: 20px;
            }

            .form-group input {
                padding: 11px 12px 11px 38px;
                font-size: 13px;
            }
        }

        /* Landscape mode for mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                padding: 16px;
                align-items: center;
                min-height: auto;
            }

            .login-card {
                padding: 20px;
            }

            .logo {
                margin-bottom: 16px;
            }

            .logo-icon {
                width: 44px;
                height: 44px;
                margin-bottom: 8px;
            }

            .logo-icon svg {
                width: 22px;
                height: 22px;
            }

            .logo h1 {
                font-size: 18px;
            }

            .logo p {
                display: none;
            }

            .form-group {
                margin-bottom: 12px;
            }

            .divider {
                margin: 16px 0;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .form-group input {
                padding-top: 14px;
                padding-bottom: 14px;
            }

            .login-btn {
                padding: 16px;
            }

            .social-btn {
                padding: 14px;
            }

            .login-btn:hover,
            .social-btn:hover {
                transform: none;
            }

            .login-btn:active,
            .social-btn:active {
                transform: scale(0.98);
            }
        }
    </style>
</head>
<body>
    <div class="bg-shapes"></div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to continue your learning journey</p>
            </div>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="you@example.com" required>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="/forgot-password" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn">Sign In</button>
            </form>

            <div class="signup-link">
                Don't have an account? <a href="/ai_study_buddy/app/views/register.php">Create one</a>
            </div>

            <div class="created-by">
                Created by <span>Naseerdeen Mohamed Safras</span>
            </div>
        </div>
    </div>
</body>
</html>