<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dacorp\ExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location','text',array('label'=>'form.label.location'))
            ->add('street', 'text', array('label' => 'form.label.street'))
            ->add('streetNr', 'text', array('label' => 'form.label.street-no'))
            ->add('zipcode', 'number', array('label' => 'form.label.zipcode'));
    }

    public function getName()
    {
        return 'address_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dacorp\ExtraBundle\Entity\Address'
        ));
    }

}
