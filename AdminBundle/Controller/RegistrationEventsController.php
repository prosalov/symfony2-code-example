<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ISSArt\DataGridBundle\Grid\Field;
use Kitpages\DataGridBundle\Grid\Grid;
use Kitpages\DataGridBundle\Grid\GridConfig;
use AppBundle\Entity\RegistrationEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/registration-events")
 */
class RegistrationEventsController extends Controller
{
    /**
     * @Route("/", name="admin_registration_events_list")
     *
     * @return array
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:RegistrationEvents:index.html.twig', [
            'grid' => $this->getGrid(),
        ]);
    }

    /**
     * @Route("/toggle-is-published/{id}", name="admin_registration_events_toggle_is_published")
     * @ParamConverter("entity", class="AppBundle:RegistrationEvent")
     *
     * @param RegistrationEvent $entity
     * @return RedirectResponse
     */
    public function toggleIsPublishedAction(RegistrationEvent $entity)
    {
        $changeTo = (! $entity->getIsPublished());
        $entity->setIsPublished($changeTo);
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', ($changeTo)
            ? 'admin.registration_event.message.has_been_published'
            : 'admin.registration_event.message.has_been_unpublished');

        return $this->redirect($this->generateUrl('admin_registration_events_list'));
    }

    /**
     * @Route("/new", name="admin_registration_events_new")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $entity = new RegistrationEvent();

        $form = $this->createForm('admin_registration_event', $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'admin.registration_event.message.has_been_added');

            return $this->redirect($this->generateUrl('admin_registration_events_list'));
        }

        return $this->render('AdminBundle:RegistrationEvents:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_registration_events_edit")
     * @ParamConverter("entity", class="AppBundle:RegistrationEvent")
     *
     * @param RegistrationEvent $entity
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(RegistrationEvent $entity, Request $request)
    {
        $form = $this->createForm('admin_registration_event', $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'admin.registration_event.message.has_been_updated');

            return $this->redirect($this->generateUrl('admin_registration_events_list'));
        }

        return $this->render('AdminBundle:RegistrationEvents:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_registration_events_delete")
     * @ParamConverter("entity", class="AppBundle:RegistrationEvent")
     *
     * @param RegistrationEvent $entity RegistrationEvent entity
     * @return RedirectResponse
     */
    public function deleteAction(RegistrationEvent $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'admin.registration_event.message.has_been_deleted');

        return $this->redirect($this->generateUrl('admin_registration_events_list'));
    }

    /**
     * @return Grid
     */
    protected function getGrid()
    {
        $queryBuilder = $this->getDoctrine()->getRepository('AppBundle:RegistrationEvent')->getGridQuery();

        $gridConfig = new GridConfig();
        $gridConfig
            ->setQueryBuilder($queryBuilder)
            ->setCountFieldName('rE.id')
            ->addField(new Field('id', [
                'label'        => 'admin.registration_event.field.id',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['rE.id'],
            ]))
            ->addField(new Field('domain', [
                'label'        => 'admin.registration_event.field.domain',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['rE.domain'],
            ]))
            ->addField(new Field('venue', [
                'label'        => 'admin.registration_event.field.venue',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['rE.venue'],
            ]))
            ->addField(new Field('address', [
                'label'        => 'admin.registration_event.field.address',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['rE.address'],
            ]))
            ->addField(new Field('city.name', [
                'label'        => 'admin.registration_event.field.city',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['cT.name'],
            ]))
            ->addField(new Field('state.name', [
                'label'        => 'admin.registration_event.field.state',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['s.name'],
            ]))
            ->addField(new Field('country.name', [
                'label'        => 'admin.registration_event.field.country',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['c.name'],
            ]))
            ->addField(new Field('postalCode', [
                'label'        => 'admin.registration_event.field.postal_code',
                'sortable'     => true,
                'filterable'   => true,
                'entityFields' => ['rE.postalCode'],
            ]))
            ->addField(new Field('date', [
                'label'               => 'admin.registration_event.field.date',
                'sortable'            => true,
                'filterable'          => true,
                'entityFields'        => ['rE.date'],
                'formatValueCallback' => function($value) { return $value->format('Y-m-d'); }
            ]))
        ;

        return $this->get('kitpages_data_grid.grid_manager')->getGrid($gridConfig, $this->getRequest());
    }
}
