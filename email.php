<?php
session_start();

// Load environment configuration
require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Configuration
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_USER', getenv('SMTP_USER') ?: '');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
define('SMTP_PORT', (int)(getenv('SMTP_PORT') ?: 587));
define('SMTP_SECURE', getenv('SMTP_SECURE') ?: 'tls');
define('ADMIN_EMAIL', getenv('ADMIN_EMAIL') ?: 'info@dwarkaexpresswayncr.com');
define('ADDITIONAL_ADMIN_EMAILS', getenv('ADDITIONAL_ADMIN_EMAILS') ?: '');

// Send JSON response and exit
function sendResponse($success, $message, $redirect = null) {
    header('Content-Type: application/json');
    $response = ['success' => $success, 'message' => $message];
    if ($redirect) {
        $response['redirect'] = $redirect;
    }
    echo json_encode($response);
    exit();
}

// Validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Sanitize input
function clean($input) {
    return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
}

// Get all admin emails
function getAdminEmails() {
    $emails = [trim(ADMIN_EMAIL)];
    if (!empty(ADDITIONAL_ADMIN_EMAILS)) {
        $additional = array_map('trim', explode(',', ADDITIONAL_ADMIN_EMAILS));
        $emails = array_merge($emails, $additional);
    }
    return array_filter($emails, 'isValidEmail');
}

// Validate form token (CSRF protection)
function isValidToken($token) {
    if (empty($token) || empty($_SESSION['form_token'])) {
        return false;
    }
    return hash_equals($_SESSION['form_token'], $token);
}

// Simple validation
function validateForm($name, $phone, $email = '') {
    // Name: required, 2-50 chars, letters and spaces only
    if (empty($name)) {
        return 'Name is required';
    }
    if (strlen($name) < 2 || strlen($name) > 50) {
        return 'Name must be 2-50 characters';
    }
    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        return 'Name should contain only letters and spaces';
    }
    
    // Phone: required, 10+ digits
    if (empty($phone)) {
        return 'Phone number is required';
    }
    $cleanPhone = preg_replace('/[^\d]/', '', $phone);
    if (strlen($cleanPhone) < 10) {
        return 'Please enter a valid phone number (minimum 10 digits)';
    }
    
    // Email: optional, but must be valid if provided
    if (!empty($email) && !isValidEmail($email)) {
        return 'Please enter a valid email address';
    }
    
    return null; // No errors
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Check form token (basic CSRF protection)
    $token = $_POST['form_token'] ?? '';
    if (!isValidToken($token)) {
        sendResponse(false, 'Invalid form submission. Please refresh the page and try again.');
    }
    
    // Get and clean form data
    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $phone = clean($_POST['phone'] ?? '');
    $message = clean($_POST['message'] ?? '');
    $subject = clean($_POST['subject'] ?? 'New Contact Form Submission');
    $project = clean($_POST['project'] ?? '');
    
    // Validate
    $error = validateForm($name, $phone, $email);
    if ($error) {
        sendResponse(false, $error);
    }
    
    // Build email content
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background: #f9f9f9; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #555; }
            .value { margin-top: 5px; }
            .footer { padding: 15px; text-align: center; font-size: 12px; color: #777; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Enquiry Received</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>Name:</div>
                    <div class='value'>{$name}</div>
                </div>
                <div class='field'>
                    <div class='label'>Phone:</div>
                    <div class='value'>{$phone}</div>
                </div>";
    
    if (!empty($email)) {
        $emailBody .= "
                <div class='field'>
                    <div class='label'>Email:</div>
                    <div class='value'>{$email}</div>
                </div>";
    }
    
    if (!empty($project)) {
        $emailBody .= "
                <div class='field'>
                    <div class='label'>Project:</div>
                    <div class='value'>{$project}</div>
                </div>";
    }
    
    if (!empty($message)) {
        $emailBody .= "
                <div class='field'>
                    <div class='label'>Message:</div>
                    <div class='value'>{$message}</div>
                </div>";
    }
    
    $emailBody .= "
            </div>
            <div class='footer'>
                Submitted on " . date('F j, Y \a\t g:i A') . "
            </div>
        </div>
    </body>
    </html>";
    
    // Send email using PHPMailer
    try {
        $mail = new PHPMailer(true);
        
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;
        
        // Email settings
        $mail->setFrom(SMTP_USER, 'Website Contact Form');
        $mail->addReplyTo($email ?: SMTP_USER, $name);
        
        // Add all admin recipients
        foreach (getAdminEmails() as $adminEmail) {
            $mail->addAddress($adminEmail);
        }
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $emailBody;
        $mail->AltBody = strip_tags(str_replace(['<br>', '</div>'], "\n", $emailBody));
        
        $mail->send();
        
        // Regenerate token after successful submission
        $_SESSION['form_token'] = bin2hex(random_bytes(32));
        
        sendResponse(true, 'Thank you! Your message has been sent successfully.', 'thankyou.php');
        
    } catch (Exception $e) {
        error_log("Email send failed: " . $e->getMessage());
        sendResponse(false, 'Sorry, there was an error sending your message. Please try again later.');
    }
    
} else {
    // Not a POST request
    sendResponse(false, 'Invalid request method.');
}
