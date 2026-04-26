<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AI Study Buddy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --primary-light: #dbeafe;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --text-muted: #9ca3af;
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --bg-sidebar: #1e293b;
            --bg-sidebar-hover: #334155;
            --border: #e5e7eb;
            --success: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-body);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: var(--bg-sidebar);
            padding: 24px 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-header {
            padding: 0 24px 32px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 24px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 24px;
            height: 24px;
            color: white;
        }

        .logo-text {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 16px;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 32px;
        }

        .nav-section-title {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 12px;
            margin-bottom: 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--bg-sidebar-hover);
            color: white;
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            background: var(--bg-card);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--bg-body);
            border-radius: 10px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .menu-toggle svg {
            width: 20px;
            height: 20px;
            color: var(--text-light);
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notification-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--bg-body);
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .notification-btn:hover {
            background: var(--primary-light);
        }

        .notification-btn svg {
            width: 20px;
            height: 20px;
            color: var(--text-light);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--error);
            border-radius: 50%;
            border: 2px solid var(--bg-card);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px 6px 6px;
            background: var(--bg-body);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile:hover {
            background: var(--primary-light);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-role {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Settings Content */
        .settings-container {
            padding: 32px;
            max-width: 1200px;
        }

        .settings-header {
            margin-bottom: 32px;
        }

        .settings-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .settings-subtitle {
            font-size: 14px;
            color: var(--text-light);
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 24px;
        }

        /* Settings Navigation */
        .settings-nav {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 16px;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .settings-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .settings-nav-item:hover {
            background: var(--bg-body);
            color: var(--text-dark);
        }

        .settings-nav-item.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .settings-nav-item svg {
            width: 20px;
            height: 20px;
        }

        /* Settings Content Area */
        .settings-content {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .settings-section {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
        }

        .section-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .section-subtitle {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Profile Settings */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 24px;
        }

        .profile-avatar-wrapper {
            position: relative;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            font-weight: 600;
        }

        .avatar-edit-btn {
            position: absolute;
            bottom: -4px;
            right: -4px;
            width: 28px;
            height: 28px;
            background: var(--primary);
            border: 3px solid var(--bg-card);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .avatar-edit-btn:hover {
            background: var(--primary-hover);
        }

        .avatar-edit-btn svg {
            width: 14px;
            height: 14px;
            color: white;
        }

        .profile-info h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .profile-info p {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Form Groups */
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-label .required {
            color: var(--error);
        }

        .form-input {
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
            background: var(--bg-body);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--primary-light);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

         .created-by {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-muted);}

        select.form-input {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 40px;
        }

        /* Toggle Switch */
        .toggle-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }

        .toggle-group:last-child {
            border-bottom: none;
        }

        .toggle-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .toggle-info p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .toggle-switch {
            position: relative;
            width: 48px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--border);
            border-radius: 26px;
            transition: 0.3s;
        }

        .toggle-slider::before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch input:checked + .toggle-slider {
            background: var(--primary);
        }

        .toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(22px);
        }

        /* Danger Zone */
        .danger-zone {
            border: 1px solid #fecaca;
            background: #fef2f2;
        }

        .danger-zone .section-title {
            color: var(--error);
        }

        .danger-btn {
            padding: 12px 24px;
            background: white;
            border: 2px solid var(--error);
            border-radius: 10px;
            color: var(--error);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .danger-btn:hover {
            background: var(--error);
            color: white;
        }

        /* Action Buttons */
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-top: 8px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: var(--bg-body);
            color: var(--text-dark);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }

            .settings-nav {
                position: static;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 12px;
            }

            .settings-nav-item {
                flex: 1;
                min-width: 140px;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: flex;
            }

            .top-navbar {
                padding: 16px;
            }

            .settings-container {
                padding: 16px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .user-info {
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="logo-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="logo-text">AI Study Buddy</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
               
              
                <a href="/ai_study_buddy/app/views/index.php" class="nav-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    AI Chat
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Account</div>
                <a href="?page=settings" class="nav-link active">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="navbar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="page-title">Settings</h1>
            </div>

            
        </header>

        <!-- Settings Content -->
        <div class="settings-container">
            <div class="settings-header">
                <h2 class="settings-title">Account Settings</h2>
                <p class="settings-subtitle">Manage your account preferences and settings</p>
            </div>

            <div class="settings-grid">
                <!-- Settings Navigation -->
                <nav class="settings-nav">
                    <button class="settings-nav-item active" onclick="showSection('profile')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile
                    </button>
                    <button class="settings-nav-item" onclick="showSection('account')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Account
                    </button>
                  
                  
                </nav>

                <!-- Settings Content -->
                <div class="settings-content">
                    <!-- Profile Section -->
                    <section class="settings-section" id="profile-section">
                        <div class="section-header">
                            <h3 class="section-title">Profile Information</h3>
                            <p class="section-subtitle">Update your personal information</p>
                        </div>

                        <div class="profile-header">
                            <div class="profile-avatar-wrapper">
                                <div class="profile-avatar">JS</div>
                                <button class="avatar-edit-btn">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="profile-info">
                                <h3>
                                    <?php
                                    if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                                        echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
                                    } else {
                                        echo 'User';
                                    }
                                    ?>
                                </h3>
                                <p>
                                    <span> <?php
                                    if (isset($_SESSION['email'])) {
                                        echo $_SESSION['email'];
                                    } else {
                                        echo 'user@example.com';
                                    }
                                    ?></span>
                                </p>
                            </div>
                        </div>

                        <form>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">First Name <span class="required">*</span></label>
                                    <input type="text" class="form-input" required placeholder="mohamed">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-input" required placeholder="safras">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Email Address <span class="required">*</span></label>
                                    <input type="email" class="form-input" required placeholder="mhdshafraz295@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-input" placeholder="+94774254552">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-input" value="2001-07-15">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gender</label>
                                    <select class="form-input">
                                        <option value="">Select gender</option>
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                        <option value="prefer">Prefer not to say</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Bio</label>
                                <textarea class="form-input" rows="3" placeholder="Tell us about yourself...">Passionate learner interested in AI and machine learning.</textarea>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </section>

                    <!-- Account Section -->
                    <section class="settings-section" id="account-section" style="display: none;">
                        <div class="section-header">
                            <h3 class="section-title">Account Settings</h3>
                            <p class="section-subtitle">Manage your account security and preferences</p>
                        </div>

                        <form>
                            <div class="form-group">
                                <label class="form-label">Username <span class="required">*</span></label>
                                <input type="text" class="form-input" required placeholder="mohamedsafras">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Change Password</label>
                                <input type="password" class="form-input" placeholder="Current password">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <input type="password" class="form-input" placeholder="New password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-input" placeholder="Confirm new password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Language</label>
                                <select class="form-input">
                                    <option value="en" selected>English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                    <option value="zh">Chinese</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Timezone</label>
                                <select class="form-input">
                                    <option value="UTC-5" selected>Eastern Time (ET)</option>
                                    <option value="UTC-6">Central Time (CT)</option>
                                    <option value="UTC-7">Mountain Time (MT)</option>
                                    <option value="UTC-8">Pacific Time (PT)</option>
                                    <option value="UTC">UTC</option>
                                </select>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </section>

                   


                    <!-- Danger Zone -->
                    <section class="settings-section danger-zone">
                        <div class="section-header">
                            <h3 class="section-title">Danger Zone</h3>
                            <p class="section-subtitle">Irreversible actions for your account</p>
                        </div>

                        <div class="toggle-group">
                            <div class="toggle-info">
                                <h4>Delete Account</h4>
                                <p>Permanently delete your account and all data</p>
                            </div>
                            <button class="danger-btn">Delete Account</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="created-by">
                Created by <span>Naseerdeen Mohamed Safras</span>
            </div>
    </main>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }

        // Show settings section
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.settings-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });

            // Show selected section
            document.getElementById(sectionId + '-section').style.display = 'block';

            // Update active nav item
            const navItems = document.querySelectorAll('.settings-nav-item');
            navItems.forEach(item => {
                item.classList.remove('active');
            });
            event.target.closest('.settings-nav-item').classList.add('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.sidebar');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    </script>
</body>
</html>