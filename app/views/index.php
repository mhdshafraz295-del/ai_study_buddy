<?php
session_start();    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AI Study Buddy</title>
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
            transition: transform 0.3s ease;
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
            flex-shrink: 0;
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

        .history-section {
            padding: 0 16px;
        }

        .history-title {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 12px;
            margin-bottom: 12px;
        }

        .history-list {
            list-style: none;
        }

        .history-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            border-radius: 8px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .history-item:hover {
            background: var(--bg-sidebar-hover);
            color: white;
        }

        .history-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            color: var(--text-muted);
        }

        .history-item-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-left: auto;
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

        .notification-btn.active {
            background: var(--primary-light);
        }

        .notification-btn svg {
            width: 20px;
            height: 20px;
            color: var(--text-light);
            transition: color 0.2s;
        }

        .notification-btn:hover svg,
        .notification-btn.active svg {
            color: var(--primary);
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

        /* Notification Dropdown */
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 320px;
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            border: 1px solid var(--border);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 100;
            overflow: hidden;
        }

        .notification-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .mark-all-read {
            font-size: 12px;
            color: var(--primary);
            cursor: pointer;
            background: none;
            border: none;
            font-weight: 500;
        }

        .mark-all-read:hover {
            text-decoration: underline;
        }

        .notification-list {
            max-height: 320px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: background 0.2s;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: var(--bg-body);
        }

        .notification-item.unread {
            background: var(--primary-light);
        }

        .notification-item.unread:hover {
            background: #c7d9fe;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-icon.upload {
            background: #dbeafe;
            color: var(--primary);
        }

        .notification-icon.quiz {
            background: #d1fae5;
            color: var(--success);
        }

        .notification-icon.system {
            background: #fef3c7;
            color: #f59e0b;
        }

        .notification-icon svg {
            width: 20px;
            height: 20px;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-text {
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .notification-text strong {
            font-weight: 600;
        }

        .notification-time {
            font-size: 11px;
            color: var(--text-muted);
        }

        .notification-empty {
            padding: 40px 20px;
            text-align: center;
        }

        .notification-empty svg {
            width: 48px;
            height: 48px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .notification-empty p {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Notification wrapper */
        .notification-wrapper {
            position: relative;
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

        .dropdown-arrow {
            width: 16px;
            height: 16px;
            color: var(--text-muted);
            transition: transform 0.2s;
        }

        .user-profile.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* User Dropdown Menu */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 240px;
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            border: 1px solid var(--border);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 100;
            overflow: hidden;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dropdown-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        .dropdown-user-info {
            flex: 1;
        }

        .dropdown-user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .dropdown-user-email {
            font-size: 12px;
            color: var(--text-muted);
        }

        .dropdown-menu {
            padding: 8px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: var(--bg-body);
            color: var(--text-dark);
        }

        .dropdown-item svg {
            width: 18px;
            height: 18px;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 0;
        }

        .dropdown-item.logout {
            color: var(--error);
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
            color: var(--error);
        }

        /* Profile wrapper for positioning */
        .user-profile-wrapper {
            position: relative;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 32px;
            max-width: 1200px;
        }

        .welcome-header {
            margin-bottom: 32px;
        }

        .welcome-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .welcome-header p {
            font-size: 15px;
            color: var(--text-light);
        }

        /* Upload Zone Card */
        .upload-card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 2px dashed var(--border);
            transition: all 0.3s;
            margin-bottom: 24px;
        }

        .upload-card:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.1);
        }

        .upload-content {
            text-align: center;
        }

        .upload-icon {
            width: 72px;
            height: 72px;
            background: var(--primary-light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .upload-icon svg {
            width: 32px;
            height: 32px;
            color: var(--primary);
        }

        .upload-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .upload-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
        }

        .file-input {
            position: absolute;
            width: 0;
            height: 0;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }

        .select-file-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .select-file-label:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .select-file-label svg {
            width: 18px;
            height: 18px;
        }

        .selected-file {
            margin-top: 16px;
            padding: 12px 20px;
            background: var(--primary-light);
            border-radius: 10px;
            display: none;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .selected-file.show {
            display: flex;
        }

        .selected-file-name {
            font-size: 14px;
            font-weight: 500;
            color: var(--primary);
        }

        .remove-file {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-file svg {
            width: 16px;
            height: 16px;
            color: var(--primary);
        }

        /* Action Button */
        .action-button-wrapper {
            margin-bottom: 32px;
        }

        .generate-btn {
            width: 100%;
            padding: 20px 32px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 14px -3px rgba(59, 130, 246, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .generate-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px -5px rgba(59, 130, 246, 0.5);
        }

        .generate-btn:active {
            transform: translateY(-1px);
        }

        .generate-btn:disabled {
            background: var(--text-muted);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .generate-btn svg {
            width: 24px;
            height: 24px;
        }

        /* Result Placeholder */
        .result-placeholder {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .result-placeholder-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-body);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .result-placeholder-icon svg {
            width: 40px;
            height: 40px;
            color: var(--text-muted);
        }

        .result-placeholder h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .result-placeholder p {
            font-size: 14px;
            color: var(--text-muted);
            max-width: 300px;
        }

         .created-by {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-muted);}

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 200;
            width: 44px;
            height: 44px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu-toggle svg {
            width: 24px;
            height: 24px;
            color: var(--text-dark);
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .top-navbar {
                padding: 12px 16px;
            }

            .user-info {
                display: none;
            }

            .dashboard-content {
                padding: 20px 16px;
            }

            .welcome-header h1 {
                font-size: 22px;
            }

            .upload-card {
                padding: 28px 20px;
            }

            .upload-title {
                font-size: 18px;
            }

            .generate-btn {
                padding: 16px 24px;
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .upload-icon {
                width: 60px;
                height: 60px;
                border-radius: 16px;
            }

            .upload-icon svg {
                width: 26px;
                height: 26px;
            }
        }

        /* Tablet landscape */
        @media (max-width: 900px) and (orientation: landscape) {
            .dashboard-content {
                padding: 16px;
            }

            .upload-card {
                padding: 20px;
            }

            .welcome-header {
                margin-bottom: 20px;
            }

            .welcome-header h1 {
                font-size: 20px;
            }

            .welcome-header p {
                font-size: 13px;
            }
        }

        /* Large tablets */
        @media (min-width: 769px) and (max-width: 1024px) {
            .dashboard-content {
                padding: 24px;
            }

            .upload-card {
                padding: 32px 24px;
            }
        }

        /* Small tablets */
        @media (min-width: 600px) and (max-width: 768px) {
            .upload-icon {
                width: 64px;
                height: 64px;
            }
        }

        /* Extra small devices */
        @media (max-width: 360px) {
            .mobile-menu-toggle {
                width: 40px;
                height: 40px;
                top: 12px;
                left: 12px;
            }

            .top-navbar {
                padding: 10px 12px;
            }

            .notification-btn {
                width: 36px;
                height: 36px;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .dashboard-content {
                padding: 16px 12px;
            }

            .welcome-header h1 {
                font-size: 18px;
            }

            .welcome-header p {
                font-size: 12px;
            }

            .upload-card {
                padding: 20px 16px;
            }

            .upload-icon {
                width: 52px;
                height: 52px;
                border-radius: 14px;
            }

            .upload-icon svg {
                width: 24px;
                height: 24px;
            }

            .upload-title {
                font-size: 16px;
            }

            .upload-subtitle {
                font-size: 12px;
            }

            .select-file-label {
                padding: 10px 18px;
                font-size: 13px;
            }

            .generate-btn {
                padding: 14px 20px;
                font-size: 14px;
                border-radius: 12px;
            }

            .generate-btn svg {
                width: 20px;
                height: 20px;
            }

            .result-placeholder {
                padding: 40px 20px;
            }

            .result-placeholder-icon {
                width: 60px;
                height: 60px;
                border-radius: 14px;
            }

            .result-placeholder-icon svg {
                width: 28px;
                height: 28px;
            }

            .result-placeholder h3 {
                font-size: 16px;
            }

            .result-placeholder p {
                font-size: 13px;
            }
        }

        /* Landscape mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .sidebar {
                width: 220px;
            }

            .sidebar-header {
                padding-bottom: 16px;
                margin-bottom: 16px;
            }

            .logo-icon {
                width: 36px;
                height: 36px;
            }

            .logo-text {
                font-size: 16px;
            }

            .nav-link {
                padding: 8px 12px;
            }

            .history-item {
                padding: 6px 10px;
            }

            .welcome-header {
                margin-bottom: 12px;
            }

            .welcome-header h1 {
                font-size: 18px;
            }

            .welcome-header p {
                display: none;
            }

            .upload-card {
                padding: 16px;
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .upload-content {
                display: flex;
                align-items: center;
                gap: 16px;
                width: 100%;
            }

            .upload-icon {
                width: 48px;
                height: 48px;
                margin: 0;
                flex-shrink: 0;
            }

            .upload-text {
                text-align: left;
                flex: 1;
            }

            .upload-title {
                font-size: 14px;
                margin-bottom: 2px;
            }

            .upload-subtitle {
                font-size: 11px;
                margin-bottom: 0;
            }

            .file-input-wrapper {
                margin-left: auto;
            }

            .select-file-label {
                padding: 8px 14px;
                font-size: 12px;
            }

            .action-button-wrapper {
                margin-bottom: 16px;
            }

            .generate-btn {
                padding: 12px 16px;
                font-size: 13px;
            }

            .result-placeholder {
                padding: 20px;
                min-height: 150px;
            }
            
       
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .nav-link,
            .history-item,
            .select-file-label {
                min-height: 44px;
            }

            .select-file-label:hover {
                transform: none;
            }

            .select-file-label:active {
                transform: scale(0.98);
            }

            .generate-btn:hover {
                transform: none;
            }

            .generate-btn:active {
                transform: scale(0.98);
            }

            .notification-btn:active {
                background: var(--primary-light);
            }

            .user-profile:active {
                background: var(--primary-light);
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .sidebar {
                border-right: 0.5px solid rgba(255, 255, 255, 0.1);
            }

            .upload-card,
            .result-placeholder {
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Print styles */
        @media print {
            .sidebar,
            .top-navbar,
            .mobile-menu-toggle,
            .sidebar-overlay {
                display: none !important;
            }

            .main-content {
                margin-left: 0;
            }

            .dashboard-content {
                padding: 0;
            }

            .upload-card,
            .result-placeholder {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="logo-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="logo-text">AI Study Buddy 📚</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Menu</div>
                <a href="index.php" class="nav-link active">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
            </div>
     
       <div class="recent-pdfs mt-6">
    <h3 style="text-transform: uppercase; font-size: 0.75rem; font-weight: 700; color: #d0d6e0;">Recent PDFS</h3>
    <ul class="space-y-1">
        <?php
        if (isset($conn) && isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $query = "SELECT file_name FROM documents WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 5";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li class="flex items-center px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 cursor-pointer transition-all group">';
                    echo '<i class="far fa-file-pdf mr-3 text-red-500 group-hover:scale-110 transition-transform"></i>';
                    echo '<span class="truncate">' . htmlspecialchars($row['file_name']) . '</span>';
                    echo '</li>';
                }
            } else {
                echo '<li class="px-4 py-2 text-xs text-gray-600 italic">No files found</li>';
            }
        }
        ?>
    </ul>
</div>

        
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="navbar-actions">
                <div class="notification-wrapper">
                    <button class="notification-btn" id="notificationBtn" onclick="toggleNotification()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.352 2.352 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="notification-badge"></span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <span class="notification-title">Notifications</span>
                            <button class="mark-all-read" onclick="markAllRead()">Mark all as read</button>
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div class="notification-item unread">
                                <div class="notification-icon upload">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-text"><strong>Physics_Notes.pdf</strong> uploaded successfully</div>
                                    <div class="notification-time">2 minutes ago</div>
                                </div>
                            </div>
                            <div class="notification-item unread">
                                <div class="notification-icon quiz">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-text">Quiz generated for <strong>History_Lesson.pdf</strong></div>
                                    <div class="notification-time">1 hour ago</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon system">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-text">Your summary is ready for <strong>Math_Formulas.pdf</strong></div>
                                    <div class="notification-time">3 hours ago</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon system">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-text">Welcome to <strong>AI Study Buddy!</strong> Start by uploading your first PDF.</div>
                                    <div class="notification-time">1 day ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="user-profile-wrapper">
                    <div class="user-profile" id="userProfile" onclick="toggleUserDropdown()">
                        <div class="user-avatar">JS</div>
                        <div class="user-info">
                            <span class="user-name">
                                <?php
                                // Assuming you have a session variable for the user's name
                                if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                                    echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
                                } else {
                                    echo 'User';
                                }
                                ?>
                            </span>
                            <span class="user-role">Student</span>
                        </div>
                        <svg class="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <!-- User Dropdown Menu -->
                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-header">
                            <div class="dropdown-avatar">JS</div>
                            <div class="dropdown-user-info">
                                <div class="dropdown-user-name">
                                    <?php
                                    if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                                        echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
                                    } else {
                                        echo 'User';
                                    }
                                    ?>
                                </div>
                                <div class="dropdown-user-email">
                                    <?php
                                    if (isset($_SESSION['email'])) {
                                        echo $_SESSION['email'];
                                    } else {
                                        echo 'user@example.com';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-menu">
                          
                            <button class="dropdown-item" onclick="openSettings()">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Settings
                            </button>
                          
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item logout" onclick="logout()">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Log Out
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Welcome Header -->
            <div class="welcome-header">
                <h1>Welcome back, <span>
                     <?php
                                // Assuming you have a session variable for the user's name
                                if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                                    echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
                                } else {
                                    echo 'User';
                                }
                                ?>
                </span>!🙌🥰</h1>
                <p>Upload your study materials and let AI generate summaries and quizzes for you.</p>
            </div>

            <!-- Upload Zone Card -->
            <div class="upload-card">
                <div class="upload-content">
                    <div class="upload-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    
                    <h2 class="upload-title">Upload your PDF study notes</h2>
                    <p class="upload-subtitle">Max size 20MB</p>

                    <form action="../../upload_logic.php" method="POST" enctype="multipart/form-data" class="file-input-wrapper">
                        <input type="file" id="pdfInput" name="pdf_file" class="file-input" accept=".pdf" required onchange="this.form.submit()">
                        
                        <label for="pdfInput" class="select-file-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Select File
                        </label>
                    </form>

                    <div class="selected-file" id="selectedFile">
                        <span class="selected-file-name" id="fileName"></span>
                        <button class="remove-file" onclick="removeFile()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="action-button-wrapper">
                <button class="generate-btn" id="generateBtn" onclick="generateSummary()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Generate Summary & Quiz ✨
                </button>
            </div>

            <!-- Result Placeholder -->
            <div id="aiResponseArea" class="result-placeholder">
                <div class="result-placeholder-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3>No results yet</h3>
                <p>Upload a PDF and click generate to see your AI-created summary and quiz here.</p>
            </div>
        </div>
    
        <div class="created-by">
                Created by <span>Naseerdeen Mohamed Safras</span>
            </div>
        
    </main>

    <script>
        // File input handling
        const pdfInput = document.getElementById('pdfInput');
        const selectedFile = document.getElementById('selectedFile');
        const fileName = document.getElementById('fileName');
        const generateBtn = document.getElementById('generateBtn');

        pdfInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (file.size > 20 * 1024 * 1024) {
                    alert('File size exceeds 20MB limit');
                    this.value = '';
                    return;
                }
                fileName.textContent = file.name;
                selectedFile.classList.add('show');
                generateBtn.disabled = false;
            }
        });

        function removeFile() {
            pdfInput.value = '';
            selectedFile.classList.remove('show');
            fileName.textContent = '';
            generateBtn.disabled = true;
        }

        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // User dropdown toggle
        function toggleUserDropdown() {
            const profile = document.getElementById('userProfile');
            const dropdown = document.getElementById('userDropdown');
            profile.classList.toggle('active');
            dropdown.classList.toggle('show');
        }

        // Notification dropdown toggle
        function toggleNotification() {
            const btn = document.getElementById('notificationBtn');
            const dropdown = document.getElementById('notificationDropdown');
            btn.classList.toggle('active');
            dropdown.classList.toggle('show');
        }

        // Mark all as read
        function markAllRead() {
            const items = document.querySelectorAll('.notification-item.unread');
            items.forEach(item => {
                item.classList.remove('unread');
            });
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                badge.style.display = 'none';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const profile = document.getElementById('userProfile');
            const dropdown = document.getElementById('userDropdown');
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationDropdown = document.getElementById('notificationDropdown');
            
            if (!profile.contains(e.target) && !dropdown.contains(e.target)) {
                profile.classList.remove('active');
                dropdown.classList.remove('show');
            }
            
            if (notificationBtn && !notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationBtn.classList.remove('active');
                notificationDropdown.classList.remove('show');
            }
        });

        // Logout function
        function logout() {
            if (confirm('Are you sure you want to log out?')) {
                // Add your logout logic here
                window.location.href = '/ai_study_buddy/app/views/login.php';
            }
        }

        // Dropdown item functions
        function openProfile() {
            document.getElementById('profileModal').style.display = 'flex';
        }

        function openSettings() {
            window.location.href = '../../app/views/settings.php';
        }

        function openHelp() {
            document.getElementById('helpModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

            async function generateSummary() {
            const area = document.getElementById('aiResponseArea');
            if (!area) return;

            area.innerHTML = "⏳ AI is processing... Please wait.";

            try {
                const response = await fetch('process_ai.php');
                const data = await response.json();

                if (data.candidates && data.candidates[0].content.parts[0].text) {
                    const summaryText = data.candidates[0].content.parts[0].text;
                    area.innerHTML = `
                        <div class="ai-card" style="padding: 15px; background: #eef2ff; border-radius: 8px;">
                            <h3>✨ AI Summary</h3>
                            <p>${summaryText.replace(/\n/g, '<br>')}</p>
                        </div>
                    `;
                } else if (data.error) {
                    area.innerHTML = `<p style="color:red;">Error: ${data.error.message}</p>`;
                }
            } catch (error) {
                area.innerHTML = "<p style='color:red;'>Connection Error!</p>";
            }
        }

        




    </script>
</body>
</html>