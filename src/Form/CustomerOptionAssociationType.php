<?php

/**
 * This file is part of the Brille24 customer options plugin.
 *
 * (c) Brille24 GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Brille24\SyliusCustomerOptionsPlugin\Form;

use Brille24\SyliusCustomerOptionsPlugin\Entity\CustomerOptions\CustomerOption;
use Brille24\SyliusCustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionAssociation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CustomerOptionAssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('option', EntityType::class, [
                'class'        => CustomerOption::class,
                'placeholder'  => 'brille24.form.customer_option_groups.select',
                'required'     => true,
                'choice_label' => 'name',
                'label'        => 'brille24.ui.customer_options',
            ])
            ->add('position', IntegerType::class, ['label' => 'sylius.ui.position']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'error_bubbling' => true,
            'data_class'     => CustomerOptionAssociation::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'brille24_customer_option_association_choice';
    }
}
