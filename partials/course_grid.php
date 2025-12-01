<?php
/**
 * Course grid partial
 * Displays a grid of course cards
 * 
 * @var array $courses Array of course data
 */
if (!isset($courses) || !is_array($courses)) {
    return;
}
?>
<!-- Lesson Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6 md:px-20">
    <?php foreach ($courses as $index => $course) : ?>
        <?php include SITE_PATH . '/partials/course_card.php'; ?>
    <?php endforeach; ?>
</div>

