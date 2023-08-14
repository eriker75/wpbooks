<?php 

namespace Inc\Public; 

class AuthorBookRelation {

    public function __construct() {}

    // Update players for a specific team
    function update_book_authors( $players, $team_id ) {
        return $this->update_elements_cpt( $players, 'book_authors', $team_id, 'author_books' );
    }

    // Update teams for a specific player
    public function update_author_books( $teams, $player_id ) {
        return $this->update_elements_cpt( $teams, 'author_books', $player_id, 'book_authors' );
    }

    // Generic update elementes cpt acf relation field
    private function update_elements_cpt( $elements, $field_name, $cpt_id, $field_name_rel ) {
        $global_name = 'is_updating_' . $field_name;

        if ( ! empty( $GLOBALS[ $global_name ] ) ) {
            return $elements;
        }

        // set global variable to avoid infinite loop
        $GLOBALS[ $global_name ] = 1;

        // Add new teams to the players
        if ( is_array( $elements ) ) {
            foreach ( $elements as $element ) {
                $values = get_field( $field_name_rel, $element, false );
                if ( empty( $values ) ) {
                    $values = array();
                }
                if ( in_array( $cpt_id, $values ) ) {
                    continue;
                }
                $values[] = $cpt_id;

                update_field( $field_name_rel, $values, $element );
            }
        }

        // Remove teams to the players
        $old_elements = get_field( $field_name, $cpt_id, false );
        if ( is_array( $old_elements ) ) {
            foreach ( $old_elements as $element ) {
                if ( is_array( $elements ) && in_array( $element, $elements ) ) {
                    continue;
                }
                $values = get_field( $field_name_rel, $element, false );
                if ( empty( $values ) ) {
                    continue;
                }
                $pos = array_search( $cpt_id, $values );
                unset( $values[ $pos ] );

                update_field( $field_name_rel, $values, $element );
            }
        }

        // reset global variable
        $GLOBALS[ $global_name ] = 0;

        return $elements;
    }
}