<?php get_header(); ?>

<main class="main">
    <?php echo "<h1>". get_the_title() . "</h1>"; ?>
    <?php the_content(); ?>
</main>
<?php get_footer(); ?>