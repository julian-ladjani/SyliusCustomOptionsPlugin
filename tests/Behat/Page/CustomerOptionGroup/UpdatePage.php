<?php

declare(strict_types=1);

namespace Tests\Brille24\CustomerOptionsPlugin\Behat\Page\CustomerOptionGroup;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;
use Brille24\CustomerOptionsPlugin\Enumerations\CustomerOptionTypeEnum;
use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class UpdatePage extends BaseUpdatePage
{
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(Session $session, array $parameters, RouterInterface $router, string $routeName, TranslatorInterface $translator)
    {
        parent::__construct($session, $parameters, $router, $routeName);

        $this->translator = $translator;
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillField(string $field, string $value)
    {
        $this->getDocument()->fillField($field, $value);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addOption()
    {
        $this->getDocument()->clickLink($this->translator->trans('brille24.form.customer_option_groups.buttons.add_option'));
    }

    /**
     * @param string $name
     * @param int $position
     *
     * @throws ElementNotFoundException
     */
    public function chooseOption(string $name, int $position)
    {
        $selectItems = $this->getDocument()->waitFor(2, function () {
            return $this->getDocument()->findAll('css', 'div[data-form-type="collection"] select');
        });
        $lastSelectItem = end($selectItems);

        if (false === $lastSelectItem) {
            throw new ElementNotFoundException($this->getSession(), 'select', 'css', 'div[data-form-type="collection"] select');
        }

        /** @var NodeElement[] $numberItems */
        $numberItems = $this->getDocument()->findAll('css', 'div[data-form-type="collection"] input[type="number"]');
        $lastNumberItem = end($numberItems);

        if (false === $lastNumberItem) {
            throw new ElementNotFoundException($this->getSession(), 'input', 'css', 'div[data-form-type="collection"] input[type="number"]');
        }

        $lastSelectItem->selectOption($name);
        $lastNumberItem->setValue($position);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addValidator()
    {
        $validatorDivs = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="validators"]');
        $lastValidatorDiv = end($validatorDivs);

        $lastValidatorDiv->clickLink($this->translator->trans('brille24.form.customer_option_groups.buttons.add_validator'));
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addCondition()
    {
        /** @var NodeElement[] $conditionDivs */
        $conditionDivs = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="conditions"]');
        $lastConditionDiv = end($conditionDivs);

        $lastConditionDiv->clickLink($this->translator->trans('brille24.form.validators.buttons.add_condition'));
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addConstraint()
    {
        /** @var NodeElement[] $constraintDivs */
        $constraintDivs = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="constraints"]');
        $lastConstraintDiv = end($constraintDivs);

        $lastConstraintDiv->clickLink($this->translator->trans('brille24.form.validators.buttons.add_constraint'));
    }

    /**
     * @throws ElementNotFoundException
     */
    public function deleteValidator()
    {
        $validatorDivs = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="validators"]');
        $lastValidatorDiv = end($validatorDivs);

        $lastValidatorDiv->clickLink($this->translator->trans('brille24.form.customer_option_groups.buttons.delete_validator'));
    }

    /**
     * @throws ElementNotFoundException
     */
    public function deleteCondition()
    {
        /** @var NodeElement[] $conditionDivs */
        $conditionDivs = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="conditions"]');
        $lastConditionDiv = end($conditionDivs);

        $lastConditionDiv->clickLink($this->translator->trans('brille24.form.validators.buttons.delete_condition'));
    }

    /**
     * @throws ElementNotFoundException
     */
    public function deleteConstraint()
    {
        /** @var NodeElement[] $constraintDivs */
        $constraintDivs = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="constraints"]');
        $lastConstraintDiv = end($constraintDivs);

        $lastConstraintDiv->clickLink($this->translator->trans('brille24.form.validators.buttons.delete_constraint'));
    }

    /**
     * @param string $name
     *
     * @throws ElementNotFoundException
     */
    public function chooseOptionForCondition(string $name)
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="conditions"]');
        $lastConditionDiv = end($conditionDiv);

        $this->selectItemInContainer($lastConditionDiv, $name, $this->translator->trans('brille24.form.validators.fields.customer_option'));
    }

    /**
     * @param string $name
     *
     * @throws ElementNotFoundException
     */
    public function chooseComparatorForCondition(string $name)
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="conditions"]');
        $lastConditionDiv = end($conditionDiv);

        $this->selectItemInContainer($lastConditionDiv, $name, $this->translator->trans('brille24.form.validators.fields.comparator'));
    }

    public function getConditionValueType(string $optionType): ?string
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->waitFor(2, function () {
            return $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="conditions"]');
        });
        $lastConditionDiv = end($conditionDiv);

        return $this->getValueItemType($lastConditionDiv, $optionType);
    }

    /**
     * @param string $name
     *
     * @throws ElementNotFoundException
     */
    public function chooseOptionForConstraint(string $name)
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="constraints"]');
        $lastConditionDiv = end($conditionDiv);

        $this->selectItemInContainer($lastConditionDiv, $name, $this->translator->trans('brille24.form.validators.fields.customer_option'));
    }

    /**
     * @param string $name
     *
     * @throws ElementNotFoundException
     */
    public function chooseComparatorForConstraint(string $name)
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="constraints"]');
        $lastConditionDiv = end($conditionDiv);

        $this->selectItemInContainer($lastConditionDiv, $name, $this->translator->trans('brille24.form.validators.fields.comparator'));
    }

    public function getConstraintValueType(string $optionType): ?string
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->waitFor(2, function () {
            return $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="constraints"]');
        });
        $lastConditionDiv = end($conditionDiv);

        return $this->getValueItemType($lastConditionDiv, $optionType);
    }

    private function selectItemInContainer(NodeElement $container, string $name, string $fieldName)
    {
        $selectItems = $container->findAll('named', [
            'field',
            $fieldName,
        ]);

        $lastSelectItem = end($selectItems);

        if (false === $lastSelectItem) {
            throw new ElementNotFoundException($this->getSession(), 'select', 'css', 'div[data-form-type="collection"][id$="conditions"] select');
        }

        $lastSelectItem->selectOption($name);
    }

    private function getValueItemType(NodeElement $container, string $optionType)
    {
        /** @var NodeElement[] $valueItems */
        $valueItems = $container->findAll('named', [
            'field',
            $this->translator->trans('brille24.form.validators.fields.value' . $this->getValueNameSuffix($optionType)),
        ]);

        $lastValueItem = end($valueItems);

        if (CustomerOptionTypeEnum::isDate($optionType)) {
            $valueItems = $container->findAll('css', 'select[id$="year"]');
            $lastValueItem = end($valueItems);
            $lastValueItem = $lastValueItem->getParent();
        }

        return $lastValueItem->getAttribute('type') ?? $lastValueItem->getTagName();
    }

    public function countValidators()
    {
        $validators = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="validators"] > div > div');

        return count($validators);
    }

    public function getAvailableConditionComparators()
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="conditions"]');
        $lastConditionDiv = end($conditionDiv);

        return $this->getAvailableComparators($lastConditionDiv);
    }

    public function getAvailableConstraintComparators()
    {
        /** @var NodeElement[] $constraintDiv */
        $constraintDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="constraints"]');
        $lastConstraintDiv = end($constraintDiv);

        return $this->getAvailableComparators($lastConstraintDiv);
    }

    private function getAvailableComparators(NodeElement $container)
    {
        /** @var NodeElement[] $selectItems */
        $selectItems = $container->findAll('named', [
            'field',
            $this->translator->trans('brille24.form.validators.fields.comparator'),
        ]);
        $lastSelectItem = end($selectItems);

        /** @var NodeElement[] $optionItems */
        $optionItems = $lastSelectItem->findAll('css', 'option');

        $comparators = [];

        foreach ($optionItems as $optionItem) {
            $comparators[] = $optionItem->getValue();
        }

        return $comparators;
    }

    /**
     * @param $value
     * @param string $optionType
     *
     * @throws ElementNotFoundException
     */
    public function setConditionValue($value, string $optionType)
    {
        /** @var NodeElement[] $conditionDiv */
        $conditionDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="conditions"]');
        $lastConditionDiv = end($conditionDiv);

        $this->setValue($lastConditionDiv, $optionType, $value);
    }

    /**
     * @param $value
     * @param string $optionType
     *
     * @throws ElementNotFoundException
     */
    public function setConstraintValue($value, string $optionType)
    {
        /** @var NodeElement[] $constraintDiv */
        $constraintDiv = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="constraints"]');
        $lastConstraintDiv = end($constraintDiv);

        $this->setValue($lastConstraintDiv, $optionType, $value);
    }

    /**
     * @param NodeElement $container
     * @param string $optionType
     * @param $value
     *
     * @throws ElementNotFoundException
     * @throws \Behat\Mink\Exception\DriverException
     * @throws \Behat\Mink\Exception\UnsupportedDriverActionException
     */
    private function setValue(NodeElement $container, string $optionType, $value)
    {
        $label = $this->translator->trans('brille24.form.validators.fields.value' . $this->getValueNameSuffix($optionType));

        // 1. Find value element
        /** @var NodeElement[] $values */
        $values = $container->findAll('named', [
            'field',
            $label,
        ]);
        $lastValue = end($values);

        // 2. Fill according to $optionType
        if (CustomerOptionTypeEnum::isSelect($optionType)) {
            foreach ($value as $val) {
                $lastValue->selectOption($val, true);
            }
        } elseif (CustomerOptionTypeEnum::isDate($optionType)) {
            $value = new \DateTime($value);

            /** @var NodeElement[] $valueItems */
            $valueItems = $container->findAll('css', 'select[id$="year"]');
            $lastValueItem = end($valueItems);
            $lastValueItem = $lastValueItem->getParent();

            $yearItem = $lastValueItem->find('css', 'select[id$="year"]');
            $monthItem = $lastValueItem->find('css', 'select[id$="month"]');
            $dayItem = $lastValueItem->find('css', 'select[id$="day"]');

            $yearItem->selectOption($value->format('Y'));
            $monthItem->selectOption($value->format('m'));
            $dayItem->selectOption($value->format('d'));
        } elseif ($optionType === CustomerOptionTypeEnum::BOOLEAN) {
            $script = sprintf('$("#%s").prop("checked", %s);', $lastValue->getAttribute('id'), ($value) ? 'true' : 'false');

            $this->getDriver()->executeScript($script);
        } else {
            $lastValue->setValue($value);
        }
    }

    public function setErrorMessage(string $message)
    {
        $validators = $this->getDocument()->findAll('css', 'div[data-form-type="collection"][id$="validators"] > div > div');
        $lastValidator = end($validators);

        $lastValidator->fillField('Message', $message);
    }

    private function getValueNameSuffix(string $optionType)
    {
        $valueSuffix = '.default';
        if ($optionType === CustomerOptionTypeEnum::TEXT) {
            $valueSuffix = '.text';
        } elseif (CustomerOptionTypeEnum::isSelect($optionType)) {
            $valueSuffix = '.set';
        }

        return $valueSuffix;
    }
}
