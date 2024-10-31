( function ( blocks, element ) {
    var el = element.createElement;
    blocks.registerBlockType( 'ninjaworkspace-blocks/ninjaworkspace', {
        edit: function () {
            return el( 'div', {}, '[Ninjaworkspace]' );
        },
        save: function () {
            return el( 'div', {}, '[Ninjaworkspace]' );
        },
    } );
} )( window.wp.blocks, window.wp.element );