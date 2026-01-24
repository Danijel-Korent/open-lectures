<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once REPO_PATH;
session_start();

if (empty($_SESSION['logged'])) {
	header('Location: ' . baseUrl('/admin/login'), true);
	exit;
}

$title = 'Change Password';
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$currentPassword = $_POST['current_password'] ?? '';
	$newPassword = $_POST['new_password'] ?? '';
	$confirmPassword = $_POST['confirm_password'] ?? '';
	$adminId = (int)($_SESSION['logged']['id'] ?? 0);
	
	// Validation
	if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
		$error = 'All fields are required.';
	} elseif ($newPassword !== $confirmPassword) {
		$error = 'New password and confirmation do not match.';
	} elseif (strlen($newPassword) < 8) {
		$error = 'New password must be at least 8 characters long.';
	} else {
		// Update password
		$result = updateAdminPassword($adminId, $currentPassword, $newPassword);
		
		if ($result) {
			$success = 'Password changed successfully!';
			// Clear form fields by redirecting to prevent resubmission
			header('Location: ' . baseUrl('/admin/password?success=1'), true);
			exit;
		} else {
			$error = 'Current password is incorrect or update failed.';
		}
	}
}

// Check for success message from redirect
if (isset($_GET['success']) && $_GET['success'] == '1') {
	$success = 'Password changed successfully!';
}

ob_start();
?>
<div class="max-w-md mx-auto mt-8">
	<h1 class="text-3xl font-bold text-center mb-6 text-primary">Change Password</h1>
	
	<?php if ($error): ?>
		<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
			<?= htmlspecialchars($error) ?>
		</div>
	<?php endif; ?>
	
	<?php if ($success): ?>
		<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
			<?= htmlspecialchars($success) ?>
		</div>
	<?php endif; ?>
	
	<form method="post" action="" class="space-y-4">
		<!-- Current Password -->
		<div class="flex flex-col gap-1 text-neutral-600">
			<label for="current_password" class="w-fit pl-0.5 text-sm font-medium">Current Password</label>
			<div x-data="{ showPassword: false }" class="relative">
				<input 
					:type="showPassword ? 'text' : 'password'" 
					id="current_password" 
					name="current_password" 
					required
					class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75"
					placeholder="Enter your current password" />
				<button 
					type="button" 
					@click="showPassword = !showPassword"
					class="absolute right-2.5 top-1/2 -translate-y-1/2 text-neutral-600" 
					aria-label="Show password">
					<svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
						<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
					</svg>
					<svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
					</svg>
				</button>
			</div>
		</div>
		
		<!-- New Password -->
		<div class="flex flex-col gap-1 text-neutral-600">
			<label for="new_password" class="w-fit pl-0.5 text-sm font-medium">New Password</label>
			<div x-data="{ showPassword: false }" class="relative">
				<input 
					:type="showPassword ? 'text' : 'password'" 
					id="new_password" 
					name="new_password" 
					required
					minlength="8"
					class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75"
					placeholder="Enter your new password (min. 8 characters)" />
				<button 
					type="button" 
					@click="showPassword = !showPassword"
					class="absolute right-2.5 top-1/2 -translate-y-1/2 text-neutral-600" 
					aria-label="Show password">
					<svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
						<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
					</svg>
					<svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
					</svg>
				</button>
			</div>
			<p class="text-xs text-neutral-500 mt-1">Password must be at least 8 characters long.</p>
		</div>
		
		<!-- Confirm New Password -->
		<div class="flex flex-col gap-1 text-neutral-600">
			<label for="confirm_password" class="w-fit pl-0.5 text-sm font-medium">Confirm New Password</label>
			<div x-data="{ showPassword: false }" class="relative">
				<input 
					:type="showPassword ? 'text' : 'password'" 
					id="confirm_password" 
					name="confirm_password" 
					required
					minlength="8"
					class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75"
					placeholder="Confirm your new password" />
				<button 
					type="button" 
					@click="showPassword = !showPassword"
					class="absolute right-2.5 top-1/2 -translate-y-1/2 text-neutral-600" 
					aria-label="Show password">
					<svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
						<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
					</svg>
					<svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
					</svg>
				</button>
			</div>
		</div>
		
		<!-- Submit Button -->
		<button 
			type="submit"
			class="mt-4 w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
			Change Password
		</button>
		
		<!-- Cancel/Back Link -->
		<div class="text-center mt-4">
			<a href="<?= baseUrl('/admin/home') ?>" class="text-sm text-primary hover:underline">
				Cancel
			</a>
		</div>
	</form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/admin_layout.php';
?>

