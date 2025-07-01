<?php
// Replace with your admin email
$admin_email = "varshith.uideveloper@gmail.com";

// Validate inputs
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = strip_tags(trim($_POST["name"]));
     $contact = strip_tags(trim($_POST["contact"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($contact) || empty($message)) {
        http_response_code(400);
        echo "Please complete the form and provide a valid email.";
        exit;
    }

    // Email to Admin
    $admin_contact = "New Contact Form Submission: $contact";
    $admin_body = "You have received a new message from the contact form.\n\n".
                  "Name: $name\n".
                  "Email: $email\n".
                  "Contact: $contact\n".
                  "Message:\n$message";
    $admin_headers = "From: $name <$email>";

    // Email to User
    $user_contact = "Thank you for contacting us!";
    $user_body = "Hi $name,\n\nThank you for reaching out to us. We have received your message and will get back to you shortly.\n\n".
                 "Here is a copy of your message:\n\n".
                 "Contact: $contact\n".
                 "Message:\n$message\n\n".
                 "Best regards,\nAdmin Team";
    $user_headers = "From: Admin <$admin_email>";

    // Send emails
    $success_admin = mail($admin_email, $admin_contact, $admin_body, $admin_headers);
    $success_user  = mail($email, $user_contact, $user_body, $user_headers);

    if ($success_admin && $success_user) {
        echo "OK";
    } else {
        http_response_code(500);
        echo "Sorry, something went wrong. Please try again later.";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
