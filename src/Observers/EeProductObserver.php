<?php

/**
 * TechDivision\Import\Product\Ee\Observers\EeProductObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/wagnert/csv-import
 * @link      http://www.appserver.io
 */

namespace TechDivision\Import\Product\Ee\Observers;

use TechDivision\Import\Product\Utils\ColumnKeys;
use TechDivision\Import\Product\Observers\ProductObserver;

/**
 * A SLSB that handles the process to import product bunches.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/wagnert/csv-import
 * @link      http://www.appserver.io
 */
class EeProductObserver extends ProductObserver
{

    /**
     * {@inheritDoc}
     * @see \Importer\Csv\Actions\Listeners\Row\ListenerInterface::handle()
     */
    public function handle(array $row)
    {

        // load the header information
        $headers = $this->getHeaders();

        // query whether or not, we've found a new SKU => means we've found a new product
        if ($this->isLastSku($row[$headers[ColumnKeys::SKU]])) {
            return $row;
        }

        // prepare the date format for the created at date
        $createdAt = date('Y-m-d H:i:s');
        if (isset($row[$headers[ColumnKeys::CREATED_AT]])) {
            if ($cda = \DateTime::createFromFormat($this->getSourceDateFormat(), $row[$headers[ColumnKeys::CREATED_AT]])) {
                $createdAt = $cda->format('Y-m-d H:i:s');
            }
        }

        // prepare the date format for the updated at date
        $updatedAt = date('Y-m-d H:i:s');
        if (isset($row[$headers[ColumnKeys::UPDATED_AT]])) {
            if ($uda = \DateTime::createFromFormat($this->getSourceDateFormat(), $row[$headers[ColumnKeys::UPDATED_AT]])) {
                $updatedAt = $uda->format('Y-m-d H:i:s');
            }
        }

        // load the product's attribute set
        $attributeSet = $this->getAttributeSetByAttributeSetName($row[$headers[ColumnKeys::ATTRIBUTE_SET_CODE]]);

        // initialize the product values
        $sku = $row[$headers[ColumnKeys::SKU]];
        $productType = $row[$headers[ColumnKeys::PRODUCT_TYPE]];
        $attributeSetId = $attributeSet[MemberNames::ATTRIBUTE_SET_ID];

        // prepare the static entity values
        $params = array($entityId, $createdIn, $updatedIn, $sku, $createdAt, $updatedAt, 0, 0, $productType, $attributeSetId);

        // insert the entity and set the entity ID, SKU and attribute set
        $this->setLastEntityId($this->persistProduct($params));
        $this->setAttributeSet($attributeSet);

        // returns the row
        return $row;
    }
}
