<?php
//Import constants file
require_once dirname(__DIR__,2).'/constants.php';
session_start();
if (empty($_SESSION['logged'])){
	header('Location: '.SITE_URL.'/admin/login',true);
	exit;
}
$title = 'Lecturer';
require_once REPO_PATH;
require_once STORAGE_REPO_PATH;

if(isset($_GET['keyword'])&& !empty($_GET['keyword'])){
//SEARCH Fn
$search = $_GET['keyword'];
$d = selectAllLecturers($search);
$dataArray['data'] = $d;
$dataArray['total'] = count($d);
$dataArray['currentPage'] = 1;
$dataArray['perPage'] = 10;
$dataArray['totalPages'] = ceil($dataArray['total'] / $dataArray['perPage']);
$title = 'Search Result for '.$search;
}else{
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$dataArray = selectPaginatedLecturers($page,10);
}

//CREATE LECTURER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createLecturer'])) {
	$firstName = $_POST['firstName'];
	$lastName= $_POST['lastName'];
	$image = $_FILES['image'];
	//add file extension .png, .jpg, .jpeg
	$directory = dirname(__DIR__,2).'/assets/images/lecturer';
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

//UPDATE LECTURER
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

//DELETE LECTURER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteLecturerId'])) {
	$id = $_POST['deleteLecturerId'];
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
		<h2 class="text-2xl font-semibold">Lecturers</h2>
		<button @click="modalIsOpen = true" type="button"
			class="cursor-pointer inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
			<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
				class="size-5 fill-neutral-100" fill="currentColor">
				<path fill-rule="evenodd"
					d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
					clip-rule="evenodd" />
			</svg>
			Add Lecturer
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
				<h3 id="defaultModalTitle" class="font-semibold tracking-wide text-neutral-900">Add New Lecturer</h3>
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
						<input id="image" name="image" type="file"
							class="w-full max-w-md overflow-clip rounded-md border border-neutral-300 bg-neutral-50/50 text-sm file:mr-4 file:cursor-pointer file:border-none file:bg-neutral-50 file:px-4 file:py-2 file:font-medium file:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75" />
						<small class="pl-0.5">.png, .jpg, .jpeg</small>
					</div>

					<!-- Name -->
					<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
						<label for="firstName" class="w-fit pl-0.5 text-sm">First Name</label>
						<input required id="firstName" type="text"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="firstName" placeholder="First Name" />
					</div>
					<div class="flex w-full flex-col gap-1 text-neutral-600 ">
						<label for="lastName" class="w-fit pl-0.5 text-sm">Last Name</label>
						<input required id="lastName" type="text"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="lastName" placeholder="Last Name" />
					</div>

				</div>
				<!-- Dialog Footer -->
				<div
					class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
					<button type="submit"
						class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
						Add Lecturer</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Create Modal -->
<div class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300 ">
	<?php if (empty($dataArray['data'])) { ?>
	<div class="p-10 w-full text-center">
		<td class="p-4 font-bold text-[2rem]" colspan="3">No lecturers found</td>
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
			<?php foreach($dataArray['data'] as $c){ ?>
			<?php $index=$c["idPredavac"];?>
			<tr>
				<td class="p-4">
					<div class="flex w-max items-center gap-3">

						<?php if(empty($c["slika_predavaca"])|| !isset($c["slika_predavaca"])){?>
						<div class="size-14 bg-gray-200 rounded-full flex items-center justify-center">
							<svg class="size-8 shrink-0" aria-hidden="true" viewBox="0 0 25 24" fill="currentColor"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M15.3289 11.4955C14.4941 11.4955 13.724 11.2188 13.1051 10.7522C13.3972 10.3301 13.6284 9.86262 13.786 9.36254C14.1827 9.7539 14.7276 9.99545 15.3289 9.99545C16.5422 9.99545 17.5258 9.01185 17.5258 7.79851C17.5258 6.58517 16.5422 5.60156 15.3289 5.60156C14.7276 5.60156 14.1827 5.84312 13.786 6.23449C13.6284 5.73441 13.3972 5.26698 13.1051 4.84488C13.7239 4.37824 14.4941 4.10156 15.3289 4.10156C17.3706 4.10156 19.0258 5.75674 19.0258 7.79851C19.0258 9.84027 17.3706 11.4955 15.3289 11.4955Z"
									fill="#323544" />
								<path
									d="M14.7723 13.1891C15.0227 13.437 15.2464 13.6945 15.4463 13.9566C16.7954 13.9826 17.7641 14.3143 18.4675 14.7651C19.2032 15.2366 19.6941 15.8677 20.0242 16.5168C20.3563 17.1698 20.5204 17.8318 20.6002 18.337C20.6398 18.5878 20.6579 18.795 20.6661 18.9365C20.6702 19.0071 20.6717 19.061 20.6724 19.0952L20.6726 19.1161L20.6727 19.1313L20.6727 19.1363L21.4197 19.1486C20.6793 19.1358 20.6728 19.136 20.6727 19.1363L20.6727 19.1376C20.6666 19.5509 20.9961 19.8914 21.4096 19.8985C21.8237 19.9057 22.1653 19.5758 22.1725 19.1617L21.4284 19.1488C22.1725 19.1617 22.1725 19.1621 22.1725 19.1617L22.1725 19.1599L22.1726 19.1575L22.1726 19.1511L22.1727 19.1319C22.1727 19.1163 22.1726 19.0951 22.1721 19.0686C22.1712 19.0158 22.1689 18.9419 22.1636 18.85C22.153 18.6665 22.1303 18.4094 22.0819 18.1029C21.9856 17.4936 21.7848 16.6697 21.3612 15.8368C20.9357 15 20.2801 14.1451 19.2768 13.5022C18.2708 12.8574 16.9604 12.4549 15.274 12.4549C14.8284 12.4549 14.4092 12.483 14.0148 12.5362C14.2852 12.7384 14.5376 12.9566 14.7723 13.1891Z"
									fill="#323544" />
								<path fill-rule="evenodd" clip-rule="evenodd"
									d="M5.13173 7.79855C5.13173 5.75678 6.7869 4.1016 8.82867 4.1016C10.8704 4.1016 12.5256 5.75678 12.5256 7.79855C12.5256 9.84031 10.8704 11.4955 8.82867 11.4955C6.7869 11.4955 5.13173 9.84031 5.13173 7.79855ZM8.82867 5.6016C7.61533 5.6016 6.63173 6.58521 6.63173 7.79855C6.63173 9.01189 7.61533 9.99549 8.82867 9.99549C10.042 9.99549 11.0256 9.01189 11.0256 7.79855C11.0256 6.58521 10.042 5.6016 8.82867 5.6016Z"
									fill="#323544" />
								<path
									d="M3.37502 19.1374C3.38126 19.5507 3.0517 19.8914 2.63812 19.8986C2.22397 19.9058 1.88241 19.5759 1.87522 19.1617L2.62511 19.1487C1.87522 19.1617 1.87523 19.1621 1.87522 19.1617L1.87519 19.1599L1.87516 19.1575L1.87509 19.1511L1.875 19.1319C1.87499 19.1163 1.87512 19.0951 1.87559 19.0687C1.87653 19.0158 1.87882 18.942 1.88413 18.85C1.89474 18.6665 1.91745 18.4094 1.96585 18.103C2.0621 17.4936 2.26292 16.6697 2.68648 15.8368C3.11206 15 3.76758 14.1452 4.77087 13.5022C5.77688 12.8575 7.08727 12.455 8.77376 12.455C10.4602 12.455 11.7706 12.8575 12.7767 13.5022C13.7799 14.1452 14.4355 15 14.861 15.8368C15.2846 16.6697 15.4854 17.4936 15.5817 18.103C15.6301 18.4094 15.6528 18.6665 15.6634 18.85C15.6687 18.942 15.671 19.0158 15.6719 19.0687C15.6724 19.0951 15.6725 19.1163 15.6725 19.1319L15.6724 19.1511L15.6724 19.1575L15.6723 19.1599C15.6723 19.1603 15.6723 19.1617 14.9282 19.1488L15.6723 19.1617C15.6651 19.5759 15.3235 19.9058 14.9094 19.8986C14.4959 19.8914 14.1664 19.5509 14.1725 19.1376L14.1725 19.1364C14.1726 19.1361 14.1791 19.1358 14.9199 19.1487L14.1725 19.1364L14.1725 19.1314L14.1724 19.1161L14.1722 19.0952C14.1716 19.061 14.17 19.0072 14.1659 18.9366C14.1577 18.7951 14.1396 18.5878 14.1 18.337C14.0202 17.8319 13.8561 17.1699 13.524 16.5168C13.1939 15.8677 12.703 15.2366 11.9673 14.7651C11.2343 14.2954 10.2132 13.955 8.77376 13.955C7.33434 13.955 6.31319 14.2954 5.58022 14.7651C4.84453 15.2366 4.35363 15.8677 4.02351 16.5168C3.6914 17.1699 3.52727 17.8319 3.44749 18.337C3.40787 18.5878 3.38981 18.7951 3.38163 18.9366C3.37756 19.0072 3.37596 19.061 3.37536 19.0952C3.37505 19.1123 3.375 19.1245 3.375 19.1314L3.37502 19.1374Z"
									fill="#323544" />
							</svg>
						</div>
						<?php }else{?>
						<img class="size-14 rounded-full object-cover"
							src="<?=ASSET_PATH."/images/lecturer/".$c['slika_predavaca'] ?>" alt="avatar" />
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
									<input type="hidden" name="oldImage" value="<?=$c["slika_predavaca"]?>">
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
											<label for="firstName" class="w-fit pl-0.5 text-sm">First Name</label>
											<input required id="firstName" type="text" value="<?=$c['ime']?>"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="firstName" placeholder="First Name" />
										</div>
										<div class="flex w-full flex-col gap-1 text-neutral-600 ">
											<label for="lastName" class="w-fit pl-0.5 text-sm">Last Name</label>
											<input required id="lastName" type="text" value="<?=$c['prezime']?>"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="lastName" placeholder="Last Name" />
										</div>

									</div>

									<!-- Dialog Footer -->
									<div
										class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
										<button type="submit"
											class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
											Update Lecturer</button>
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
										Delete <?=$c['ime']?> <?=$c['prezime']?></h3>
									<p class="text-md">Are you sure you want to delete this lecturer?</p>
								</div>
								<!-- Dialog Footer -->
								<div class="flex items-center justify-center border-neutral-300 p-4">
									<form action="" method="post">
										<input type="hidden" name="oldImage" value="<?=$c["slika_predavaca"]?>">
										<input type="hidden" name="deleteLecturerId" value="<?=$index?>">
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
if (empty($_GET['keyword'])){?>
<div class="flex justify-between mt-4 px-2">
	<p class="text-sm md:text-lg font-normal">
		Showing
		<span class="font-bold">
			<?= min(($dataArray['currentPage'] - 1) * $dataArray['perPage'] + count($dataArray['data']), $dataArray['total']) ?>
		</span>
		of <span class="font-bold"><?= $dataArray['total'] ?></span> entries
	</p>
	<nav aria-label="pagination">
		<ul class="flex flex-shrink-0 items-center gap-2 text-sm md:text-md font-normal">
			<!-- Previous Page -->
			<li>
				<?php if ($dataArray['currentPage'] > 1): ?>
				<a href="?page=<?= $dataArray['currentPage'] - 1 ?>"
					class="flex items-center justify-center rounded-md p-1 text-white hover:bg-blue-600 bg-primary"
					aria-label="previous page">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
						class="size-6">
						<path fill-rule="evenodd"
							d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
							clip-rule="evenodd" />
					</svg>
					Previous
				</a>
				<?php else: ?>
				<span class="flex items-center rounded-md p-1 text-neutral-400">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
						class="size-6">
						<path fill-rule="evenodd"
							d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
							clip-rule="evenodd" />
					</svg>
					Previous
				</span>
				<?php endif; ?>
			</li>
			<!-- Current Page -->
			<li class="font-semibold text-lg mx-2"><?= $dataArray['currentPage'] ?></li>
			<!-- Next Page -->
			<li>
				<?php if ($dataArray['currentPage'] < ceil($dataArray['total'] / $dataArray['perPage'])): ?>
				<a href="?page=<?= $dataArray['currentPage'] + 1 ?>"
					class="flex items-center justify-center rounded-md p-1 pr-2 text-white hover:bg-blue-600 bg-primary"
					aria-label="next page">
					Next
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
						class="size-6">
						<path fill-rule="evenodd"
							d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
							clip-rule="evenodd" />
					</svg>
				</a>
				<?php else: ?>
				<span class="flex items-center rounded-md p-1 text-neutral-400 ">
					Next
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
						class="size-6">
						<path fill-rule="evenodd"
							d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
							clip-rule="evenodd" />
					</svg>
				</span>
				<?php endif; ?>
			</li>
		</ul>
	</nav>
</div>
<?php } ?>
<?php }?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../partials/admin_layout.php';
?>