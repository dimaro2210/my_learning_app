<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Login - BOU26</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="login-ui/images/icons/favicon.ico"/>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	<style>
		:root {
			--primary-color: #f1c40f; /* Mustard Yellow */
			--accent-color: #d4ac0d;
			--dark-bg: #1e293b;
			--bg-gradient: linear-gradient(135deg, #f1c40f 0%, #d4ac0d 100%);
		}

		body, html {
			height: 100%;
			margin: 0;
			font-family: 'Poppins', sans-serif;
			background-color: #f8fafc;
		}

		.login-container {
			display: flex;
			height: 100vh;
			width: 100%;
			overflow: hidden;
		}

		/* Left Side - Hero Section */
		.hero-section {
			flex: 1.2;
			background: var(--bg-gradient);
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			color: #1a1a1a;
			padding: 60px;
			position: relative;
			overflow: hidden;
		}

		/* Abstract Bubbles */
		.hero-section::before, .hero-section::after {
			content: '';
			position: absolute;
			border-radius: 50%;
			background: rgba(0, 0, 0, 0.05);
		}

		.hero-section::before {
			width: 400px;
			height: 400px;
			top: -100px;
			left: -100px;
		}

		.hero-section::after {
			width: 300px;
			height: 300px;
			bottom: -50px;
			right: -50px;
		}

		.hero-content {
			z-index: 10;
			text-align: center;
			width: 100%;
			max-width: 500px;
		}

		.hero-content img {
			max-width: 300px;
			width: 100%;
			height: auto;
			margin-bottom: 30px;
			filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
		}

		.hero-content p {
			font-size: 1.1rem;
			color: #333;
			margin-bottom: 40px;
			line-height: 1.6;
			font-weight: 500;
		}

		.powered-by {
			position: absolute;
			bottom: 40px;
			left: 60px;
			font-size: 0.9rem;
			color: #000;
			font-weight: 700;
			letter-spacing: 1px;
			opacity: 0.6;
		}

		/* Right Side - Form Section */
		.form-section {
			flex: 1;
			background: white;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 40px;
		}

		.login-card {
			width: 100%;
			max-width: 400px;
		}

		.login-card h3 {
			font-size: 2.2rem;
			font-weight: 800;
			color: #0f172a;
			margin-bottom: 10px;
		}

		.login-card p {
			color: #64748b;
			margin-bottom: 35px;
			font-size: 1rem;
		}

		.form-group {
			margin-bottom: 25px;
			position: relative;
		}

		.form-group label {
			display: block;
			font-size: 0.9rem;
			font-weight: 600;
			color: #334155;
			margin-bottom: 10px;
		}

		.input-wrapper {
			position: relative;
			display: flex;
			align-items: center;
		}

		.input-wrapper i {
			position: absolute;
			left: 18px;
			color: #94a3b8;
			font-size: 1.1rem;
		}

		.input-field {
			width: 100%;
			padding: 14px 15px 14px 50px;
			background: #f1f5f9;
			border: 2px solid transparent;
			border-radius: 12px;
			font-size: 1rem;
			transition: all 0.3s;
			color: #1e293b;
		}

		.input-field:focus {
			outline: none;
			border-color: var(--primary-color);
			background: white;
			box-shadow: 0 0 0 4px rgba(241, 196, 15, 0.1);
		}

		.login-btn {
			width: 100%;
			padding: 16px;
			background: #0f172a; /* Dark button for contrast */
			color: var(--primary-color);
			border: none;
			border-radius: 12px;
			font-size: 1.1rem;
			font-weight: 700;
			cursor: pointer;
			transition: all 0.3s;
			margin-top: 15px;
			text-transform: uppercase;
			letter-spacing: 1px;
		}

		.login-btn:hover {
			background: #000;
			transform: translateY(-2px);
			box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
		}

		@media (max-width: 992px) {
			.hero-section { display: none; }
		}
	</style>
</head>
<body>
	
	<div class="login-container">
		<!-- Left Panel -->
		<div class="hero-section">
			<div class="hero-content">
				<img src="login-ui/images/logo.png" alt="My Learning Logo">
				<p>Your comprehensive educational examination management system. Secure, efficient, and reliable.</p>
			</div>
			<div class="powered-by">
				POWERED BY EGOLD TECHNOLOGY
			</div>
		</div>

		<!-- Right Panel -->
		<div class="form-section">
			<div class="login-card">
				<h3>Sign in</h3>
				<p>Please enter your administrator credentials to continue.</p>

				<form method="post" id="adminLoginFrm">
					<div class="form-group">
						<label>Username</label>
						<div class="input-wrapper">
							<i class="fa fa-user"></i>
							<input class="input-field" type="text" name="username" placeholder="Enter admin username" required>
						</div>
					</div>

					<div class="form-group">
						<label>Password</label>
						<div class="input-wrapper">
							<i class="fa fa-lock"></i>
							<input class="input-field" type="password" name="pass" placeholder="Enter password" required>
						</div>
					</div>

					<button type="submit" class="login-btn">
						Login Now
					</button>
				</form>
			</div>
		</div>
	</div>
	
	<script src="login-ui/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="js/sweetalert.js"></script>
    <script src="js/ajax.js"></script>

</body>
</html>
</html>