<?php
require_once 'includes/config.php';
require_once 'includes/Transaction.php';

$transaction = new Transaction();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $balance = floatval($_POST['balance']);

    // Input validation
    if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || $balance < 0) {
        json_response(false, 'Invalid input data.');
        exit;
    }

    $result = $transaction->createUser($name, $email, $balance);
    json_response($result['success'], $result['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - Kashie Bank</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/modern.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container py-5 animate-fade-in">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Create New User</h2>
                        
                        <form id="createUserForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       pattern="[A-Za-z\s]+" minlength="2" maxlength="50">
                                <div class="invalid-feedback">
                                    Please enter a valid name (2-50 characters, letters only)
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email address
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="balance" class="form-label">Initial Balance</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="balance" name="balance"
                                           required min="0" step="0.01">
                                    <div class="invalid-feedback">
                                        Please enter a valid amount
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Create User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast for notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="notification" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-info-circle me-2"></i>
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('createUserForm');
            const toast = new bootstrap.Toast(document.getElementById('notification'));
            
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if (!form.checkValidity()) {
                    e.stopPropagation();
                    form.classList.add('was-validated');
                    return;
                }
                
                try {
                    const formData = new FormData(form);
                    const response = await fetch('createuser.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    document.querySelector('.toast-body').textContent = result.message;
                    document.getElementById('notification').className = 
                        `toast ${result.success ? 'bg-success' : 'bg-danger'} text-white`;
                    
                    if (result.success) {
                        form.reset();
                        form.classList.remove('was-validated');
                    }
                    
                    toast.show();
                } catch (error) {
                    console.error('Error:', error);
                    document.querySelector('.toast-body').textContent = 
                        'An error occurred. Please try again.';
                    document.getElementById('notification').className = 
                        'toast bg-danger text-white';
                    toast.show();
                }
            });
        });
    </script>
</body>
</html>