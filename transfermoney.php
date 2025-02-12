<?php
require_once 'includes/config.php';
require_once 'includes/Transaction.php';

$transaction = new Transaction();
$users = $transaction->getAllUsers();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = intval($_POST['sender_id']);
    $receiver_id = intval($_POST['receiver_id']);
    $amount = floatval($_POST['amount']);
    
    $result = $transaction->transferMoney($sender_id, $receiver_id, $amount);
    json_response($result['success'], $result['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money - Kashie Bank</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/modern.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container py-5 animate-fade-in">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Transfer Money</h2>
                        
                        <form id="transferForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="sender_id" class="form-label">From Account</label>
                                <select class="form-select" id="sender_id" name="sender_id" required>
                                    <option value="">Select sender</option>
                                    <?php if ($users['success']): ?>
                                        <?php foreach ($users['data'] as $user): ?>
                                            <option value="<?php echo $user['id']; ?>" 
                                                    data-balance="<?php echo $user['balance']; ?>">
                                                <?php echo htmlspecialchars($user['name']); ?> 
                                                (Balance: $<?php echo number_format($user['balance'], 2); ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a sender
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="receiver_id" class="form-label">To Account</label>
                                <select class="form-select" id="receiver_id" name="receiver_id" required>
                                    <option value="">Select receiver</option>
                                    <?php if ($users['success']): ?>
                                        <?php foreach ($users['data'] as $user): ?>
                                            <option value="<?php echo $user['id']; ?>">
                                                <?php echo htmlspecialchars($user['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a receiver
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="amount" class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                           required min="0.01" step="0.01">
                                    <div class="invalid-feedback">
                                        Please enter a valid amount
                                    </div>
                                </div>
                                <small id="balanceHelp" class="form-text text-muted">
                                    Available balance: $<span id="availableBalance">0.00</span>
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="transferBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <i class="fas fa-exchange-alt me-2"></i>Transfer Money
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.form-select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
            
            // Update available balance
            $('#sender_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                const balance = selectedOption.data('balance') || 0;
                $('#availableBalance').text(balance.toFixed(2));
            });
            
            // Prevent selecting same sender and receiver
            $('#receiver_id').change(function() {
                const senderId = $('#sender_id').val();
                const receiverId = $(this).val();
                
                if (senderId === receiverId) {
                    $(this).val('').trigger('change');
                    showNotification('Cannot transfer to the same account', false);
                }
            });
        });
        
        const form = document.getElementById('transferForm');
        const toast = new bootstrap.Toast(document.getElementById('notification'));
        const transferBtn = document.getElementById('transferBtn');
        const spinner = transferBtn.querySelector('.spinner-border');
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }
            
            // Disable button and show spinner
            transferBtn.disabled = true;
            spinner.classList.remove('d-none');
            
            try {
                const formData = new FormData(form);
                const response = await fetch('transfermoney.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                showNotification(result.message, result.success);
                
                if (result.success) {
                    form.reset();
                    form.classList.remove('was-validated');
                    $('.form-select').val('').trigger('change');
                    $('#availableBalance').text('0.00');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', false);
            } finally {
                // Re-enable button and hide spinner
                transferBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        });
        
        function showNotification(message, success) {
            document.querySelector('.toast-body').textContent = message;
            document.getElementById('notification').className = 
                `toast ${success ? 'bg-success' : 'bg-danger'} text-white`;
            toast.show();
        }
    </script>
</body>
</html>