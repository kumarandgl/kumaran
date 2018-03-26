<?php

namespace Sampleapi\Sampleapi\Api;

interface CustomRepositoryInterface
{
    /**
     * Create custom Api.
     *
     * @param \Sampleapi\Sampleapi\Api\Data\CustomDataInterface $entity
     * @return \Sampleapi\Sampleapi\Api\Data\CustomDataInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function create(\Sampleapi\Sampleapi\Api\Data\CustomDataInterface $entity);
    
    /**
     * Update custom Api.
     *
     * @param \Sampleapi\Sampleapi\Api\Data\CustomDataInterface $entity
     * @return \Sampleapi\Sampleapi\Api\Data\CustomDataInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function update(\Sampleapi\Sampleapi\Api\Data\CustomDataInterface $entity);
    
    /**
     * Get custom Api.
     *
     * @param int $id
     * @return \Sampleapi\Sampleapi\Api\Data\CustomDataInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($id);
    
    /**
     * Delete custom Api.
     *
     * @param int $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete($id);
}