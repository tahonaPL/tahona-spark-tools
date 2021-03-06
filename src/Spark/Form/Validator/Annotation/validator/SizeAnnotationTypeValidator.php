<?php
/**
 *
 *
 * Date: 17.04.17
 * Time: 10:28
 */

namespace Spark\Form\Validator\Annotation\validator;


use Spark\Form\Validator\Annotation\Size;
use Spark\Utils\Collections;
use Spark\Utils\Objects;
use Spark\Utils\Predicates;
use Spark\Utils\StringUtils;
use Spark\Utils\ValidatorUtils;

class SizeAnnotationTypeValidator implements AnnotationTypeValidator {

    public function getAnnotationClassName() {
        return Size::class;
    }

    public function isValid($obj, $value, $annotation) {

        return StringUtils::isBlank($value)
        || $this->isSizeValueValid($value, $annotation);
    }

    public function getAnnotationValues($annotation) {
        return Collections::builder()
            ->add($annotation->min)
            ->add($annotation->max)
            ->add($annotation->size)
            ->filter(Predicates::notNull())
            ->getList();
    }

    /**
     * @param $value
     * @param $annotation
     * @return bool
     */
    public function isSizeValueValid($value, $annotation) {
        $value = $this->getValue($value);
        return
            (Objects::isNull($annotation->min ) || $value >= $annotation->min)
            && (Objects::isNull($annotation->max ) || $value <= $annotation->max)
            && (Objects::isNull($annotation->size ) || $value == $annotation->size);
    }

    private function getValue($value) {
        if (Objects::isArray($value)) {
            return Collections::size($value);
        }
        if (Objects::isString($value)) {
            return StringUtils::length($value);
        }
        return $value;
    }
}