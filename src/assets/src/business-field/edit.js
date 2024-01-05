/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InnerBlocks } from '@wordpress/editor'; // or wp.editor
import { SelectControl, PanelRow, PanelBody } from '@wordpress/components';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

import ServerSideRender from '@wordpress/server-side-render';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes: { select_field }, setAttributes } ) {
        const blockProps = useBlockProps();
        const onChangeField = ( new_value ) => {
            setAttributes( {
                select_field: new_value
            } );
        }
	// TODO: Support editing / adding marker info (e.g. excerpt)
	return (
            <>
            <InspectorControls key="setting">
                <PanelBody title={ __('Field Settings', 'acf-business-directory') } initialOpen={ true } >
                        <SelectControl
                            label={ __('Select Field', 'acf-business-directory') }
                            value={ select_field }
                            onChange={ onChangeField }
                            options={[
                                { label: __('Email', 'acf-business-directory'), value: 'email' },
                                { label: __('Phone', 'acf-business-directory'), value: 'phone' },
                                { label: __('Website', 'acf-business-directory'), value: 'website' },
                                { label: __('Address', 'acf-business-directory'), value: 'address' },
                                { label: __('Hours', 'acf-business-directory'), value: 'hours' },
                                { label: __('Map', 'acf-business-directory'), value: 'map' },
                                { label: __('Gallery', 'acf-business-directory'), value: 'photos' },
                            ]}
                        />
                </PanelBody>
            </InspectorControls>
            <div { ...blockProps }>
					<InnerBlocks />
                    <ServerSideRender
                            block="acf-business-directory/business-field"
                            attributes={ { select_field: select_field } }
                    />
            </div>
            </>
	);
}
