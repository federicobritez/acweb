<?php
/*
 * DefaultController.php
 *
 * Copyright 2016 Federico Britez <fedebritez@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 *
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;



use AppBundle\Entity\Cliente;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\EstadoReserva;
use AppBundle\Entity\HorariosReserva;
use AppBundle\Entity\ReservasHabitaciones;
use AppBundle\Entity\Habitaciones;
use AppBundle\Entity\TipoPago;
use AppBundle\Entity\ConsumosCliente;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('acweb/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }


    /**
     * Render AcWeb page. Control de acceso por login. El usuario debe tener asociado un cliente 
     *
     * @Route("/login", name="login" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function loginAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $nombre = $request->get('inputUsuario');
        $pass = $request->get('inputPassword');

        $user = $em->getRepository('AppBundle:Usuario')->findOneBy(array('usuario'=>$nombre));

        if($user != null ){

            if($user->getClave() == $pass){

                if($this->get('session') == null){
                   $session = new Session();
                    $session->start();
                }

                $this->get('session')->set('usuario_nombre', $user->getUsuario());
                $this->get('session')->set('usuario_template', $user->getPerfil()->getVista()->getNombrePlantilla());

                $cliente = $user->getCliente();
                if($cliente != null){
                    $this->get('session')->set('cliente_nombre', $cliente->getNombre());
                    $this->get('session')->set('cliente_id', $cliente->getId());
                }

                return $this->redirectToRoute('usuario_panel');
            }       

    }
    
        return $this->render(sprintf('acweb/%s.html.twig', "login"));
    }


    /**
     * Render AcWeb page. Carga el panel de Usurio con información de sus consumos, reservas, facturas, etc
     *
     * @Route("/usuario", name="usuario_panel" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function usuarioPanelAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        /*  El cliente
        */
        $cliente = $em->getRepository('AppBundle:Cliente')->find($this->get('session')->get('cliente_id'));

        /*  Las Reservas
        */
        $qb = $em->createQueryBuilder();
        $qb->select('rr')->from('AppBundle:Reserva', 'rr')->andWhere("rr.cliente=:idcliente")->andWhere("rr.fechaDesde>=:hoy")->setParameter("idcliente",$cliente->getId())->setParameter("hoy", date("Y-m-d 00:00"))->orderBy('rr.fechaDesde','DESC');
        $reservasFuturas = $qb->getQuery()->getResult();

        $qb = $em->createQueryBuilder();
        $qb->select('rr')->from('AppBundle:Reserva', 'rr')->andWhere("rr.cliente=:idcliente")->andWhere("rr.fechaDesde<:hoy")->setParameter("idcliente",$cliente->getId())->setParameter("hoy", date("Y-m-d 00:00"))->orderBy('rr.fechaDesde','DESC');
        $reservasAnteriores = $qb->getQuery()->getResult();


        /*  Los estados de las Reserva
        */
        $estadosReservas = $em->getRepository('AppBundle:EstadoReserva');


        /*  Los reservas impagas
        */
        // Reservas no abonados por el cliente- No esta en ConsumoCliente
        $qb = $em->createQueryBuilder();
        $qb->select('rr')->from('AppBundle:Reserva', 'rr')->leftJoin('AppBundle:ConsumosCliente', 'cc','WITH','rr.id = cc.reserva')->andWhere("cc.reserva IS NULL")->andWhere("rr.cliente=:idcliente")->setParameter("idcliente",$cliente->getId());

        $reservasImpagas = $qb->getQuery()->getResult();

        /*  Los Consumos Reservables del cliente
        */

        $qb = $em->createQueryBuilder();
        $qb->select('cc')->from('AppBundle:ConsumosCliente', 'cc')->where('cc.cliente=:idcliente')->andWhere('cc.servicio IS NOT NULL')->orderBy('cc.fecha','DESC')->setParameter('idcliente',$cliente->getId());

        $consumosReservables = $qb->getQuery()->getResult();

        /*  Los Consumos No Reservables del cliente
        */
        $qb = $em->createQueryBuilder();
        $qb->select('cc')->from('AppBundle:ConsumosCliente', 'cc')->where('cc.cliente=:idcliente')->andWhere('cc.servicio is NULL')->orderBy('cc.fecha','DESC')->setParameter('idcliente',$cliente->getId());
        $consumosNoReservables = $qb->getQuery()->getResult();



        return $this->render(sprintf('acweb/%s.html.twig', "usuarioPanel"),
            array('cliente'=> $cliente,
                  'reservasFuturas'=> $reservasFuturas,
                  'reservasAnteriores'=> $reservasAnteriores,
                  'reservasImpagas' => $reservasImpagas,
                  'consumosReservables'=> $consumosReservables,
                  'consumosNoReservables' => $consumosNoReservables,
                  'estadosReservas' => $estadosReservas));
    }


    /**
     * Render AcWeb page. Carga el panel de Usurio con información de sus consumos, reservas, facturas, etc
     *
     * @Route("/usuarioReservasServicios", name="usuario_reservas_servicios" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function usuarioReservasServiciosAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        /*  Los servicios Reservables
        */

        $query = $em->createQuery('SELECT sr FROM AppBundle:ServiciosReservables sr');
        $serviciosReservables = $query->getResult();

        /*  Los horarios de Servicios
        */
        $query = $em->createQuery('SELECT sr FROM AppBundle:HorariosServicios sr');
        $HorariosServicios = $query->getResult();

        

        return $this->render(sprintf('acweb/%s.html.twig', "usuarioReservasServicios"),array('serviciosReservables'=>$serviciosReservables));

    }












}
