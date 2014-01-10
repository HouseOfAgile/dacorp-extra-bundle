<?php


namespace Dacorp\ExtraBundle\Form\Type;

use Dacorp\ExtraBundle\Form\Type\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormViewInterface;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array('label' => 'form.label.firstname'))
            ->add('lastname', 'text', array('label' => 'form.label.lastname'))
            ->add('address', new AddressType(), array('required' => false, 'label' => false))
            ->add('email', 'email', array('label' => 'form.label.email'))
            ->add('birthdate', 'birthday', array('label' => 'form.label.birthdate'))
            ->add('avatar', 'form_dacorp_media', array('label' => false, 'mapped' => false, 'editId' => $options['editId'], 'existingFiles' => $options['existingFiles']));
        ;
        ;
        //->add('avatar');
    }

    public function getName()
    {
        return 'user_edit_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       
        $resolver->setDefaults(array(
            'data_class' => 'Dacorp\ExtraBundle\Entity\User',
            'editId' => null,
            'existingFiles' => null
        ));
    }
    
}
