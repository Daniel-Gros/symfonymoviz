<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MovieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }
    public function configureFields(string $pageName): iterable
    {

        $mappingsParams = $this->getParameter('vich_uploader.mappings');

        $moviesImagesPath = $mappingsParams['movies']['uri_prefix']; 

        yield TextField::new('name', 'Nom');
        yield DateField::new('release_date', 'Date de sortie');
        yield TimeField::new('duration', 'Durée du film');
        yield TextareaField::new('synopsis', 'Synopsis');
        yield TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex();
        yield ImageField::new('imageName')->setBasePath($moviesImagesPath)->hideOnForm();
        yield AssociationField::new('directors', 'Réalisateurs');
        yield AssociationField::new('genres', 'Genre');
    }
}
