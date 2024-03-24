<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Turbo\TurboBundle;
use Utils\TableColumn;
use Utils\Sort;

class UserController extends AbstractController
{

    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepo, Request $request): Response
    {
        $currentPage = intval($request->query->get('page')) ? intval($request->query->get('page')) : 1;
        $size = intval($request->query->get('size')) ? intval($request->query->get('size')) : 10;
        $allowedTableSize = [10,20,50,100];
        $sortCol = $request->query->get('sort-col');
        $sortAction = $request->query->get('sort-action');

        $sortAsc = new \Sort('Croissant', 'asc', '<i class="bi bi-sort-alpha-down"></i>');
        $sortDesc = new \Sort('Décroissant', 'desc', '<i class="bi bi-sort-alpha-up"></i>');

        $basicSort = [
            $sortAsc,
            $sortDesc
        ];

        $tableColumns = [
            new TableColumn('id', '#', 'text-center', true, $basicSort),
            new TableColumn('firstname', 'Firstname', 'text-center', true, $basicSort),
            new TableColumn('lastname', 'Lastname', 'text-center', true, $basicSort),
            new TableColumn('email', 'Email', 'text-center', true, $basicSort),
            new TableColumn('banned', 'Banned', 'text-center', true, $basicSort),
            new TableColumn('created', 'Created', 'text-center', true, $basicSort),
            new TableColumn('updated', 'Updated', 'text-center', true, $basicSort)
        ];

        if (!in_array($size, $allowedTableSize)){
            //error size not allowed
            $size = 10;
        }

        $customQueryBuilder = $userRepo->createQueryBuilder('u');

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
