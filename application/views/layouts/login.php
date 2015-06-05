<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $title; ?></title>

  <!-- CSS -->
  <link rel="stylesheet" href="./public/css/joust.min.css" type="text/css" media="screen" title="no title" charset="utf-8">

  <!-- Javascript -->
  <script type="text/javascript" src=""></script>

</head>
	<body class="joust-login">
		
    <div class="joust-login-form">
      <form action="/login" method="post" novalidate>
        <div class="form-field">
          <label for="username">Username:</label>
          <input class="field-input" type="email" name="username" id="username">
        </div>
        <div class="form-field">
          <label for="password">Password:</label>
          <input class="field-input" type="password" name="password" id="password">
        </div>
        <div class="form-field">
          <input class="field-button button button-blue" type="submit" value="Login">
        </div>
      </form>
      <?php echo isset($error) ? $error : "" ; ?>
    </div>

	</body>
</html>