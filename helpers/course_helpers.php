<?php
/**
 * Helper functions for course data processing
 */

/**
 * Transform raw course data from database to display format.
 * Calculates statistics and enriches course data with university information.
 * 
 * @param array $courses Array of course records from database
 * @param array|null $university_list Optional pre-loaded university list. If null, will fetch it.
 * @return array Associative array with keys:
 *               - 'courses': Array of transformed course data
 *               - 'total_courses': Total number of courses
 *               - 'total_hours': Total duration in hours
 */
function transformCoursesForDisplay(array $courses, ?array $university_list = null) {
    if ($university_list === null) {
        if (!function_exists('selectUstanove')) {
            require_once REPO_PATH;
        }
        $university_list = selectUstanove();
    }
    
    $all_total_length = 0;
    $all_courses = 0;
    $list = [];
    
    foreach ($courses as $course) {
        $course_totalLength = $course['t_duration'];
        $all_courses++;
        $all_total_length += $course_totalLength;
        $university_index = $course['ustanova'] - 1;
        $course_university = isset($university_list[$university_index]) 
            ? $university_list[$university_index]['name'] 
            : '';
        
        $data = [
            'course_id' => $course['id'],
            'course_name' => $course['name'],
            'course_description' => $course['description'],
            'course_totalLength' => $course['t_duration'],
            'course_linkPlaylist' => $course['link_1'],
            'course_image' => $course['image'],
            'course_university' => $course_university,
            'university_index' => $university_index,
            'broken_reports' => (int)($course['broken_reports'] ?? 0),
            'views' => (int)($course['views'] ?? 0)
        ];
        
        $list[] = $data;
    }
    
    return [
        'courses' => $list,
        'total_courses' => $all_courses,
        'total_hours' => $all_total_length
    ];
}

