<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\ParentEntity;
use App\Form\ParentEntityType;
use App\Repository\ParentEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/parent/index", name="parent_index")
     */
    public function index(ParentEntityRepository $per): Response
    {
        $parents = $per->findAll();
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'parents' => $parents,
        ]);
    }

    /**
     * @Route("/parent/create", name="parent_create")
     */
    public function create(EntityManagerInterface $em): Response
    {
        $parent = new ParentEntity();
        $parent->setProp1('parent '.rand());
        $em->persist($parent);
        $em->flush();
        return $this->redirectToRoute('parent_index');
    }

    /**
     * @Route("/parent/update/{id}", name="parent_update")
     * @ParamConverter("parent", class="App:ParentEntity")
     */
    public function update(EntityManagerInterface $em, Request $request, ParentEntity $parent): Response
    {
        $form = $this->createForm(ParentEntityType::class, $parent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $parent = $form->getData();
          $em->flush();
          $this->addFlash('success', 'Updated '.$parent->getProp1());
          return $this->redirectToRoute('parent_update',['id' => $parent->getId()]);
        }
        return $this->render('test/update.html.twig',[
            'form' => $form->createView()
        ]);  
    }

  }
