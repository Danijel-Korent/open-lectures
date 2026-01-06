<?php
/**
 * Course card partial
 * Displays a single course card with modal trigger
 * 
 * @var array $course Course data array
 * @var int $index Index for modal identification
 */
if (!isset($course) || !isset($index)) {
    return;
}

$modalKey = 'Modal' . $index;
$viewsId = 'views-count-' . ($course['course_id'] ?? 'unknown') . '-' . $index;
?>
<!-- Modal -->
<div x-data="{<?=$modalKey?>: false}">
    <a @click="<?=$modalKey?> = true; trackCourseView(<?=$course['course_id']?>, '<?=$viewsId?>')" 
       role="button" target='_blank' rel='noopener noreferrer'
        class="no-underline cursor-pointer">
        <!-- <span class='tooltiptext p-1'><?=$course['course_description']?></span> -->
        <div class=" hover:scale-105 transition-all bg-white rounded-xl shadow-md overflow-hidden">
            <div class="relative">
                <img class="w-full h-48 object-cover" src="<?=$course['course_image']?>"
                    alt="<?=$course['course_name']?>" />
                <!-- <div class="absolute top-0 right-0 bg-indigo-500 text-white font-bold px-2 py-1 m-2 rounded-md">New
                </div> -->
                <div class="absolute bottom-0 right-0 bg-gray-800 text-white px-2 py-1 m-2 rounded-md text-xs">
                    <?=$course['course_totalLength']?> h </div>
            </div>
            <div class="p-4">
                <div class="hover:underline transition-all text-lg font-medium text-gray-800 mb-2">
                    <?=$course['course_name']?></div>
                <p class="text-gray-500 text-sm font-bold text-left"><?=$course['course_university']?></p>
                <p class="text-gray-500 pt-2 text-sm"><?=truncateString($course['course_description'],180)?></p>
            </div>
        </div>
    </a>
    <?php include SITE_PATH . '/partials/course_modal.php'; ?>
</div>


