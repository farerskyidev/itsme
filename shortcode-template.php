<?php
$args = array(
    'post_type' => 'art',
    'posts_per_page' => intval($atts['items']),
    'tax_query' => array(
        'relation' => 'AND',
    ),
    'meta_query' => array(
        array(
            'key'   => 'author',
            'value' => $atts['author'],
            'compare' => 'LIKE'
        ),
    ),
);

if (!empty($atts['music'])) {
    $args['tax_query'][] = array(
        'taxonomy' => 'music',
        'field'    => 'slug',
        'terms'    => $atts['music'],
        'operator' => 'IN',
    );
}
if (!empty($atts['photography'])) {
    $args['tax_query'][] = array(
        'taxonomy' => 'photography',
        'field'    => 'slug',
        'terms'    => $atts['photography'],
        'operator' => 'IN',
    );
}

$query = new WP_Query($args);

if ($query->have_posts()) {
    echo '<div class="art-cards">';

    while ($query->have_posts()) {
        $query->the_post();
        $music_terms = wp_get_post_terms(get_the_ID(), 'music', array('fields' => 'names'));
        $photography_terms = wp_get_post_terms(get_the_ID(), 'photography', array('fields' => 'names'));
        $author = get_post_meta(get_the_ID(), 'author', true);

        echo '<div class="art-card">';
        if (has_post_thumbnail()) {
            echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(null, 'medium') . '</a>';
        }
        echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
        echo '<p class="art-music">Music: ' . implode(', ', $music_terms) . '</p>';
        echo '<p class="art-photography">Photography: ' . implode(', ', $photography_terms) . '</p>';
        echo '<p class="art-author">Author: ' . esc_html($author) . '</p>';
        echo '</div>';
    }

    echo '</div>';

    wp_reset_postdata();
} else {
    echo 'Пости не знайдено.';
}
