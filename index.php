<html>
<?php
require_once __DIR__.'/boot.php';

error_reporting(E_ERROR | E_PARSE);

$user = $_SESSION['user'];

if (check_auth()) {
    // Получим данные пользователя по сохранённому идентификатору
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<style>
 :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --error-color: #f72585;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
	* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
	body {
            background-color: var(--light-color);
            display: flex;
            justify-content: center;
            align-items: top;
            min-height: 100vh;
            padding: 20px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
	.container {
            width: 100%;
            max-width: 500px;
        }
    .main-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
    .registration-card {
            background-color: white;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
	.registration-card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
    .form-title {
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
        }
	.name {
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
            font-size: 2rem;
        }
        
    .text-center {
            text-align: center;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
        }
        
    .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }
	.form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }
	.form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
        }
	.form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
	.form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
	.form-check-input {
            margin-right: 0.5rem;
        }
	.form-check-label {
            color: var(--dark-color);
        }
	.btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
        }
	.btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
    .btn-primary:active {
            transform: translateY(0);
        }
	.mt-3 {
            margin-top: 1rem;
        }
        
    .mt-5 {
            margin-top: 3rem;
        }
	.mb-3 {
            margin-bottom: 1rem;
        }
        
    a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
    a:hover {
            text-decoration: underline;
        }
	.catalog-section {
            background-color: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        .section-title {
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            font-weight: 600;
            text-align: center;
        }
    .catalog-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 15px;
    }
	.catalog-table th, 
        .catalog-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
			vertical-align: top;
			width: 50%;
        }
        
    .catalog-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
    }
	.catalog-table tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
    }
	.product-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
            max-width: 300px;
            margin: 0 auto;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }
        
        .product-info {
            padding: 1.25rem;
        }
        
        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }
        
        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0.75rem 0;
        }
        
        .product-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .product-link {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
        }
        
        .product-link:hover {
            background-color: var(--secondary-color);
            text-decoration: none;
        }
        
        /* Адаптивные стили */
        @media (max-width: 768px) {
            .catalog-table, 
			.catalog-table tbody, 
			.catalog-table tr, 
			.catalog-table td {
				display: block;
				width: 100%;
			}
			
			.catalog-table td {
				margin-bottom: 15px;
			}
			
			.catalog-table tr:last-child td:last-child {
				margin-bottom: 0;
			}
            
            .product-card {
                max-width: 100%;
            }
        }
</style>
<body>
<div class="main-container">
	<div class="registration-card">
<?php if ($user) { ?>

		<h1 class="name text-center">Welcome, <?=htmlspecialchars($user['username'])?>!</h1>
        <p class="text-center">You are already logged in.</p>
        <form class="mt-5" method="post" action="do_logout.php">
            <button type="submit" class="btn btn-primary btn-register">Logout</button>
        </form>

<?php } else { 
$_SESSION['bruh'] = 0101;
echo $user['id']; ?>

    <h1  class="mb-5">Registration:|</h1>
	<p class="mb-5" style="font-size:14">*optional</p>

    <?php flash("uioiuo"); ?>

     <form method="post" action="do_register.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Minimum 8 characters</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">I agree to the Terms and Conditions</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Register</button>
                    
                    <div class="mt-3 text-center">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </form>
            <?php } ?>
		</div value = "registraion card"> 
<!-- Новый блок каталога -->
    <div class="catalog-section">
    <h2 class="section-title">Our Products</h2>
    
    <!-- Таблица каталога (2 колонки) -->
    <table class="catalog-table">
        <tbody>
            <!-- Первая строка с двумя карточками -->
            <tr>
                <td>
                    <div class="product-card">
                        <img src="https://via.placeholder.com/300x200" alt="Product Image" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title">Product 1</h3>
                            <div class="product-price">$19.99</div>
                            <p class="product-description">Brief description of the first product.</p>
                            <a href="about_product/ID1.html" class="product-link">View Details</a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="product-card">
                        <img src="https://via.placeholder.com/300x200" alt="Product Image" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title">Product 2</h3>
                            <div class="product-price">$24.99</div>
                            <p class="product-description">Brief description of the second product.</p>
                            <a href="about_product/ID2.html" class="product-link">View Details</a>
                        </div>
                    </div>
                </td>
            </tr>
            <!-- Вторая строка с двумя карточками -->
            <tr>
                <td>
                    <div class="product-card">
                        <img src="https://via.placeholder.com/300x200" alt="Product Image" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title">Product 3</h3>
                            <div class="product-price">$29.99</div>
                            <p class="product-description">Brief description of the third product.</p>
                            <a href="about_product/ID3.html" class="product-link">View Details</a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="product-card">
                        <img src="https://via.placeholder.com/300x200" alt="Product Image" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title">Product 4</h3>
                            <div class="product-price">$34.99</div>
                            <p class="product-description">Brief description of the fourth product.</p>
                            <a href="about_product/ID4.html" class="product-link">View Details</a>
                        </div>
                    </div>
                </td>
            </tr>
            
            <!-- Строки будут генерироваться через PHP -->
        </tbody>
    </table>
	</div>
</div>
</body>
<script>
let appendee_1 = document.createElement("appendee");
	appendee_1.innerHTML = 
				`<td>
                    <div class="product-card">
                        <img src="https://via.placeholder.com/300x200" alt="Product Image" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title">Product 3</h3>
                            <div class="product-price">$29.99</div>
                            <p class="product-description">Brief description of the third product.</p>
                            <a href="product-details.php?id=3" class="product-link">View Details</a>
                        </div>
                    </div>
                </td>`;
let append_array = [
	{
		element: appendee_1,
		innerHTML: appendee_1.innerHTML
	}
];

console.log(append_array);
let ol = document.getElementById("catalog_items_go_here");
let append_count = 5;
for (let i = 0; i < append_count; i++){ 
	
	ol.append(append_array[i]);
}
</script>
<html>