<?php 
require_once dirname(__DIR__,2).'/constants.php';
require_once REPO_PATH;
session_start();
if (!empty($_SESSION['logged'])){
	header('Location: '.SITE_URL.'/admin/home',true);
	exit;
}
$title = 'Login';
//Logic
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['email'];
	$password = $_POST['password'];
	//Query
	$query = db()->prepare('SELECT * FROM admin WHERE email = ?');
	$query->bind_param('s', $email);
	$query->execute();
	$result = $query->get_result();
	$user = $result->fetch_assoc();
	if($user && password_verify($password, $user['password'])) {
		//Login
		// fUser = db()->prepare('SELECT * FROM admin WHERE id = ?');
		// $fUser->bind_param('i', $user['id']);
		// $
		$_SESSION['logged'] = $user;
		header('Location: '.SITE_URL.'/admin/home',true);
		exit;
	}
}
ob_start();
?>
<section class="w-full h-screen h-full flex flex-col justify-center items-center">
	<form class=" md:w-1/3" action="" method="post">
		<h2 class="text-xl font-bold text-center mb-2">Login into your account</h2>
		<!-- Email Address -->
		<div class="flex flex-col gap-1 text-neutral-600 ">
			<label for="email" class="w-fit pl-0.5 text-sm">Email Address</label>
			<input id="email" name="email" type="email" required class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75" placeholder="Enter your email address" />
		</div>

		<!-- Password -->
		<div class="flex w-full flex-col gap-1 text-neutral-600 my-3">
		<label for="password" class="w-fit pl-0.5 text-sm">Password</label>
		<div x-data="{ showPassword: false }" class="relative">
			<input :type="showPassword ? 'text' : 'password'" requiredß id="password" name="password" class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75" placeholder="Enter your password"/>
			<button type="button"  @click="showPassword = !showPassword" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-neutral-600" aria-label="Show password">
				<svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5"> 
					<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
					<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
				</svg>
				<svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5"> 
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
				</svg>
			</button>
		</div>
	</div>
	<!-- Button -->
	 <button type="submit" class="mt-2 w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">Login</button>
	</form>

</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/blank.php';
?>