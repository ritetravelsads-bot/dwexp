# Email Form Setup Guide

## What Was Fixed

### 1. **Security Issues**
- ✅ Removed hardcoded email credentials from code
- ✅ Added input validation and sanitization for all form fields
- ✅ Implemented proper rate limiting (3 attempts per 10 minutes)
- ✅ Added Google reCAPTCHA v3 verification to prevent spam
- ✅ Converted to AJAX form submission with proper error handling
- ✅ Removed unnecessary "address" field that wasn't in the form

### 2. **Captcha Implementation**
- ✅ Integrated Google reCAPTCHA v3 (invisible, no user interaction needed)
- ✅ Validates form submissions automatically
- ✅ Blocks spam submissions with low confidence scores

### 3. **Code Quality**
- ✅ Better error handling and validation
- ✅ Uses environment variables for sensitive data
- ✅ Proper JSON responses instead of page redirects
- ✅ User-friendly success/error messages

---

## Setup Instructions

### Step 1: Set Up Gmail SMTP (App Password)

1. Go to your Google Account: https://myaccount.google.com
2. Enable 2-Factor Authentication if not already enabled
3. Go to **Security** → **App passwords**
4. Select Mail and Windows Computer
5. Copy the 16-character password generated
6. Create a .env file and add:
   ```
   SMTP_USER=your-email@gmail.com
   SMTP_PASS=xxxxxxxxxxxxxxxx
   ```

### Step 2: Get Google reCAPTCHA v3 Keys

1. Go to Google reCAPTCHA Admin Console: https://www.google.com/recaptcha/admin
2. Click "+" to create a new site
3. Fill in:
   - **Label**: Dwarka Expressway
   - **reCAPTCHA type**: reCAPTCHA v3
   - **Domains**: dwarkaexpresswayncr.com
4. Accept terms and submit
5. Copy both keys:
   - **SITE KEY**: Add to .env as `RECAPTCHA_SITE_KEY`
   - **SECRET KEY**: Add to .env as `RECAPTCHA_SECRET`

### Step 3: Update Your .env File

Create a `.env` file in your root directory (same level as email.php):

```
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password
RECAPTCHA_SECRET=your-recaptcha-secret-key
RECAPTCHA_SITE_KEY=your-recaptcha-site-key
```

### Step 4: Update the Site Key in index.php

Replace `your-recaptcha-site-key` in index.php (2 places):

1. Line ~1717: `grecaptcha.execute('your-recaptcha-site-key', ...)`
2. Line ~1687: `<script src="https://www.google.com/recaptcha/api.js?render=your-recaptcha-site-key">`

Replace with your actual reCAPTCHA site key from Step 2.

### Step 5: Test the Form

1. Refresh your website
2. Fill out the contact form
3. Submit and verify:
   - ✅ Emails are sent to both admin and user
   - ✅ ReCAPTCHA appears to be working
   - ✅ Input validation prevents invalid submissions
   - ✅ Rate limiting kicks in after 3 attempts in 10 minutes

---

## File Changes Summary

### Modified Files:
- **email.php** - Complete rewrite with security, validation, and reCAPTCHA
- **index.php** - Added reCAPTCHA script, AJAX form submission, and improved UI

### New Files:
- **.env.example** - Template for configuration variables
- **config.php** - Loads environment variables from .env file
- **SETUP.md** - This setup guide

---

## Rate Limiting Details

Users can submit the form **3 times every 10 minutes**:
- 1st attempt: ✅ Submitted
- 2nd attempt: ✅ Submitted
- 3rd attempt: ✅ Submitted  
- 4th attempt: ❌ Blocked for 10 minutes

---

## reCAPTCHA v3 Info

- **Invisible**: No checkbox or popup shown to users
- **Automatic**: Runs on every form submission
- **Score-based**: Analyzes user behavior (0.0 to 1.0)
  - 1.0 = Very likely legitimate
  - 0.0 = Very likely bot
  - Threshold set at 0.5 (medium confidence)

---

## Troubleshooting

### Error: "reCAPTCHA verification failed"
- Check that your secret key in .env matches Google reCAPTCHA console
- Ensure domain is added to reCAPTCHA allowed domains

### Error: "Email could not be sent"
- Verify SMTP_USER and SMTP_PASS in .env are correct
- Check if Gmail 2FA app-specific password is valid
- Ensure templates (email_template.html, user_template.html) exist

### Rate limiting issue
- Clear session: Close browser tab or wait 10 minutes
- Rate limit is per session, not per IP address

### Form not submitting
- Open browser console (F12) and check for JavaScript errors
- Ensure reCAPTCHA site key matches your actual key

---

## Security Best Practices

✅ **Do**:
- Store credentials in .env file (never commit to git)
- Use Gmail app-specific passwords (not main password)
- Keep reCAPTCHA secret key private
- Add .env to .gitignore

❌ **Don't**:
- Hardcode credentials in PHP files
- Share your reCAPTCHA secret key
- Use main Gmail password for SMTP
- Disable reCAPTCHA validation

---

## Support

For issues or questions, check:
1. Browser console errors (F12)
2. PHP error log in `/error_log`
3. Email credentials and reCAPTCHA keys are correct
