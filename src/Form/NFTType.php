<?php

namespace App\Form;

use App\Entity\NFT;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NFTType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('img')
            ->add('description')
            ->add('launchDate')
            ->add('launchPriceEth')
            ->add('launchPriceEuro')
            ->add('collectionNFT', EntityType::class, [
                'class' => 'App\Entity\collectionNFT',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('categoryNFTs', EntityType::class, [
                'class' => 'App\Entity\categoryNFT',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NFT::class,
        ]);
    }
}
