<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

class User
{
    public $email;
    public $password;
    public $name;

    public function __construct($email, $password, $name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }

    public static function check_password($password)
    {
		//															capital char                                           small char									special char
        if (strlen($password) >= 12 && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[\W_]/', $password)) {
            return true;
        }
        return false;
    }

	public static function validate_email($email)
	{
		if (preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
			return true;
		}
	}
    public function copy_with($new_email = null, $new_password = null, $new_name = null)
    {
        $updated_email = $new_email ?? $this->email;
        $updated_password = $new_password ?? $this->password;
        $updated_name = $new_name ?? $this->name;

        return new self($updated_email, $updated_password, $updated_name);
    }
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(["error" => "Invalid JSON data"]);
    exit();
}

if (!isset($data['email']) || !User::validate_email($data['email'])) {
    echo json_encode(["error" => "Invalid email format"]);
    exit();
}

if (!isset($data['password']) || !User::check_password($data['password'])) {
    echo json_encode(["error" => "Password must be at least 12 characters long, contain at least 1 uppercase letter, 1 lowercase letter, and 1 special character"]);
    exit();
}

$user = new User($data['email'], $data['password'], isset($data['name']) ? $data['name'] : 'Unknown');

// $newUser = $user->copy_with(new_name: "Updated User");

echo json_encode([
    "success" => true,
    "message" => "User data is valid",
    "original_user" => [
        "email" => $user->email,
        "password" => $user->password,
        "name" => $user->name
    ],
    // "updated_user" => [
    //     "email" => $newUser->email,
    //     "password" => $newUser->password,
    //     "name" => $newUser->name
    // ]
]);
