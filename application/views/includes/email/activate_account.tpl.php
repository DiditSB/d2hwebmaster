<html>
<body>
	<h1>Hi <?php echo $identity;?></h1>
        <p><strong>To complete the sign-up process, please follow this link:</strong></p>
	<p><?php echo anchor('index/activate_account/'. $user_id .'/'. $activation_token, 'index/activate_account/'. $user_id .'/'. $activation_token);?></p>
        <p>Welcome to d2hwebmaster!</p>
</body>
</html>