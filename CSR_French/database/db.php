<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP has no password
$dbname = "SchoolDB"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

/**
 * Counts the number of entries in a database table.
 *
 * @param $conn The database connection object.
 * @param $tableName The name of the table to count entries from.
 * @return int The number of entries in the table.
 */
function countTableEntries($conn, $tableName)
{
  $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM " . $tableName);
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $row = $result->fetch_assoc();
  $stmt->close();

  return isset($row['count']) ? (int) $row['count'] : 0;
}

/**
 * Retrieves static content from the database.
 *
 * @param $conn The database connection object.
 * @param $page The page name.
 * @param $section The section name.
 * @return The static content retrieved from the database.
 */
function getStaticContent($conn, $page, $section)
{
  $stmt = $conn->prepare("SELECT * FROM StaticContent WHERE Page=? AND Section=?");
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param("ss", $page, $section);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $transformed = ['heading' => '', 'texts' => [], 'notes' => '', 'link' => '', 'images' => []];

  while ($row = $result->fetch_assoc()) {
    if (empty($transformed['heading'])) {
      $transformed['heading'] = $row['Heading'];
    }
    $transformed['texts'] = array_merge($transformed['texts'], [$row['Text']]);
    $transformed['notes'] = $row['Notes'];
    $transformed['link'] = $row['Link'];
    $transformed['images'] = $row['ImageSRC'] !== NULL ? array_merge($transformed['images'], [[
      'src' => $row['ImageSRC'],
      'alt' => $row['ImageALT'],
      'loading' => 'lazy',
      'class' => $row['ImageClass']
    ]]) : $transformed['images'];
  }

  $stmt->close();
  return $transformed;
}

/**
 * Retrieves options from the database.
 *
 * @param $conn The database connection object.
 * @return array An array of options.
 */
function getOptions($conn)
{
  $stmt = $conn->prepare("SELECT OptionName, Description FROM Options");
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $options = [];
  while ($row = $result->fetch_assoc()) {
    $options[] = [
      'name' => $row['OptionName'],
      'description' => $row['Description']
    ];
  }

  $stmt->close();
  return $options;
}


/**
 * Retrieves the details of a school from the database.
 *
 * @param mysqli $conn The database connection object.
 * @param int $schoolID The ID of the school to retrieve details for.
 * @return array|null Returns an array containing the school details if found, or null if not found.
 */
function getSchoolDetails($conn, $schoolID)
{
  $stmt = $conn->prepare("SELECT School, Classes, Day, StartTime, EndTime, AdmissionConditions FROM Schools WHERE SchoolID=?");
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param("i", $schoolID);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $details = [];
  if ($row = $result->fetch_assoc()) {
    $details = [
      'school' => $row['School'],
      'classes' => explode(', ', $row['Classes']),
      'day' => $row['Day'],
      'time' => $row['StartTime'] . " - " . $row['EndTime'],
      'conditions' => $row['AdmissionConditions']
    ];
  }

  $stmt->close();
  return $details;
}

/**
 * Retrieves the admission conditions for a specific school.
 *
 * @param mysqli $conn The database connection object.
 * @param int $schoolID The ID of the school.
 * @return array An array containing the admission conditions.
 */
function getAdmissionConditions($conn, $schoolID)
{
  $stmt = $conn->prepare("SELECT ConditionText FROM AdmissionConditions WHERE SchoolID=?");
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param("i", $schoolID);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $conditions = [];
  while ($row = $result->fetch_assoc()) {
    $conditions[] = $row['ConditionText'];
  }

  $stmt->close();
  return $conditions;
}


/**
 * Retrieves achievements by category from the database.
 *
 * @param $conn The database connection object.
 * @param $category The category of achievements to retrieve.
 * @return array An array of achievements matching the specified category.
 */
function getAchievementsByCategory($conn, $category)
{
  $stmt = $conn->prepare('SELECT Year, Description FROM Achievements WHERE Category=?');
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param("s", $category);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $achievements = [];
  while ($row = $result->fetch_assoc()) {
    $year = $row['Year'];
    if (!isset($achievements[$year])) {
      $achievements[$year] = [];
    }
    $achievements[$year][] = $row['Description'];
  }

  $stmt->close();
  return $achievements;
}

/**
 * Retrieves news articles by category from the database.
 *
 * @param $conn The database connection object.
 * @param $category The category of news articles to retrieve.
 * @return array An array of news articles matching the specified category.
 */
function getNewsByCategory($conn, $category)
{
  $stmt = $conn->prepare('SELECT * FROM News WHERE Category=? ORDER BY Date DESC');
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param('s', $category);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $news = [];
  while ($row = $result->fetch_assoc()) {
    $news[$row['Title']] = [
      'date' => $row['Date'],
      'description' => $row['Description'],
      'image' => [
        'src' => $row['ImageSRC'],
        'alt' => $row['ImageALT'],
      ]
    ];
  }

  $stmt->close();
  return $news;
}

/**
 * Retrieves the details of a student based on their email.
 *
 * @param $conn The database connection object.
 * @param $email The email of the student.
 * @return array|false The student details as an associative array, or false if no student is found.
 */
function getStudentDetailsByEmail($conn, $email)
{
  $stmt = $conn->prepare('SELECT * FROM Students WHERE Email=?');
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $details = [];
  if ($row = $result->fetch_assoc()) {
    $details = [
      'id' => $row['StudentID'],
      'name' => $row['Name'],
      'birthdate' => $row['Birthdate'],
      'email' => $row['Email'],
      'password' => $row['Password'],
      'phone' => $row['Phone']
    ];
  }

  $stmt->close();
  return $details;
}

/**
 * Retrieves a product from the database based on its ID.
 *
 * @param $conn The database connection object.
 * @param $id The ID of the product to retrieve.
 * @return The product data as an associative array, or null if the product is not found.
 */
function getProductById($conn, $id)
{
  $stmt = $conn->prepare('SELECT * FROM Products WHERE ProductID=?');
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $product = [];

  $row = $result->fetch_assoc();
  if ($row) {
    $product = [
      'id' => $row['ProductID'],
      'name' => $row['Name'],
      'description' => $row['Description'],
      'category' => $row['Category'],
      'image' => [
        'src' => $row['ImageSRC'],
        'alt' => $row['ImageALT'],
        'loading' => 'lazy',
        'class' => $row['ImageClass']
      ],
      'price' => $row['Price'],
      'stock' => $row['StockQuantity']
    ];
  }

  $stmt->close();
  return $product;
}

/**
 * Retrieves products by category from the database.
 *
 * @param $conn The database connection object.
 * @param $category The category of the products to retrieve.
 * @return array An array of products matching the specified category.
 */
function getProductByCategory($conn, $category)
{
  $stmt = $conn->prepare('SELECT * FROM Products WHERE Category=?');
  if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    return false;
  }

  $stmt->bind_param('s', $category);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result === false) {
    error_log("Error executing statement: " . $stmt->error);
    $stmt->close();
    return false;
  }

  $products = [];

  while ($row = $result->fetch_assoc()) {
    $products[] = [
      'id' => $row['ProductID'],
      'name' => $row['Name'],
      'description' => $row['Description'],
      'category' => $row['Category'],
      'image' => [
        'src' => $row['ImageSRC'],
        'alt' => $row['ImageALT'],
        'loading' => 'lazy',
        'class' => $row['ImageClass']
      ],
      'price' => $row['Price'],
      'stock' => $row['StockQuantity']
    ];
  }

  $stmt->close();
  return $products;
}

/**
 * Inserts a student record into the database.
 *
 * @param $conn The database connection object.
 * @param $name The name of the student.
 * @param $birthdate The birthdate of the student.
 * @param $email The email of the student.
 * @param $phone The phone number of the student.
 * @param $hashedPassword The hashed password of the student.
 */
function insertStudent($conn, $name, $birthdate, $email, $phone, $hashedPassword)
{
  $stmt = $conn->prepare("INSERT INTO Students (Name, Birthdate, Email, Phone, Password) VALUES (?, ?, ?, ?, ?)");

  if ($stmt === false) {
    error_log("Error: " . $conn->error);
    return false;
  } else {
    $stmt->bind_param("sssss", $name, $birthdate, $email, $phone, $hashedPassword);

    if ($stmt->execute()) {
      $_SESSION['id'] = $conn->insert_id;
      $_SESSION['name'] = $name;
      $_SESSION['email'] = $email;
      $_SESSION['phone'] = $phone;
      $_SESSION['password'] = $hashedPassword;
      $_SESSION['cart'] = [];
    } else {
      // Handle error - user was not inserted
      error_log("Error: " . $stmt->error);
      $stmt->close();
      return false;
    }

    $stmt->close();
  }

  return true;
}

/**
 * Inserts an order into the database.
 *
 * @param $conn The database connection object.
 * @param $studentId The ID of the student placing the order.
 * @param $orderDate The date of the order.
 * @param $total The total amount of the order.
 */
function insertOrder($conn, $studentId, $orderDate, $total)
{
  $stmt = $conn->prepare('INSERT INTO Orders (StudentID, OrderDate, TotalAmount) VALUES (?, ?, ?)');

  if ($stmt === false) {
    error_log("Error: " . $conn->error);
    return 0;
  }

  $stmt->bind_param("isd", $studentId, $orderDate, $total);
  if ($stmt->execute()) {
    $last_id = $conn->insert_id;
    $stmt->close();
    return $last_id;
  } else {
    error_log("Error: " . $stmt->error);
    $stmt->close();
    return 0;
  }
}

/**
 * Inserts order details into the database.
 *
 * @param $conn The database connection object.
 * @param $orderId The ID of the order.
 * @param $productId The ID of the product.
 * @param $quantity The quantity of the product.
 * @param $price The price of the product.
 * @param $total The total cost of the order.
 */
function insertOrderDetails($conn, $orderId, $productId, $quantity, $price, $total) {
  $stmt = $conn->prepare('INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Price, Total) VALUES (?, ?, ?, ?, ?)');

  if ($stmt === false) {
    error_log("Error: " . $conn->error);
    return false;
  }

  $stmt->bind_param("iiidd", $orderId, $productId, $quantity, $price, $total);
  if ($stmt->execute()) {
    $stmt->close();
    return true;
  } else {
    error_log("Error: " . $stmt->error);
    $stmt->close();
    return false;
  }
}

/**
 * Updates the quantity of a product by its ID.
 *
 * @param $conn The database connection object.
 * @param $productId The ID of the product to update.
 * @param $quantity The new quantity value.
 */
function updateQuantityByProductId($conn, $productId, $quantity) {
  $stmt = $conn->prepare('UPDATE Products SET StockQuantity = StockQuantity - ? WHERE ProductID = ?');

  if ($stmt === false) {
    error_log("Error: " . $conn->error);
    return false;
  }

  $stmt->bind_param("ii", $quantity, $productId);
  if ($stmt->execute()) {
    $stmt->close();
    return true;
  } else {
    // Handle error - quantity was not updated
    error_log("Error: " . $stmt->error);
    $stmt->close();
    return false;
  }
}
