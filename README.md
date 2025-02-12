# Kashie-Banks-TSF
Kashie Banks - The Sparks Foundation Internship Project #1

Basic Banking System : A Web Application used to transfer money between multiple users (Project contains 10 dummy users). A dummy user can also be created.

Front-end : HTML, CSS, Bootstrap & Javascript 
Back-end  : PHP 
Database  : MySQL

Database contains two Tables- Users Table & Transaction Table

  1. User table have basic fields such as name, email, phone number & current balance.
  2. Transaction table records all transfers happened along with their time.

Flow of the Website: Home Page > View all Users > Select and View one User > Transfer Money > Select reciever > View all Users > View Transfer History.

## Installation Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/Romil2112/Kashie-Banks-TSF.git
   ```
2. Navigate to the project directory:
   ```bash
   cd Kashie-Banks-TSF
   ```
3. Set up the database using the provided SQL scripts.

## Usage Instructions
1. Start the web server (e.g., XAMPP, WAMP).
2. Access the application via a web browser at `http://localhost/Kashie-Banks-TSF`.
3. Follow the flow: Home Page > View all Users > Select and View one User > Transfer Money > Select receiver > View all Users > View Transfer History.

## Security Considerations
- Ensure that input data is validated and sanitized to prevent SQL injection.
- Use prepared statements for database queries.
- Implement HTTPS for secure data transmission.

## Contributing
If you would like to contribute to this project, please fork the repository and submit a pull request with your changes.
