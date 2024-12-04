<?php

define('BASE_PATH', 'C:/xampp/htdocs/VivirMVC-new/'); // Full absolute path to the project

// Now require the model file using the BASE_PATH
require_once BASE_PATH . 'model/UserModel.php'; // Correct path to the model file

class UserController {
    public $conn; // Changed from private to public for accessibility

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
        $this->userModel = new UserModel();
    }

    public function handleSignUp($firstName, $lastName, $email, $password) {
        if ($this->userModel->signUp($firstName, $lastName, $email, $password)) {
            // Redirect to the login page with a success message
            header("Location: ../view/login.php?success=1");
            exit();
        } else {
            echo "<p style='color: red;'>Sign-up failed. Email may already be in use.</p>";
        }
    }
    public function handleLogin($email, $password, $userType) {
        $user = null;

        if ($userType === 'user') {
            $user = $this->userModel->loginAsUser($email, $password); // For normal users (customer table)
        } elseif ($userType === 'admin') {
            $user = $this->userModel->loginAsAdmin($email, $password); // For admin users (staff table)
        }

        if ($user) {
            session_start();
            $_SESSION['email'] = $email; // You can also store other user info here (e.g., name)

            // Redirect based on user type
            if ($userType === 'user') {
                header("Location: ../index.php"); // Redirect to user homepage
            } elseif ($userType === 'admin') {
                header("Location: ../view/admin/dashboard.php"); // Redirect to admin dashboard
            }
            exit;
        } else {
            echo "Invalid email or password.";
        }
    }
    
    public function getPage() {
        $default = $_REQUEST['default'] ?? 'Home'; 
    
        switch ($default) {
            case 'Home': 
                include_once('view/home.php');
                break;
    
            case 'About':
                include_once('view/user/about.php'); // Assuming this file exists
                break;
    
            case 'Services':
                include_once('view/user/services.php');
                break;
    
            case 'Projects':
                include_once('view/user/projects.php'); // Assuming this file exists
                break;
    
            case 'Contacts':
                include_once('view/user/contacts.php'); // Assuming this file exists
                break;
    
            default:
                include_once('view/home.php'); // Default to home if no match
                break;
        }
    }

    public function handleAddStaff($formData) {
        return $this->userModel->addStaff(
            $formData['first-name'],
            $formData['last-name'],
            $formData['email'],
            $formData['password'],
            $formData['phone'],
            $formData['specialty'],
    
        );
    }

    public function getAllStaff() {
        return $this->userModel->getAllStaff(); // Correct property usage
    }

    public function handleDeleteStaff($staffId) {
        return $this->userModel->deleteStaff($staffId);
    }

    public function getStaffById($staffId) {
        // Assuming you have a method in the model to fetch staff by ID
        return $this->userModel->getStaffById($staffId);
    }

    public function handleUpdateStaff($postData) {
        $staffId = $postData['staff_id']; // Make sure staff_id is part of the form data
        $firstName = $postData['first-name'];
        $lastName = $postData['last-name'];
        $email = $postData['email'];
        $password = $postData['password'];
        $phone = $postData['phone'];
        $specialty = $postData['specialty'];
        // Update the staff member in the database using the model
        return $this->userModel->updateStaff($staffId, $firstName, $lastName, $email, $password, $phone, $specialty);
    }

    public function handleAddEquipment($formData) {
        return $this->userModel->addEquipment(
            $formData['equipment_name'],
            $formData['type'],
            $formData['quantity'] // Correct field name
        );
    }
    
    public function getAllEquipment() {
        return $this->userModel->getAllEquipment();
    }
    
    public function handleDeleteEquipment($equipmentId) {
        return $this->userModel->deleteEquipment($equipmentId);
    }
    
    public function getEquipmentById($equipmentId) {
        return $this->userModel->getEquipmentById($equipmentId);
    }
    
    public function handleUpdateEquipment($postData) {
        return $this->userModel->updateEquipment(
            $postData['equipment-id'],  // equipment-id
            $postData['equipment-name'], // equipment-name
            $postData['type'],           // type
            $postData['quantity']        // quantity
        );
    }
    
    

    public function getStaffCount() {
        $query = "SELECT COUNT(*) AS count FROM staff";
        $stmt = $this->userModel->conn->prepare($query); // Use the connection from UserModel
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0; // Return the count or 0 if null
    }

    public function getEquipmentCount() {
        $query = "SELECT COUNT(*) AS count FROM equipment";
        $stmt = $this->userModel->conn->prepare($query); // Use the connection from UserModel
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0; // Return the count or 0 if null
    }

    public function getAllBookings() {
        return $this->userModel->getAllBookings();
    }
}

?>
