<?php
// Define variables and set to empty values
$name = $email = $message = "";
$error = "";
$success = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Email headers
        $to = "info@segrpinc.com";
        $subject = "New Contact Form Submission from " . $name;
        
        // Email content
        $email_content = "Name: " . $name . "\n";
        $email_content .= "Email: " . $email . "\n\n";
        $email_content .= "Message:\n" . $message . "\n";
        
        // Email headers
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // Try to send email
        if (mail($to, $subject, $email_content, $headers)) {
            $success = true;
        } else {
            $error = "Sorry, there was an error sending your message";
        }
    }
}

// If this is an AJAX request, return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $response = array(
        'success' => $success,
        'error' => $error
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If it's not an AJAX request, redirect back to the form
if ($success) {
    header("Location: index.html#contactus?status=success");
} else if ($error) {
    header("Location: index.html#contactus?status=error");
}
?>