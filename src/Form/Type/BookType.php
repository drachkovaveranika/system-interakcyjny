<?php

/**
 * Book type.
 */

namespace App\Form\Type;

use App\Entity\Book;
use App\Entity\Catalog;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookType.
 */
class BookType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => '%title%',
                'label_translation_parameters' => [
                    '%title%' => 'Tytuł',
                ],
                'required' => true,
                'attr' => ['min_length' => 5],
            ]
        );
        $builder->add(
            'author',
            TextType::class,
            [
                'label' => '%author%',
                'label_translation_parameters' => [
                    '%author%' => 'Autor',
                ],
                'required' => true,
                'attr' => ['min_length' => 5],
            ]
        );
        $builder->add(
            'catalog',
            EntityType::class,
            [
                'class' => Catalog::class,
                'choice_label' => function ($catalog): string {
                    return $catalog->getName();
                },
                'label' => '%catalog%',
                'label_translation_parameters' => [
                    '%catalog%' => 'Katalog',
                ],
                'required' => true,
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Book::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'book';
    }
}
