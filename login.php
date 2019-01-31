
<html>
<body>
	<style>
	*{
		font-family:"verdana";
	}
	input.form-control{
		padding:25px!important;
	}
	.btn-success{
	 padding:15px!important;
 }
 @media only screen and (max-width:768px){
   #housewife{
		 display:none;
	 }
 }
	</style>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<nav class="navbar" style="border-radius:0px;border:0px;border-bottom:1px solid #ccc;margin-bottom:0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
			<a class="navbar-brand" href="#" style="color:#a68100;font-size:26px;font-weight:bold;">KwikAssist</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar" style="float:right;">
      <ul class="nav navbar-nav">
        <li><a href="#" style="color:#333;font-size:14px;">Home</a></li>
				<li><a href="#" style="color:#333;font-size:14px;">Services</a></li>
				<li><a href="#" style="color:#333;font-size:14px;">About</a></li>
				<li><a href="#" style="color:#333;font-size:14px;">Appliances</a></li>
				<li><a href="#" style="color:#333;font-size:14px;">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
<nav class="navbar-default" style="background:none;margin:0px;border:none;margin:0px;">
	<ul class="nav navbar-nav">
		<li><a href="#" style="font-size:12px;color:#333;">Home > Customer Registration > Login</a></li>
	</ul>
</nav>

<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: register.php");
    exit;
}
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'kwikAssist');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "CREATE TABLE users(email_addr varchar(100), password varchar(100), PRIMARY KEY(email_addr))";
$result = mysqli_query($link, $sql);

$sql = "INSERT INTO users(email_addr,password) values('103890303','*2Shower*')";
$result = mysqli_query($link, $sql);


if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $sql = "SELECT email_addr FROM users where email_addr = '".$_POST['username']."' and password = '".$_POST['password']."'";
				$result = mysqli_query($link, $sql);
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count == 1) {
                 session_start();
                  $_SESSION["loggedin"] = true;
                  $_SESSION["username"] = $_POST['username'];
                  header("location: register.php");
        }
}
?>
<div style="background:url(images/house.jpg) no-repeat left 0px;width:100%;height:600px;box-sizing:border-box;overflow:hidden;">
	 <div style="float:left;background:#fff;width:450px;margin-left:80px;margin-top:100px;height:400px;border-radius:10px;padding:25px;box-sizing:border-box;">
		 <div class="login-form">
		     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		         <h2 style="line-height:36px;">My Account</h2>
		         <div class="form-group">
		             <input type="text" name="username" class="form-control" value="103890303" placeholder="Username" required="required">
		         </div>
		         <div class="form-group">
		             <input type="password" name="password" class="form-control" value="*2Shower*" placeholder="Password" required="required">
		         </div>
		         <div class="form-group">
		             <button type="submit" class="btn btn-success btn-block">Log in</button>
		         </div>
		         <div class="clearfix">
		             <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
		             <a href="#" class="pull-right">Forgot Password?</a>
		         </div>
		     </form>
		     <p class="text-center"><a href="#">Create an Account</a></p>
		 </div>
	 </div>
   <div id="housewife" style="float:right;background:url(images/housewife.png) no-repeat left top;width:505px;height:581px;margin-top:17px;"></div>
</div>
<footer style="text-align:center;font-size:11px;padding:10px;">Copyright &copy; 2018 KwikAssist. All rights reserved.</footer>
</body>
</html>
