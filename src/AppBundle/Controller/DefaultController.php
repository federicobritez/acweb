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

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Doctrine\ORM\Query\ResultSetMapping;

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
     * Render AcWeb page. Carga el panel de Usurio con los servicios que puede reservas
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
        $query = $em->createQuery('SELECT sr FROM AppBundle:HorariosServicio sr');
        $horariosServicio = $query->getResult();

        /*  Las habitaciones , disponibles para hoy
        */  
        $habitaciones = $this->getHabitacionesDisponibles(date("Y-m-d"));


        return $this->render(sprintf('acweb/%s.html.twig', "usuarioReservasServicios"),
            array('serviciosReservables'=>$serviciosReservables,
                  'horariosServicios'=> $horariosServicio,
                  'habitaciones' => $habitaciones));
    }

    /**
     * Render AcWeb page. Recibe los datos del servicio comprado. Genera la factura
     *
     * @Route("/usuarioVerFactura", name="usuario_ver_factura" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function usuarioVerFacturaAction(Request $request){


        $em = $this->getDoctrine()->getManager();
        
        $reserva_id = 35;//$request->get('reserva_id');
        $tipoPago_id = 6;//$request->get('tipo_pago_id');
        $coutas = 6;//$request->get('cant_cuotas');


        /*  El cliente
        */
        $cliente = $em->getRepository('AppBundle:Cliente')->find($this->get('session')->get('cliente_id'));



        $reserva = $em->getRepository('AppBundle:Reserva')->find($reserva_id);

        $tipoPago = $em->getRepository('AppBundle:TipoPago')->find($tipoPago_id);

        $saldo =  array();

        $saldo["subtotal"] = $this->calcularValorReserva($reserva);

        $interes = ($tipoPago->getInteres()/100)* $saldo["subtotal"];
                
        $saldo["interes"] = $interes;

        $saldo["iva"] = 0.21 * $saldo["subtotal"];

        $saldo["total"] = $saldo["subtotal"] + $saldo["interes"]  + $saldo["iva"];



        $serverTime = new \DateTime(date("Y-m-d H:i:s"));




        return $this->render(sprintf('acweb/%s.html.twig', "usuarioVerFactura"),
                                array('reserva' => $reserva, 
                                      'cliente' => $cliente,
                                      'tipoPago'=> $tipoPago,
                                      'detalleSaldo' => $saldo,
                                      'serverTime' => $serverTime));


    }

    /**
    * Libreria de funciones : Calcular Valor de una Reserva
    *
    *
    * @param Reserva $request
    *
    * @return var float
    */

    public function calcularValorReserva($reserva){

        /*El valor se calcula:
            Total = ((V.unitarioServicio)*CantPersonasReserva)*Cantidad de Dias  
        */
        if( $reserva == null){
            return -1;
        }

        //Cantidad de dias :
        $intervalo = $reserva->getFechaDesde()->diff($reserva->getFechaHasta());

        $dias = intval($intervalo->format('%R%a'))+1; //Sumamos un dia mas porque 

        $precioUnitario = $reserva->getServicio()->getValorUnitario();
        $cantPersonas = $reserva->getCantPersonas();

        return $precioUnitario*$dias*$cantPersonas;

    }

    /**
    * Libreria de funciones : Devuelve Habitaciones sin ocupar para una fecha específica
    *
    *
    * @param string fecha $fecha (Y-m-d)
    *
    * @return array de  Habitaciones 
    */


    public function getHabitacionesDisponibles($fecha){

        /*
        Select hh.* from ecoturismo.reserva rr 
        right join ecoturismo.reservas_habitaciones  rh ON  rr.id = rh.reserva_id AND rr.fecha_desde >= "2016-03-17"
        right join ecoturismo.habitaciones hh ON rh.habitaciones_id = hh.id
        WHERE rh.habitaciones_id is null;

        Select * from ecoturismo.habitaciones hh 
        left join ecoturismo.reservas_habitaciones rh ON  hh.id = rh.habitaciones_id
        left join ecoturismo.reserva rr ON  rh.reserva_id = rr.id AND rr.fecha_desde >= "2016-03-17"
        WHERE rh.habitaciones_id IS NULL;

        */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('hh')->from('AppBundle:Habitaciones','hh')->leftJoin('AppBundle:ReservasHabitaciones','rh','WITH','hh.id = rh.habitaciones')->leftJoin('AppBundle:Reserva','rr','WITH','rr.fechaDesde >= :fecha')->where('rh.habitaciones IS NULL')->setParameter('fecha','2016-03-17');

        $habitacionesDisponibles = $qb->getQuery()->getResult();

        return $habitacionesDisponibles;
    }




    /**
    * Ajax Reservas
    *
    * @Route("/ajaxServicios/estadoReserva", name="ajax_cambio_estado_reserva")
    *
    * @param Request $request
    *
    * @return Response
    */

    public function ajaxEstadoReservaAction(Request $request){

        $em = $this->getDoctrine()->getManager();     

      $id_estado = $request->get("id_estado");
      $id_reserva = $request->get("id_reserva");
      $respuesta="";    
      /*Obtengo la reserva*/
      $reserva = $this->getDoctrine()->getRepository('AppBundle:Reserva')->find($id_reserva);


      if($reserva == null){
        $respuesta= "ERROR";
      }
      else{

        $estadoReserva = $this->getDoctrine()->getRepository('AppBundle:EstadoReserva')->find($id_estado);
        $reserva->setEstadoReserva($estadoReserva);
        $em->persist($reserva); $em->flush();
        $respuesta= "OK";
      }


       return new JsonResponse(array('mje' => $respuesta));
    }
    

    /**
    * Ajax Pagos
    *
    * @Route("/ajaxServicios/pagorReserva", name="ajax_pagar_reserva")
    *
    * @param Request $request
    *
    * @return Response
    */

    public function ajaxPagarReservaAction(Request $request){

        $em = $this->getDoctrine()->getManager();           
        $id_reserva = $request->get("id_reserva");
        $id_tipopago = $request->get("id_tipopago");
        $montoTotal = $request->get("monto_abonado");
        $monto_abonado = $request->get("monto_abonado");

        $respuesta="";  

        /*Obtengo la reserva*/
        $reserva = $this->getDoctrine()->getRepository('AppBundle:Reserva')->find($id_reserva);

        if($reserva == null){
            $respuesta= "ERROR";
        }
        else{
            $tipoPago = $this->getDoctrine()->getRepository('AppBundle:TipoPago')->find($id_tipopago);

            $consumosCliente = new ConsumosCliente();
            $consumosCliente->setCliente($reserva->getCliente());
            $consumosCliente->setServicio($reserva->getServicio());
            $consumosCliente->setMontoAbonado($monto_abonado);
            $consumosCliente->setSaldo($montoTotal-$monto_abonado);
            $consumosCliente->setTipoPago($tipoPago);
            $consumosCliente->setFecha(new \DateTime(date("Y-m-d H:i:s")));
            $consumosCliente->setReserva($reserva);

            $em->persist($consumosCliente);

            $em->flush();

            $respuesta= "OK";
        }

       return new JsonResponse(array('mje' => $respuesta));
    }

    /**
    * Ajax Reservas
    *
    * @Route("/ajaxServicios/editarCliente", name="ajax_cliente_editar")
    *
    * @param Request $request
    *
    * @return Response
    */

    public function ajaxEditarClienteAction(Request $request){

        $em = $this->getDoctrine()->getManager();           

        $idCliente = $request->get("id_cliente");

        $nombre = $request->get("nombre");
        $apellido = $request->get("apellido");
        $dni = $request->get("dni");
        $telefono1 = $request->get("telefono1");
        $telefono2 = $request->get("telefono2");
        $correo = $request->get("correo");
        $pais = $request->get("pais");
        $provincia = $request->get("provincia");
        $localidad = $request->get("localidad");
        
        $respuesta="";

        if($idCliente == null ){
            $cliente = new Cliente();
        }
        else{
            $cliente = $this->getDoctrine()->getRepository('AppBundle:Cliente')->find($idCliente);  
        }

         
        if($cliente == null){
            $respuesta= "ERROR";
        }
        else{

            $cliente->setNombre($nombre);
            $cliente->setApellido($apellido);
            $cliente->setDni($dni);
            $cliente->setTelefono1($telefono1);
            $cliente->setTelefono2($telefono2);
            $cliente->setCorreo($correo);
            $cliente->setPais($pais);
            $cliente->setProvincia($provincia);
            $cliente->setCiudad($localidad);

            $em->persist($cliente); 
            $em->flush();
            $respuesta= "OK";
        }

       return new JsonResponse(array('mje' => $respuesta));
    }

    /**
    * Ajax Reservas
    *
    * @Route("/ajaxServicios/habitacionesDisponibles", name="ajax_habitaciones_disponibles")
    *
    * @param Request $request
    *
    * @return Response
    */

    public function ajaxHabitacionesDisponibesAction(Request $request){

      $fechaArribo = $request->get("fecha_inicio");
      //$fechaSalida = $request->get("fecha_fin");

      
      $habitacionesDisponibles = $this->getHabitacionesDisponibles($fechaArribo);

      $encoders = array(new JsonEncoder());
      $normalizers = array(new ObjectNormalizer());

      $serializer = new Serializer($normalizers, $encoders);

      $jsonHabitaciones = $serializer->serialize($habitacionesDisponibles, 'json');
      

      return new JsonResponse(array('habitaciones' => $jsonHabitaciones));
    }

    /**
    * Ajax Reservas
    *
    * @Route("/ajaxServicios/horarioServicio", name="ajax_horario_servicio")
    *
    * @param Request $request
    *
    * @return Response
    */
    public function ajaxHorarioServicioAction(Request $request){

      $idServicio = $request->get("id_servicio");

      $horarios  = $this->getDoctrine()->getRepository('AppBundle:HorariosServicio')->findBy(array('servicio_id'=>$idServicio));

      $encoders = array(new JsonEncoder());
      $normalizers = array(new ObjectNormalizer());

      $serializer = new Serializer($normalizers, $encoders);

      $jsonHorarios = $serializer->serialize($horarios, 'json');

      return new JsonResponse(array('horarios' => $jsonHabitaciones));  
    }


















}
