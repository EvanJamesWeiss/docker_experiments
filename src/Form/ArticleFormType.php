<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // The author field (when type is not specified and no options),
        // utilizes the __toString method on the User entity

        // EntityType facilitates data transformation (EntityType > ChoiceType)

        // Required option is powered by the nullable field on the entity (unless field type is defined)

        $builder
            ->add('title', TextType::class, [
                'help' => 'Choose something catchy!'
            ])
            ->add('content')
            ->add('publishedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
//                'choice_label' => 'email', // or...
                'choice_label' => function (User $user) {
                    return sprintf('(%d) %s', $user->getId(), $user->getEmail());
                },
                'placeholder' => 'Choose an Author',
                'choices' => $this->userRepository->findAllEmailAlphabetical(),
                'invalid_message' => 'Symfony is too smart for your hacking!'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Set options for how the form behaves
        $resolver->setDefaults([
            'data_class' => Article::class // Binds the form to the class
        ]);
    }
}