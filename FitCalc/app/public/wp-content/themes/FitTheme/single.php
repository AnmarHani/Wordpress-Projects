<?php get_header(); ?>

<?php

$args = array(
    'post_type' => 'Field', // Replace 'custom' with the actual name of your custom post type
    'posts_per_page' => -1 // Adjust the number of posts per page as needed
);

// The Query
$the_query = new WP_Query($args);

// The Loop
if ($the_query->have_posts()) {
    while ($the_query->have_posts()) : $the_query->the_post();
?>
        <p><?php the_title(); ?></p>
        <h1><?php echo get_field("label"); ?></h1>
        <p><?php the_content(); ?></p>
<?php
    endwhile;
}
?>

<?php get_footer(); ?>