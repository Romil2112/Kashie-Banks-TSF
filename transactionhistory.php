<?php
require_once 'includes/config.php';
require_once 'includes/Transaction.php';

$transaction = new Transaction();
$history = $transaction->getTransactionHistory();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - Kashie Bank</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/modern.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container py-5 animate-fade-in">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Transaction History</h2>
                        
                        <?php if ($history['success'] && !empty($history['data'])): ?>
                            <div class="table-responsive">
                                <table id="transactionTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($history['data'] as $transaction): ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                        $date = new DateTime($transaction['timestamp']);
                                                        echo $date->format('M j, Y g:i A'); 
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($transaction['sender_name']); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['receiver_name']); ?></td>
                                                <td>
                                                    <span class="fw-semibold">
                                                        $<?php echo number_format($transaction['amount'], 2); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill bg-success">
                                                        <?php echo ucfirst($transaction['status']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5>No transactions found</h5>
                                <p class="text-muted">Start making transactions to see them here.</p>
                                <a href="transfermoney.php" class="btn btn-primary">
                                    <i class="fas fa-exchange-alt me-2"></i>Make a Transfer
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#transactionTable').DataTable({
                responsive: true,
                order: [[0, 'desc']], // Sort by date descending
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search transactions..."
                },
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
</body>
</html>