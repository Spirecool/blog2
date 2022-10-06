<?php

namespace App\Service;

use App\Repository\CategoryRepository;

class NavCategory 
{
    private $CategoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // permet de récupérer toutes les catégories de la bdd
    public function category(): array
    {
        return $this->categoryRepository->findAll();
    }
}