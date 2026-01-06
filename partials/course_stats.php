<?php
/**
 * Course statistics partial
 * Displays total courses and total hours
 * 
 * @var int $total_courses Total number of courses
 * @var int $total_hours Total duration in hours
 */
if (!isset($total_courses) || !isset($total_hours)) {
    return;
}
?>
<!-- Stats Hero -->
<div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
    <div class="grid grid-cols-2 gap-8 md:grid-cols-2">
        <div class="text-center md:border-r">
            <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl"><?=$total_courses?></h6>
            <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                Ukupno kolegija
            </p>
        </div>
        <div class="text-center ">
            <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl"><?=$total_hours?>h</h6>
            <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                Ukupno sati
            </p>
        </div>
    </div>
</div>


