<?php

require_once 'dbconfig.php';

class Session
{

  public $conn;
  public $logged_in;


  public function __construct()
  {
    $database = new Database();
    $db = $database->dbConnection();
    $this->conn = $db;

    if (!isset($_SESSION)) {
      $this->startSession();
    }
    
  }

  function startSession()
  {
    global $database;  //The database connection
    session_start();   //Tell PHP to start the session

    /* Determine if user is logged in */
    $this->logged_in = $this->is_logged_in();

  }


  public function runQuery($sql)
  {
    $stmt = $this->conn->prepare($sql);
    return $stmt;
  }

  public function lastID()
  {
    $stmt = $this->conn->lastInsertId();
    return $stmt;
  }

  public function register($uname, $email, $upass, $phone, $code)
  {
    try {
      $password = password_hash($upass, PASSWORD_DEFAULT);
      $stmt = $this->conn->prepare("INSERT INTO users(Full_Name,Email,Phone,userPassword,tokenCode) 
			                                             VALUES(:user_name, :user_mail,:user_phone, :user_pass, :active_code)");
      $stmt->bindparam(":user_name", $uname);
      $stmt->bindparam(":user_mail", $email);
      $stmt->bindparam(":user_pass", $password);
      $stmt->bindparam(":user_phone", $phone);
      $stmt->bindparam(":active_code", $code);
      $stmt->execute();
      return $stmt;
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }

  public function login($email, $upass)
  {
    try {
      $stmt = $this->conn->prepare("SELECT * FROM users WHERE Email=:email_id");
      $stmt->execute(array(":email_id" => $email));
      $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($stmt->rowCount() == 1) {
        if ($userRow['isVerified'] == 1) {
          if (password_verify($upass, $userRow['userPassword'])) {
            $_SESSION['userSession'] = $userRow['userId'];
            return true;
          } else {
            header('Location: login.php?error');
            exit;
          }
        } else {
          header("Location: login.php?inactive");
          exit;
        }
      } else {
        header('Location: login.php?error');
        exit;
      }
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
  }


  public function is_logged_in()
  {
    if (isset($_SESSION['userSession'])) {
      return true;
    }
  }

  public function redirect($url)
  {
    header("Location: $url");
  }

  public function logout()
  {
    session_destroy();
    $_SESSION['userSession'] = false;
  }

  function getLoginAttempt($ip)
  {
    global $database;
    $sql = "SELECT * FROM login_attempts WHERE ip = :ip";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('ip', $ip);
      $stmt->execute();
      $loginAttempt = $stmt->fetch();
      return $loginAttempt;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function getUser($userId)
  {
    global $database;
    $sql = "Select * from users WHERE userID = :userID";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam('userID', $userId);
    $stmt->execute();
    $user = $stmt->fetch();
    return $user;
  }

  function deleteIPCounter($ip)
  {
    global $database;
    $sql = "DELETE from login_attempts WHERE ip = :ip";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('ip', $ip);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function updateIpCounter($ip, $updatedCounter)
  {
    global $database;
    $sql = "UPDATE login_attempts SET failedCounter = :failedCounter WHERE ip = :ip";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('ip', $ip);
      $stmt->bindParam('failedCounter', $updatedCounter);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function checkIfIpExists($ip)
  {
    global $database;
    $sql = "SELECT * FROM login_attempts WHERE ip = :ip";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('ip', $ip);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function addLoginAttempts($ip, $counter)
  {
    global $database;
    try {
      $stmt = $this->conn->prepare('INSERT INTO login_attempts(ip, failedCounter) VALUES(:ip, :counter) ');
      $stmt->bindParam(':ip', $ip);
      $stmt->bindParam(':counter', $counter);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  // function deleteUser($userId)
  // {
  //   global $database;
  //   $sql = "DELETE from users WHERE userID = :userId";
  //   try {
  //      $stmt = $this->conn->prepare($sql);
  //     $stmt->bindParam('userId', $userId);
  //     $stmt->execute();
  //   } catch (Exception $e) {
  //     return $e->getMessage();
  //   }

  //   return 'User successfully deleted!';
  // }
  function getUsers()
  {
    global $database;
    $sql = "Select * from users";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $pizzas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $pizzas;
  }

  function changePassword($userId, $newPassword){
        $sql = "UPDATE users SET userPassword = :userPassword WHERE userID = :userID";
      $stmt = $this->conn->prepare($sql);
        $stmt->bindparam(":userPassword", $newPassword);
        $stmt->bindparam(":userID", $userId);
        $stmt->execute();
  }


  /******************************************************************************************
   * Pjesa per Kategori
   **********************************************************************************************/


  /******************************************************************************************
   * Pjesa per Ingredients
   **********************************************************************************************/
  public function addIngredient($name)
  {
    global $database;
    try {
      $sql = "INSERT into ingredient(i_name) VALUES(:name)";
      $stmt = $this->conn->prepare($sql);

      $stmt->bindParam(':name', $name);

      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function getIngredient($ingredientId)
  {
    global $database;
    try {
      $sql = "SELECT * FROM ingredient WHERE ingredientId = :i_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('i_id', $ingredientId);
      $stmt->execute();
      $ing = $stmt->fetch();
      return $ing;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function editIngredient($ingredientId, $ingredientName)
  {
    global $database;
    $sql = "UPDATE ingredient SET i_name = :i_name WHERE ingredientId = :i_id";

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('i_id', $ingredientId);
      $stmt->bindParam('i_name', $ingredientName);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function deleteIngredient($ingredientId)
  {
    global $database;
    $sql = "DELETE from ingredient WHERE ingredientId = :i_id";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('i_id', $ingredientId);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function checkIfIngredientExists($name)
  {
    global $database;
    $sql = "SELECT * FROM ingredient WHERE i_name = :name ";
    try {

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('name', $name);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }


    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  /********************************************************************************************************************
   * PJESA PER KATEGORI
   *****************************************************************************************************************/
  public function addCategory($name)
  {
    global $database;
    try {
      $sql = "INSERT into category(name) VALUES(:name)";
      $stmt = $this->conn->prepare($sql);

      $stmt->bindParam(':name', $name);

      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function getCategory($categoryId)
  {
    global $database;
    try {
      $sql = "SELECT * FROM category WHERE categoryId = :c_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('c_id', $categoryId);
      $stmt->execute();
      $ing = $stmt->fetch();
      return $ing;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function checkIfCategoryExists($name)
  {
    global $database;
    $sql = "SELECT * FROM category WHERE name = :name";
    try {

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('name', $name);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }


    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function getCategories()
  {
    global $database;
    try {
      $sql = "SELECT * FROM category";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $categoryList = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $categoryList;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }


  function editCategory($categoryId, $categoryName)
  {
    global $database;
    $sql = "UPDATE category SET name = :name WHERE categoryId = :c_id";

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('c_id', $categoryId);
      $stmt->bindParam('name', $categoryName);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function updateProfilePicture($userId, $image){
    global $database;
    $sql = "UPDATE users SET userPicture = :userPic WHERE userId = :user_id";

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('user_id', $userId);
      $stmt->bindParam('userPic', $image);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }

  }

  function deleteCategory($categoryId)
  {
    global $database;
    $sql = "DELETE from category WHERE categoryId = :c_id";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('c_id', $categoryId);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function checkIfSizeExists($name, $category)
  {
    global $database;
    $sql = "SELECT * FROM size WHERE name = :name AND CategoryIDFK = :categoryID";
    try {

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('name', $name);
      $stmt->bindParam('categoryID', $category);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }


    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function addSize($name, $category)
  {
    global $database;
    try {
      $sql = 'INSERT into size(name,CategoryIDFK) VALUES(:name,:CategoryIDFK)';
      $stmt = $this->conn->prepare($sql);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':CategoryIDFK', $category);

      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function editSize($sizeId, $name, $category)
  {
    global $database;
    $sql = "UPDATE size SET name = :name, CategoryIDFK = :categoryIDFK WHERE sizeId = :sizeId";

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('sizeId', $sizeId);
      $stmt->bindParam('name', $name);
      $stmt->bindParam('categoryIDFK', $category);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function getSize($sizeId)
  {
    global $database;
    try {
      $sql = "SELECT * FROM size WHERE sizeId = :sizeId";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('sizeId', $sizeId);
      $stmt->execute();
      $size = $stmt->fetch();
      return $size;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function deleteSize($sizeId)
  {
    global $database;
    $sql = "DELETE from size WHERE sizeId = :size_id";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('size_id', $sizeId);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function deleteUser($userId)
  {
    global $database;
    $sql = "DELETE from users WHERE userId = :userId";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('userId', $userId);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function editUser($userId, $fullName, $email, $phone, $role)
  {
    global $database;


    try {
      $sql = "UPDATE users SET Full_Name = :name, Email = :email, Phone = :phone, userRole = :userRole WHERE userId = :userId";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('userId', $userId);
      $stmt->bindParam('name', $fullName);
      $stmt->bindParam('email', $email);
      $stmt->bindParam('phone', $phone);
      $stmt->bindParam('userRole', $role);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
   function editUserInfo($userId, $fullName, $phone)
  {
    global $database;


    try {
      $sql = "UPDATE users SET Full_Name = :name, Phone = :phone WHERE userId = :userId";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('userId', $userId);
      $stmt->bindParam('name', $fullName);
      $stmt->bindParam('phone', $phone);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }


  function checkIfUserExists($fullName, $email, $phone, $role)
  {
    global $database;
    $sql = "SELECT * FROM users WHERE Full_Name = :name AND Email = :email AND Phone = :phone AND userRole = :userRole ";
    try {

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('name', $fullName);
      $stmt->bindParam('email', $email);
      $stmt->bindParam('phone', $phone);
      $stmt->bindParam('userRole', $role);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }


    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function addProduct($name, $photo, $category)
  {
    global $database;
    try {

      $sql = "INSERT into product(name,photo,categoryIdFK) VALUES(:name,:photo,:categoryIdFK)";
      $stmt = $this->conn->prepare($sql);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':photo', $photo);
      $stmt->bindParam(':categoryIdFK', $category);

      $stmt->execute();


    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function deleteProduct($productId)
  {
    global $database;
    $sql = "DELETE from product WHERE productId = :product_id";
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('product_id', $productId);
      $stmt->execute();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function getIngredients()
  {
    global $database;
    $sql = "SELECT * FROM ingredient";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $ingredientsList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $ingredientsList;

  }
    function getProduct($productId)
  {
    global $database;
    try {
      $sql = "SELECT * FROM product WHERE productId = :productId";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam('productId', $productId);
      $stmt->execute();
      $product = $stmt->fetch();
      return $product;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
  public function addProductIngredient($productId, $ingredientid)
  {
    global $database;
    try {

      $sql = "INSERT INTO product_ingredients(productIdFK,ingredientIdFK) VALUES(:product,:ingredient)";
      $stmt = $this->conn->prepare($sql);

      $stmt->bindParam(':product', $productId);
      $stmt->bindParam(':ingredient', $ingredientid);
     

      $stmt->execute();


    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function getProductsByCategory($categoryId){
    global $database;
    $sql = "Select * from product where categoryIdFK = :category_id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam('category_id', $categoryId);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $products;
  }
  public function sendFeedback($name,$email,$subject,$message){
       global $database,$session;
    $stmt = $this->conn->prepare('INSERT INTO contact(name,email,subject,message) VALUES(:name, :email, :subject, :message)');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);

    $stmt->execute();

    $message = <<<EMAIL
Hi! My name is $name.

My message is: $message

From: $name
Email: $email

EMAIL;

    $to = 'contactgrandmaspizza@gmail.com';
    //$to='grandmaspizza@hotmail.com';
    $headers = 'From: mail@grandmaspizza.online-presence.com' . "\r\n" .
      // 'Reply-To: mail@grandmaspizza.online-presence.com' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
    //$headers = '';
    // $headers = 'From: '. $email . "\r\n";


    mail($to, $subject, $message, $headers);


  }

 


  function send_mail($email, $message, $subject)
  {
    require_once('../mailer/class.phpmailer.php');
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->AddAddress($email);
    $mail->Username = "contactgrandmaspizza@gmail.com";
    $mail->Password = "shki2016";
    $mail->SetFrom('contactgrandmaspizza@gmail.com', 'Grandmas Pizza');
    $mail->AddReplyTo("contactgrandmaspizza@gmail.com", "Grandmas Pizza");
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    $mail->Send();
  }
}

//$session = new SESSION();
?>