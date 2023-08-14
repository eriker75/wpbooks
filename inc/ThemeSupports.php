<?php

namespace Inc;

class ThemeSupports {

    /**
     * @var ThemeSupports The single instance of this class.
     */
    private static $instance;

    /**
     * @var array $supports The wordpress theme supports
     */
    private $supports;

    /**
     * Constructor
     *
     * This method prevents the class from being instantiated directly.
     */
    private function __construct($supports) {
        $this->supports = $supports;
    }

    /**
     * Get the single instance of this class.
     *
     * @return ThemeSupports The single instance of this class.
     */
    public static function get_instance($supports) {
        if (self::$instance === null) {
            self::$instance = new self($supports);
        }

        return self::$instance;
    }

    /**
     * Add supports
     *
     * This method adds support for the specified features.
     *
     * @param array $features The features to add support for.
     */
    public function add_supports() {
        foreach ($this->supports as $support => $args) {
            add_theme_support($support, $args);
        }
    }

}
