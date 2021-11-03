import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, BlockControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { RangeControl } from '@wordpress/components';
import { ToolbarGroup, ToolbarButton, SelectControl, ToggleControl ,Panel, PanelBody, PanelRow } from '@wordpress/components';

registerBlockType('yarpp-block/list', {
  title: __('YARPP Block', 'yarpp_block'),
  category: 'layout',
  icon: 'share-alt',
  supports: {
		align: ['wide', 'full']
	},
  keywords: [ 'YARPP Block' ],
  attributes: {
		use_cache: {
			type: 'boolean',
      default: false
		},
    updated: {
      type: 'number',
      default: 0,
    },
    blocktype: {
      type: 'string',
      default: 'related',
    },
    align: {
      type: 'string',
    }
	},
  edit: function(props) {
    return (
    <>
    <InspectorControls>
      <Panel>
        <PanelBody>
            
            <SelectControl
							label={ __('YARPP block type', 'yarpp_block') }
              help= { __('Displays 3 posts of the configured type.', 'yarpp_block') }
							value={ props.attributes.blocktype }
							options={ [
								{ value: 'related', label: __('Related posts (default)', 'yarpp_block') },
								{ value: 'latest', label: __('Latest posts excluding related posts', 'yarpp_block') },
							] }
							onChange={ ( blocktype ) => props.setAttributes( { blocktype: blocktype } ) }
						/>
          
        </PanelBody>
      </Panel>
    </InspectorControls>
    <BlockControls>
      <ToolbarGroup>
        <ToolbarButton
          className="components-icon-button components-toolbar__control"
          label={__('Update table of contents', 'yarpp-block')}
          onClick={ () => props.setAttributes( { updated: Date.now()} ) }
          icon="update"
        />
      </ToolbarGroup>
  </BlockControls>
  <ServerSideRender block={props.name} attributes={props.attributes} />
  </>
  )
  },
  save: props => {
    return null;
  },
});
