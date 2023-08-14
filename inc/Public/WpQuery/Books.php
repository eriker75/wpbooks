<?php

namespace Inc\Public\WpQuery;

class Books {
    
    public function __construct() {
        // Add the ACF field group
        $this->add_acf_field_group();
    }

    public function get_all() {
        // Get all books
        $books = get_posts([
            'post_type' => 'books',
        ]);

        // Loop through the books and get the authors
        foreach ($books as $book) {
            $book->authors = wp_get_object_terms($book->ID, 'authors');
        }

        return $books;
    }

    public function get_all_by_filters() {
        // Get the user input
        $args = [
            'post_type' => 'books',
        ];

        if ($title = filter_input(INPUT_GET, 'title')) {
            $args['s'] = $title;
        }

        if ($author = filter_input(INPUT_GET, 'author')) {
            $args['author__in'] = array_map('intval', explode(',', $author));
        }

        if ($genre = filter_input(INPUT_GET, 'genre')) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'genres',
                    'terms' => array_map('intval', explode(',', $genre)),
                ],
            ];
        }

        // Get the books
        $books = get_posts($args);

        // Loop through the books and get the authors
        foreach ($books as $book) {
            $book->authors = wp_get_object_terms($book->ID, 'authors');
        }

        return $books;
    }

    public function get_all_by_reviews() {
        // Get the user input
        $args = [
            'post_type' => 'books',
            'meta_query' => [
                [
                    'key' => 'star_rating',
                    'value' => [2, 3, 4, 5],
                    'compare' => '>=',
                ],
            ],
        ];

        // Get the books
        $books = get_posts($args);

        // Loop through the books and get the authors
        foreach ($books as $book) {
            $book->authors = wp_get_object_terms($book->ID, 'authors');
        }

        return $books;
    }

    public function get_by_genres() {
        // Get the user input
        $args = [
            'post_type' => 'books',
            'tax_query' => [
                [
                    'taxonomy' => 'genres',
                    'terms' => filter_input(INPUT_GET, 'genres'),
                ],
            ],
        ];

        // Get the books
        $books = get_posts($args);

        // Loop through the books and get the authors
        foreach ($books as $book) {
            $book->authors = wp_get_object_terms($book->ID, 'authors');
        }

        return $books;
    }

    public function get_all_by_authors() {
        // Get the user input
        $args = [
            'post_type' => 'books',
            'author__in' => array_map('intval', explode(',', filter_input(INPUT_GET, 'authors'))),
        ];

        // Get the books
        $books = get_posts($args);

        // Loop through the books and get the authors
        foreach ($books as $book) {
            $book->authors = wp_get_object_terms($book->ID, 'authors');
        }

        return $books;
    }

    public function get_authors() {
        // Get all authors
        $authors = get_posts([
            'post_type' => 'authors',
        ]);

        // Loop through the authors and get the books they wrote
        foreach ($authors as $author) {
            $author->books = wp_get_object_terms($author->ID, 'books');
        }

        return $authors;
    }

    public function get_by_id($id) {
        // Get the book by ID
        $book = get_post($id);

        // Get the authors of the book
        $book->authors = wp_get_object_terms($book->ID, 'authors');

        return $book;
    }

    public function get_by_title($title) {
        // Get the books by title
        $books = get_posts([
            'post_type' => 'books',
            's' => $title,
        ]);

        // Loop through the books and get the authors
        foreach ($books as $book) {
            $book->authors = wp_get_object_terms($book->ID, 'authors');
        }

        return $books;
    }

    public function get_reviews() {
        // Get all reviews
        $reviews = get_posts([
            'post_type' => 'reviews',
        ]);

        // Loop through the reviews and get the books they are for
        foreach ($reviews as $review) {
            $review->book = get_post($review->meta['book_id']);
        }

        return $reviews;
    }

    private function add_acf_field_group() {
        // Add the ACF field group
        acf_add_field_group([
            'key' => 'books_acf_field_group',
            'title' => 'Books',
            'fields' => [
                [
                    'key' => 'star_rating',
                    'label' => 'Star Rating',
                    'type' => 'number',
                    'min' => 1,
                    'max' => 5,
                ],
                [
                    'key' => 'book_cover',
                    'label' => 'Book Cover',
                    'type' => 'image',
                ],
            ],
        ]);
    }
}