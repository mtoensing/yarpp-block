import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, BlockControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { TextControl } from '@wordpress/components';
import { ToolbarGroup, ToolbarButton, SelectControl ,Panel, PanelBody } from '@wordpress/components';

registerBlockType('yarpp-block/list', {
  title: __('List YARPP Block', 'yarpp_block'),
  category: 'layout',
  icon: 'ellipsis',
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
    }, 
    headline: {
      type: 'string',
      default: "Related posts"
    },
    level: {
      type: 'string',
      default: "h3"
    }
	},
  edit: function(props) {

    function updateHeadline( newValue ) {
      props.setAttributes( { headline: newValue } );
    }

    function updateLevel( newValue ) {
      props.setAttributes( { level: newValue } );
    }

    return (
    <>
    <InspectorControls>
      <Panel>
        <PanelBody>
            <TextControl 
              onChange={ updateHeadline }
              className="headline"
              label={ __( 'Headline' ) }
              value={ props.attributes.headline }
              placeholder={ __( 'Write headline', 'yarpp_block' ) }
            />
            <SelectControl
							label={ __('Heading level', 'yarpp_block') }
              help= { __('Select the heading level', 'yarpp_block') }
							value={ props.attributes.level }
							options={ [
								{ value: 'h1', label: __('H1', 'yarpp_block') },
								{ value: 'h2', label: __('H2', 'yarpp_block') },
                { value: 'h3', label: __('H3', 'yarpp_block') },
                { value: 'h4', label: __('H4', 'yarpp_block') },
                { value: 'h5', label: __('H5', 'yarpp_block') },
                { value: 'h6', label: __('H6', 'yarpp_block') },
							] }
							onChange={ updateLevel }
						/>
            <SelectControl
							label={ __('YARPP block type', 'yarpp_block') }
              help= { __('Displays 3 posts of the configured type. ', 'yarpp_block') }
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
