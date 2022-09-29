import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';

registerBlockType( metadata, {
	icon: 'ellipsis',
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
} );
