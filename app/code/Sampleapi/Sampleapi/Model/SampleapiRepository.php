<?php
namespace Sampleapi\Sampleapi\Model;
use Sampleapi\Sampleapi\Api\CustomRepositoryInterface;
use Sampleapi\Sampleapi\Api\Data\CustomDataInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\CouldNotSaveException;

class CustomRepository implements CustomRepositoryInterface
{
    
    public function __construct(
        \Sampleapi\Sampleapi\Api\Data\CustomDataInterfaceFactory $customFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
        ) {
            $this->customFactory=$customFactory;
            $this->_objectManager = $objectManager;
            $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }
    
    public function create(CustomDataInterface $data){
        $customerData=$this->_objectManager->create('Magento\Customer\Model\Customer')->load($data->getCustomerId());
        $productData=$this->_objectManager->create('Magento\Catalog\Model\Product')->load($data->getProductId());
        //Check if customer id exists
        if(!$customerData->getEntityId()){
            throw new InputException(__("Customer ID do not exist",$data->getCustomerId()));
        }
        //Check if product id exists
        elseif(!$productData->getEntityId()){
            throw new InputException(__("Product ID do not exist",$data->getProductId()));
        }
        $customDataArray = $this->extensibleDataObjectConverter
        ->toNestedArray($data, [], 'Sampleapi\Sampleapi\Api\Data\CustomDataInterface');
        //Saving custom data in the table
        $customModel=$this->_objectManager->create('Sampleapi\Sampleapi\Model\Custom');
        $customModel->setData($customDataArray);
        $customModel->save();
        $customId=$customModel->getId();
        $data->setId($customId);
        return $data;
    }
    
    public function update(CustomDataInterface $data){
        $id=$data->getId();
        if(!$this->_objectManager->create('Sampleapi\Sampleapi\Model\Custom')->load($id)->getData()){
            throw new InputException(__("Invalid ID provided",$id));
        }
        else{
            $customerData=$this->_objectManager->create('Magento\Customer\Model\Customer')->load($data->getCustomerId());
            $productData=$this->_objectManager->create('Magento\Catalog\Model\Product')->load($data->getProductId());
            //Check if customer id exists
            if(!$customerData->getEntityId()){
                throw new InputException(__("Customer ID do not exist",$data->getCustomerId()));
            }
            //Check if product id exists
            elseif(!$productData->getEntityId()){
                throw new InputException(__("Product ID do not exist",$data->getProductId()));
            }
            $customDataArray = $this->extensibleDataObjectConverter
            ->toNestedArray($data, [], 'Sampleapi\Sampleapi\Api\Data\CustomDataInterface');
            //Updating custom data in the table
            $customDataArray['id']=$id;
            $customModel=$this->_objectManager->create('Sampleapi\Sampleapi\Model\Custom');
            $customModel->setData($customDataArray);
            $customModel->save();
            $customId=$customModel->getId();
        }
        $data->setId($customId);
        return $data;
    }
    
    public function get($id){
        if(!$this->_objectManager->create('Sampleapi\Sampleapi\Model\Custom')->load($id)->getData()){
            throw new InputException(__("Invalid ID provided",$id));
        }
        else{
            $modelData=$this->_objectManager->create('Sampleapi\Sampleapi\Model\Custom')->load($id)->getData();
        }
        $result=array();
        $result[]=$modelData;
        return $result;
    }
    
    public function delete($id){
        if(!$this->_objectManager->create('Sampleapi\Sampleapi\Model\Custom')->load($id)->getData()){
            throw new InputException(__("Invalid ID provided",$id));
        }
        else{
            $this->_objectManager->create('Sampleapi\Sampleapi\Model\Custom')->load($id)->delete();
            return true;
        }
    }
}