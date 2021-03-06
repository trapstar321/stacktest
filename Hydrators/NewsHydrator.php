<?php

namespace Hydrators;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\Query\Query;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadataInfo;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class NewsHydrator implements HydratorInterface
{
    private $dm;
    private $unitOfWork;
    private $class;

    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $class)
    {
        $this->dm = $dm;
        $this->unitOfWork = $uow;
        $this->class = $class;
    }

    public function hydrate($document, $data, array $hints = array())
    {
        $hydratedData = array();

        /** @Field(type="int_id") */
        if (isset($data['_id']) || (! empty($this->class->fieldMappings['id']['nullable']) && array_key_exists('_id', $data))) {
            $value = $data['_id'];
            if ($value !== null) {
                $return = (int) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['title']) || (! empty($this->class->fieldMappings['title']['nullable']) && array_key_exists('title', $data))) {
            $value = $data['title'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['title']->setValue($document, $return);
            $hydratedData['title'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['short_desc']) || (! empty($this->class->fieldMappings['short_desc']['nullable']) && array_key_exists('short_desc', $data))) {
            $value = $data['short_desc'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['short_desc']->setValue($document, $return);
            $hydratedData['short_desc'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['text']) || (! empty($this->class->fieldMappings['text']['nullable']) && array_key_exists('text', $data))) {
            $value = $data['text'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['text']->setValue($document, $return);
            $hydratedData['text'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['img_path']) || (! empty($this->class->fieldMappings['img_path']['nullable']) && array_key_exists('img_path', $data))) {
            $value = $data['img_path'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['img_path']->setValue($document, $return);
            $hydratedData['img_path'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['post_date'])) {
            $value = $data['post_date'];
            if ($value === null) { $return = null; } else { $return = \Doctrine\ODM\MongoDB\Types\DateType::getDateTime($value); }
            $this->class->reflFields['post_date']->setValue($document, clone $return);
            $hydratedData['post_date'] = $return;
        }

        /** @ReferenceOne */
        if (isset($data['author'])) {
            $reference = $data['author'];
            if (isset($this->class->fieldMappings['author']['storeAs']) && $this->class->fieldMappings['author']['storeAs'] === ClassMetadataInfo::REFERENCE_STORE_AS_ID) {
                $className = $this->class->fieldMappings['author']['targetDocument'];
                $mongoId = $reference;
            } else {
                $className = $this->unitOfWork->getClassNameForAssociation($this->class->fieldMappings['author'], $reference);
                $mongoId = $reference['$id'];
            }
            $targetMetadata = $this->dm->getClassMetadata($className);
            $id = $targetMetadata->getPHPIdentifierValue($mongoId);
            $return = $this->dm->getReference($className, $id);
            $this->class->reflFields['author']->setValue($document, $return);
            $hydratedData['author'] = $return;
        }
        return $hydratedData;
    }
}