<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Utils\AscStrategy;
use App\Utils\DescStrategy;
use App\Utils\Treatment;
use App\Utils\Column;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Turbo\TurboBundle;


class UserController extends AbstractController
{

    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepo, Request $request): Response
    {
        $currentPage = intval($request->query->get('page')) ? intval($request->query->get('page')) : 1;
        $size = intval($request->query->get('size')) ? intval($request->query->get('size')) : 10;
        $allowedTableSize = [10,20,50,100];


        if (!in_array($size, $allowedTableSize)){
            //error size not allowed
            $size = 10;
        }

        $alias = 'u';
        $customQueryBuilder = $userRepo->createQueryBuilder($alias);

        $asc = new AscStrategy();
        $desc = new DescStrategy();

        $sortAsc = new Treatment('Croissant', $asc, '<i class="bi bi-sort-alpha-down"></i>', $customQueryBuilder);
        $sortDesc = new Treatment('Décroissant', $desc, '<i class="bi bi-sort-alpha-up"></i>', $customQueryBuilder);

        $basicSort = [
            $sortAsc,
            $sortDesc
        ];

        $tableColumns = [
            new Column('id', '#', 'text-center', true, $basicSort, $request),
            new Column('firstname', 'Firstname', 'text-center', true, $basicSort, $request),
            new Column('lastname', 'Lastname', 'text-center', true, $basicSort, $request),
            new Column('email', 'Email', 'text-center', true, $basicSort, $request),
            new Column('banned', 'Banned', 'text-center', true, $basicSort, $request),
            new Column('created', 'Created', 'text-center', true, $basicSort, $request),
            new Column('updated', 'Updated', 'text-center', true, $basicSort, $request)
        ];

        foreach ($tableColumns as $column) {
            $customQueryBuilder = $column->executeTreatment($customQueryBuilder, $alias);
        }

        $paginator = $userRepo->getPaginator($currentPage, $size, $customQueryBuilder);

        return $this->render('user/index.html.twig', [
            'users' => $paginator,
            'currentPage' => $currentPage,
            'nbPage' => ($paginator->count() / $size),
            'size' => $size,
            'allowedTableSize' => $allowedTableSize,
            'tableColumns' => $tableColumns
        ]);
    }

    #[Route('/toggle-user', name: 'app_user_toggle')]
    public function toggleUser(UserRepository $userRepo, Request $request, EntityManagerInterface $em): Response
    {
        $userId = $request->query->get('user_id');
        $page = $request->query->get('page');

        $user = $userRepo->find($userId);
        $user->setDisabled(!$user->isDisabled());

        $em->persist($user);
        $em->flush();

        if ($request->getPreferredFormat() === TurboBundle::STREAM_FORMAT) {

            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            $type = 'success';
            $message = 'Utilisateur désactivé';

            $this->addFlash('success', $message);

            return $this->render('turbo/refresh_row.html.twig', [
                'rowId' => $userId,
                'message' => $message,
                'type' => $type
            ]);

        }
        $this->addFlash('success', 'suppression réussie');
        return $this->redirectToRoute('app_user', ['page' => $page]);
        
    }

}
