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
define('RECAPTCHA_SECRET', getenv('RECAPTCHA_SECRET') ?: '');
define('IP_SECURITY_FILE', __DIR__ . '/inc/ip_security.json');
define('SPAM_THRESHOLD', 3);
define('SPAM_WINDOW_SECONDS', 86400); // 24 hours
define('IP_BLOCK_DURATION_SECONDS', 86400); // 24 hours
define('CAPTCHA_FAIL_BLOCK_THRESHOLD', 1);
define('FORM_CAPTCHA_THRESHOLD', 3);
define('FORM_CAPTCHA_WINDOW_SECONDS', 86400); // 24 hours

// Rate limiting configuration
define('RATE_LIMIT_WINDOW', 600); // 10 minutes
define('MAX_ATTEMPTS', 3);

// Anti-bot configuration
define('MIN_FORM_SUBMIT_TIME', 3); // Minimum seconds between page load and form submit (bots are instant)
define('MAX_FORM_SUBMIT_TIME', 3600); // Maximum seconds (1 hour - stale tokens)

// Helper function to set response
function setResponse($success, $message, $extra = []) {
    header('Content-Type: application/json');
    $payload = array_merge(['success' => $success, 'message' => $message], is_array($extra) ? $extra : []);
    echo json_encode($payload);
    exit();
}

function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

// Helper function to validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Helper function to validate phone
function isValidPhone($phone) {
    // Allow various phone formats
    return preg_match('/^[\d\s\-\+\(\)]{7,}$/', $phone);
}

// LEVEL 3: Backend Spam Detection
function detectSpamContent($text) {
    if (empty($text)) return null;
    
    // Array of spam keywords and patterns
    $spamKeywords = [
        'viagra', 'cialis', 'casino', 'lottery', 'winner', 'congratulations',
        'click here', 'buy now', 'limited offer', 'act now', 'bitcoin',
        'crypto', 'forex', 'nigerian prince', 'inheritance', 'millionaire',
        'free money', 'make money fast', 'work from home', 'earn now',
        'xxx', 'adult', 'dating', 'loans', 'mortgage', 'payday',
        'nigerian', 'prince', 'fund your account', 'claim prize',
        'dear friend', 'dear sir', 'dear madam', 'greetings',
        'udacious', 'undisclosed', 'confidential arrangement',
        'seo services', 'backlinks', 'rank #1', 'google ranking',
        'cbd oil', 'weight loss', 'diet pills', 'enhancement',
        'investment opportunity', 'double your', 'guaranteed returns',
        'wire transfer', 'bank details', 'routing number'
    ];
    
    $textLower = strtolower($text);
    
    // Check for spam keywords
    foreach ($spamKeywords as $keyword) {
        if (strpos($textLower, $keyword) !== false) {
            return "Spam keyword detected: '$keyword'";
        }
    }
    
    // Check for excessive URLs
    $urlCount = substr_count($text, 'http://') + substr_count($text, 'https://') + substr_count($text, 'www.');
    if ($urlCount > 1) {
        return "URLs not allowed in form submissions";
    }
    
    // Check for HTML tags (common in spam)
    if (preg_match('/<[^>]+>/', $text)) {
        return "HTML tags are not allowed";
    }
    
    // Check for repeated special characters (!!!!!!, ????, etc.)
    if (preg_match('/([!?*]){5,}/', $text)) {
        return "Excessive special character repetition detected";
    }
    
    // Check for excessive numbers in text
    $numberCount = preg_match_all('/\d/', $text);
    $textLength = strlen(preg_replace('/\s/', '', $text));
    if ($textLength > 0 && $numberCount / $textLength > 0.5) {
        return "Too many numbers in text";
    }
    
    // Check for very long words (possible spam encoding)
    $words = preg_split('/\s+/', $text);
    foreach ($words as $word) {
        if (strlen($word) > 40) {
            return "Suspiciously long word detected";
        }
    }
    
    // Check for repeated characters
    if (preg_match('/(.)\\1{4,}/', $text)) {
        return "Excessive character repetition detected";
    }
    
    // Check for Cyrillic or other non-Latin scripts (common in spam from certain regions)
    if (preg_match('/[\x{0400}-\x{04FF}]/u', $text)) {
        return "Invalid characters detected";
    }
    
    return null;
}

// Check if name looks like a real person's name (not gibberish)
function isValidHumanName($name) {
    // Must have at least one vowel
    if (!preg_match('/[aeiouAEIOU]/', $name)) {
        return false;
    }
    
    // Check for common bot patterns (random characters)
    if (preg_match('/[bcdfghjklmnpqrstvwxyz]{5,}/i', $name)) {
        return false; // 5+ consonants in a row is suspicious
    }
    
    // Check for keyboard mashing patterns
    $keyboardPatterns = ['asdf', 'qwer', 'zxcv', 'jkl;', 'uiop', '1234', 'abcd'];
    $nameLower = strtolower($name);
    foreach ($keyboardPatterns as $pattern) {
        if (strpos($nameLower, $pattern) !== false) {
            return false;
        }
    }
    
    return true;
}

// LEVEL 3: Comprehensive backend validation
function validateFormData($name, $email, $phone) {
    $errors = [];
    
    // Name validation
    if (empty($name)) {
        $errors[] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters';
    } elseif (strlen($name) > 50) {
        $errors[] = 'Name must not exceed 50 characters';
    } elseif (!preg_match('/^[a-zA-Z\s\'\.]*$/', $name)) {
        $errors[] = 'Name contains invalid characters';
    } elseif (preg_match('/\d/', $name)) {
        $errors[] = 'Name should not contain numbers';
    } elseif (!isValidHumanName($name)) {
        $errors[] = 'Please enter a valid name';
    }
    
    // Check for spam content in name
    $nameSpam = detectSpamContent($name);
    if ($nameSpam) {
        $errors[] = $nameSpam;
    }
    
    // Phone validation
    if (empty($phone)) {
        $errors[] = 'Phone is required';
    } else {
        $cleanedPhone = preg_replace('/[^\d+]/', '', $phone);
        if (strlen($cleanedPhone) < 10) {
            $errors[] = 'Phone must be at least 10 digits';
        } elseif (strlen($cleanedPhone) > 20) {
            $errors[] = 'Phone number is too long';
        } elseif (!preg_match('/^[0-9+]*$/', $cleanedPhone)) {
            $errors[] = 'Phone contains invalid characters';
        }
    }
    
    // Email validation (optional field)
    if (!empty($email)) {
        if (!isValidEmail($email)) {
            $errors[] = 'Email address format is invalid';
        } elseif (strlen($email) > 100) {
            $errors[] = 'Email is too long';
        }
        
        // Check for spam content in email
        $emailSpam = detectSpamContent($email);
        if ($emailSpam) {
            $errors[] = $emailSpam;
        }
    }
    
    return empty($errors) ? null : implode('. ', $errors);
}

// Helper function to sanitize input
function sanitizeInput($input) {
    return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
}

function getTrustedProxies() {
    $raw = getenv('TRUSTED_PROXIES') ?: '';
    if ($raw === '') {
        return [];
    }
    $items = array_map('trim', explode(',', $raw));
    return array_values(array_filter($items, function ($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }));
}

function isTrustedProxyIp($ip) {
    if (empty($ip)) {
        return false;
    }
    return in_array($ip, getTrustedProxies(), true);
}

function firstValidPublicIpFromList($ipList) {
    foreach ($ipList as $candidate) {
        $candidate = trim((string)$candidate);
        if ($candidate === '') {
            continue;
        }
        if (filter_var($candidate, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $candidate;
        }
    }
    return null;
}

function getClientIp() {
    $remoteAddr = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    // Only trust forwarded headers when request came through trusted reverse proxies.
    if (isTrustedProxyIp($remoteAddr) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwardedIps = explode(',', (string)$_SERVER['HTTP_X_FORWARDED_FOR']);
        $publicIp = firstValidPublicIpFromList($forwardedIps);
        if ($publicIp !== null) {
            return $publicIp;
        }
    }

    if ($remoteAddr !== 'unknown' && filter_var($remoteAddr, FILTER_VALIDATE_IP)) {
        return $remoteAddr;
    }

    return 'unknown';
}

function loadIpSecurityData() {
    if (!file_exists(IP_SECURITY_FILE)) {
        return [];
    }

    $json = file_get_contents(IP_SECURITY_FILE);
    if ($json === false || $json === '') {
        return [];
    }

    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function saveIpSecurityData($data) {
    $dir = dirname(IP_SECURITY_FILE);
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }

    $encoded = json_encode($data, JSON_PRETTY_PRINT);
    if ($encoded !== false) {
        @file_put_contents(IP_SECURITY_FILE, $encoded, LOCK_EX);
    }
}

function getIpSecurityRecord($data, $ip) {
    $record = isset($data[$ip]) && is_array($data[$ip]) ? $data[$ip] : [];
    if (!isset($record['spam_attempts']) || !is_array($record['spam_attempts'])) {
        $record['spam_attempts'] = [];
    }
    if (!isset($record['form_submit_attempts']) || !is_array($record['form_submit_attempts'])) {
        $record['form_submit_attempts'] = [];
    }
    if (!isset($record['blocked_until'])) {
        $record['blocked_until'] = 0;
    }
    if (!isset($record['captcha_failures']) || !is_numeric($record['captcha_failures'])) {
        $record['captcha_failures'] = 0;
    }
    if (!isset($record['rate_limit_attempts']) || !is_array($record['rate_limit_attempts'])) {
        $record['rate_limit_attempts'] = [];
    }
    return $record;
}

function persistIpSecurityRecord($ip, $record) {
    $data = loadIpSecurityData();
    $data[$ip] = $record;
    saveIpSecurityData($data);
}

function pruneIpSecurityRecord($record, $now) {
    $record['spam_attempts'] = array_values(array_filter(
        $record['spam_attempts'],
        function ($timestamp) use ($now) {
            return is_numeric($timestamp) && ($now - (int)$timestamp) <= SPAM_WINDOW_SECONDS;
        }
    ));
    $record['form_submit_attempts'] = array_values(array_filter(
        $record['form_submit_attempts'],
        function ($timestamp) use ($now) {
            return is_numeric($timestamp) && ($now - (int)$timestamp) <= FORM_CAPTCHA_WINDOW_SECONDS;
        }
    ));
    $record['rate_limit_attempts'] = array_values(array_filter(
        $record['rate_limit_attempts'],
        function ($timestamp) use ($now) {
            return is_numeric($timestamp) && ($now - (int)$timestamp) <= RATE_LIMIT_WINDOW;
        }
    ));

    if (!is_numeric($record['blocked_until']) || (int)$record['blocked_until'] < $now) {
        $record['blocked_until'] = 0;
    } else {
        $record['blocked_until'] = (int)$record['blocked_until'];
    }
    $record['captcha_failures'] = max(0, (int)$record['captcha_failures']);

    return $record;
}

function isIpBlocked($record, $now) {
    return isset($record['blocked_until']) && (int)$record['blocked_until'] > $now;
}

function isCaptchaRequiredForIp($record) {
    return count($record['spam_attempts']) >= SPAM_THRESHOLD;
}

function registerSpamAttempt($ip, $now) {
    $data = loadIpSecurityData();
    $record = getIpSecurityRecord($data, $ip);
    $record = pruneIpSecurityRecord($record, $now);
    $record['spam_attempts'][] = $now;
    $data[$ip] = $record;
    saveIpSecurityData($data);
    return $record;
}

function registerFormSubmitAttempt($ip, $now) {
    $data = loadIpSecurityData();
    $record = getIpSecurityRecord($data, $ip);
    $record = pruneIpSecurityRecord($record, $now);
    $record['form_submit_attempts'][] = $now;
    $data[$ip] = $record;
    saveIpSecurityData($data);
    return $record;
}

function isCaptchaRequiredByFormAttempts($record) {
    return isset($record['form_submit_attempts']) && count($record['form_submit_attempts']) >= FORM_CAPTCHA_THRESHOLD;
}

function blockIpForOneDay($ip, $now) {
    $data = loadIpSecurityData();
    $record = getIpSecurityRecord($data, $ip);
    $record = pruneIpSecurityRecord($record, $now);
    $record['blocked_until'] = $now + IP_BLOCK_DURATION_SECONDS;
    $data[$ip] = $record;
    saveIpSecurityData($data);
}

function registerCaptchaFailure($ip, $now) {
    $data = loadIpSecurityData();
    $record = getIpSecurityRecord($data, $ip);
    $record = pruneIpSecurityRecord($record, $now);
    $record['captcha_failures'] = ((int)$record['captcha_failures']) + 1;
    $data[$ip] = $record;
    saveIpSecurityData($data);
    return $record;
}

function resetCaptchaFailures($ip, $now) {
    $data = loadIpSecurityData();
    $record = getIpSecurityRecord($data, $ip);
    $record = pruneIpSecurityRecord($record, $now);
    $record['captcha_failures'] = 0;
    $data[$ip] = $record;
    saveIpSecurityData($data);
}

function checkRateLimit($ip, $now) {
    $data = loadIpSecurityData();
    $record = getIpSecurityRecord($data, $ip);
    $record = pruneIpSecurityRecord($record, $now);

    if (count($record['rate_limit_attempts']) >= MAX_ATTEMPTS) {
        $data[$ip] = $record;
        saveIpSecurityData($data);
        return false;
    }

    $record['rate_limit_attempts'][] = $now;
    $data[$ip] = $record;
    saveIpSecurityData($data);
    return true;
}

function isValidFormToken($token) {
    if (!is_string($token) || $token === '') {
        return false;
    }
    if (empty($_SESSION['form_token']) || !is_string($_SESSION['form_token'])) {
        return false;
    }
    return hash_equals($_SESSION['form_token'], $token);
}

function verifyRecaptcha($token) {
    if (empty(RECAPTCHA_SECRET)) {
        return ['verified' => false, 'type' => 'config', 'message' => 'Missing RECAPTCHA_SECRET in .env'];
    }

    if (empty($token)) {
        return ['verified' => false, 'type' => 'missing', 'message' => 'Empty token received'];
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['secret' => RECAPTCHA_SECRET, 'response' => $token]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($response === false) {
        return ['verified' => false, 'type' => 'service', 'message' => 'cURL Error: ' . $curlError];
    }
    
    $result = json_decode($response, true);
    if (!is_array($result)) {
        return ['verified' => false, 'type' => 'service', 'message' => 'Invalid response from reCAPTCHA'];
    }
    
    // Log the response for debugging
    error_log('reCAPTCHA Response: ' . json_encode($result));

    $isValid = isset($result['success']) && $result['success'] === true;

    if (!$isValid) {
        $type = isset($result['error-codes']) ? 'verification' : 'service';
        return [
            'verified' => false,
            'type' => $type,
            'message' => 'Verification failed',
            'result' => $result
        ];
    }

    return ['verified' => true, 'type' => 'ok', 'message' => 'OK', 'result' => $result];
}

function getAdminRecipientEmails() {
    $all = [trim((string)ADMIN_EMAIL)];
    if (!empty(ADDITIONAL_ADMIN_EMAILS)) {
        $all = array_merge($all, array_map('trim', explode(',', ADDITIONAL_ADMIN_EMAILS)));
    }
    $all = array_filter($all, function ($email) {
        return !empty($email) && isValidEmail($email);
    });
    return array_values(array_unique($all));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $now = time();
    $ip = getClientIp();
    $ipData = loadIpSecurityData();
    $ipRecord = getIpSecurityRecord($ipData, $ip);
    $ipRecord = pruneIpSecurityRecord($ipRecord, $now);
    persistIpSecurityRecord($ip, $ipRecord);

    if (isIpBlocked($ipRecord, $now)) {
        setResponse(false, 'This IP is blocked for 24 hours due to repeated spam/captcha failures.');
    }

    // HONEYPOT CHECK - if this hidden field is filled, it's a bot
    $honeypot = isset($_POST['website_url']) ? trim($_POST['website_url']) : '';
    if (!empty($honeypot)) {
        // Silently block - don't give bots useful feedback
        blockIpForOneDay($ip, $now);
        error_log("HONEYPOT TRIGGERED: IP $ip filled honeypot field with: $honeypot");
        setResponse(false, 'Form submission failed. Please try again.');
    }

    // TIME-BASED CHECK - form submitted too quickly (bot) or token too old (stale/replay)
    $formLoadTime = isset($_POST['form_load_time']) ? (int)$_POST['form_load_time'] : 0;
    if ($formLoadTime > 0) {
        $timeTaken = $now - $formLoadTime;
        if ($timeTaken < MIN_FORM_SUBMIT_TIME) {
            // Submitted too fast - likely a bot
            blockIpForOneDay($ip, $now);
            error_log("TIME CHECK FAILED: IP $ip submitted form in $timeTaken seconds (too fast)");
            setResponse(false, 'Form submission failed. Please try again.');
        }
        if ($timeTaken > MAX_FORM_SUBMIT_TIME) {
            // Token too old - could be replay attack or stale session
            error_log("TIME CHECK FAILED: IP $ip submitted form after $timeTaken seconds (too old)");
            setResponse(false, 'Your session has expired. Please refresh the page and try again.');
        }
    }

    $submittedToken = isset($_POST['form_token']) ? (string)$_POST['form_token'] : '';
    if (!isValidFormToken($submittedToken)) {
        setResponse(false, 'Invalid or missing form token. Please refresh and try again.');
    }

    $ipRecord = registerFormSubmitAttempt($ip, $now);
    $captchaRequired = isCaptchaRequiredForIp($ipRecord) || isCaptchaRequiredByFormAttempts($ipRecord);

    if (!$captchaRequired && !checkRateLimit($ip, $now)) {
        setResponse(false, 'Too many attempts. Please try again in 10 minutes.');
    }

    // Collect and sanitize form data
    $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
    $message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';

    // LEVEL 3: Backend validation with spam detection
    $validationError = validateFormData($name, $email, $phone);
    if ($validationError) {
        $updatedRecord = registerSpamAttempt($ip, $now);
        if (count($updatedRecord['spam_attempts']) >= SPAM_THRESHOLD) {
            $validationError .= '. Too many spam attempts from this IP. CAPTCHA is now required.';
        }
        setResponse(false, $validationError, ['require_captcha' => (isCaptchaRequiredForIp($updatedRecord) || isCaptchaRequiredByFormAttempts($updatedRecord))]);
    }

    if ($captchaRequired) {
        $recaptcha_token = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
        $captchaCheck = verifyRecaptcha($recaptcha_token);
        if (!$captchaCheck['verified']) {
            error_log('reCAPTCHA check failed (' . $captchaCheck['type'] . '): ' . $captchaCheck['message']);
            if ($captchaCheck['type'] === 'missing') {
                setResponse(false, 'Please complete the reCAPTCHA.', ['require_captcha' => true]);
            }
            if ($captchaCheck['type'] === 'verification') {
                $record = registerCaptchaFailure($ip, $now);
                if ((int)$record['captcha_failures'] >= CAPTCHA_FAIL_BLOCK_THRESHOLD) {
                    blockIpForOneDay($ip, $now);
                    setResponse(false, 'reCAPTCHA verification failed. This IP is blocked for 24 hours.', ['require_captcha' => true]);
                }
                setResponse(false, 'reCAPTCHA verification failed. Please try again.', ['require_captcha' => true]);
            }
            setResponse(false, 'reCAPTCHA service/config error. Please try again later.', ['require_captcha' => true]);
        }
        resetCaptchaFailures($ip, $now);
    }

    if (empty(SMTP_USER) || empty(SMTP_PASS)) {
        error_log('SMTP: Missing SMTP_USER or SMTP_PASS in .env');
        setResponse(false, 'Email configuration is missing. Please contact support.');
    }
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->Port = SMTP_PORT;
        $mail->SMTPSecure = SMTP_SECURE;

        $mail->setFrom('info@dwarkaexpresswayncr.com', 'Dwarka Expressway NCR');
        $mail->isHTML(true);

        $recipients = [
            ['email' => 'info@dwarkaexpresswayncr.com', 'type' => 'admin', 'subject' => 'New Lead Form'],
        ];
        if (!empty($email) && isValidEmail($email)) {
            $recipients[] = ['email' => $email, 'type' => 'user', 'subject' => 'Thank You for Contacting Us'];
            $mail->addReplyTo($email, $name);
        }

        foreach($recipients as $r) {
            if($r['type'] == 'admin') {
                $template = file_get_contents('email_template.html');
            } else if($r['type'] == 'user') {
                $template = file_get_contents('user_template.html');
            } else {
                continue;
            }

            if ($template === false) {
                setResponse(false, 'Email template not found.');
            }

            $template = str_replace('{{name}}', $name, $template);
            $template = str_replace('{{email}}', $email, $template);
            $template = str_replace('{{phone}}', $phone, $template);
            $template = str_replace('{{message}}', $message, $template);

            $mail->clearAddresses();
            $mail->addAddress($r['email']);
            $mail->Subject = $r['subject'];
            $mail->Body = $template;
            $mail->send();
        }

        // Rotate token after successful send to reduce replay risk.
        $_SESSION['form_token'] = bin2hex(random_bytes(32));

        if (!isAjaxRequest()) {
            header('Location: thankyou.html');
            exit();
        }

        setResponse(true, 'Thank you! We will contact you shortly.', ['redirect' => 'thankyou.html']);
        
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo . ' | Exception: ' . $e->getMessage());
        setResponse(false, 'Email could not be sent. Please try again later.');
    }
} else {
    // Not a POST request
    setResponse(false, 'Invalid request method.');
}
?>
