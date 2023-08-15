<?php

$template = [
	[
		'core/heading',
		[
			'level'     => 6,
			'content'   => '<strong>Title</strong>',
			'align'     => 'center',
			'className' => 'card-heading'
		]
	],
	[ 'core/paragraph', [ 'content' => 'Description', 'align' => 'center' ] ],
	[ 'core/button', [ 'content' => 'Get in touch', 'align' => 'center' ] ],
	[ 'core/social-links', [ 'align' => 'center' ] ],
];

$allowed_blocks = [ 'core/heading', 'core/paragraph', 'core/button', 'core/social-links' ];

?>
<div class="col-md-9 col-xs-12" style="min-height:500px">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <InnerBlocks
                    template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>"
		            allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
                    templateLock="all"
                />
            </div>
        </div>
    </div>
</div>