<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', 'C:/xampp/htdocs/VivirMVC-new/'); // Define base path for project
}

// Require the database connection class
require_once BASE_PATH . 'config/database.php'; 


class UserModel {
    public $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
        
        if (!$this->conn) {
            die("Database connection failed.");
        }
    }

    // User login verification (using the 'customer' table)
    public function loginAsUser($email, $password) {
        $query = "SELECT * FROM customer WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        
        if (!$stmt->execute()) {
            echo "Error executing query";
            print_r($stmt->errorInfo());
            return false;
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data if login is successful
        }
        return false; // Return false if login fails
    }

   // Admin login verification (using the 'staff' table)
   public function loginAsAdmin($email, $password) {
    $query = "SELECT * FROM staff WHERE email = :email";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        if (password_verify($password, $admin['password'])) {
            return $admin; // Return admin data if login is successful
        } else {
            return false;  // Password does not match
        }
    }

    return false; // Admin not found
}

    
    // User registration (for customers)
    public function signUp($firstName, $lastName, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO customer (fname, lname, email, registered_date, password) 
                  VALUES (:fname, :lname, :email, NOW(), :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fname', $firstName);
        $stmt->bindParam(':lname', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute(); // Return true if the insert is successful
    }

    public function addStaff($fname, $lname, $email, $password, $phone, $specialty) {
        if ($this->conn === null) {
            throw new Exception("Database connection not initialized.");
        }
    
        try {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Prepare SQL query
            $sql = "INSERT INTO staff (fname, lname, email, password, phone, specialty) 
                    VALUES (:fname, :lname, :email, :password, :phone, :specialty)";
            $stmt = $this->conn->prepare($sql);
    
            // Bind parameters
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword); // Bind hashed password
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':specialty', $specialty);
         
    
            // Execute the query
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    
    
    
}
    // Get all staff members (admins)
    public function getAllStaff() {
        $query = "SELECT * FROM staff";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return an array of staff data
    }

    // Delete staff member (admin)
    public function deleteStaff($staffId) {
        $query = "DELETE FROM staff WHERE staff_id = :staff_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':staff_id', $staffId);
        return $stmt->execute(); // Return true if the delete is successful
    }

    // Fetch staff details by ID (admin)
    public function getStaffById($staffId) {
        $query = "SELECT * FROM staff WHERE staff_id = :staff_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':staff_id', $staffId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return the staff details
    }

    // Update staff details (admin)
    public function updateStaff($staffId, $firstName, $lastName, $email, $password, $phone, $specialty) {
        // Don't include staff_id in the fields to be updated
        $query = "UPDATE staff SET fname = :fname, lname = :lname, email = :email, specialty = :specialty, 
                  phone = :phone WHERE staff_id = :staff_id";
        
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters
        $stmt->bindParam(':staff_id', $staffId);
        $stmt->bindParam(':fname', $firstName);
        $stmt->bindParam(':lname', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':specialty', $specialty);
      
    
        // Bind password only if provided (do not update if empty)
        if (!empty($password)) {
            $stmt->bindParam(':password', $password); // Bind password only if it's provided
        }
    
        // Execute the query and return the result
        return $stmt->execute(); // Return true if the update is successful
    }

    // Add equipment (admin)
    public function addEquipment($equipmentName, $type, $quantity) {
        $query = "INSERT INTO equipment (equipment_name, type, quantity) 
                  VALUES (:equipment_name, :type, :quantity)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':equipment_name', $equipmentName);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':quantity', $quantity);
    
        return $stmt->execute(); // Return true if the insert is successful
    }
    // Get all equipment
    public function getAllEquipment() {
        $query = "SELECT * FROM equipment";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return an array of equipment data
    }

    // Delete equipment (admin)
    public function deleteEquipment($equipmentId) {
        $query = "DELETE FROM equipment WHERE equipment_id = :equipment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':equipment_id', $equipmentId);
    
        return $stmt->execute(); // Return true if deletion is successful
    }
    
    // Get equipment by ID
    public function getEquipmentById($equipmentId) {
        $query = "SELECT * FROM equipment WHERE equipment_id = :equipment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':equipment_id', $equipmentId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return the equipment details
    }

    // Update equipment details (admin)
    public function updateEquipment($equipmentId, $equipmentName, $type, $quantity) {
        $query = "UPDATE equipment 
                  SET equipment_name = :equipment_name, 
                      type = :type, 
                      quantity = :quantity
                  WHERE equipment_id = :equipment_id";
        $stmt = $this->conn->prepare($query);
        
        // Bind the parameters
        $stmt->bindParam(':equipment_id', $equipmentId);
        $stmt->bindParam(':equipment_name', $equipmentName);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':quantity', $quantity);
        
        return $stmt->execute(); // Return true if the update is successful
    }

    public function getBookingById($bookingId) {
        $query = "SELECT * FROM booking WHERE booking_id = :booking_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $bookingId);
        $stmt->execute(); 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllBookings() {
        $query = "SELECT 
                    b.booking_id, 
                    CONCAT(c.fname, ' ', c.lname) AS customer_name, 
                    p.package_name, 
                    b.booking_date, 
                    b.event_date, 
                    b.status, 
                    b.time_start, 
                    b.time_end, 
                    b.total_price 
                  FROM 
                    booking b
                  INNER JOIN 
                    customer c ON b.customer_id = c.customer_id
                  INNER JOIN 
                    package p ON b.package_id = p.package_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function updateBookingStatus($bookingId, $status) {
        // Ensure connection is valid
        if (!$this->conn) {
            die("Database connection is not available.");
        }

        try {
            $query = "UPDATE booking SET status = :status WHERE booking_id = :booking_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);

            // Execute the query
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error updating booking status: " . $e->getMessage();
            return false;
        }
    }

    public function getBookingsByStatus($status) {
        // Query to fetch bookings by status, including customer name and package name
        $query = "SELECT 
                    b.booking_id, 
                    CONCAT(c.fname, ' ', c.lname) AS customer_name, 
                    p.package_name, 
                    b.booking_date, 
                    b.event_date, 
                    b.status, 
                    b.time_start, 
                    b.time_end, 
                    b.total_price 
                 FROM 
                    booking b
                 INNER JOIN 
                    customer c ON b.customer_id = c.customer_id
                 INNER JOIN 
                    package p ON b.package_id = p.package_id
                 WHERE 
                    b.status = :status
                 ORDER BY 
                    b.event_date ASC"; // Order by booking_id in ascending order
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        // Fetch all results
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Check if any results are returned and print for debugging if necessary
        if (!$bookings) {
            // No bookings found
            return [];
        }
        
        // Return the fetched bookings
        return $bookings;
    }
    
    
}   
?>
