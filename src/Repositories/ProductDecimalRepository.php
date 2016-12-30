<?php

/**
 * TechDivision\Import\Product\Ee\Repositories\ProductDecimalRepository
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
use TechDivision\Import\Repositories\AbstractRepository;

/**
 * Repository implementation to load product decimal attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-ee
 * @link      http://www.techdivision.com
 */
class ProductDecimalRepository extends AbstractRepository
{

    /**
     * The prepared statement to load the existing product decimal attribute.
     *
     * @var \PDOStatement
     */
    protected $productDecimalStmt;

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
        $this->productDecimalStmt = $this->getConnection()->prepare($utilityClassName::PRODUCT_DECIMAL);
    }

    /**
     * Load's and return's the varchar attribute with the passed row/attribute/store ID.
     *
     * @param integer $row         The row ID of the attribute
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

        // load and return the product decimal attribute with the passed store/entity/attribute ID
        $this->productDecimalStmt->execute($params);
        return $this->productDecimalStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
