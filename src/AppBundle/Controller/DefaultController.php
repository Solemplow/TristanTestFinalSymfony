<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();
        $sections = $em->getRepository('AppBundle:Section')->findAll();
        return $this->render('default/index.html.twig', array(
            'articles' => $articles,
            'sections' => $sections
        ));
    }
    /**
     * @Route("/section/{id}", name="sections")
     */
    public function sectionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $titre_section = $em->getRepository('AppBundle:Section')->find($id);
        $repository = $em->getRepository('AppBundle:Article');
        $articles = $repository->createQueryBuilder('a')
            ->innerJoin('a.section', 'g')
            ->where('g.id = :idactu')
            ->setParameter('idactu', $id)
            ->getQuery()->getResult();
        $sections = $em->getRepository('AppBundle:Section')->findAll();
        return $this->render('default/section.html.twig', array(
            'titre' => $titre_section,
            'articles' => $articles,
            'sections' => $sections
        ));
    }
}
