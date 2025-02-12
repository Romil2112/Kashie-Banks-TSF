<?php
require_once 'config.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createUser($name, $email, $balance) {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, email, balance) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $name, $email, $balance);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'User created successfully'];
            }
            return ['success' => false, 'message' => 'Failed to create user'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function transferMoney($from_id, $to_id, $amount) {
        try {
            $this->db->getConnection()->begin_transaction();

            // Check sender's balance
            $stmt = $this->db->prepare("SELECT balance FROM users WHERE id = ? FOR UPDATE");
            $stmt->bind_param("i", $from_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $sender = $result->fetch_assoc();

            if ($sender['balance'] < $amount) {
                $this->db->getConnection()->rollback();
                return ['success' => false, 'message' => 'Insufficient balance'];
            }

            // Update sender's balance
            $stmt = $this->db->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
            $stmt->bind_param("di", $amount, $from_id);
            $stmt->execute();

            // Update receiver's balance
            $stmt = $this->db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
            $stmt->bind_param("di", $amount, $to_id);
            $stmt->execute();

            // Record transaction
            $stmt = $this->db->prepare("INSERT INTO transactions (sender_id, receiver_id, amount) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $from_id, $to_id, $amount);
            $stmt->execute();

            $this->db->getConnection()->commit();
            return ['success' => true, 'message' => 'Transaction completed successfully'];
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getTransactionHistory() {
        try {
            $query = "SELECT t.*, 
                      s.name as sender_name, 
                      r.name as receiver_name,
                      t.timestamp 
                      FROM transactions t
                      JOIN users s ON t.sender_id = s.id
                      JOIN users r ON t.receiver_id = r.id
                      ORDER BY t.timestamp DESC";
            
            $result = $this->db->query($query);
            $transactions = [];
            
            while ($row = $result->fetch_assoc()) {
                $transactions[] = $row;
            }
            
            return ['success' => true, 'data' => $transactions];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getAllUsers() {
        try {
            $result = $this->db->query("SELECT * FROM users ORDER BY name");
            $users = [];
            
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            
            return ['success' => true, 'data' => $users];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            return ['success' => true, 'data' => $user];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
?>
