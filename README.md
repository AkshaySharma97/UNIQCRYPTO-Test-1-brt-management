# BRT Management System

This is a full-stack BRT (Blume Reserve Ticket) management system built with **Laravel (backend)** and **React.js (frontend)**. It provides secure authentication using JWT, an admin panel with Filament, real-time notifications using Pusher, and API endpoints for CRUD operations.

---

## 📌 **Project Setup**

### **1. Clone the Repository**
```
git clone https://github.com/AkshaySharma97/UNIQCRYPTO-Test-1-brt-management.git
cd brt-management
```

---

## **Laravel Backend Setup**

### **2. Install Dependencies**
```
composer update
```

### **3. Set Up Environment Variables**
```
cp .env.example .env
```
 the `.env` file and configure the database connection and Pusher credentials.

### **4. Generate JWT Secret Key**
```
php artisan jwt:secret
```

### **5. Run Database Migrations & Seed Data**
```
php artisan migrate --seed
```

### **6. Start the Laravel Development Server**
```
php artisan serve
```
The backend will be accessible at `http://127.0.0.1:8000`

---

## **React Frontend Setup**

### **7. Install Node.js Dependencies**
```
cd brt-frontend
npm install
```

### **8. Set Up Environment Variables**
Create a `.env` file inside `brt-frontend` and add:
```
REACT_APP_API_URL_BRT=http://127.0.0.1:8000/api/brts
REACT_APP_API_URL=http://127.0.0.1:8000/api
```

### **9. Start the React Development Server**
```
npm run dev
```
The frontend will be accessible at `http://localhost:3000`

---

## **Tech Stack**
- **Backend:** Laravel, Filament, JWT Authentication
- **Frontend:** React.js, Axios, Bootstrap
- **Database:** SQLite/
- **Real-Time:** Laravel

---

## **API Endpoints**
### **Authentication APIs**
- `POST /api/register` - Register a new user
- `POST /api/login` - Login user and return JWT

### **BRT Management APIs**
- `POST /api/brts` - Create a new BRT
- `GET /api/brts` - Retrieve all BRTs for the authenticated user
- `GET /api/brts/{id}` - Retrieve a specific BRT by ID
- `PUT /api/brts/{id}` - Update a specific BRT by ID
- `DELETE /api/brts/{id}` - Delete a specific BRT by ID

---

### **Access Filament Admin Panel**
Open http://127.0.0.1:8000/admin in your browser.

`Login using:`
- Email: admin@example.com
- Password: password123

---

### **Running Tests**
 1. Run All Tests
    - php artisan test
 2. Run Only Unit Tests
    - php artisan test --filter=UserTest
 3. Run Only Feature Tests
    - php artisan test --filter=BRTManagementTest

### ** Test Cases**
    Unit Tests (UserTest.php)
    - Can create a user.
    - Can have multiple BRTs.
    - Can return JWT identifier and custom claims.

    Feature Tests (BRTManagementTest.php)
    - User can create a BRT.
    - User can view all BRTs.
    - User can view a single BRT.
    - User can update a BRT.
    - User can delete a BRT.