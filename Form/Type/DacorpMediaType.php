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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class DacorpMediaType extends AbstractType
{
 
public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('editId','hidden',array('data'=>$options['editId'], 'attr' => array('sm-role' => 'edit-id')))
            ->add('existingFiles','hidden',array('data'=>$options['existingFiles'], 'attr' => array('sm-role' => 'existing-files')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
        $resolver->setRequired(array(
            'editId',
            'existingFiles'
        ));
    }


    public function getName()
    {
        return 'form_dacorp_media';
    }

}