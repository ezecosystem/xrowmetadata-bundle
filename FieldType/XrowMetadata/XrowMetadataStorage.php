<?php
/**
 * File containing the XrowMetadataStorage Converter class
 */

namespace xrow\XrowMetadataBundle\FieldType\XrowMetadata;

use eZ\Publish\Core\FieldType\GatewayBasedStorage;
use eZ\Publish\SPI\Persistence\Content\VersionInfo;
use eZ\Publish\SPI\Persistence\Content\Field;

/**
 * Converter for XrowMetadata field type external storage
 */
class XrowMetadataStorage extends GatewayBasedStorage
{
    /**
     * @see \eZ\Publish\SPI\FieldType\FieldStorage
     */
    public function storeFieldData( VersionInfo $versionInfo, Field $field, array $context )
    {
        if ( empty( $field->value->externalData ) )
        {
            return;
        }

        $gateway = $this->getGateway( $context );

        $contentTypeId = $gateway->getContentTypeId( $field );
        return $gateway->storeFieldData( $field, $contentTypeId );
    }

    /**
     * Populates $field value property based on the external data.
     * $field->value is a {@link eZ\Publish\SPI\Persistence\Content\FieldValue} object.
     * This value holds the data as a {@link eZ\Publish\Core\FieldType\Value} based object,
     * according to the field type (e.g. for TextLine, it will be a {@link eZ\Publish\Core\FieldType\TextLine\Value} object).
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     *
     * @return void
     */
    public function getFieldData( VersionInfo $versionInfo, Field $field, array $context )
    {
        $gateway = $this->getGateway( $context );
        // @todo: This should already retrieve the ContentType ID
        return $gateway->getFieldData( $field );
    }

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\VersionInfo $versionInfo
     * @param array $fieldIds
     * @param array $context
     *
     * @return boolean
     */
    public function deleteFieldData( VersionInfo $versionInfo, array $fieldIds, array $context )
    {
        $gateway = $this->getGateway( $context );
        foreach ( $fieldIds as $fieldId )
        {
            $gateway->deleteFieldData( $fieldId );
        }
    }

    /**
     * Checks if field type has external data to deal with
     *
     * @return boolean
     */
    public function hasFieldData()
    {
        return true;
    }

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     */
    public function getIndexData( VersionInfo $versionInfo, Field $field, array $context )
    {
        return null;
    }
}
