<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
        // Set the recipient email address
        $to = "info@segrpinc.com"; 
        $subject = "New Contact Form Submission from $name";

        // Email body content
        $body = "
        Name: $name\n
        Email: $email\n
        Message: $message
        ";

        // Email headers
        $headers = "From: $email";

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            echo "Message sent successfully!";
        } else {
            echo "Message failed to send.";
        }
    } else {
        echo "Please fill all fields correctly.";
    }
} else {
    echo "Invalid request.";
}
?>
