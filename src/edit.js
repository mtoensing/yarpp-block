import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import {
	InspectorControls,
	BlockControls,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	TextControl,
	ToolbarGroup,
	ToolbarButton,
	SelectControl,
	ToggleControl,
	Panel,
	PanelBody,
} from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {

    const blockProps = useBlockProps();

		function updateHeadline( newValue ) {
			setAttributes( { headline: newValue } );
		}

		function updateLevel( newValue ) {
			setAttributes( { level: newValue } );
		}

		function updateImagesize( newValue ) {
			setAttributes( { imgsize: newValue } );
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
								value={ attributes.headline }
								placeholder={ __(
									'Write headline',
									'yarpp_block'
								) }
							/>
							<TextControl
								onChange={ updateImagesize }
								className="imgsize"
								label={ __( 'Image size' ) }
								type="number"
								value={ attributes.imgsize }
								placeholder={ __(
									'Image size',
									'yarpp_block'
								) }
							/>
							<SelectControl
								label={ __( 'Heading level', 'yarpp_block' ) }
								help={ __(
									'Select the heading level',
									'yarpp_block'
								) }
								value={ attributes.level }
								options={ [
									{
										value: 'h1',
										label: __( 'H1', 'yarpp_block' ),
									},
									{
										value: 'h2',
										label: __( 'H2', 'yarpp_block' ),
									},
									{
										value: 'h3',
										label: __( 'H3', 'yarpp_block' ),
									},
									{
										value: 'h4',
										label: __( 'H4', 'yarpp_block' ),
									},
									{
										value: 'h5',
										label: __( 'H5', 'yarpp_block' ),
									},
									{
										value: 'h6',
										label: __( 'H6', 'yarpp_block' ),
									},
								] }
								onChange={ updateLevel }
							/>
							<SelectControl
								label={ __(
									'YARPP block type',
									'yarpp_block'
								) }
								help={ __(
									'Displays 3 posts of the configured type. ',
									'yarpp_block'
								) }
								value={ attributes.blocktype }
								options={ [
									{
										value: 'related',
										label: __(
											'Related posts (default)',
											'yarpp_block'
										),
									},
									{
										value: 'latest',
										label: __(
											'Latest posts excluding related posts',
											'yarpp_block'
										),
									},
								] }
								onChange={ ( blocktype ) =>
									setAttributes( {
										blocktype: blocktype,
									} )
								}
							/>
							<ToggleControl
								label={ __(
									'Open links in new tab.',
									'yarpp_block'
								) }
								help={ __(
									'Adds target="_blank" and rel="noopener" parameters to the links.',
									'yarpp_block'
								) }
								checked={ attributes.targetblank }
								onChange={ () =>
							        setAttributes( {
										targetblank:
											! attributes.targetblank,
									} )
								}
							/>
						</PanelBody>
					</Panel>
				</InspectorControls>
				<BlockControls>
					<ToolbarGroup>
						<ToolbarButton
							className="components-icon-button components-toolbar__control"
							label={ __( 'Update YARPP Block', 'yarpp-block' ) }
							onClick={ () =>
								setAttributes( { updated: Date.now() } )
							}
							icon="update"
						/>
					</ToolbarGroup>
				</BlockControls>
				<ServerSideRender
					block="yarpp-block/list"
					attributes={ attributes }
				/>
			</>
		);
	}