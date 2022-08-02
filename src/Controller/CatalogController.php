<?php
/**
 * Catalog controller.
 */

namespace App\Controller;

use App\Entity\Catalog;
use App\Form\Type\CatalogType;
use App\Service\CatalogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CategoryController.
 */
#[Route('/catalog')]
class CatalogController extends AbstractController
{
    /**
     * Category service.
     */
    private CatalogServiceInterface $catalogService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param CatalogServiceInterface $catalogService Catalog service
     * @param TranslatorInterface     $translator     Translator
     */
    public function __construct(CatalogServiceInterface $catalogService, TranslatorInterface $translator)
    {
        $this->catalogService = $catalogService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'catalog_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->catalogService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('catalog/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Catalog $catalog Catalog
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'catalog_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Catalog $catalog): Response
    {
        return $this->render('catalog/show.html.twig', ['catalog' => $catalog]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'catalog_create', methods: 'GET|POST', )]
    public function create(Request $request): Response
    {
        $catalog = new Catalog();
        $form = $this->createForm(
            CatalogType::class,
            $catalog,
            ['action' => $this->generateUrl('catalog_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->catalogService->save($catalog);

            $this->addFlash(
                'success',
                $this->translator->trans('created successfully')
            );

            return $this->redirectToRoute('catalog_index');
        }

        return $this->render('catalog/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Catalog $catalog Catalog entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'catalog_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Catalog $catalog): Response
    {
        $form = $this->createForm(
            CatalogType::class,
            $catalog,
            [
                'method' => 'GET',
                'action' => $this->generateUrl('catalog_edit', ['id' => $catalog->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->catalogService->save($catalog);

            $this->addFlash(
                'success',
                $this->translator->trans('edited successfully')
            );

            return $this->redirectToRoute('catalog_index');
        }

        return $this->render(
            'catalog/edit.html.twig',
            [
                'form' => $form->createView(),
                'catalog' => $catalog,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Catalog $catalog Catalog entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'catalog_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Catalog $catalog): Response
    {
        $form = $this->createForm(
            FormType::class,
            $catalog,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('catalog_delete', ['id' => $catalog->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->catalogService->delete($catalog);

            $this->addFlash(
                'success',
                $this->translator->trans('deleted successfully')
            );

            return $this->redirectToRoute('catalog_index');
        }

        return $this->render(
            'catalog/delete.html.twig',
            [
                'form' => $form->createView(),
                'catalog' => $catalog,
            ]
        );
    }
}
