<?php


namespace Dacorp\ExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormViewInterface;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SingleImageFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('editId', 'hidden', array('mapped' => false, 'data' => $options['editId']))
            ->add('attachments', 'form_dacorp_media', array('label' => 'add Image', 'mapped' => false, 'editId' => $options['editId'], 'existingFiles' => $options['existingFiles']));


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'editId' => null,
            'existingFiles' => null
        ));
    }

    public function getName()
    {
        return 'form_simple_image';
    }
    
}
