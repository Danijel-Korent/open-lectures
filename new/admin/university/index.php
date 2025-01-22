<?php
//Import constants file
require_once dirname(__DIR__,2).'/constants.php';
session_start();
if (empty($_SESSION['logged'])){
	header('Location: '.SITE_URL.'/admin/login',true);
	exit;
}
$title = 'University';
require_once REPO_PATH;


//CREATE UNI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createLecturer'])) {
	$firstName = $_POST['firstName'];
	$lastName= $_POST['lastName'];
	$image = $_FILES['image'];
	//add file extension .png, .jpg, .jpeg
	$directory = dirname(__DIR__,2).'/assets/images/UNI';
	$filePath = saveFile($image,strtolower($firstName.$lastName),$directory);
	if($filePath){
		$created = insertLecturer($firstName,$lastName,$filePath);
		if($created){
			header('Location: '.SITE_URL.'/admin/lecturer',true);
			exit;
		}
	}else{
		echo '<script>alert("Error uploading image")</script>';
	}

}

//UPDATE UNI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateLecturerId'])) {
    $id = $_POST['updateLecturerId'];
	$firstName = trim($_POST['firstName']);
	$lastName = trim($_POST['lastName']);
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;
    $oldImage = $_POST['oldImage'];
    $directory = dirname(__DIR__, 2) . '/assets/images/lecturer';

    // Directory for saving images

    // Initialize the filePath with the old image path
    $filePath = $oldImage;

    try {
        // Validate ID and Name
        if (empty($id) || empty($firstName)||empty($lastName)) {
            throw new Exception('Lecturer ID and Name are required.');
        }

        // Check if a new image is uploaded
        if (!empty($image) && $image['error'] === UPLOAD_ERR_OK) {
            // Delete the old image file if it exists
            $oldImagePath = $directory . '/' . $oldImage;
            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Save the new image
            $filePath = saveFile($image, strtolower($firstName.$lastName), $directory);

            // If saving fails, show an error message
            if (!$filePath) {
                throw new Exception('Error uploading new image.');
            }
        }

        // Update the category in the database
        $updateCategory = updateLecturer($id, $firstName,$lastName, $filePath);
        if ($updateCategory) {
            header('Location: ' . SITE_URL . '/admin/lecturer');
            exit;
        } else {
            throw new Exception('Error updating lecturer in the database.');
        }
    } catch (Exception $e) {
        echo '<script>alert("' . $e->getMessage() . '");</script>';
    }
}

//DELETE UNI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUniId'])) {
	$id = $_POST['deleteUniId'];
	$imageName = $_POST['oldImage'];
	$res = true;
	if (!empty($imageName)){
		$res =deleteFile(dirname(__DIR__,2).'/assets/images/lecturer/'.$imageName);
	}
if($res){
	$deleteCategory = deleteLecturer($id);
	if($deleteCategory){
		header('Location: '.SITE_URL.'/admin/lecturer',true);
		exit;
	}
}else{
	echo '<script>alert("Error deleting image")</script>';
}
}

ob_start();
?>
<div x-data="{modalIsOpen: false}">
	<div class="flex w-full justify-between mb-5">
		<h2 class="text-2xl font-semibold">Universities</h2>
		<button @click="modalIsOpen = true" type="button"
			class="cursor-pointer inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
			<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
				class="size-5 fill-neutral-100" fill="currentColor">
				<path fill-rule="evenodd"
					d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
					clip-rule="evenodd" />
			</svg>
			Add University
		</button>
	</div>
	<!-- Search -->
	<form action="" method="get" class="flex gap-2 ml-2">
		<div class="relative flex w-full mb-4 min-w-sm md:max-w-md flex-col gap-1 text-neutral-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
				stroke="currentColor" aria-hidden="true"
				class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
			</svg>
			<input type="search" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>"
				class="w-full rounded-md border border-neutral-300 bg-neutral-50 py-2 pl-10 pr-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
				name="keyword" placeholder="Search" aria-label="search" />
		</div>
		<button type="submit"
			class="cursor-pointer h-10 inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
			Search
		</button>
	</form>
	<!-- Create Modal -->
	<div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen"
		@keydown.esc.window="modalIsOpen = false" @click.self="modalIsOpen = false"
		class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
		role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
		<!-- Modal Dialog -->
		<div x-show="modalIsOpen"
			x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
			x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
			class="flex md:w-[40%] w-[90%] flex-col gap-4 overflow-hidden rounded-md border border-neutral-300 bg-white text-neutral-600">
			<!-- Dialog Header -->
			<div class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4">
				<h3 id="defaultModalTitle" class="font-semibold tracking-wide text-neutral-900">Add New University</h3>
				<button @click="modalIsOpen = false" aria-label="close modal">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
						fill="none" stroke-width="1.4" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
			<!-- Dialog Body -->
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="createLecturer" value="1">
				<div class="px-4 pb-4">
					<!-- Photo -->
					<div
						class="border-b border-neutral-300 pb-4 mb-3 relative flex w-full flex-col gap-1 text-neutral-600">
						<label for="image" class="w-fit pl-0.5 text-sm">Upload Image</label>
						<input required id="image" name="image" type="file"
							class="w-full max-w-md overflow-clip rounded-md border border-neutral-300 bg-neutral-50/50 text-sm file:mr-4 file:cursor-pointer file:border-none file:bg-neutral-50 file:px-4 file:py-2 file:font-medium file:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75" />
						<small class="pl-0.5">.png, .jpg, .jpeg</small>
					</div>

					<!-- Name -->
					<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
						<label for="name" class="w-fit pl-0.5 text-sm">Name</label>
						<input required id="name" type="text"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="name" placeholder="Name" />
					</div>
					<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
						<label for="city" class="w-fit pl-0.5 text-sm">City</label>
						<input required id="city" type="text"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="city" placeholder="City" />
					</div>
					<div class="flex w-full flex-col gap-1 text-neutral-600 ">
						<label for="country" class="w-fit pl-0.5 text-sm">Country</label>
						<input required id="country" type="text"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="country" placeholder="Country" />
					</div>

				</div>
				<!-- Dialog Footer -->
				<div
					class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
					<button type="submit"
						class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
						Add University</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Create Modal -->
<div class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300 ">
	<table class="w-full text-left text-sm text-neutral-600">
		<thead class="border-b border-neutral-300 bg-neutral-50 text-sm text-neutral-900">
			<tr>
				<th scope="col" class="p-4">Name</th>
				<th scope="col" class="p-4">Action</th>
			</tr>
		</thead>
		<tbody class="divide-y divide-neutral-300">
			<?php foreach($dataArray['data'] as $c){ ?>
			<?php $index=$c["idPredavac"];?>
			<tr>
				<td class="p-4">
					<div class="flex w-max items-center gap-3">

						<?php if(empty($c["slika_ustanove"])|| !isset($c["slika_ustanove"])){?>
						<div class="size-14 bg-gray-200 rounded-full flex items-center justify-center">
							<svg class="size-8 shrink-0" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor"
								xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
								<path
									d="M12.75 14.6667C12.75 14.2524 13.0858 13.9167 13.5 13.9167H16.5C16.9142 13.9167 17.25 14.2524 17.25 14.6667C17.25 15.0809 16.9142 15.4167 16.5 15.4167H13.5C13.0858 15.4167 12.75 15.0809 12.75 14.6667Z"
									fill="#343C54" />
								<path
									d="M13.5 8.58334C13.0858 8.58334 12.75 8.91913 12.75 9.33334C12.75 9.74756 13.0858 10.0833 13.5 10.0833H16.5C16.9142 10.0833 17.25 9.74756 17.25 9.33334C17.25 8.91913 16.9142 8.58334 16.5 8.58334H13.5Z"
									fill="#343C54" />
								<path fill-rule="evenodd" clip-rule="evenodd"
									d="M11.5 3.25C10.2574 3.25 9.25 4.25736 9.25 5.5V7.75H5.5C4.25736 7.75 3.25 8.75736 3.25 10V20C3.25 20.4142 3.58579 20.75 4 20.75H20C20.4142 20.75 20.75 20.4142 20.75 20V5.5C20.75 4.25736 19.7426 3.25 18.5 3.25H11.5ZM9.25 19.25V17H7.75586C7.34165 17 7.00586 16.6642 7.00586 16.25C7.00586 15.8358 7.34165 15.5 7.75586 15.5H9.25V13H7.75586C7.34165 13 7.00586 12.6642 7.00586 12.25C7.00586 11.8358 7.34165 11.5 7.75586 11.5H9.25V9.25H5.5C5.08579 9.25 4.75 9.58579 4.75 10V19.25H9.25ZM10.75 12.2773C10.7503 12.2683 10.7505 12.2591 10.7505 12.25C10.7505 12.2409 10.7503 12.2317 10.75 12.2227V5.5C10.75 5.08579 11.0858 4.75 11.5 4.75H18.5C18.9142 4.75 19.25 5.08579 19.25 5.5V19.25H10.75V16.2773C10.7503 16.2683 10.7505 16.2591 10.7505 16.25C10.7505 16.2409 10.7503 16.2317 10.75 16.2227V12.2773Z"
									fill="#343C54" />
							</svg>
						</div>
						<?php }else{?>
						<img class="size-14 rounded-full object-cover"
							src="<?=ASSET_PATH."/images/lecturer/".$c['slika_ustanove'] ?>" alt="avatar" />
						<?php } ?>
						<div class="flex flex-col">
							<span class="text-neutral-900 text-lg font-semibold">
								<?=$c['ime']?> <?=$c["prezime"]?>
							</span>
						</div>
					</div>
				</td>
				<td class="p-4">
					<div x-data="{deleteModal<?=$index?>: false, updateModal<?=$index?>: false }">
						<button @click="updateModal<?=$index?> = true" type="button"
							class="cursor-pointer whitespace-nowrap rounded-md bg-sky-500 px-4 py-2 text-xs font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">Edit</button>

						<button type="button" @click="deleteModal<?=$index?> = true"
							class="cursor-pointer whitespace-nowrap rounded-md bg-red-500 px-4 py-2 text-xs font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">Delete</button>

						<!-- Update Modal -->
						<div x-cloak x-show="updateModal<?=$index?>" x-transition.opacity.duration.200ms
							x-trap.inert.noscroll="updateModal<?=$index?>"
							@keydown.esc.window="updateModal<?=$index?> = false"
							@click.self="updateModal<?=$index?> = false"
							class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
							role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
							<!-- Modal Dialog -->
							<div x-show="updateModal<?=$index?>"
								x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
								x-transition:enter-start="opacity-0 scale-50"
								x-transition:enter-end="opacity-100 scale-100"
								class="flex md:w-[40%] w-[90%] flex-col gap-4 overflow-hidden rounded-md border border-neutral-300 bg-white text-neutral-600">
								<!-- Dialog Header -->
								<div
									class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4">
									<h3 id="defaultModalTitle" class="font-semibold tracking-wide text-neutral-900">
										Update Lecturer</h3>
									<button @click="updateModal<?=$index?> = false" aria-label="close modal">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
											stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M6 18L18 6M6 6l12 12" />
										</svg>
									</button>
								</div>
								<!-- Dialog Body -->
								<form action="" method="post" enctype="multipart/form-data">
									<input type="hidden" name="updateLecturerId" value="<?=$index?>">
									<input type="hidden" name="oldImage" value="<?=$c["slika_ustanove"]?>">
									<div class="px-4 pb-4">
										<!-- Photo -->
										<div
											class="border-b border-neutral-300 pb-4 mb-3 relative flex w-full flex-col gap-1 text-neutral-600">
											<label for="image" class="w-fit pl-0.5 text-sm">Upload Image</label>
											<input type="file" name="image" id="image"
												class="w-full max-w-md overflow-clip rounded-md border border-neutral-300 bg-neutral-50/50 text-sm file:mr-4 file:cursor-pointer file:border-none file:bg-neutral-50 file:px-4 file:py-2 file:font-medium file:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75" />
											<small class="pl-0.5">.png, .jpg, .jpeg</small>
										</div>

										<!-- Name -->
										<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
											<label for="name" class="w-fit pl-0.5 text-sm">Name</label>
											<input required id="name" type="text" value="<?=$c['naziv_ustanove']?>"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="name" placeholder="Name" />
										</div>
										<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
											<label for="city" class="w-fit pl-0.5 text-sm">City</label>
											<input required id="city" type="text" value="<?=$c['mjesto']?>"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="city" placeholder="City" />
										</div>
										<div class="flex w-full flex-col gap-1 text-neutral-600 ">
											<label for="country" class="w-fit pl-0.5 text-sm">Country</label>
											<input required id="country" type="text" value="<?=$c['drzava']?>"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="country" placeholder="Country" />
										</div>


									</div>

									<!-- Dialog Footer -->
									<div
										class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
										<button type="submit"
											class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
											Update University</button>
									</div>
								</form>
							</div>
						</div>
						<!-- End Update Modal -->
						<!-- Delete Modal -->
						<div x-cloak x-show="deleteModal<?=$index?> " x-transition.opacity.duration.200ms
							x-trap.inert.noscroll="deleteModal<?=$index?> "
							@keydown.esc.window="deleteModal<?=$index?>  = false"
							@click.self="deleteModal<?=$index?> = false"
							class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
							role="dialog" aria-modal="true" aria-labelledby="dangerModalTitle">
							<!-- Modal Dialog -->
							<div x-show="deleteModal<?=$index?>"
								x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
								x-transition:enter-start="opacity-0 scale-50"
								x-transition:enter-end="opacity-100 scale-100"
								class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-md border border-neutral-300 bg-white text-neutral-600">
								<!-- Dialog Header -->
								<div
									class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 px-4 py-2">
									<div
										class="flex items-center justify-center rounded-full bg-red-500/20 text-red-500 p-1">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
											class="size-6" aria-hidden="true">
											<path fill-rule="evenodd"
												d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
												clip-rule="evenodd" />
										</svg>
									</div>
									<button @click="deleteModal<?=$index?> = false" aria-label="close modal">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
											stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M6 18L18 6M6 6l12 12" />
										</svg>
									</button>
								</div>
								<!-- Dialog Body -->
								<div class="px-4 text-center">
									<h3 id="dangerModalTitle"
										class="mb-2 font-semibold tracking-wide text-lg text-neutral-900">
										Delete <?=$c['naziv_ustanove']?>?></h3>
									<p class="text-md">Are you sure you want to delete this university?</p>
								</div>
								<!-- Dialog Footer -->
								<div class="flex items-center justify-center border-neutral-300 p-4">
									<form action="" method="post">
										<input type="hidden" name="oldImage" value="<?=$c["slika_ustanove"]?>">
										<input type="hidden" name="deleteUniId" value="<?=$index?>">
										<button type="submit"
											class="w-full cursor-pointer whitespace-nowrap rounded-md bg-red-500 px-4 py-2 text-center text-sm font-semibold tracking-wide text-white transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500 active:opacity-100 active:outline-offset-0">
											Delete Now</button>
									</form>
								</div>
							</div>
						</div>
						<!-- End Delete Modal -->

					</div>
				</td>

			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/admin_layout.php';
?>