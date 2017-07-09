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
class UserHydrator implements HydratorInterface
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
        if (isset($data['username']) || (! empty($this->class->fieldMappings['username']['nullable']) && array_key_exists('username', $data))) {
            $value = $data['username'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['username']->setValue($document, $return);
            $hydratedData['username'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['password']) || (! empty($this->class->fieldMappings['password']['nullable']) && array_key_exists('password', $data))) {
            $value = $data['password'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['password']->setValue($document, $return);
            $hydratedData['password'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['firstname']) || (! empty($this->class->fieldMappings['firstname']['nullable']) && array_key_exists('firstname', $data))) {
            $value = $data['firstname'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['firstname']->setValue($document, $return);
            $hydratedData['firstname'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['lastname']) || (! empty($this->class->fieldMappings['lastname']['nullable']) && array_key_exists('lastname', $data))) {
            $value = $data['lastname'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['lastname']->setValue($document, $return);
            $hydratedData['lastname'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['email']) || (! empty($this->class->fieldMappings['email']['nullable']) && array_key_exists('email', $data))) {
            $value = $data['email'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['email']->setValue($document, $return);
            $hydratedData['email'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['token']) || (! empty($this->class->fieldMappings['token']['nullable']) && array_key_exists('token', $data))) {
            $value = $data['token'];
            if ($value !== null) {
                $return = (string) $value;
            } else {
                $return = null;
            }
            $this->class->reflFields['token']->setValue($document, $return);
            $hydratedData['token'] = $return;
        }

        /** @Many */
        $mongoData = isset($data['news']) ? $data['news'] : null;
        $return = $this->dm->getConfiguration()->getPersistentCollectionFactory()->create($this->dm, $this->class->fieldMappings['news']);
        $return->setHints($hints);
        $return->setOwner($document, $this->class->fieldMappings['news']);
        $return->setInitialized(false);
        if ($mongoData) {
            $return->setMongoData($mongoData);
        }
        $this->class->reflFields['news']->setValue($document, $return);
        $hydratedData['news'] = $return;
        return $hydratedData;
    }
}