<?php

/**
 * TechDivision\Import\Product\Ee\Repositories\ProductDatetimeRepository
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Ee\Repositories;

use TechDivision\Import\Product\Ee\Utils\MemberNames;

/**
 * Repository implementation to load product datetime attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-ee
 * @link      http://www.techdivision.com
 */
class ProductDatetimeRepository extends \TechDivision\Import\Product\Repositories\ProductDatetimeRepository
{

    /**
     * The prepared statement to load the existing product datetime attribute.
     *
     * @var \PDOStatement
     */
    protected $productDatetimeStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // load the utility class name
        $utilityClassName = $this->getUtilityClassName();

        // initialize the prepared statements
        $this->productDatetimeStmt = $this->getConnection()->prepare($utilityClassName::PRODUCT_DATETIME);
    }

    /**
     * Load's and return's the varchar attribute with the passed row/attribute/store ID.
     *
     * @param integer $rowId       The row ID of the attribute
     * @param integer $attributeId The attribute ID of the attribute
     * @param integer $storeId     The store ID of the attribute
     *
     * @return array|null The varchar attribute
     */
    public function findOneByRowIdAndAttributeIdAndStoreId($rowId, $attributeId, $storeId)
    {

        // prepare the params
        $params = array(
            MemberNames::ROW_ID        => $rowId,
            MemberNames::STORE_ID      => $storeId,
            MemberNames::ATTRIBUTE_ID  => $attributeId
        );

        // load and return the product datetime attribute with the passed store/entity/attribute ID
        $this->productDatetimeStmt->execute($params);
        return $this->productDatetimeStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
