<?php
/**
 * Markimatics Child Theme functions.
 *
 * @package Markimatics_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Markimatics full-page templates that use the custom design system.
 *
 * @return string[]
 */
function markimatics_page_templates() {
	return array( 'page-markimatics.php', 'page-subject.php', 'page-grade.php' );
}

/**
 * Whether the current view uses a Markimatics page template.
 *
 * @return bool
 */
function markimatics_is_template() {
	foreach ( markimatics_page_templates() as $template ) {
		if ( is_page_template( $template ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Resolve the permalink for a subject page by slug.
 *
 * Looks for a published page with the given slug that uses the Subject template.
 * Falls back to any page with that slug, then to a pretty URL path.
 *
 * @param string $slug Subject page slug (e.g. science, ela, math, nclex).
 * @return string
 */
function markimatics_get_subject_url( $slug ) {
	$slug = sanitize_title( $slug );

	$pages = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-subject.php',
		)
	);

	if ( ! empty( $pages ) ) {
		return get_permalink( $pages[0] );
	}

	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}

	return home_url( '/' . $slug . '/' );
}

/**
 * Grade-level card definitions for a subject.
 *
 * Optional store_url keeps the TeachersPayTeachers category for later use.
 * "View Lessons" uses markimatics_get_grade_url() (grade page), not store_url.
 *
 * @param string $subject_slug Subject page slug.
 * @return array<int, array{label: string, slug: string, color: string, store_url?: string}>
 */
function markimatics_get_subject_grades( $subject_slug ) {
	$catalog = array(
		'science' => array(
			array( 'label' => 'Kinder', 'slug' => 'kinder', 'color' => '#7cb342', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1496930' ),
			array( 'label' => 'Grade 1', 'slug' => 'grade-1', 'color' => '#9b8572', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1385095' ),
			array( 'label' => 'Grade 2', 'slug' => 'grade-2', 'color' => '#e67e22', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1376161' ),
			array( 'label' => 'Grade 3', 'slug' => 'grade-3', 'color' => '#e74c3c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1375944' ),
			array( 'label' => 'Grade 4', 'slug' => 'grade-4', 'color' => '#e91e8c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1378670' ),
			array( 'label' => 'Grade 5', 'slug' => 'grade-5', 'color' => '#9b59b6', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1375569' ),
			array( 'label' => 'Grade 6', 'slug' => 'grade-6', 'color' => '#5c6bc0', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1304684' ),
			array( 'label' => 'Grade 7', 'slug' => 'grade-7', 'color' => '#42a5f5', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1326376' ),
			array( 'label' => 'Grade 8', 'slug' => 'grade-8', 'color' => '#26a69a', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1326377' ),
			array( 'label' => 'HS Astronomy', 'slug' => 'hs-astronomy', 'color' => '#3949ab', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1394982' ),
			array( 'label' => 'HS Biology', 'slug' => 'hs-biology', 'color' => '#43a047', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1391063' ),
			array( 'label' => 'HS Chemistry', 'slug' => 'hs-chemistry', 'color' => '#fb8c00', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1391060' ),
			array( 'label' => 'HS Earth Science', 'slug' => 'hs-earth-science', 'color' => '#8d6e63', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-amp-1287791' ),
			array( 'label' => 'HS Physics', 'slug' => 'hs-physics', 'color' => '#5e35b1' ),
		),
		'math'    => array(
			array( 'label' => 'Pre-Kinder', 'slug' => 'pre-kinder', 'color' => '#26c6da' ),
			array( 'label' => 'Kinder', 'slug' => 'kinder', 'color' => '#7cb342', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1534845' ),
			array( 'label' => 'Grade 1', 'slug' => 'grade-1', 'color' => '#f1c40f', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1517573' ),
			array( 'label' => 'Grade 2', 'slug' => 'grade-2', 'color' => '#e67e22', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1434612' ),
			array( 'label' => 'Grade 3', 'slug' => 'grade-3', 'color' => '#e74c3c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1564823' ),
			array( 'label' => 'Grade 4', 'slug' => 'grade-4', 'color' => '#e91e8c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1557684' ),
			array( 'label' => 'Grade 5', 'slug' => 'grade-5', 'color' => '#9b59b6', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1434644' ),
			array( 'label' => 'Grade 6', 'slug' => 'grade-6', 'color' => '#5c6bc0', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386221' ),
			array( 'label' => 'Grade 7', 'slug' => 'grade-7', 'color' => '#42a5f5', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386220' ),
			array( 'label' => 'Grade 8', 'slug' => 'grade-8', 'color' => '#0072ce', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1386222' ),
			array( 'label' => 'Algebra I', 'slug' => 'algebra-i', 'color' => '#1565c0', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386225' ),
			array( 'label' => 'Algebra II', 'slug' => 'algebra-ii', 'color' => '#283593', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1430134' ),
			array( 'label' => 'Geometry', 'slug' => 'geometry', 'color' => '#00897b', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386224' ),
			array( 'label' => 'Statistics', 'slug' => 'statistics', 'color' => '#6a1b9a', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1445485' ),
			array( 'label' => 'Trigonometry', 'slug' => 'trigonometry', 'color' => '#ad1457', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1445484' ),
		),
	);

	$subject_slug = sanitize_title( $subject_slug );

	return isset( $catalog[ $subject_slug ] ) ? $catalog[ $subject_slug ] : array();
}

/**
 * Lesson (task card) definitions for a subject + grade.
 *
 * Add lessons here as images and product links become available.
 *
 * Keys per lesson:
 * - title        Full lesson title (shown on composed card / image alt)
 * - label        Blue bar text under the card
 * - slug         Unique lesson slug (used for image filename lookup)
 * - url          Product / lesson link (optional until provided)
 * - image        Full cover image URL (optional; falls back to asset lookup)
 * - badge        Corner ribbon text (default: TASK CARD)
 * - count        e.g. "24 Task Cards"
 * - action       e.g. "Print, Cut, Laminate"
 * - difficulties Array of: easy, moderate, challenging, hard
 *
 * @param string $subject_slug Subject slug (e.g. science).
 * @param string $grade_slug   Grade slug (e.g. grade-5).
 * @return array<int, array<string, mixed>>
 */
function markimatics_get_grade_lessons( $subject_slug, $grade_slug ) {
	$images = get_stylesheet_directory_uri() . '/markimatics/images/';

	$catalog = array(
		'science' => array(
			'kinder' => array(
				array(
					'title'        => 'Sorting & Describing Objects',
					'label'        => 'Task Card: TEKS K-6: Sorting and Describing Objects',
					'slug'         => 'sorting-and-describing-objects',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-6 Sorting and Describing Objects.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K6-Sorting-and-Describing-Objects-14967136',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding What Magnets Can Do',
					'label'        => 'Task Card: TEKS K-7: Understanding What Magnets Can Do',
					'slug'         => 'understanding-what-magnets-can-do',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-7 Understanding What Magnets Can Do.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K7-Understanding-What-Magnets-Can-Do-14967190',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Seeing Things With Light',
					'label'        => 'Task Card: TEKS K-8A: Seeing Things With Light',
					'slug'         => 'seeing-things-with-light',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-8A Seeing Things With Light.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K8A-Seeing-Things-With-Light-14967261',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding Light\'s Travel',
					'label'        => 'Task Card: TEKS K-8B: Understanding Light\'s Travel',
					'slug'         => 'understanding-light-s-travel',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-8B Understanding Light\'s Travel.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K8B-Understanding-Lights-Travel-14967339',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Day and Night Patterns',
					'label'        => 'Task Card: TEKS K-9A: Day and Night Patterns',
					'slug'         => 'day-and-night-patterns',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-9A Day and Night Patterns.png' ),
					'url'          => '',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Things We See in the Sky Sun, Moon, Stars, and Clouds',
					'label'        => 'Task Card: TEKS K-9B: Things We See in the Sky Sun, Moon, Stars, and Clouds',
					'slug'         => 'things-we-see-in-the-sky-sun-moon-stars-and-clouds',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-9B Things We See in the Sky Sun, Moon, Stars, and Clouds.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K9B-Things-We-See-in-the-Sky-Sun-Moon-Stars-and-Clouds-14967600',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Sorting Rocks by How They Look and Feel',
					'label'        => 'Task Card: TEKS K-10A: Sorting Rocks by How They Look and Feel',
					'slug'         => 'sorting-rocks-by-how-they-look-and-feel',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-10A Sorting Rocks by How They Look and Feel.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K10A-Sorting-Rocks-by-How-They-Look-and-Feel-14967786',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding the Changes in Weather',
					'label'        => 'Task Card: TEKS K-10B: Understanding the Changes in Weather',
					'slug'         => 'understanding-the-changes-in-weather',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-10B Understanding the Changes in Weather.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K10B-Understanding-the-Changes-in-Weather-14967954',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Air and Wind Around Us',
					'label'        => 'Task Card: TEKS K-10C: Air and Wind Around Us',
					'slug'         => 'air-and-wind-around-us',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-10C Air and Wind Around Us.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K10C-Air-and-Wind-Around-Us-14968042',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Uses of Rocks, Soil, and Water',
					'label'        => 'Task Card: TEKS K-11: Uses of Rocks, Soil, and Water',
					'slug'         => 'uses-of-rocks-soil-and-water',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-11 Uses of Rocks, Soil, and Water.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K11-Uses-of-Rocks-Soil-and-Water-14968183',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'What Plants Need to Grow',
					'label'        => 'Task Card: TEKS K-12A: What Plants Need to Grow',
					'slug'         => 'what-plants-need-to-grow',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-12A What Plants Need to Grow.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K12A-What-Plants-Need-to-Grow-14968225',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Animals Depend on Air, Water, Food, Space & Shelter',
					'label'        => 'Task Card: TEKS K-12B: Animals Depend on Air, Water, Food, Space & Shelter',
					'slug'         => 'animals-depend-on-air-water-food-space-shelter',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-12B Animals Depend on Air, Water, Food, Space & Shelter.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K12B-Animals-Depend-on-Air-Water-Food-Space-Shelter-14968088',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Identifying Plant Structures',
					'label'        => 'Task Card: TEKS K-13A: Identifying Plant Structures',
					'slug'         => 'identifying-plant-structures',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-13A Identifying Plant Structures.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K13A-Identifying-Plant-Structures-14968348',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Animal Body Parts and How They Help Animals',
					'label'        => 'Task Card: TEKS K-13B: Animal Body Parts and How They Help Animals',
					'slug'         => 'animal-body-parts-and-how-they-help-animals',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-13B Animal Body Parts and How They Help Animals.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K13B-Animal-Body-Parts-and-How-They-Help-Animals-14968524',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Plant Life Cycle',
					'label'        => 'Task Card: TEKS K-13C: Plant Life Cycle',
					'slug'         => 'plant-life-cycle',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-13C Plant Life Cycle.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K13C-Plant-Life-Cycle-14968578',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Young Plants Look Like the Parent Plant',
					'label'        => 'Task Card: TEKS K-13D: How Young Plants Look Like the Parent Plant',
					'slug'         => 'how-young-plants-look-like-the-parent-plant',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-13D How Young Plants Look Like the Parent Plant.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K13D-How-Young-Plants-Look-Like-the-Parent-Plant-14968701',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Young Plants Resemble Parents',
					'label'        => 'Task Card: TEKS K-13D: How Young Plants Resemble Parents',
					'slug'         => 'how-young-plants-resemble-parents',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-13D How Young Plants Resemble Parents.png' ),
					'url'          => '',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
			),
			'grade-1' => array(
				array(
					'title'        => 'Classifying Objects by Their Physical Properties',
					'label'        => 'Task Card: TEKS 1-6A: Classifying Objects by Their Physical Properties',
					'slug'         => 'classifying-objects-by-their-physical-properties',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-6A Classifying Objects by Their Physical Properties.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-16A-Classifying-Objects-by-Their-Physical-Properties-14899638',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Exploring Changes in Materials Through Heating and Cooling',
					'label'        => 'Task Card: TEKS 1-6B: Exploring Changes in Materials Through Heating and Cooling',
					'slug'         => 'exploring-changes-in-materials-through-heating-and-cooling',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-6B Exploring Changes in Materials Through Heating and Cooling.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-16B-Exploring-Changes-in-Materials-Through-Heating-and-Cooling-14899672',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding Objects and Their Parts (such as Toys)',
					'label'        => 'Task Card: TEKS 1-6C: Understanding Objects and Their Parts such as Toy',
					'slug'         => 'understanding-objects-and-their-parts-such-as-toy',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-6C Understanding Objects and Their Parts such as Toy.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-16C-Understanding-Objects-and-Their-Parts-such-as-Toy-14899711',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Pushes & Pulls: How Objects Move, Stop, & Change Direction',
					'label'        => 'Task Card: TEKS 1-7A: Pushes & Pulls How Objects Move, Stop, & Change Direction',
					'slug'         => 'pushes-and-pulls-how-objects-move-stop-and-change-direction',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-7A Pushes & Pulls How Objects Move, Stop, & Change Direction.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-1-7A-Pushes-Pulls-How-Objects-Move-Stop-Change-Direction-14899748',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Investigating How Pushes and Pulls Affect Motion',
					'label'        => 'Task Card: TEKS 1-7B: Investigating How Pushes and Pulls Affect Motion',
					'slug'         => 'investigating-how-pushes-and-pulls-affect-motion',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-7B Investigating How Pushes and Pulls Affect Motion.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-1-7B-Investigating-How-Pushes-and-Pulls-Affect-Motion-14899809',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Heat Helps Us in Everyday Life',
					'label'        => 'Task Card: TEKS 1-8A: Investigating How Heat Helps Us in Everyday Life',
					'slug'         => 'investigating-how-heat-helps-us-in-everyday-life',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-8A Investigating How Heat Helps Us in Everyday Life.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-18A-Investigating-How-Heat-Helps-Us-in-Everyday-Life-14899830',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Heat Changes: Reversible & Irreversible Transformations',
					'label'        => 'Task Card: TEKS 1-8B: Heat Changes Reversible and Irreversible Transformations',
					'slug'         => 'heat-changes-reversible-and-irreversible-transformations',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-8B Heat Changes Reversible and Irreversible Transformations.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-18B-Heat-Changes-Reversible-and-Irreversible-Transformations-14899961',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Patterns of the Seasons',
					'label'        => 'Task Card: TEKS 1-9: Understanding the Patterns of the Seasons',
					'slug'         => 'understanding-the-patterns-of-the-seasons',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-9 Understanding the Patterns of the Seasons.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-19-Understanding-the-Patterns-of-the-Seasons-14899949',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Exploring Soil: Its Color, Texture, and Tiny Parts',
					'label'        => 'Task Card: TEKS 1-10A: Exploring Soil - Its Color, Texture, and Tiny Parts',
					'slug'         => 'exploring-soil-its-color-texture-and-tiny-parts',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-10A Exploring Soil — Its Color, Texture, and Tiny Parts.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-110A-Exploring-Soil-Its-Color-Texture-and-Tiny-Parts-14899974',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Investigate the Movement of Water and Soil Particles',
					'label'        => 'Task Card: TEKS 1-10B: Investigating the Movement of Water and Soil Particles',
					'slug'         => 'investigating-the-movement-of-water-and-soil-particles',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-10B Investigating the Movement of Water and Soil Particles.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-110B-Investigating-the-Movement-of-Water-and-Soil-Particles-14899991',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Water Bodies: Puddles, Ponds, Streams, Rivers, Lakes, and Oceans',
					'label'        => 'Task Card: TEKS 1-10C: Water Bodies Puddle, Pond, Stream, River, Lakes, Ocean',
					'slug'         => 'water-bodies-puddle-pond-stream-river-lakes-ocean',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-10C Water Bodies Puddle, Pond, Stream, River, Lakes, Ocean.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-110C-Water-Bodies-Puddle-Pond-Stream-River-Lakes-Ocean-14905067',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Weather and Its Impact on Our Daily Choices',
					'label'        => 'Task Card: TEKS 1-10D: Understanding Weather and Its Impact on Our Daily Choices',
					'slug'         => 'understanding-weather-and-its-impact-on-our-daily-choices',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-10D Understanding Weather and Its Impact on Our Daily Choices.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-110D-Understanding-Weather-and-Its-Impact-on-Our-Daily-Choices-14905365',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Plants, Animals, and Humans Use Rocks, Soil, & Water',
					'label'        => 'Task Card: TEKS 1-11A: How Plants, Animals, and Humans Use Rocks, Soil, & Water',
					'slug'         => 'how-plants-animals-and-humans-use-rocks-soil-and-water',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-11A How Plants, Animals, and Humans Use Rocks, Soil, & Water.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-111A-How-Plants-Animals-and-Humans-Use-Rocks-Soil-Water-14905399',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Why Water Conservation is Important',
					'label'        => 'Task Card: TEKS 1-11B: Why Water Conservation is Important',
					'slug'         => 'why-water-conservation-is-important',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-11B Why Water Conservation is Important.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-111B-Why-Water-Conservation-is-Important-14905416',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Ways to Conserve Water and Protect Water Sources',
					'label'        => 'Task Card: TEKS 1-11C: Ways to Conserve Water and Protect Water Sources',
					'slug'         => 'ways-to-conserve-water-and-protect-water-sources',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-11C Ways to Conserve Water and Protect Water Sources.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-111C-Ways-to-Conserve-Water-and-Protect-Water-Sources-15281997',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Classifying Living and Nonliving Things',
					'label'        => 'Task Card: TEKS 1-12A: Classifying Living and Nonliving Things',
					'slug'         => 'classifying-living-and-nonliving-things',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-12A Classifying Living and Nonliving Things.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-112A-Classifying-Living-and-Nonliving-Things-14905425',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Life Working Together in Terrariums and Aquariums',
					'label'        => 'Task Card: TEKS 1-12B: Life Working Together in Terrariums and Aquariums',
					'slug'         => 'life-working-together-in-terrariums-and-aquariums',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-12B Life Working Together in Terrariums and Aquariums.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-112B-Life-Working-Together-in-Terrariums-and-Aquariums-14905438',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Living Things Depend on Each Other in Food Chains',
					'label'        => 'Task Card: TEKS 1-12C: How Living Things Depend on Each Other in Food Chains',
					'slug'         => 'how-living-things-depend-on-each-other-in-food-chains',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-12C How Living Things Depend on Each Other in Food Chains.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-1-12C-How-Living-Things-Depend-on-Each-Other-in-Food-Chains-14905458',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Animal Body Parts Help Them Live and Move',
					'label'        => 'Task Card: TEKS 1-13A: Exploring How Animal Body Parts Help Them Live and Move',
					'slug'         => 'exploring-how-animal-body-parts-help-them-live-and-move',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-13A Exploring How Animal Body Parts Help Them Live and Move.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-113A-Exploring-How-Animal-Body-Parts-Help-Them-Live-and-Move-14905543',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Exploring the Life Cycles of Birds, Mammals, and Fish',
					'label'        => 'Task Card: TEKS 1-13B: Exploring the Life Cycles of Birds, Mammals, and Fish',
					'slug'         => 'exploring-the-life-cycles-of-birds-mammals-and-fish',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-13B Exploring the Life Cycles of Birds, Mammals, and Fish.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-113B-Exploring-the-Life-Cycles-of-Birds-Mammals-and-Fish-14905559',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Young Animals Look Like Their Parents',
					'label'        => 'Task Card: TEKS 1-13C: Comparing How Young Animals Look Like Their Parents',
					'slug'         => 'comparing-how-young-animals-look-like-their-parents',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 1-13C Comparing How Young Animals Look Like Their Parents.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-1-13C-Comparing-How-Young-Animals-Look-Like-Their-Parents-14905577',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
			),
			'grade-2' => array(
				array(
					'title'        => 'Classifying Matter by Physical Properties',
					'label'        => 'Task Card: TEKS 2-6A: Classifying Matter by Physical Properties',
					'slug'         => 'classifying-matter-by-physical-properties',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-6A Classifying Matter by Physical Properties.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-26A-Classifying-Matter-by-Physical-Properties-14785281',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Physical Properties: Cut, Fold, Sand, Melt, Freeze',
					'label'        => 'Task Card: TEKS 2-6B: Physical Properties - Cut, Fold, Sand, Melt, Freeze',
					'slug'         => 'physical-properties-cut-fold-sand-melt-freeze',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-6B Physical Properties - Cut, Fold, Sand, Melt, Freeze.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-26B-Physical-Properties-Cut-Fold-Sand-Melt-Freeze-14785349',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Building New Objects from Small Parts',
					'label'        => 'Task Card: TEKS 2-6C: Building New Objects from Small Parts',
					'slug'         => 'building-new-objects-from-small-parts',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-6C Building New Objects from Small Parts.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-26C-Building-New-Objects-from-Small-Parts-14785420',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Objects Push and Change Shape During Collisions',
					'label'        => 'Task Card: TEKS 2-7A: How Objects Push and Change Shape During Collisions',
					'slug'         => 'how-objects-push-and-change-shape-during-collisions',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-7A How Objects Push and Change Shape During Collisions.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-27A-How-Objects-Push-and-Change-Shape-During-Collisions-14785465',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Investigating How Push and Pull Affect Motion',
					'label'        => 'Task Card: TEKS 2-7B: Investigating How Push and Pull Affect Motion',
					'slug'         => 'investigating-how-push-and-pull-affect-motion',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-7B Investigating How Push and Pull Affect Motion.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-27B-Investigating-How-Push-and-Pull-Affect-Motion-14785510',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Vibrations Make Sound',
					'label'        => 'Task Card: TEKS 2-8A: How Vibrations Make Sound',
					'slug'         => 'how-vibrations-make-sound',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-8A How Vibrations Make Sound.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-28A-How-Vibrations-Make-Sound-14785543',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding Sound Levels in Everyday Life',
					'label'        => 'Task Card: TEKS 2-8B: Understanding Sound Levels in Everyday Life',
					'slug'         => 'understanding-sound-levels-in-everyday-life',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-8B Understanding Sound Levels in Everyday Life.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-28B-Understanding-Sound-Levels-in-Everyday-Life-14785568',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Designing Devices to Use Sound for Communication',
					'label'        => 'Task Card: TEKS 2-8C: Designing Devices to Use Sound for Communication',
					'slug'         => 'designing-devices-to-use-sound-for-communication',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-8C Designing Devices to Use Sound for Communication.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-28C-Designing-Devices-to-Use-Sound-for-Communication-14785606',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'The Sun and Moon: Light, Heat, and Reflection',
					'label'        => 'Task Card: TEKS 2-9A: The Sun and Moon Light, Heat, and Reflection',
					'slug'         => 'the-sun-and-moon-light-heat-and-reflection',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-9A The Sun and Moon Light, Heat, and Reflection.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-29A-The-Sun-and-Moon-Light-Heat-and-Reflection-14785647',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Observing the Sky with Tools and the Naked Eye',
					'label'        => 'Task Card: TEKS 2-9B: Observing the Sky with Tools and the Naked Eye',
					'slug'         => 'observing-the-sky-with-tools-and-the-naked-eye',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-9B Observing the Sky with Tools and the Naked Eye.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-29B-Observing-the-Sky-with-Tools-and-the-Naked-Eye-14785689',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Wind and Water Move Soil and Rock Particles',
					'label'        => 'Task Card: TEKS 2-10A: How Wind and Water Move Soil and Rock Particles',
					'slug'         => 'how-wind-and-water-move-soil-and-rock-particles',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-10A How Wind and Water Move Soil and Rock Particles.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-210A-How-Wind-and-Water-Move-Soil-and-Rock-Particles-14785728',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Measuring, Recording, and Graphing Weather Information',
					'label'        => 'Task Card: TEKS 2-10B: Measuring, Recording, and Graphing Weather Information',
					'slug'         => 'measuring-recording-and-graphing-weather-information',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-10B Measuring, Recording, and Graphing Weather Information.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-210B-Measuring-Recording-and-Graphing-Weather-Information-14785779',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding Severe Weather Events',
					'label'        => 'Task Card: TEKS 2-10C: Understanding Severe Weather Events',
					'slug'         => 'understanding-severe-weather-events',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-10C Understanding Severe Weather Events.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-210C-Understanding-Severe-Weather-Events-14785810',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding Natural and Manmade Resources',
					'label'        => 'Task Card: TEKS 2-11A: Understanding Natural and Manmade Resources',
					'slug'         => 'understanding-natural-and-manmade-resources',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-11A Understanding Natural and Manmade Resources.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-211A-Understanding-Natural-and-Manmade-Resources-14785857',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Making Choices to Conserve & Properly Dispose of Materials',
					'label'        => 'Task Card: TEKS 2-11B: Make Choices to Conserve & Properly Dispose of Materials',
					'slug'         => 'make-choices-to-conserve-properly-dispose-of-materials',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-11B Make Choices to Conserve & Properly Dispose of Materials.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-211B-Make-Choices-to-Conserve-Properly-Dispose-of-Materials-14785889',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Rainfall and Environment Support Plants and Animals',
					'label'        => 'Task Card: TEKS 2-12A: How Rainfall and Environment Support Plants and Animals',
					'slug'         => 'how-rainfall-and-environment-support-plants-and-animals',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-12A How Rainfall and Environment Support Plants and Animals.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-212A-How-Rainfall-and-Environment-Support-Plants-and-Animals-14785928',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Food Chains Show Animal Dependence',
					'label'        => 'Task Card: TEKS 2-12B: Understanding How Food Chains Show Animal Dependence',
					'slug'         => 'understanding-how-food-chains-show-animal-dependence',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-12B Understanding How Food Chains Show Animal Dependence.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-212B-Understanding-How-Food-Chains-Show-Animal-Dependence-14786005',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Plants Use Wind, Water, & Living Things to Grow',
					'label'        => 'Task Card: TEKS 2-12C: How Plants Use Wind, Water, & Living Things to Grow',
					'slug'         => 'how-plants-use-wind-water-living-things-to-grow',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-12C How Plants Use Wind, Water, & Living Things to Grow.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-212C-How-Plants-Use-Wind-Water-Living-Things-to-Grow-14786062',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Identify & Compare How Plant Parts Function for Survival',
					'label'        => 'Task Card: TEKS 2-13A: Identify & Compare How Plant Parts Function for Survival',
					'slug'         => 'identify-compare-how-plant-parts-function-for-survival',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-13A Identify & Compare How Plant Parts Function for Survival.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-213A-Identify-Compare-How-Plant-Parts-Function-for-Survival-14786101',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Animal Body Parts & Behaviors Help Them Survive',
					'label'        => 'Task Card: TEKS 2-13B: Animal Body Parts & Behaviors Help Them Survive',
					'slug'         => 'animal-body-parts-behaviors-help-them-survive',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-13B Animal Body Parts & Behaviors Help Them Survive.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-213B-Animal-Body-Parts-Behaviors-Help-Them-Survive-14786151',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'How Living in Groups Helps Animals Survive and Find Food',
					'label'        => 'Task Card: TEKS 2-13C: How Living in Groups Helps Animals Survive and Find Food',
					'slug'         => 'how-living-in-groups-helps-animals-survive-and-find-food',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-13C How Living in Groups Helps Animals Survive and Find Food.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-213C-How-Living-in-Groups-Helps-Animals-Survive-and-Find-Food-14786228',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Explore Animal Life Cycles From Young to Adult Animals',
					'label'        => 'Task Card: TEKS 2-13D: Explore Animal Life Cycles From Young to Adult Animals',
					'slug'         => 'explore-animal-life-cycles-from-young-to-adult-animals',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS 2-13D Explore Animal Life Cycles From Young to Adult Animals.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-213D-Explore-Animal-Life-Cycles-From-Young-to-Adult-Animals-14786278',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
			),
		),
		'math'    => array(),
	);

	$subject_slug = sanitize_title( $subject_slug );
	$grade_slug   = sanitize_title( $grade_slug );

	if ( empty( $catalog[ $subject_slug ][ $grade_slug ] ) ) {
		return array();
	}

	return $catalog[ $subject_slug ][ $grade_slug ];
}

/**
 * URL for a lesson cover image, if the asset exists.
 *
 * Prefers: markimatics/images/{subject}-{grade}-{lesson}-card.png
 *
 * @param string $subject_slug Subject slug.
 * @param string $grade_slug   Grade slug.
 * @param string $lesson_slug  Lesson slug.
 * @return string|null
 */
function markimatics_get_lesson_card_image( $subject_slug, $grade_slug, $lesson_slug ) {
	if ( ! $lesson_slug ) {
		return null;
	}

	$dir  = get_stylesheet_directory() . '/markimatics/images/';
	$base = get_stylesheet_directory_uri() . '/markimatics/images/';

	$filename = sprintf(
		'%s-%s-%s-card.png',
		sanitize_title( $subject_slug ),
		sanitize_title( $grade_slug ),
		sanitize_title( $lesson_slug )
	);

	if ( file_exists( $dir . $filename ) ) {
		return $base . rawurlencode( $filename );
	}

	return null;
}

/**
 * URL for a grade card body image, if the asset exists.
 *
 * Prefers: markimatics/images/{subject}-{grade}-card.png
 * Fallback: markimatics/images/{Subject} - {Label} - final.png
 *
 * @param string $subject_slug  Subject slug (e.g. science).
 * @param string $grade_slug    Grade slug (e.g. grade-1).
 * @param string $subject_title Subject title (e.g. Science).
 * @param string $grade_label   Grade label (e.g. Grade 1).
 * @return string|null
 */
function markimatics_get_grade_card_image( $subject_slug, $grade_slug, $subject_title = '', $grade_label = '' ) {
	$dir  = get_stylesheet_directory() . '/markimatics/images/';
	$base = get_stylesheet_directory_uri() . '/markimatics/images/';

	$candidates = array(
		sprintf( '%s-%s-card.png', sanitize_title( $subject_slug ), sanitize_title( $grade_slug ) ),
	);

	if ( $subject_title && $grade_label ) {
		$candidates[] = sprintf( '%s - %s - final.png', $subject_title, $grade_label );
	}

	foreach ( $candidates as $filename ) {
		if ( file_exists( $dir . $filename ) ) {
			return $base . rawurlencode( $filename );
		}
	}

	return null;
}

/**
 * Link for a grade level under a subject page (lessons hub).
 *
 * Prefers a published child page using the Markimatics Grade template,
 * then any child / path match for the grade slug.
 *
 * @param int    $subject_id Subject page ID.
 * @param string $grade_slug Grade slug (e.g. grade-1).
 * @return string
 */
function markimatics_get_grade_url( $subject_id, $grade_slug ) {
	$grade_slug = sanitize_title( $grade_slug );
	$subject_id = (int) $subject_id;

	$children = get_pages(
		array(
			'parent'      => $subject_id,
			'sort_column' => 'menu_order',
		)
	);

	foreach ( $children as $child ) {
		if ( $child->post_name !== $grade_slug ) {
			continue;
		}

		$template = get_page_template_slug( $child->ID );
		if ( 'page-grade.php' === $template || '' === $template ) {
			return get_permalink( $child );
		}
	}

	$subject_path = get_page_uri( $subject_id );
	if ( $subject_path ) {
		$page = get_page_by_path( trailingslashit( $subject_path ) . $grade_slug );
		if ( $page instanceof WP_Post ) {
			return get_permalink( $page );
		}
	}

	foreach ( $children as $child ) {
		$child_grade = get_post_meta( $child->ID, 'mk_grade_slug', true );
		if ( $child_grade && sanitize_title( $child_grade ) === $grade_slug ) {
			return get_permalink( $child );
		}
	}

	return '#';
}

/**
 * Enqueue parent theme styles (skipped on Markimatics templates).
 */
function markimatics_child_enqueue_parent_styles() {
	if ( markimatics_is_template() ) {
		return;
	}

	wp_enqueue_style(
		'astra-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'astra' )->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'markimatics_child_enqueue_parent_styles' );

/**
 * Remove Astra front-end assets on Markimatics templates to avoid style conflicts.
 */
function markimatics_dequeue_astra_on_landing() {
	if ( ! markimatics_is_template() ) {
		return;
	}

	$astra_styles = array(
		'astra-theme-css',
		'astra-theme-dynamic',
		'astra-addon-css',
		'astra-menu-animation',
	);

	foreach ( $astra_styles as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'markimatics_dequeue_astra_on_landing', 99 );

/**
 * Enqueue Markimatics template assets.
 */
function markimatics_enqueue_assets() {
	if ( ! markimatics_is_template() ) {
		return;
	}

	$base = get_stylesheet_directory_uri() . '/markimatics';
	$ver  = '1.3.0';

	wp_enqueue_style(
		'markimatics-variables',
		$base . '/css/variables.css',
		array(),
		$ver
	);

	wp_enqueue_style(
		'markimatics-main',
		$base . '/css/main.css',
		array( 'markimatics-variables' ),
		$ver
	);

	wp_enqueue_script(
		'markimatics-main',
		$base . '/js/main.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'markimatics_enqueue_assets' );

/**
 * Add mk-body class on Markimatics templates.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function markimatics_body_class( $classes ) {
	if ( markimatics_is_template() ) {
		$classes[] = 'mk-body';
	}

	return $classes;
}
add_filter( 'body_class', 'markimatics_body_class' );
