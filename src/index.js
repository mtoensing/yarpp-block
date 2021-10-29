import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, BlockControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { RangeControl } from '@wordpress/components';
import { ToolbarGroup, ToolbarButton, ToggleControl,Panel, PanelBody, PanelRow } from '@wordpress/components';

registerBlockType('yarpp-block/list', {
  title: __('YARPP Block', 'yarpp_block'),
  category: 'layout',
  icon: 'share-alt',
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
	},
  edit: function(props) {
    return (
    <>
    <InspectorControls>
      <Panel>
        <PanelBody>
          <PanelRow>
          <ToggleControl
                label={__('Use cache', 'yarpp-block')}
                help={__('Cache the result for one hour', 'yarpp-block')}
                checked={ props.attributes.use_cache }
                onChange={ () => props.setAttributes( {  use_cache: ! props.attributes.use_cache } ) }
            />
          </PanelRow>
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
