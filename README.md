# Kashie-Banks-TSF
Kashie Banks - The Sparks Foundation Internship Project #1

## 🏦 Basic Banking System

A secure web application for transferring money between multiple users. The system comes pre-loaded with 10 dummy users and supports creation of new users.

### 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend:** PHP 8
- **Database:** MySQL
- **Additional Libraries:** 
  - DataTables for transaction history
  - Select2 for enhanced dropdowns
  - Font Awesome for icons

### 💾 Database Structure

#### Users Table
- Name
- Email
- Phone Number
- Current Balance
- Timestamp
- Unique identifiers

#### Transaction Table
- Sender information
- Receiver information
- Amount transferred
- Timestamp
- Transaction status
- Transaction reference

### 🔄 Website Flow
1. Home Page
2. View all Users
3. Select and View one User
4. Transfer Money
5. Select receiver
6. View all Users
7. View Transfer History

### 🔒 Security Features

1. **Data Protection**
   - Prepared statements to prevent SQL injection
   - Input validation and sanitization
   - XSS protection through HTML escaping
   - CSRF token implementation

2. **Transaction Security**
   - Atomic transactions with rollback support
   - Double-entry accounting system
   - Balance verification before transfers
   - Transaction logging and audit trails

3. **Error Handling**
   - Secure error logging
   - Custom error pages
   - Graceful failure handling
   - User-friendly error messages

4. **Database Security**
   - Encrypted sensitive data
   - Secure connection handling
   - Transaction isolation
   - Audit logging for all operations

5. **Application Security**
   - Rate limiting for API endpoints
   - Session management
   - Secure headers implementation
   - Input length restrictions

### 🎯 Features

- Real-time balance updates
- Responsive design for all devices
- Dark mode support
- Interactive transaction history
- Form validation with instant feedback
- Toast notifications for actions
- Modern and intuitive UI

### 🌟 The Sparks Foundation
This project was completed as part of The Sparks Foundation Graduate Rotational Internship Program (GRIP).
