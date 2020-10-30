<?php


namespace App\Form;


use App\Entity\Medida;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', IntegerType::class, [
                'required' => false
            ])
            ->add('description', TextType::class, [])
            ->add('medida', EntityType::class, [
                'class' => Medida::class,
                'choice_label' => function ($medida) {
                    return $medida->getAbreviacion();
                }
            ])
            ->add('quantity', IntegerType::class, [])
            ->add('priceUnit', MoneyType::class, [
                'currency' => 'S/.',
                'scale' => 2,
                'attr' => [
                    'min' => '0.00',
                    'max' => '9999999999.99',
                    'step' => '0.01'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }
}