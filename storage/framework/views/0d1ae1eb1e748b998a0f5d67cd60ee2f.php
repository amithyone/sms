<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FaddedSMS - Under Maintenance</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .maintenance-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            max-width: 600px;
            width: 90%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .maintenance-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .status-icon {
            font-size: 4rem;
            color: #f39c12;
            margin: 1rem 0;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .title {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        
        .subtitle {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .status-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 2rem 0;
            border-left: 4px solid #667eea;
        }
        
        .status-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .status-message {
            color: #7f8c8d;
            font-size: 0.95rem;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 1rem 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            width: 75%;
            animation: progress 3s ease-in-out infinite;
        }
        
        @keyframes progress {
            0%, 100% { width: 75%; }
            50% { width: 85%; }
        }
        
        .contact-info {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0.5rem 0;
            color: #7f8c8d;
        }
        
        .contact-item i {
            margin-right: 0.5rem;
            color: #667eea;
            width: 20px;
        }
        
        .social-links {
            margin-top: 1.5rem;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 0.5rem;
            color: #667eea;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: #764ba2;
        }
        
        .estimated-time {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin: 1.5rem 0;
            color: #856404;
        }
        
        .refresh-button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin-top: 1rem;
        }
        
        .refresh-button:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .maintenance-container {
                padding: 2rem;
                margin: 1rem;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .logo {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="logo">
            <i class="fas fa-sms"></i> FaddedSMS
        </div>
        
        <div class="status-icon">
            <i class="fas fa-tools"></i>
        </div>
        
        <h1 class="title">We're Upgrading Our System</h1>
        
        <p class="subtitle">
            We're currently performing essential maintenance to improve your SMS experience. 
            Our team is working hard to bring you back online as soon as possible.
        </p>
        
        <div class="status-card">
            <div class="status-title">
                <i class="fas fa-cog fa-spin"></i> Maintenance Status
            </div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            <div class="status-message">
                System optimization in progress...
            </div>
        </div>
        
        <div class="estimated-time">
            <i class="fas fa-clock"></i>
            <strong>Estimated Completion:</strong> 30-45 minutes
        </div>
        
        <div class="contact-info">
            <h3 style="color: #2c3e50; margin-bottom: 1rem;">Need Help?</h3>
            
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <span>support@faddedsms.com</span>
            </div>
            
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <span>+234 XXX XXX XXXX</span>
            </div>
            
            <div class="contact-item">
                <i class="fas fa-globe"></i>
                <span>www.faddedsms.com</span>
            </div>
            
            <div class="social-links">
                <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="#" title="Telegram"><i class="fab fa-telegram"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
        
        <button class="refresh-button" onclick="window.location.reload()">
            <i class="fas fa-sync-alt"></i> Check Status
        </button>
        
        <div style="margin-top: 2rem; font-size: 0.85rem; color: #95a5a6;">
            <p>Thank you for your patience. We're working to serve you better!</p>
            <p style="margin-top: 0.5rem;">
                <i class="fas fa-heart" style="color: #e74c3c;"></i> 
                Powered by FaddedSMS Team
            </p>
        </div>
    </div>
    
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            window.location.reload();
        }, 30000);
        
        // Update progress message every 5 seconds
        const messages = [
            "System optimization in progress...",
            "Database maintenance running...",
            "Security updates being applied...",
            "Performance improvements in progress...",
            "Finalizing system updates..."
        ];
        
        let messageIndex = 0;
        setInterval(function() {
            const statusMessage = document.querySelector('.status-message');
            statusMessage.textContent = messages[messageIndex];
            messageIndex = (messageIndex + 1) % messages.length;
        }, 5000);
    </script>
</body>
</html>
<?php /**PATH /Users/amiithyone/Documents/faddedsms/resources/views/errors/503.blade.php ENDPATH**/ ?>