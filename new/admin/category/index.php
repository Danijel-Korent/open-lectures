<?php
//Import constants file
require_once dirname(__DIR__,2).'/constants.php';
require_once REPO_PATH;
require_once STORAGE_REPO_PATH;

session_start();
if (empty($_SESSION['logged'])){
	header('Location: '.SITE_URL.'/admin/login',true);
	exit;
}
$title = 'Category';
$data = selectKategorije();

//CREATE CATEGORY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createCategory'])) {
	$name = $_POST['name'];
	$image = $_FILES['image'];
	//add file extension .png, .jpg, .jpeg
	$directory = dirname(__DIR__,2).'/assets/images/categories';
	$filePath = saveFile($image,strtolower($name),$directory);
	if($filePath){
		$createCategory = insertCategory($name,$filePath);
		if($createCategory){
			header('Location: '.SITE_URL.'/admin/category',true);
			exit;
		}
	}else{
		echo '<script>alert("Error uploading image")</script>';
	}

}

//UPDATE CATEGORY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCategoryId'])) {
    $id = $_POST['updateCategoryId'];
    $name = trim($_POST['name']);
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;
    $oldImage = $_POST['oldImage'];
    $directory = dirname(__DIR__, 2) . '/assets/images/categories';

    // Directory for saving images

    // Initialize the filePath with the old image path
    $filePath = $oldImage;

    try {
        // Validate ID and Name
        if (empty($id) || empty($name)) {
            throw new Exception('Category ID and Name are required.');
        }

        // Check if a new image is uploaded
        if (!empty($image) && $image['error'] === UPLOAD_ERR_OK) {
            // Delete the old image file if it exists
            $oldImagePath = $directory . '/' . $oldImage;

            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Save the new image
            $filePath = saveFile($image, strtolower($name), $directory);

            // If saving fails, show an error message
            if (!$filePath) {
                throw new Exception('Error uploading new image.');
            }
        }

        // Update the category in the database
        $updateCategory = updateCategory($id, $name, $filePath);
        if ($updateCategory) {
            header('Location: ' . SITE_URL . '/admin/category');
            exit;
        } else {
            throw new Exception('Error updating category in the database.');
        }
    } catch (Exception $e) {
        echo '<script>alert("' . $e->getMessage() . '");</script>';
    }
}

//DELETE CATEGORY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCategoryId'])) {
	$id = $_POST['deleteCategoryId'];
	$imageName = $_POST['oldImage'];
	$res = true;
	if (!empty($imageName)){
		$res =deleteFile(dirname(__DIR__,2).'/assets/images/categories/'.$imageName);
	}
if($res){
	$deleteCategory = deleteCategory($id);
	if($deleteCategory){
		header('Location: '.SITE_URL.'/admin/category',true);
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
		<h2 class="text-2xl font-semibold">Categories</h2>
		<button @click="modalIsOpen = true" type="button"
			class="cursor-pointer inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
			<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
				class="size-5 fill-neutral-100" fill="currentColor">
				<path fill-rule="evenodd"
					d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
					clip-rule="evenodd" />
			</svg>
			Add Category
		</button>
	</div>
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
				<h3 id="defaultModalTitle" class="font-semibold tracking-wide text-neutral-900">Add New Category</h3>
				<button @click="modalIsOpen = false" aria-label="close modal">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
						fill="none" stroke-width="1.4" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
			<!-- Dialog Body -->
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="createCategory" value="1">
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
					<div class="flex w-full flex-col gap-1 text-neutral-600 ">
						<label for="textInputDefault" class="w-fit pl-0.5 text-sm">Category Name</label>
						<input required id="textInputDefault" type="text"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="name" placeholder="Category Name" />
					</div>

				</div>
				<!-- Dialog Footer -->
				<div
					class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
					<button type="submit"
						class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
						Add Category</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Create Modal -->
<div class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300 ">
	<?php if (empty($data)) { ?>
	<div class="p-10 w-full text-center">
		<td class="p-4 font-bold text-[2rem]" colspan="3">No categories found</td>
	</div>
	<?php }else{ ?>
	<table class="w-full text-left text-sm text-neutral-600">
		<thead class="border-b border-neutral-300 bg-neutral-50 text-sm text-neutral-900">
			<tr>
				<th scope="col" class="p-4">Name</th>
				<th scope="col" class="p-4">Action</th>
			</tr>
		</thead>
		<tbody class="divide-y divide-neutral-300">
			<?php foreach($data as $c){ ?>
			<?php $index=$c["idKategorije"];?>
			<tr>
				<td class="p-4">
					<div class="flex w-max items-center gap-3">
						<img class="size-14 rounded-full object-cover"
							src="<?=$c["slika_kategorije"] == "" ?ASSET_PATH."/images/categories/uncategorized.jpeg":ASSET_PATH."/images/categories/".$c['slika_kategorije'] ?>"
							alt="user avatar" />
						<div class="flex flex-col">
							<span class="text-neutral-900 text-lg font-semibold"> <?=$c['naziv_kategorije']?></span>
						</div>
					</div>
				</td>
				<td class="p-4">
					<div x-data="{deleteModal<?=$index?>: false, updateModal<?=$index?>: false }">
						<button type="button" @click="updateModal<?=$index?> = true"
							class="cursor-pointer whitespace-nowrap rounded-md bg-transparent p-0.5 font-semibold text-black outline-black hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0">Edit</button>
						<button type="button" @click="deleteModal<?=$index?> = true"
							class="cursor-pointer whitespace-nowrap rounded-md bg-transparent p-0.5 font-semibold text-red-500 outline-black hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0">Delete</button>
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
										Update Category</h3>
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
									<input type="hidden" name="updateCategoryId" value="<?=$c['idKategorije']?>">
									<input type="hidden" name="oldImage" value="<?=$c["slika_kategorije"]?>">
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
										<div class="flex w-full flex-col gap-1 text-neutral-600 ">
											<label for="textInputDefault" class="w-fit pl-0.5 text-sm">Category
												Name</label>
											<input id="textInputDefault" type="text"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="name" value="<?=$c['naziv_kategorije']?>"
												placeholder="Category Name" />
										</div>

									</div>
									<!-- Dialog Footer -->
									<div
										class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
										<button type="submit"
											class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
											Update Category</button>
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
										Delete <?=$c['naziv_kategorije']?> Category</h3>
									<p class="text-md">Are you sure you want to delete this category?</p>
								</div>
								<!-- Dialog Footer -->
								<div class="flex items-center justify-center border-neutral-300 p-4">
									<form action="" method="post">
										<input type="hidden" name="oldImage" value="<?=$c["slika_kategorije"]?>">
										<input type="hidden" name="deleteCategoryId" value="<?=$c['idKategorije']?>">
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
	<?php } ?>
</div>
<div class="flex w-full justify-end mt-5">
	<button @click="modalIsOpen = true" type="button"
		class="cursor-pointer inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
		<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-neutral-100"
			fill="currentColor">
			<path fill-rule="evenodd"
				d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
				clip-rule="evenodd" />
		</svg>
		Add Category
	</button>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/admin_layout.php';
?>