<?php

namespace LarpManager\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

use LarpManager\Form\JoueurForm;
use LarpManager\Form\FindJoueurForm;
use LarpManager\Form\RestaurationForm;
use LarpManager\Form\JoueurXpForm;

/**
 * LarpManager\Controllers\ParticipantController
 *
 * @author kevin
 *
 */
class ParticipantController
{
	/**
	 * Affiche la vue index.twig
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function indexAction(Request $request, Application $app) 
	{
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Joueur');
		$joueurs = $repo->findAll();
		return $app['twig']->render('joueur/index.twig', array('joueurs' => $joueurs));
	}
	
	/**
	 * Gestion des lieu de restauration
	 * @param Request $request
	 * @param Application $app
	 */
	public function adminRestaurationAction(Request $request, Application $app)
	{
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Participant');
		
		
		$availableTaverns = $app['larp.manager']->getAvailableTaverns();
		$tavern = array();
		foreach ($availableTaverns as $key => $tavern)
		{
			$taverns[$key] = array(
				'label' => $tavern,
				'joueurs' => $repo->findAllByTavern($key),
			);
		}
				
		return $app['twig']->render('admin/restauration.twig', array(
				'taverns' => $taverns,
		));
	}
	
	/**
	 * Affiche le formulaire d'ajout d'un joueur
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function addAction(Request $request, Application $app)
	{
		$joueur = new \LarpManager\Entities\Joueur();
	
		$form = $app['form.factory']->createBuilder(new JoueurForm(), $joueur)
			->add('save','submit', array('label' => "Sauvegarder"))
			->getForm();
	
		$form->handleRequest($request);
	
		if ( $form->isValid() )
		{
			$joueur = $form->getData();
			$app['user']->setJoueur($joueur);
			
			$app['orm.em']->persist($app['user']);
			$app['orm.em']->persist($joueur);
			$app['orm.em']->flush();
	
			$app['session']->getFlashBag()->add('success', 'Vos informations ont été enregistrés.');
	
			return $app->redirect($app['url_generator']->generate('homepage'),301);
		}
	
		return $app['twig']->render('joueur/add.twig', array(
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Recherche d'un joueur
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function searchAction(Request $request, Application $app)
	{
		$form = $app['form.factory']->createBuilder(new FindJoueurForm(), array())
			->add('submit','submit', array('label' => 'Rechercher'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$data = $form->getData();
			
			$type = $data['type'];
			$search = $data['search'];

			$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Joueur');
			
			$joueurs = null;
			
			switch ($type)
			{
				case 'lastName' :
					$joueurs = $repo->findByLastName($search);
					break;
				case 'firstName' :
					$joueurs = $repo->findByFirstName($search);
					break;
				case 'numero' :
					// TODO
					break;
			}
			
			if ( $joueurs != null )
			{
				if ( $joueurs->count() == 0 )
				{
					$app['session']->getFlashBag()->add('error', 'Le joueur n\'a pas été trouvé.');
					return $app->redirect($app['url_generator']->generate('homepage'), 301);
				}
				else if ( $joueurs->count() == 1 )
				{
					$app['session']->getFlashBag()->add('success', 'Le joueur a été trouvé.');
					return $app->redirect($app['url_generator']->generate('joueur.detail.orga', array('index'=> $joueurs->first()->getId())),301);
				}
				else
				{
					$app['session']->getFlashBag()->add('success', 'Il y a plusieurs résultats à votre recherche.');
					return $app['twig']->render('joueur/search_result.twig', array(
						'joueurs' => $joueurs,
					));
				}
			}
			
			$app['session']->getFlashBag()->add('error', 'Désolé, le joueur n\'a pas été trouvé.');
		}
		
		return $app['twig']->render('joueur/search.twig', array(
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Detail d'un joueur
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function adminDetailAction(Request $request, Application $app)
	{
		$id = $request->get('index');
	
		$joueur = $app['orm.em']->find('\LarpManager\Entities\Joueur',$id);
	
		if ( $joueur )
		{
			return $app['twig']->render('joueur/admin/detail.twig', array('joueur' => $joueur));
		}
		else
		{
			$app['session']->getFlashBag()->add('error', 'Le joueur n\'a pas été trouvé.');
			return $app->redirect($app['url_generator']->generate('homepage'));
		}	
	}
	
	/**
	 * Met a jours les points d'expérience des joueurs
	 *
	 * @param Application $app
	 * @param Request $request
	 */
	public function adminXpAction(Application $app, Request $request)
	{
		$id = $request->get('index');
	
		$joueur = $app['orm.em']->find('\LarpManager\Entities\Joueur',$id);
	
		$form = $app['form.factory']->createBuilder(new JoueurXpForm(), $joueur)
			->add('update','submit', array('label' => "Sauvegarder"))
			->getForm();
	
		$form->handleRequest($request);
			
		if ( $request->getMethod() == 'POST')
		{
			$newXps = $request->get('xp');
			$explanation = $request->get('explanation');
	
			$personnage = $joueur->getPersonnage();
			if ( $personnage->getXp() != $newXps)
			{
				$oldXp = $personnage->getXp();
				$gain = $newXps - $oldXp;
						
				$personnage->setXp($newXps);
				$app['orm.em']->persist($personnage);
						
				// historique
				$historique = new \LarpManager\Entities\ExperienceGain();
				$historique->setExplanation($explanation);
				$historique->setOperationDate(new \Datetime('NOW'));
				$historique->setPersonnage($personnage);
				$historique->setXpGain($gain);
				$app['orm.em']->persist($historique);
				$app['orm.em']->flush();
				
				$app['session']->getFlashBag()->add('success','Les points d\'expérience ont été sauvegardés');
			}
			
		}
	
		return $app['twig']->render('joueur/admin/xp.twig', array(
				'joueur' => $joueur,
		));
	}
	
	/**
	 * Detail d'un joueur (pour les orgas)
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function detailOrgaAction(Request $request, Application $app)
	{
		$id = $request->get('index');
	
		$joueur = $app['orm.em']->find('\LarpManager\Entities\Joueur',$id);
	
		if ( $joueur )
		{
			return $app['twig']->render('joueur/admin/detail.twig', array('joueur' => $joueur));
		}
		else
		{
			$app['session']->getFlashBag()->add('error', 'Le joueur n\'a pas été trouvé.');
			return $app->redirect($app['url_generator']->generate('homepage'));
		}
	}
	
	/**
	 * Met à jour les informations d'un joueur
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function updateAction(Request $request, Application $app)
	{
		$id = $request->get('index');
	
		$joueur = $app['orm.em']->find('\LarpManager\Entities\Joueur',$id);
	
		$form = $app['form.factory']->createBuilder(new JoueurForm(), $joueur)
			->add('update','submit', array('label' => "Sauvegarder"))
			->getForm();
	
		$form->handleRequest($request);
	
		if ( $form->isValid() )
		{
			$joueur = $form->getData();
	
			$app['orm.em']->persist($joueur);
			$app['orm.em']->flush();
			$app['session']->getFlashBag()->add('success', 'Le joueur a été mis à jour.');
	
			return $app->redirect($app['url_generator']->generate('joueur.detail', array('index'=> $id)));
		}
	
		return $app['twig']->render('joueur/update.twig', array(
				'joueur' => $joueur,
				'form' => $form->createView(),
		));
	}
}
