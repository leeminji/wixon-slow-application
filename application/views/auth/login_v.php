
<div class="LoginForm">
	<?php 
		$attr = array('class' => 'form-signin', 'id'=>'frm');
		echo form_open('', $attr); 
	?>
		<input type="hidden" name="return_url" value="<?php echo $return_url?>">
		<input type="hidden" name="token" value="<?php echo $token ?>" />
		
		<h2 class="LoginForm__title">
			<span class="login-text">Slow</span>
		</h2>
		
		<?php foreach($error as $value){ ?>
		<div id="alert-area" class="AlertArea">
			<p class="bg-warning"><?php echo $value ?></p>
		</div>
		<?php }?>
		<div class="pt10"></div>
		<div class="LoginForm__item">
			<label for="mb_id" class="sr-only">ID</label>
			<input type="text" id="mb_id" name="mb_id" class="form-control" placeholder="ID" required autofocus>
		</div>
		<div class="pt5"></div>
		<div class="LoginForm__item">
			<label for="mb_passwd" class="sr-only">Password</label>
			<input type="password" id="mb_passwd" name="mb_passwd" class="form-control" placeholder="Password" required>
		</div>
		<div class="LoginForm__bottom">
			<button class="Button Button__login" type="submit">로그인</button>
		</div>
	</form>
</div>