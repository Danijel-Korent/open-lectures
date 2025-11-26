<?php
//Import constants file
require_once dirname(__DIR__,2).'/config.php';
session_start();
if (empty($_SESSION['logged'])){
	header('Location: '.baseUrl('/admin/login'),true);
	exit;
}
$title = 'Course';
require_once REPO_PATH;

$lecturers = [];
foreach (selectAllLecturers() as $d){
	$data = [
		'label' => $d['firstName'].' '.$d['lastName'],
        'value' => $d['id']
    ];
    array_push($lecturers, $data);
};
$universities = [];
foreach(selectAllUniversity() as $d){
	$data = [
		'label'=> $d['name'],
		'value'=> $d['id']
	];
	array_push($universities, $data);
}
$categories = [];
foreach (selectAllCategories() as $category) {
	$data = [
		'label' => $category['name'],
        'value' => $category['id']
    ];
    array_push($categories, $data);
}
//FETCHING DATA
$courseArray = [];
if(isset($_GET['keyword'])&& !empty($_GET['keyword'])){
//SEARCH Fn
$search = $_GET['keyword'];
$d = searchCourse($search);
$courseArray['data'] = $d;
$courseArray['total'] = count($d);
$courseArray['currentPage'] = 1;
$courseArray['perPage'] = 10;
$courseArray['totalPages'] = ceil($courseArray['total'] / $courseArray['perPage']);
$title = 'Search Result for '.$search;
}else{
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$courseArray = selectPaginatedCourse($page,10);
}
//Get University list
$university_list = selectUstanove();
$list =[];
//Loop through the array and calculate the total length of all courses
foreach ($courseArray['data'] as $course)
{
  $course_totalLength  = $course['t_duration'];
  $university_index  = $course['ustanova'] - 1;
  $course_university = $university_list[$university_index]['name'];
  $data=[
	'id' => $course['id'],
	'name' => $course['name'],
	'language' => $course['language'],
	'year' => $course['year'],
	'n_lectures' => $course['n_lectures'],
	't_duration' => $course['t_duration'],
	'course_code' => $course['course_code'],
	'description' => $course['description'],
	'link_1' => $course['link_1'],
	'link_2' => $course['link_2'],
	'image' => $course['image'],
	'universityId' => $course['universityId'],
	'categoryId' => $course['categoryId'],
	'lecturerId' => $course['lecturerId'],
	'u_name' => $course['u_name'],
	'firstName' => $course['firstName'],
	'lastName' => $course['lastName'],
	'kategorije' => $course['kategorije'],
	'ustanova' => $course['ustanova'],
	'course_name' => $course['name'],
	'course_description' => $course['description'],
	'course_totalLength' => $course['t_duration'],
	'category_index' => $course['categoryId'],
	'course_linkPlaylist' => $course['link_1'],
	'course_image' => $course['image'],
	'course_university' =>$course_university,
	'university_index' => $university_index 
  ];
  
	array_push($list, $data);
}

//ADD COURSE
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createCourse'])) {
try{
		$res =insertCourse(
			trim($_POST['name']),
			$_POST['category'],
			$_POST['lecturer'],
			$_POST['university'],
			$_POST['year'],
			$_POST['language'],
			$_POST['lectures'],
			$_POST['duration'],
			trim($_POST['description']),
			$_POST['vidLink'],
			$_POST['link'],
			$_POST['imgLink'],
			$_POST['code']
		);
		if($res){
			header('Location: '.baseUrl('/admin/courses'),true);
			exit;
		}else{
		throw new Exception('Error updating category in the database.');
		}
 } catch (Exception $e) {
        echo '<script>alert("' . $e->getMessage() . '");</script>';
    }

}

//UPDATE COURSE
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCourse'])){
	try {
		echo "called";
	$uniLecId=$_POST['universityLecturerId'];
	$id = $_POST['updateCourse'];
	$res = updateCourse(
		$id,
		$uniLecId,
		trim($_POST['name']),
		$_POST['category'],
		$_POST['lecturer'],
		$_POST['university'],
		$_POST['year'],
		$_POST['language'],
		$_POST['lectures'],
		$_POST['duration'],
		trim($_POST['description']),
		$_POST['vidLink'],
		$_POST['link'],
		$_POST['imgLink'],
		$_POST['code']
	);
	if($res){
		header('Location: '.baseUrl('/admin/courses'),true);
		exit;
	}else{
		throw new Exception('Error updating category in the database.');
	}
	} catch (Exception $e) {
        echo '<script>alert("' . $e->getMessage() . '");</script>';
    }
	
}

//DELETE COURSE
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCourse'])){
	try {
		$id = $_POST['deleteCourse'];
		$res = deleteCourse($id);
		if($res){
			header('Location: '.baseUrl('/admin/courses'),true);
			exit;
		}else{
			throw new Exception('Error updating category in the database.');
		}
	} catch (Exception $e) {
		echo '<script>alert("' . $e->getMessage() . '");</script>';
	}
}

ob_start();
?>
<div x-data="{modalIsOpen: false}">
	<div class="flex w-full justify-between items-start mb-5 gap-2">
		<h2 class="text-2xl font-semibold">Courses</h2>
		<button @click="modalIsOpen = true" type="button"
			class="cursor-pointer h-10 inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
			<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
				class="size-5 fill-neutral-100" fill="currentColor">
				<path fill-rule="evenodd"
					d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
					clip-rule="evenodd" />
			</svg>
			Add Course
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
			class="flex md:w-[50%] w-[90%] flex-col gap-4 overflow-hidden rounded-md border border-neutral-300 bg-white text-neutral-600">
			<!-- Dialog Header -->
			<div class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4">
				<h3 id="defaultModalTitle" class="font-semibold tracking-wide text-neutral-900">Add New Course</h3>
				<button @click="modalIsOpen = false" aria-label="close modal">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor"
						fill="none" stroke-width="1.4" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
			<!-- Dialog Body -->
			<form action="" method="post" enctype="multipart/form-data"
				class="overflow-y-auto max-h-[80vh] md:max-h-[100vh]">
				<input type="hidden" name="createCourse" value="1">
				<div class="px-4 pb-4">
					<!-- Name -->
					<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
						<label for="textInputDefault" class="w-fit pl-0.5 text-sm">Course Name*</label>
						<input required id="textInputDefault" type="text"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="name" placeholder="Course Name" />
					</div>

					<!-- Select Category -->
					<div x-data="{
							catOptions: <?= str_replace('"', "'", json_encode($categories)) ?>,
							catTemp: [],
							isCatOpen: false,
							openedWithKeyboard: false,
							selectedCat: null,
							setSelectedOption(option) {
								this.selectedCat = option;
								this.isCatOpen = false;
								this.openedWithKeyboard = false;
								this.$refs.hiddenTextField.value = option.value;
							},
							getFilteredOptions(query) {
								this.catTemp = this.catOptions.filter((option) =>
									option.label.toLowerCase().includes(query.toLowerCase())
								);
								if (this.catTemp.length === 0) {
									this.$refs.noResultsMessage.classList.remove('hidden');
								} else {
									this.$refs.noResultsMessage.classList.add('hidden');
								}
							},
							handleKeydownOnOptions(event) {
								if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
									this.$refs.searchField.focus();
								}
							},
						}" x-on:keydown="handleKeydownOnOptions($event)"
						x-on:keydown.esc.window="isCatOpen = false, openedWithKeyboard = false"
						x-init="catTemp = catOptions" class="flex w-full flex-col gap-1 mb-2">

						<label for="category" class="w-fit pl-0.5 text-sm text-neutral-600">Category*</label>
						<div class="relative">

							<!-- trigger button  -->
							<button type="button"
								class="inline-flex w-full items-center justify-between gap-2 border border-neutral-300 rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
								role="combobox" aria-controls="makesList" aria-haspopup="listbox"
								x-on:click="isCatOpen = ! isCatOpen"
								x-on:keydown.down.prevent="openedWithKeyboard = true"
								x-on:keydown.enter.prevent="openedWithKeyboard = true"
								x-on:keydown.space.prevent="openedWithKeyboard = true"
								x-bind:aria-expanded="isCatOpen || openedWithKeyboard"
								x-bind:aria-label="selectedCat ? selectedCat.label : 'Select category'">
								<span class="text-sm font-normal"
									x-text="selectedCat ? selectedCat.label : 'Select category'"></span>
								<!-- Chevron  -->
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
									class="size-5" aria-hidden="true">
									<path fill-rule="evenodd"
										d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
										clip-rule="evenodd" />
								</svg>
							</button>

							<!-- Hidden Input To Grab The Selected Value  -->
							<input id="category" required name="category" x-ref="hiddenTextField" hidden="" />
							<div x-show="isCatOpen || openedWithKeyboard" id="makesList"
								class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-neutral-300 bg-neutral-50"
								role="listbox" aria-label="industries list"
								x-on:click.outside="isCatOpen = false, openedWithKeyboard = false"
								x-on:keydown.down.prevent="$focus.wrap().next()"
								x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition
								x-trap="openedWithKeyboard">

								<!-- Search  -->
								<div class="relative">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"
										fill="none" stroke-width="1.5"
										class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50"
										aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
									</svg>
									<input type="text"
										class="w-full border-b borderneutral-300 bg-neutral-50 py-2.5 pl-11 pr-4 text-sm text-neutral-600 focus:outline-none focus-visible:border-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
										name="searchField" aria-label="Search"
										x-on:input="getFilteredOptions($el.value)" x-ref="searchField"
										placeholder="Search" />
								</div>

								<!-- Options  -->
								<ul class="flex max-h-44 flex-col overflow-y-auto z-10">
									<li class="hidden px-4 py-2 text-sm text-neutral-600" x-ref="noResultsMessage">
										<span>No matches found</span>
									</li>
									<template x-for="(item, index) in catTemp" x-bind:key="item.value">
										<li class="combobox-option inline-flex cursor-pointer justify-between gap-6 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/5 focus-visible:text-neutral-900 focus-visible:outline-none"
											role="option" x-on:click="setSelectedOption(item)"
											x-on:keydown.enter="setSelectedOption(item)" x-bind:id="'option-' + index"
											tabindex="0">
											<!-- Label  -->
											<span x-bind:class="selectedCat == item ? 'font-bold' : null"
												x-text="item.label"></span>
											<!-- Screen reader 'selected' indicator  -->
											<span class="sr-only"
												x-text="selectedCat == item ? 'selected' : null"></span>
											<!-- Checkmark  -->
											<svg x-cloak x-show="selectedCat == item" xmlns="http://www.w3.org/2000/svg"
												viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2"
												class="size-4" aria-hidden="true">
												<path stroke-linecap="round" stroke-linejoin="round"
													d="m4.5 12.75 6 6 9-13.5">
											</svg>
										</li>
									</template>
								</ul>
							</div>
						</div>
					</div>

					<!-- Select Lecturer -->
					<div x-data="{
							catOptions: <?= str_replace('"', "'", subject: json_encode($lecturers)) ?>,
							catTemp: [],
							isCatOpen: false,
							openedWithKeyboard: false,
							selectedCat: null,
							setSelectedOption(option) {
								this.selectedCat = option;
								this.isCatOpen = false;
								this.openedWithKeyboard = false;
								this.$refs.hiddenTextField.value = option.value;
							},
							getFilteredOptions(query) {
								this.catTemp = this.catOptions.filter((option) =>
									option.label.toLowerCase().includes(query.toLowerCase())
								);
								if (this.catTemp.length === 0) {
									this.$refs.noResultsMessage.classList.remove('hidden');
								} else {
									this.$refs.noResultsMessage.classList.add('hidden');
								}
							},
							handleKeydownOnOptions(event) {
								if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
									this.$refs.searchField.focus();
								}
							},
						}" x-on:keydown="handleKeydownOnOptions($event)"
						x-on:keydown.esc.window="isCatOpen = false, openedWithKeyboard = false"
						x-init="catTemp = catOptions" class="flex w-full flex-col gap-1 mb-2">

						<label for="lecturer" class="w-fit pl-0.5 text-sm text-neutral-600">Lecturer*</label>
						<div class="relative">

							<!-- trigger button  -->
							<button type="button"
								class="inline-flex w-full items-center justify-between gap-2 border border-neutral-300 rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
								role="combobox" aria-controls="makesList" aria-haspopup="listbox"
								x-on:click="isCatOpen = ! isCatOpen"
								x-on:keydown.down.prevent="openedWithKeyboard = true"
								x-on:keydown.enter.prevent="openedWithKeyboard = true"
								x-on:keydown.space.prevent="openedWithKeyboard = true"
								x-bind:aria-expanded="isCatOpen || openedWithKeyboard"
								x-bind:aria-label="selectedCat ? selectedCat.label : 'Select lecturer'">
								<span class="text-sm font-normal"
									x-text="selectedCat ? selectedCat.label : 'Select lecturer'"></span>
								<!-- Chevron  -->
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
									class="size-5" aria-hidden="true">
									<path fill-rule="evenodd"
										d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
										clip-rule="evenodd" />
								</svg>
							</button>

							<!-- Hidden Input To Grab The Selected Value  -->
							<input id="lecturer" required name="lecturer" x-ref="hiddenTextField" hidden="" />
							<div x-show="isCatOpen || openedWithKeyboard" id="makesList"
								class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-neutral-300 bg-neutral-50"
								role="listbox" aria-label="industries list"
								x-on:click.outside="isCatOpen = false, openedWithKeyboard = false"
								x-on:keydown.down.prevent="$focus.wrap().next()"
								x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition
								x-trap="openedWithKeyboard">

								<!-- Search  -->
								<div class="relative">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"
										fill="none" stroke-width="1.5"
										class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50"
										aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
									</svg>
									<input type="text"
										class="w-full border-b borderneutral-300 bg-neutral-50 py-2.5 pl-11 pr-4 text-sm text-neutral-600 focus:outline-none focus-visible:border-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
										name="searchField" aria-label="Search"
										x-on:input="getFilteredOptions($el.value)" x-ref="searchField"
										placeholder="Search" />
								</div>

								<!-- Options  -->
								<ul class="flex max-h-44 flex-col overflow-y-auto z-10">
									<li class="hidden px-4 py-2 text-sm text-neutral-600" x-ref="noResultsMessage">
										<span>No matches found</span>
									</li>
									<template x-for="(item, index) in catTemp" x-bind:key="item.value">
										<li class="combobox-option inline-flex cursor-pointer justify-between gap-6 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/5 focus-visible:text-neutral-900 focus-visible:outline-none"
											role="option" x-on:click="setSelectedOption(item)"
											x-on:keydown.enter="setSelectedOption(item)" x-bind:id="'option-' + index"
											tabindex="0">
											<!-- Label  -->
											<span x-bind:class="selectedCat == item ? 'font-bold' : null"
												x-text="item.label"></span>
											<!-- Screen reader 'selected' indicator  -->
											<span class="sr-only"
												x-text="selectedCat == item ? 'selected' : null"></span>
											<!-- Checkmark  -->
											<svg x-cloak x-show="selectedCat == item" xmlns="http://www.w3.org/2000/svg"
												viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2"
												class="size-4" aria-hidden="true">
												<path stroke-linecap="round" stroke-linejoin="round"
													d="m4.5 12.75 6 6 9-13.5">
											</svg>
										</li>
									</template>
								</ul>
							</div>
						</div>
					</div>

					<!-- Select University -->
					<div x-data="{
							catOptions: <?= str_replace('"', "'", subject: json_encode($universities)) ?>,
							catTemp: [],
							isCatOpen: false,
							openedWithKeyboard: false,
							selectedCat: null,
							setSelectedOption(option) {
								this.selectedCat = option;
								this.isCatOpen = false;
								this.openedWithKeyboard = false;
								this.$refs.hiddenTextField.value = option.value;
							},
							getFilteredOptions(query) {
								this.catTemp = this.catOptions.filter((option) =>
									option.label.toLowerCase().includes(query.toLowerCase())
								);
								if (this.catTemp.length === 0) {
									this.$refs.noResultsMessage.classList.remove('hidden');
								} else {
									this.$refs.noResultsMessage.classList.add('hidden');
								}
							},
							handleKeydownOnOptions(event) {
								if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
									this.$refs.searchField.focus();
								}
							},
						}" x-on:keydown="handleKeydownOnOptions($event)"
						x-on:keydown.esc.window="isCatOpen = false, openedWithKeyboard = false"
						x-init="catTemp = catOptions" class="flex w-full flex-col gap-1 mb-2">

						<label for="university" class="w-fit pl-0.5 text-sm text-neutral-600">University*</label>
						<div class="relative">

							<!-- trigger button  -->
							<button type="button"
								class="inline-flex w-full items-center justify-between gap-2 border border-neutral-300 rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
								role="combobox" aria-controls="makesList" aria-haspopup="listbox"
								x-on:click="isCatOpen = ! isCatOpen"
								x-on:keydown.down.prevent="openedWithKeyboard = true"
								x-on:keydown.enter.prevent="openedWithKeyboard = true"
								x-on:keydown.space.prevent="openedWithKeyboard = true"
								x-bind:aria-expanded="isCatOpen || openedWithKeyboard"
								x-bind:aria-label="selectedCat ? selectedCat.label : 'Select university'">
								<span class="text-sm font-normal"
									x-text="selectedCat ? selectedCat.label : 'Select university'"></span>
								<!-- Chevron  -->
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
									class="size-5" aria-hidden="true">
									<path fill-rule="evenodd"
										d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
										clip-rule="evenodd" />
								</svg>
							</button>

							<!-- Hidden Input To Grab The Selected Value  -->
							<input id="university" required name="university" x-ref="hiddenTextField" hidden="" />
							<div x-show="isCatOpen || openedWithKeyboard" id="makesList"
								class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-neutral-300 bg-neutral-50"
								role="listbox" aria-label="industries list"
								x-on:click.outside="isCatOpen = false, openedWithKeyboard = false"
								x-on:keydown.down.prevent="$focus.wrap().next()"
								x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition
								x-trap="openedWithKeyboard">

								<!-- Search  -->
								<div class="relative">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"
										fill="none" stroke-width="1.5"
										class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50"
										aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
									</svg>
									<input type="text"
										class="w-full border-b borderneutral-300 bg-neutral-50 py-2.5 pl-11 pr-4 text-sm text-neutral-600 focus:outline-none focus-visible:border-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
										name="searchField" aria-label="Search"
										x-on:input="getFilteredOptions($el.value)" x-ref="searchField"
										placeholder="Search" />
								</div>

								<!-- Options  -->
								<ul class="flex  max-h-44 flex-col overflow-y-auto z-10">
									<li class="hidden px-4 py-2 text-sm text-neutral-600" x-ref="noResultsMessage">
										<span>No matches found</span>
									</li>
									<template x-for="(item, index) in catTemp" x-bind:key="item.value">
										<li class="combobox-option inline-flex cursor-pointer justify-between gap-6 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/5 focus-visible:text-neutral-900 focus-visible:outline-none"
											role="option" x-on:click="setSelectedOption(item)"
											x-on:keydown.enter="setSelectedOption(item)" x-bind:id="'option-' + index"
											tabindex="0">
											<!-- Label  -->
											<span x-bind:class="selectedCat == item ? 'font-bold' : null"
												x-text="item.label"></span>
											<!-- Screen reader 'selected' indicator  -->
											<span class="sr-only"
												x-text="selectedCat == item ? 'selected' : null"></span>
											<!-- Checkmark  -->
											<svg x-cloak x-show="selectedCat == item" xmlns="http://www.w3.org/2000/svg"
												viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2"
												class="size-4" aria-hidden="true">
												<path stroke-linecap="round" stroke-linejoin="round"
													d="m4.5 12.75 6 6 9-13.5">
											</svg>
										</li>
									</template>
								</ul>
							</div>
						</div>
					</div>
					<!-- Description -->
					<div class="flex w-full mb-2 flex-col gap-1 text-neutral-600">
						<label for="textArea" class="w-fit pl-0.5 text-sm">Description*</label>
						<textarea required id="description" name="description"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2.5 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
							rows="3" placeholder="What is this course about..."></textarea>
					</div>
					<div class="flex items-center gap-2 mb-2">
						<!-- Language -->
						<div class="flex w-full flex-col gap-1 text-neutral-600 ">
							<label for="code" class="w-fit pl-0.5 text-sm">Language*</label>
							<input required id="language" type="text"
								class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
								name="language" placeholder="Course Language" />
						</div>
						<!-- Year -->
						<div class="flex w-full flex-col gap-1 text-neutral-600">
							<label for="year" class="w-fit pl-0.5 text-sm">Year*</label>
							<input required id="year" type="text"
								class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
								name="year" placeholder="Year" />
						</div>
						<!-- No. of lectures -->
						<div class="flex w-full flex-col gap-1 text-neutral-600">
							<label for="lectures" class="w-fit pl-0.5 text-sm">No. of lectures</label>
							<input id="lectures" type="number"
								class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
								name="lectures" placeholder="No. of lectures" />
						</div>
					</div>
					<div class="items-center flex gap-2 mb-2">
						<!-- Course Code -->
						<div class="flex w-full flex-col gap-1 text-neutral-600">
							<label for="code" class="w-fit pl-0.5 text-sm">Course Code*</label>
							<input required id="code" type="text"
								class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
								name="code" placeholder="Course Code" />
						</div>
						<!-- Course Duration -->
						<div class="flex w-full flex-col gap-1 text-neutral-600">
							<label for="textInputDefault" class="w-fit pl-0.5 text-sm">Duration*</label>
							<input required id="duration" type="number" min="0"
								class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
								name="duration" placeholder="Course Duration" />
						</div>
					</div>
					<!-- Video Link -->
					<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
						<label for="vidLink" class="w-fit pl-0.5 text-sm">Video URL*</label>
						<input required id="vidLink" type="url"
							class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
							name="vidLink" placeholder="Video URL" />
					</div>
					<div class="flex items-center gap-2 mb-2">
						<!-- Image Link -->
						<div class="flex w-full flex-col gap-1 text-neutral-600">
							<label for="imgLink" class="w-fit pl-0.5 text-sm">Image URL*</label>
							<input required id="imgLink" type="url"
								class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
								name="imgLink" placeholder="Image URL" />
						</div>
						<!-- Link 2 -->
						<div class="flex w-full flex-col gap-1 text-neutral-600">
							<label for="link" class="w-fit pl-0.5 text-sm">Link</label>
							<input id="link" type="url"
								class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
								name="link" placeholder="Link" />
						</div>
					</div>


				</div>
				<!-- Dialog Footer -->
				<div
					class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
					<button type="submit"
						class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
						Add Course</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Table -->
<div class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300 ">
	<?php if (empty($list)) { ?>
	<div class="p-10 w-full text-center">
		<td class="p-4 font-bold text-[2rem]" colspan="3">No courses found</td>
	</div>
	<?php }else{ ?>
	<table class="w-full text-left text-sm text-neutral-600">
		<thead class="border-b border-neutral-300 bg-neutral-50 text-sm text-neutral-900">
			<tr>
				<th scope="col" class="p-4">Name</th>
				<th scope="col" class="p-4">University</th>
				<th scope="col" class="p-4">Action</th>
			</tr>
		</thead>
		<tbody class="divide-y divide-neutral-300">
			<?php foreach ($list as $index => $course) { ?>
			<tr>
				<td class="p-4">
					<div class="flex items-center gap-3">
						<img class="size-12 md:size-20 rounded-md object-cover" src="<?=$course['course_image']?>"
							alt="user avatar" />
						<div class="flex flex-col">
							<span class="text-neutral-900 text-sm md:text-lg font-semibold">
								<?=$course['course_name']?>
							</span>
							<span class="flex gap-1 items-center text-neutral-900 ext-sm md:text-lg font-normal">
								<svg class="size-5 shrink-0" aria-hidden="true" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd"
										d="M7.33301 5.5C7.33301 4.25736 8.34037 3.25 9.58301 3.25H11.1663C12.3908 3.25 13.3868 4.22809 13.4157 5.44559C13.6431 5.27137 13.9077 5.13795 14.2016 5.0592L16.4554 4.45529C17.6557 4.13367 18.8894 4.84598 19.2111 6.04628L21.9287 16.1885C22.2503 17.3888 21.538 18.6226 20.3377 18.9442L18.0838 19.5481C16.8835 19.8697 15.6498 19.1574 15.3282 17.9571L13.4163 10.8221V17.25C13.4163 18.4926 12.409 19.5 11.1663 19.5H9.58301C9.00682 19.5 8.48122 19.2834 8.08317 18.9272C7.68512 19.2834 7.15952 19.5 6.58333 19.5H4.25C3.00736 19.5 2 18.4926 2 17.25V7.75C2 6.50736 3.00736 5.5 4.25 5.5H6.58333C6.84619 5.5 7.09852 5.54507 7.33301 5.62791V5.5ZM7.33301 17.25V7.72768C7.3212 7.32379 6.99008 7 6.58333 7H4.25C3.83579 7 3.5 7.33579 3.5 7.75V17.25C3.5 17.6642 3.83579 18 4.25 18H6.58333C6.99108 18 7.32283 17.6746 7.33309 17.2693L7.33301 17.25ZM9.58301 18C9.17526 18 8.84351 17.6746 8.83325 17.2693L8.83333 17.25V7.75C8.83333 7.73708 8.83322 7.72419 8.83301 7.71133V5.5C8.83301 5.08579 9.16879 4.75 9.58301 4.75H11.1663C11.5806 4.75 11.9163 5.08579 11.9163 5.5V17.25C11.9163 17.6642 11.5806 18 11.1663 18H9.58301ZM14.0595 7.42665C13.9522 7.02655 14.1897 6.6153 14.5898 6.50809L16.8436 5.90418C17.2437 5.79697 17.655 6.03441 17.7622 6.43451L20.4798 16.5767C20.587 16.9768 20.3495 17.3881 19.9494 17.4953L17.6956 18.0992C17.2955 18.2064 16.8843 17.969 16.7771 17.5689L14.0595 7.42665Z"
										fill="#323544" />
								</svg>
								<?=$course['kategorije']?></span>
							<span class="hidden md:block text-neutral-600 text-xs md:text-sm font-normal">
								<span>Course Length: </span><?=$course['course_totalLength']?> h
							</span>
						</div>
					</div>
				</td>

				<td class="p-4">
					<div class="flex flex-col gap-1">
						<span class="flex gap-1 items-center text-neutral-900 ext-sm md:text-lg font-normal">
							<svg class="size-5 shrink-0" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor"
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
							<?=$course['course_university']?></span>
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
										Update Course</h3>
									<button @click="updateModal<?=$index?> = false" aria-label="close modal">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
											stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M6 18L18 6M6 6l12 12" />
										</svg>
									</button>
								</div>
								<!-- Dialog Body -->
								<form action="" method="post" enctype="multipart/form-data"
									class="overflow-y-auto max-h-[80vh] md:max-h-[100vh]">
									<input type="hidden" name="updateCourse" value="<?=$course['id']?>">

									<div class="px-4 pb-4">
										<!-- Name -->
										<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
											<label for="textInputDefault" class="w-fit pl-0.5 text-sm">Course
												Name*</label>
											<input required id="textInputDefault" type="text"
												value="<?=$course['course_name']?>"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="name" placeholder="Course Name" />
										</div>

										<!-- Select Category -->
										<div x-data="{
							catOptions: <?= str_replace('"', "'", json_encode($categories)) ?>,
							catTemp: [],
							isCatOpen: false,
							openedWithKeyboard: false,
							selectedCat: <?=str_replace('"', "'",json_encode(
								[
									'value' => $course['categoryId'],
									'label' => $course['kategorije']
								]
							))?>,
							setSelectedOption(option) {
								this.selectedCat = option;
								this.isCatOpen = false;
								this.openedWithKeyboard = false;
								this.$refs.hiddenTextField.value = option.value;
							},
							getFilteredOptions(query) {
								this.catTemp = this.catOptions.filter((option) =>
									option.label.toLowerCase().includes(query.toLowerCase())
								);
								if (this.catTemp.length === 0) {
									this.$refs.noResultsMessage.classList.remove('hidden');
								} else {
									this.$refs.noResultsMessage.classList.add('hidden');
								}
							},
							handleKeydownOnOptions(event) {
								if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
									this.$refs.searchField.focus();
								}
							},
						}" x-on:keydown="handleKeydownOnOptions($event)"
											x-on:keydown.esc.window="isCatOpen = false, openedWithKeyboard = false"
											x-init="catTemp = catOptions" class="flex w-full flex-col gap-1 mb-2">

											<label for="category"
												class="w-fit pl-0.5 text-sm text-neutral-600">Category*</label>
											<div class="relative">

												<!-- trigger button  -->
												<button type="button"
													class="inline-flex w-full items-center justify-between gap-2 border border-neutral-300 rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
													role="combobox" aria-controls="makesList" aria-haspopup="listbox"
													x-on:click="isCatOpen = ! isCatOpen"
													x-on:keydown.down.prevent="openedWithKeyboard = true"
													x-on:keydown.enter.prevent="openedWithKeyboard = true"
													x-on:keydown.space.prevent="openedWithKeyboard = true"
													x-bind:aria-expanded="isCatOpen || openedWithKeyboard"
													x-bind:aria-label="selectedCat ? selectedCat.label : 'Select category'">
													<span class="text-sm font-normal"
														x-text="selectedCat ? selectedCat.label : 'Select category'"></span>
													<!-- Chevron  -->
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
														fill="currentColor" class="size-5" aria-hidden="true">
														<path fill-rule="evenodd"
															d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
															clip-rule="evenodd" />
													</svg>
												</button>

												<!-- Hidden Input To Grab The Selected Value  -->
												<input value="<?=$course['categoryId']?>" id="category" required
													name="category" x-ref="hiddenTextField" hidden="" />
												<div x-show="isCatOpen || openedWithKeyboard" id="makesList"
													class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-neutral-300 bg-neutral-50"
													role="listbox" aria-label="industries list"
													x-on:click.outside="isCatOpen = false, openedWithKeyboard = false"
													x-on:keydown.down.prevent="$focus.wrap().next()"
													x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition
													x-trap="openedWithKeyboard">

													<!-- Search  -->
													<div class="relative">
														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
															stroke="currentColor" fill="none" stroke-width="1.5"
															class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50"
															aria-hidden="true">
															<path stroke-linecap="round" stroke-linejoin="round"
																d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
														</svg>
														<input type="text"
															class="w-full border-b borderneutral-300 bg-neutral-50 py-2.5 pl-11 pr-4 text-sm text-neutral-600 focus:outline-none focus-visible:border-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
															name="searchField" aria-label="Search"
															x-on:input="getFilteredOptions($el.value)"
															x-ref="searchField" placeholder="Search" />
													</div>

													<!-- Options  -->
													<ul class="flex max-h-44 flex-col overflow-y-auto z-10">
														<li class="hidden px-4 py-2 text-sm text-neutral-600"
															x-ref="noResultsMessage">
															<span>No matches found</span>
														</li>
														<template x-for="(item, index) in catTemp"
															x-bind:key="item.value">
															<li class="combobox-option inline-flex cursor-pointer justify-between gap-6 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/5 focus-visible:text-neutral-900 focus-visible:outline-none"
																role="option" x-on:click="setSelectedOption(item)"
																x-on:keydown.enter="setSelectedOption(item)"
																x-bind:id="'option-' + index" tabindex="0">
																<!-- Label  -->
																<span
																	x-bind:class="selectedCat == item ? 'font-bold' : null"
																	x-text="item.label"></span>
																<!-- Screen reader 'selected' indicator  -->
																<span class="sr-only"
																	x-text="selectedCat == item ? 'selected' : null"></span>
																<!-- Checkmark  -->
																<svg x-cloak x-show="selectedCat == item"
																	xmlns="http://www.w3.org/2000/svg"
																	viewBox="0 0 24 24" stroke="currentColor"
																	fill="none" stroke-width="2" class="size-4"
																	aria-hidden="true">
																	<path stroke-linecap="round" stroke-linejoin="round"
																		d="m4.5 12.75 6 6 9-13.5">
																</svg>
															</li>
														</template>
													</ul>
												</div>
											</div>
										</div>

										<!-- Select Lecturer -->
										<div x-data="{
							catOptions: <?= str_replace('"', "'", subject: json_encode($lecturers)) ?>,
							catTemp: [],
							isCatOpen: false,
							openedWithKeyboard: false,
							selectedCat: <?=str_replace('"', "'",json_encode(
								[
									'value' => (string)$course['lecturerId'],
									'label' => $course['firstName'].' '.$course['lastName']
								]
							))?>,
							setSelectedOption(option) {
								this.selectedCat = option;
								this.isCatOpen = false;
								this.openedWithKeyboard = false;
								this.$refs.hiddenTextField.value = option.value;
							},
							getFilteredOptions(query) {
								this.catTemp = this.catOptions.filter((option) =>
									option.label.toLowerCase().includes(query.toLowerCase())
								);
								if (this.catTemp.length === 0) {
									this.$refs.noResultsMessage.classList.remove('hidden');
								} else {
									this.$refs.noResultsMessage.classList.add('hidden');
								}
							},
							handleKeydownOnOptions(event) {
								if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
									this.$refs.searchField.focus();
								}
							},
						}" x-on:keydown="handleKeydownOnOptions($event)"
											x-on:keydown.esc.window="isCatOpen = false, openedWithKeyboard = false"
											x-init="catTemp = catOptions" class="flex w-full flex-col gap-1 mb-2">

											<label for="lecturer"
												class="w-fit pl-0.5 text-sm text-neutral-600">Lecturer*</label>
											<div class="relative">

												<!-- trigger button  -->
												<button type="button"
													class="inline-flex w-full items-center justify-between gap-2 border border-neutral-300 rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
													role="combobox" aria-controls="makesList" aria-haspopup="listbox"
													x-on:click="isCatOpen = ! isCatOpen"
													x-on:keydown.down.prevent="openedWithKeyboard = true"
													x-on:keydown.enter.prevent="openedWithKeyboard = true"
													x-on:keydown.space.prevent="openedWithKeyboard = true"
													x-bind:aria-expanded="isCatOpen || openedWithKeyboard"
													x-bind:aria-label="selectedCat ? selectedCat.label : 'Select lecturer'">
													<span class="text-sm font-normal"
														x-text="selectedCat ? selectedCat.label : 'Select lecturer'"></span>
													<!-- Chevron  -->
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
														fill="currentColor" class="size-5" aria-hidden="true">
														<path fill-rule="evenodd"
															d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
															clip-rule="evenodd" />
													</svg>
												</button>

												<!-- Hidden Input To Grab The Selected Value  -->
												<input id="lecturer" value="<?=$course['lecturerId']?>" required
													name="lecturer" x-ref="hiddenTextField" hidden="" />
												<div x-show="isCatOpen || openedWithKeyboard" id="makesList"
													class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-neutral-300 bg-neutral-50"
													role="listbox" aria-label="industries list"
													x-on:click.outside="isCatOpen = false, openedWithKeyboard = false"
													x-on:keydown.down.prevent="$focus.wrap().next()"
													x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition
													x-trap="openedWithKeyboard">

													<!-- Search  -->
													<div class="relative">
														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
															stroke="currentColor" fill="none" stroke-width="1.5"
															class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50"
															aria-hidden="true">
															<path stroke-linecap="round" stroke-linejoin="round"
																d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
														</svg>
														<input type="text"
															class="w-full border-b borderneutral-300 bg-neutral-50 py-2.5 pl-11 pr-4 text-sm text-neutral-600 focus:outline-none focus-visible:border-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
															name="searchField" aria-label="Search"
															x-on:input="getFilteredOptions($el.value)"
															x-ref="searchField" placeholder="Search" />
													</div>

													<!-- Options  -->
													<ul class="flex max-h-44 flex-col overflow-y-auto z-10">
														<li class="hidden px-4 py-2 text-sm text-neutral-600"
															x-ref="noResultsMessage">
															<span>No matches found</span>
														</li>
														<template x-for="(item, index) in catTemp"
															x-bind:key="item.value">
															<li class="combobox-option inline-flex cursor-pointer justify-between gap-6 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/5 focus-visible:text-neutral-900 focus-visible:outline-none"
																role="option" x-on:click="setSelectedOption(item)"
																x-on:keydown.enter="setSelectedOption(item)"
																x-bind:id="'option-' + index" tabindex="0">
																<!-- Label  -->
																<span
																	x-bind:class="selectedCat == item ? 'font-bold' : null"
																	x-text="item.label"></span>
																<!-- Screen reader 'selected' indicator  -->
																<span class="sr-only"
																	x-text="selectedCat == item ? 'selected' : null"></span>
																<!-- Checkmark  -->
																<svg x-cloak x-show="selectedCat == item"
																	xmlns="http://www.w3.org/2000/svg"
																	viewBox="0 0 24 24" stroke="currentColor"
																	fill="none" stroke-width="2" class="size-4"
																	aria-hidden="true">
																	<path stroke-linecap="round" stroke-linejoin="round"
																		d="m4.5 12.75 6 6 9-13.5">
																</svg>
															</li>
														</template>
													</ul>
												</div>
											</div>
										</div>

										<!-- Select University -->
										<div x-data="{
							catOptions: <?= str_replace('"', "'", subject: json_encode($universities)) ?>,
							catTemp: [],
							isCatOpen: false,
							openedWithKeyboard: false,
							selectedCat: <?=str_replace('"', "'",json_encode(
								[
									'value' => (string)$course['university_index'],
									'label' => $course['course_university']
								]
							))?>,
							setSelectedOption(option) {
								this.selectedCat = option;
								this.isCatOpen = false;
								this.openedWithKeyboard = false;
								this.$refs.hiddenTextField.value = option.value;
							},
							getFilteredOptions(query) {
								this.catTemp = this.catOptions.filter((option) =>
									option.label.toLowerCase().includes(query.toLowerCase())
								);
								if (this.catTemp.length === 0) {
									this.$refs.noResultsMessage.classList.remove('hidden');
								} else {
									this.$refs.noResultsMessage.classList.add('hidden');
								}
							},
							handleKeydownOnOptions(event) {
								if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
									this.$refs.searchField.focus();
								}
							},
						}" x-on:keydown="handleKeydownOnOptions($event)"
											x-on:keydown.esc.window="isCatOpen = false, openedWithKeyboard = false"
											x-init="catTemp = catOptions" class="flex w-full flex-col gap-1 mb-2">

											<label for="university"
												class="w-fit pl-0.5 text-sm text-neutral-600">University*</label>
											<div class="relative">

												<!-- trigger button  -->
												<button type="button"
													class="inline-flex w-full items-center justify-between gap-2 border border-neutral-300 rounded-md bg-neutral-50 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
													role="combobox" aria-controls="makesList" aria-haspopup="listbox"
													x-on:click="isCatOpen = ! isCatOpen"
													x-on:keydown.down.prevent="openedWithKeyboard = true"
													x-on:keydown.enter.prevent="openedWithKeyboard = true"
													x-on:keydown.space.prevent="openedWithKeyboard = true"
													x-bind:aria-expanded="isCatOpen || openedWithKeyboard"
													x-bind:aria-label="selectedCat ? selectedCat.label : 'Select university'">
													<span class="text-sm font-normal"
														x-text="selectedCat ? selectedCat.label : 'Select university'"></span>
													<!-- Chevron  -->
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
														fill="currentColor" class="size-5" aria-hidden="true">
														<path fill-rule="evenodd"
															d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
															clip-rule="evenodd" />
													</svg>
												</button>

												<!-- Hidden Input To Grab The Selected Value  -->
												<input id="university" value="<?=$course['universityId']?>" required
													name="university" x-ref="hiddenTextField" hidden="" />
												<div x-show="isCatOpen || openedWithKeyboard" id="makesList"
													class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-neutral-300 bg-neutral-50"
													role="listbox" aria-label="industries list"
													x-on:click.outside="isCatOpen = false, openedWithKeyboard = false"
													x-on:keydown.down.prevent="$focus.wrap().next()"
													x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition
													x-trap="openedWithKeyboard">

													<!-- Search  -->
													<div class="relative">
														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
															stroke="currentColor" fill="none" stroke-width="1.5"
															class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50"
															aria-hidden="true">
															<path stroke-linecap="round" stroke-linejoin="round"
																d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
														</svg>
														<input type="text"
															class="w-full border-b borderneutral-300 bg-neutral-50 py-2.5 pl-11 pr-4 text-sm text-neutral-600 focus:outline-none focus-visible:border-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
															name="searchField" aria-label="Search"
															x-on:input="getFilteredOptions($el.value)"
															x-ref="searchField" placeholder="Search" />
													</div>

													<!-- Options  -->
													<ul class="flex  max-h-44 flex-col overflow-y-auto z-10">
														<li class="hidden px-4 py-2 text-sm text-neutral-600"
															x-ref="noResultsMessage">
															<span>No matches found</span>
														</li>
														<template x-for="(item, index) in catTemp"
															x-bind:key="item.value">
															<li class="combobox-option inline-flex cursor-pointer justify-between gap-6 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/5 focus-visible:text-neutral-900 focus-visible:outline-none"
																role="option" x-on:click="setSelectedOption(item)"
																x-on:keydown.enter="setSelectedOption(item)"
																x-bind:id="'option-' + index" tabindex="0">
																<!-- Label  -->
																<span
																	x-bind:class="selectedCat == item ? 'font-bold' : null"
																	x-text="item.label"></span>
																<!-- Screen reader 'selected' indicator  -->
																<span class="sr-only"
																	x-text="selectedCat == item ? 'selected' : null"></span>
																<!-- Checkmark  -->
																<svg x-cloak x-show="selectedCat == item"
																	xmlns="http://www.w3.org/2000/svg"
																	viewBox="0 0 24 24" stroke="currentColor"
																	fill="none" stroke-width="2" class="size-4"
																	aria-hidden="true">
																	<path stroke-linecap="round" stroke-linejoin="round"
																		d="m4.5 12.75 6 6 9-13.5">
																</svg>
															</li>
														</template>
													</ul>
												</div>
											</div>
										</div>
										<!-- Description -->
										<div class="flex w-full mb-2 flex-col gap-1 text-neutral-600">
											<label for="textArea" class="w-fit pl-0.5 text-sm">Description*</label>
											<textarea required id="description" name="description"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2.5 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-75"
												rows="3"
												placeholder="What is this course about..."><?=$course['description']?></textarea>
										</div>
										<div class="flex items-center gap-2 mb-2">
											<!-- Language -->
											<div class="flex w-full flex-col gap-1 text-neutral-600 ">
												<label for="code" class="w-fit pl-0.5 text-sm">Language*</label>
												<input required id="language" type="text"
													value="<?=$course['language']?>"
													class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
													name="language" placeholder="Course Language" />
											</div>
											<!-- Year -->
											<div class="flex w-full flex-col gap-1 text-neutral-600">
												<label for="year" class="w-fit pl-0.5 text-sm">Year*</label>
												<input required id="year" type="text" value="<?=$course['year']?>"
													class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
													name="year" placeholder="Year" />
											</div>
											<!-- No. of lectures -->
											<div class="flex w-full flex-col gap-1 text-neutral-600">
												<label for="lectures" class="w-fit pl-0.5 text-sm">No. of
													lectures</label>
												<input id="lectures" type="number" value="<?=$course['n_lectures']?>"
													class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
													name="lectures" placeholder="No. of lectures" />
											</div>
										</div>
										<div class="items-center flex gap-2 mb-2">
											<!-- Course Code -->
											<div class="flex w-full flex-col gap-1 text-neutral-600">
												<label for="code" class="w-fit pl-0.5 text-sm">Course Code*</label>
												<input required id="code" type="text"
													value="<?=$course['course_code']?>"
													class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
													name="code" placeholder="Course Code" />
											</div>
											<!-- Course Duration -->
											<div class="flex w-full flex-col gap-1 text-neutral-600">
												<label for="textInputDefault"
													class="w-fit pl-0.5 text-sm">Duration*</label>
												<input required id="duration" type="number" min="0"
													value="<?=$course['t_duration']?>"
													class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
													name="duration" placeholder="Course Duration" />
											</div>
										</div>
										<!-- Video Link -->
										<div class="flex w-full flex-col gap-1 text-neutral-600 mb-2">
											<label for="vidLink" class="w-fit pl-0.5 text-sm">Video URL*</label>
											<input required id="vidLink" type="url" value="<?=$course['link_1']?>"
												class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
												name="vidLink" placeholder="Video URL" />
										</div>
										<div class="flex items-center gap-2 mb-2">
											<!-- Image Link -->
											<div class="flex w-full flex-col gap-1 text-neutral-600">
												<label for="imgLink" class="w-fit pl-0.5 text-sm">Image URL*</label>
												<input required id="imgLink" type="url" value="<?=$course['image']?>"
													class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
													name="imgLink" placeholder="Image URL" />
											</div>
											<!-- Link 2 -->
											<div class="flex w-full flex-col gap-1 text-neutral-600">
												<label for="link" class="w-fit pl-0.5 text-sm">Link</label>
												<input id="link" type="url" value="<?=$course['link_2']?>"
													class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
													name="link" placeholder="Link" />
											</div>
										</div>


									</div>
									<!-- Dialog Footer -->
									<div
										class="border-t border-neutral-300 bg-neutral-50/60 p-4 sm:flex-row sm:items-center md:justify-end">
										<button type="submit"
											class="w-full cursor-pointer whitespace-nowrap rounded-md bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0">
											Update Course</button>
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
										Delete <?=$course['course_name']?> </h3>
									<p class="text-md">Are you sure you want to delete this course?</p>
								</div>
								<!-- Dialog Footer -->
								<div class="flex items-center justify-center border-neutral-300 p-4">
									<form action="" method="post">
										<input type="hidden" name="deleteCourse" value="<?=$course['id']?>">
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
			<?= min(($courseArray['currentPage'] - 1) * $courseArray['perPage'] + count($courseArray['data']), $courseArray['total']) ?>
		</span>
		of <span class="font-bold"><?= $courseArray['total'] ?></span> entries
	</p>
	<nav aria-label="pagination">
		<ul class="flex flex-shrink-0 items-center gap-2 text-sm md:text-md font-normal">
			<!-- Previous Page -->
			<li>
				<?php if ($courseArray['currentPage'] > 1): ?>
				<a href="?page=<?= $courseArray['currentPage'] - 1 ?>"
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
			<li class="font-semibold text-lg mx-2"><?= $courseArray['currentPage'] ?></li>
			<!-- Next Page -->
			<li>
				<?php if ($courseArray['currentPage'] < ceil($courseArray['total'] / $courseArray['perPage'])): ?>
				<a href="?page=<?= $courseArray['currentPage'] + 1 ?>"
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