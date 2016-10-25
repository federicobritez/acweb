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
use AppBundle\Entity\FacturaConsumo;

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
     * @Route("/login/{page}", name="login" , defaults={"page"="null"} )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function loginAction(Request $request, $page="null"){

        if($page == "salir"){
            if($this->get('session') != null ){
                $this->get('session')->clear();
                $this->get('session')->invalidate();
                return $this->render(sprintf('acweb/%s.html.twig', "login"),array("estado"=>"desconectado"));
            }
        }
        else{
          if($this->get('session') != null ){
              return $this->render(sprintf('acweb/%s.html.twig', "login"),array("estado"=>"conectado"));
          }

          $em = $this->getDoctrine()->getManager();

          $nombre_email = $request->get('inputUsuario');
          $pass = $request->get('inputPassword');
          $user =  $this->getUsuario(array('usuario' => $nombre_email));

          /*Lo busco por email*/
          if($user == null){
            $cliente = $this->getCliente(array('correo'=> $nombre_email));
            if($cliente != null){
              $user = $this->getUsuario(array('cliente' => $cliente->getId()));  
            }
            else{
              return $this->render(sprintf('acweb/%s.html.twig', "login"),array("estado"=>"invalido"));
            }
          }

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
        }
        return $this->render(sprintf('acweb/%s.html.twig', "login"),array("estado"=>"invalido"));
    }


    /**
     * Render AcWeb page. 
     *
     * @Route("/usuarioEditarCliente", name="usuario_editar_cliente" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function usuarioEditarClienteAction(Request $request){
        /*  El cliente
        */
        $cliente = $this->getCliente(array('id'=> $this->get('session')->get('cliente_id')));

        return $this->render(sprintf('acweb/%s.html.twig', "usuarioEditarCliente"),
                              array("cliente" => $cliente));
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
        $cliente = $this->getCliente(array('id'=> $this->get('session')->get('cliente_id')));

        /*  Las Reservas
        */
        $qb = $em->createQueryBuilder();
        $qb->select('rr')->from('AppBundle:Reserva', 'rr')->andWhere("rr.cliente=:idcliente")->andWhere("rr.fechaDesde>=:hoy")->setParameter("idcliente",$cliente->getId())->setParameter("hoy", date("Y-m-d 00:00"))->orderBy('rr.fechaDesde','ASC');
        $reservasFuturas = $qb->getQuery()->getResult();


        $qb = $em->createQueryBuilder();
        $qb->select('rr')->from('AppBundle:Reserva', 'rr')->andWhere("rr.cliente=:idcliente")->andWhere("rr.fechaDesde<:hoy")->setParameter("idcliente",$cliente->getId())->setParameter("hoy", date("Y-m-d 00:00"))->orderBy('rr.fechaDesde','ASC');
        $reservasAnteriores = $qb->getQuery()->getResult();

        // Paso por session la cantidad de ReservasAnteriores
        $this->get('session')->set('cant_reservas_hist', count($reservasAnteriores));

        /*  Los estados de las Reserva Solo CONFIRMAR - CANCELAR - Y 
        */
        $estadosReservas = $em->getRepository('AppBundle:EstadoReserva')->findBy(array('id' => array(1,3, 4)));;

        /*  Los reservas impagas
        */
        // Reservas no abonados por el cliente- No esta en ConsumoCliente
        $qb = $em->createQueryBuilder();
        $qb->select('rr')->from('AppBundle:Reserva', 'rr')->leftJoin('AppBundle:ConsumosCliente', 'cc','WITH','rr.id = cc.reserva')->andWhere("cc.reserva IS NULL")->andWhere("rr.cliente=:idcliente")->setParameter("idcliente",$cliente->getId());

        $reservasImpagas = $qb->getQuery()->getResult();

        $this->get('session')->set('cant_reservas_pendientes', count($reservasFuturas));

        /*  Los Consumos Reservables del cliente
        */

        $qb = $em->createQueryBuilder();
        $qb->select('cc')->from('AppBundle:ConsumosCliente', 'cc')->where('cc.cliente=:idcliente')->andWhere('cc.servicio IS NOT NULL')->orderBy('cc.fecha','DESC')->setParameter('idcliente',$cliente->getId());

        $consumosReservables = $qb->getQuery()->getResult();

        $this->get('session')->set('cant_consumos', count($consumosReservables));

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

        $aServicios = array();
        foreach ($serviciosReservables as $item) {
            $nombre = str_replace(" ","_",strtolower($item->getServicio()->getNombre()));
            $aServicios[$nombre] = $item;
        }

        /*  Los horarios de Servicios
        */
        $query = $em->createQuery('SELECT sr FROM AppBundle:HorariosServicio sr');
        $horariosServicios = $query->getResult();


        $aHorarios =array();
        foreach ($horariosServicios as $item) {
          $nombre = str_replace(" ","_",strtolower($item->getServicio()->getNombre()));
          if(! array_key_exists($nombre, $aHorarios)){ $aHorarios[$nombre]  = array(); }
          array_push($aHorarios[$nombre], $item);
        }



        /*  Las habitaciones , disponibles para hoy
        */  
        //$habitaciones = $this->getHabitacionesDisponibles(date("Y-m-d"),date("Y-m-d"));
        $habitaciones = $this->getHabitacionesDisponibles("2016-03-18","2016-03-21");


        return $this->render(sprintf('acweb/%s.html.twig', "usuarioReservasServicios"),
            array('servicios'=>$aServicios,
                  'horarios'=> $aHorarios,
                  'habitaciones' => $habitaciones));
    }

    /**
     * Render AcWeb page. Carga el panel de Usurio con los servicios que puede reservas
     *
     * @Route("/usuarioReservar/{page}", name="usuario_reservar" ,defaults={"page"="null"} )
     *
     * @param Request $request
     * @param string  $page    Page name
     *
     * @return Response
     */
    public function usuarioReservarAction(Request $request, $page="null"){


      $em = $this->getDoctrine()->getManager();

      if($page == "cancelar"){
          $idReserva = $request->get("id_reserva");
          $reserva = $this->getReserva(array("id"=>$idReserva));
          if($reserva !=null){
              $reserva->setEstadoReserva($this->getEstadoReserva(array('id' => 4)));
          }
          $em->persist($reserva);
          $em->flush();

      }


      if($page == "null"){
          return $this->redirectToRoute("usuario_panel");
      }

      if(in_array($page, array("posada","paseo_nautico","camping","pesca","guia_pesca","restaurant","cabalgata"))){

          $arrFechas     = explode("-",$request->get("fecha")); // => "21/10/2016 - 28/10/2016"
          if(count($arrFechas) >1){
            $fechaInicio   = trim($arrFechas[0]);
            $fechaFin      = trim($arrFechas[1]);  
          }
          else{
            $fechaInicio   = trim($arrFechas[0]);
            $fechaFin   = $fechaInicio;
          }
          $cant          = $request->get("cant");
          $habitaciones  = $request->get("habitaciones");
          $idServicio    = $request->get("id_servicio");
          $idHorario     = $request->get("horario");
          $cliente       = $this->getCliente(array('id'=> $this->get('session')->get('cliente_id')));

          $servicio = $this->getServicios($idServicio);

          $reserva = new Reserva();
          $reserva->setFechaReserva(new \DateTime(date("Y-m-d H:i:s")));
          $reserva->setFechaDesde(\DateTime::createFromFormat("d/m/Y",$fechaInicio));
          $reserva->setFechaHasta(\DateTime::createFromFormat("d/m/Y",$fechaFin));
          $reserva->setCliente($cliente);
          $reserva->setCantPersonas($cant);
          $reserva->setServicio($servicio);

          //$totalValorReservas += $valorReserva;
            

          /* Seteamos el estado por default que es Esperando Confirmacion*/
          $estadoReserva = $this->getDoctrine()->getRepository('AppBundle:EstadoReserva')->find(3);
          $reserva->setEstadoReserva($estadoReserva);
    
          $em->persist($reserva);
          $em->flush();               

          $rha=array();
          if($habitaciones != null && count($habitaciones) > 0){
            foreach($habitaciones as $idHabit){
                    
                    $habitacion = $this->getDoctrine()->getRepository('AppBundle:Habitaciones')->find($idHabit);
                    $rh = new ReservasHabitaciones();
                    $rh->setReserva($reserva);
                    $rh->setHabitaciones($habitacion);
                    array_push($rha, $rh);
                    $em->persist($rh);
                    $em->flush();
                }
          }          

          $horario = null;
          if($idHorario != null){
            $horario  = $em->getRepository('AppBundle:HorariosServicio')->find($idHorario);
          }
          //
          $horarios_reserva = null;
          if($horario != null){
                  $horarios_reserva = new HorariosReserva();
                $horarios_reserva->setReserva($reserva);
                $horarios_reserva->setHorariosServicio($horario);
                
                //$em->persist($horarios_reserva);
                //$em->flush();       
           }

          $valorReserva = $this->calcularValorReserva($reserva);
          
          $reserva->setValorTotal($valorReserva);
          $em->persist($reserva);
          $em->flush();

          /*
          $aDatos = array("reserva"=>$reserva, "habitaciones" =>$rha ,"horario"=>$horarios_reserva, "request"=>$request);

          return $this->render(sprintf('acweb/%s.html.twig', "debug"),
                                array('request'=>$aDatos));
          */
          return $this->redirectToRoute("usuario_panel");
        
      }

      return $this->redirectToRoute("usuario_panel");
    }


    /**
     * Render AcWeb page. 
     *
     * @Route("/usuarioPagoReserva/{page}", name="usuario_pago_reservar" ,defaults={"page"="null"} )
     *
     * @param Request $request
     * @param string  $page    Page name
     *
     * @return Response
     */
    public function usuarioPagoReservaAction(Request $request, $page="null"){


        if($page == "pagar"){
          $em = $this->getDoctrine()->getManager(); 

          $idReserva      = $request->get("id_reserva");     
          $idTipoPago     = $request->get("id_tipo_pago"); //"tipoPago" => "4_12"
          $cuota          = $request->get("cuotas");
          $nombreApellido = $request->get("nombre");
          $numeroTarjeta  = $request->get("num_tarjeta");
          $mesVencimiento = $request->get("vencimiento_mes");
          $anioVencimiento= $request->get("vencimiento_anio");
          $codSeguridad   = $request->get("cod_seguridad");          

          $montoTotal = $request->get("monto_abonado");
          $monto_abonado = $request->get("monto_abonado");

          $respuesta="";  

          /*Obtengo la reserva*/
          $reserva = $this->getReserva(array("id"=>$idReserva));

          if($reserva == null){
              $respuesta= "ERROR";
               return $this->render(sprintf('acweb/%s.html.twig', "debug"),
                                array('request'=>$request));
          }
          else{

              $tipoPago = $this->getDoctrine()->getRepository('AppBundle:TipoPago')->findOneBy(array('id'=>$idTipoPago));

              $consumosCliente = new ConsumosCliente();
              $consumosCliente->setCliente($reserva->getCliente());
              $consumosCliente->setServicio($reserva->getServicio());
              $consumosCliente->setMontoAbonado($monto_abonado);
              $consumosCliente->setSaldo($montoTotal-$monto_abonado);
              $consumosCliente->setTipoPago($tipoPago);
              $consumosCliente->setFecha(new \DateTime(date("Y-m-d H:i:s")));
              $consumosCliente->setReserva($reserva);


              $em->persist($consumosCliente);$em->flush();


              $facturaConsumo = new FacturaConsumo();
              $facturaConsumo->setNumeroTarjeta( $numeroTarjeta);
              $facturaConsumo->setValidaHasta( $mesVencimiento."-".$anioVencimiento);
              $facturaConsumo->setNombreApellidoTarjeta($nombreApellido);
              $facturaConsumo->setDniTitular($reserva->getCliente()->getDni());
              $facturaConsumo->setCuil("30".$reserva->getCliente()->getDni()."6");
              $facturaConsumo->setCodSeguridad($codSeguridad);
              $facturaConsumo->setConsumosCliente($consumosCliente);


              $em->persist($consumosCliente);$em->flush();

              //Marcamos como confirmada la reserva :

              $reserva->setEstadoReserva($this->getEstadoReserva(array('id'=>1)));

              $em->persist($reserva);$em->flush();

              $aDebug = array('consumo' => $consumosCliente, 'factura' => $facturaConsumo, 'request' => $request);

              return $this->render(sprintf('acweb/%s.html.twig', "usuarioDetallePago"),
                                    array('consumosCliente'=>$consumosCliente,'facturaConsumo'=>$facturaConsumo));
          }
         
        }
        elseif ($page == "null") {
            $idReserva = $request->get("id_reserva");

            $reserva = $this->getReserva(array("id"=>$idReserva));
            $servicio = $reserva->getServicio();

            $formasPago = $this->getFormasPagoServicio(array("servicio" => $servicio->getId()));



            return $this->render(sprintf('acweb/%s.html.twig', "usuarioPagoReserva"),
                                    array('formasDePago'=>$formasPago,
                                          'reserva'=> $reserva));

        }

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

        $idConsumo = $request->get('id_consumo');
        $reserva_id = $request->get('reserva_id');
        $tipoPago_id = $request->get('tipo_pago_id');
        $coutas = $request->get('cant_cuotas');

        /*  El cliente
        */
        $cliente = $em->getRepository('AppBundle:Cliente')->find($this->get('session')->get('cliente_id'));

        $reserva = $em->getRepository('AppBundle:Reserva')->find($reserva_id);

        $tipoPago = $em->getRepository('AppBundle:TipoPago')->find($tipoPago_id);

        $consumo = $em->getRepository('AppBundle:ConsumosCliente')->find($idConsumo);

        $saldo =  array();

        $saldo["subtotal"] = $consumo->getReserva()->getValorTotal();

        $interes = ($consumo->getTipoPago()->getInteres()/100)* ($saldo["subtotal"] * 1.21) ;

        $saldo["interes"] = $interes;

        $saldo["iva"] = 0.21 * $saldo["subtotal"];

        $saldo["total"] = $saldo["subtotal"]* (1.21) + $saldo["interes"] ;

        $serverTime = $consumo->getFecha();//new \DateTime(date("Y-m-d H:i:s"));

        return $this->render(sprintf('acweb/%s.html.twig', "usuarioVerFactura"),
                                array('reserva' => $reserva, 
                                      'cliente' => $cliente,
                                      'tipoPago'=> $tipoPago,
                                      'detalleSaldo' => $saldo,
                                      'serverTime' => $serverTime));
    }

    /**
     * Render AcWeb page. Lista los consumos pagados por el cliente
     *
     * @Route("/usuarioListarFactura", name="usuario_listar_factura" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function usuarioListarFacturaAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $consumosCliente = $em->createQuery('SELECT cc FROM AppBundle:ConsumosCliente cc WHERE cc.cliente ='.$this->get('session')->get('cliente_id').' ORDER BY cc.fecha DESC')->getResult();

        /*
        $saldo =  array();

        $saldo["subtotal"] = $this->calcularValorReserva($reserva);

        $interes = ($tipoPago->getInteres()/100)* $saldo["subtotal"];
                
        $saldo["interes"] = $interes;

        $saldo["iva"] = 0.21 * $saldo["subtotal"];

        $saldo["total"] = $saldo["subtotal"] + $saldo["interes"]  + $saldo["iva"];
        */

        $serverTime = new \DateTime(date("Y-m-d H:i:s"));

        return $this->render(sprintf('acweb/%s.html.twig', "usuarioListaFacturas"),
                                array('consumos' => $consumosCliente));
    }



    /**
     * Render AcWeb page. Consultas por mail
     *
     * @Route("/usuarioEnviarEmail", name="usuario_enviar_email" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function usuarioEnviarEmail(Request $request){
      $asunto       =  $request->get('asunto');
      $emailCliente =  $request->get('email');
      $mensaje      =  $request->get('mensaje');

      $nombreCliente = $this->get('session')->get('cliente_nombre');
      $idCliente = $this->get('session')->get('cliente_id');
      
      $this->sendEmailAction($nombreCliente, $idCliente, 'ac.ecoturismo@gmail.com', $asunto, $mensaje);

      return $this->render(sprintf('acweb/%s.html.twig', "usuarioConsultas"));
    }



/**
     * Render AcWeb page. Consultas por mail
     *
     * @Route("/usuarioConsultas", name="usuario_consultas" )
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function usuarioConsultas(Request $request){
      return $this->render(sprintf('acweb/%s.html.twig', "usuarioConsultas"));
    }

    /**
    * Libreria de funciones : Calcular Valor de una Reserva
    *
    *
    * @param Reserva $request
    *
    * @return var float
    */

    public function calcularValorReserva($reserva,$aHabitaciones = null){

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

        $idServicio = $reserva->getServicio()->getId();

        $cant = 0;

        switch ($idServicio) {
          case 2:
              $habitaciones = $this->getHabitacionesDeReserva($reserva->getId());
              foreach ($habitaciones as $h) {
                  $cant += $h->getValorHabitacion();// Contamos las habitaciones, no las personas
              }
             break;

          default:
            $cant = $reserva->getCantPersonas(); // Los demas son valores por persona
            break;
        }

        return $precioUnitario*$dias*$cant;

    }

    /**
    * Libreria de funciones : Devuelve Habitaciones sin ocupar para una fecha específica
    *
    *
    * @param string fecha $fecha (Y-m-d)
    *
    * @return array de  Habitaciones 
    */


    public function getHabitacionesDisponibles($fechaInicio, $fechaFin){

        /*
        Select hh.* from ecoturismo.reserva rr 
        right join ecoturismo.reservas_habitaciones  rh ON  rr.id = rh.reserva_id AND rr.fecha_desde >= "2016-03-17"
        right join ecoturismo.habitaciones hh ON rh.habitaciones_id = hh.id
        WHERE rh.habitaciones_id is null;

        Select hh.id from ecoturismo.habitaciones hh 
        left join ecoturismo.reservas_habitaciones rh ON  hh.id = rh.habitaciones_id
        left join ecoturismo.reserva rr ON  rh.reserva_id = rr.id AND rr.fecha_desde >= "2016-03-17"
        WHERE rh.habitaciones_id IS NULL;

        */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        //$qb->select('hh')->from('AppBundle:Habitaciones','hh')->leftJoin('AppBundle:ReservasHabitaciones','rh','WITH','hh.id = rh.habitaciones')->leftJoin('AppBundle:Reserva','rr','WITH','rr.fechaDesde >= :fecha')->add('where', $qb->expr()->isNull('rr.id'))->setParameter('fecha','2016-03-28');

        $dbname = $em->getConnection()->getDatabase();

        $sql = ' Select hh.id from '.$dbname.'.habitaciones hh 
        left join '.$dbname.'.reservas_habitaciones rh ON  hh.id = rh.habitaciones_id
        left join '.$dbname.'.reserva rr ON  rh.reserva_id = rr.id AND  rr.fecha_desde BETWEEN :fechaInicio AND :fechaFin
        WHERE rr.id IS NULL; ';

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute(array("fechaInicio" => $fechaInicio , "fechaFin"=>$fechaFin));
        $resulset = $stmt->fetchAll();
        $idsHabitaciones = $resulset;

        $aIds = array();
        foreach ($idsHabitaciones as $key => $value) {  
              array_push($aIds, intval($value['id']));
        }

        $sql = ' Select hh.id from '.$dbname.'.habitaciones hh 
        left join '.$dbname.'.reservas_habitaciones rh ON  hh.id = rh.habitaciones_id
        left join '.$dbname.'.reserva rr ON  rh.reserva_id = rr.id AND  rr.fecha_hasta BETWEEN :fechaInicio AND :fechaFin
        WHERE rr.id IS NULL; ';

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute(array("fechaInicio" => $fechaInicio , "fechaFin"=>$fechaFin));
        $resulset = $stmt->fetchAll();
        $idsHabitaciones = $resulset;

        $bIds = array();
        foreach ($idsHabitaciones as $key => $value) {  
              array_push($bIds, intval($value['id']));
        }

        $xIds = array_intersect($aIds, $bIds);


        $habitacionesDisponibles = $em->getRepository('AppBundle:Habitaciones')->findBy(array('id' => $xIds));

        return $habitacionesDisponibles;
    }


    public function getServicios($id=""){

      return $this->getDoctrine()->getRepository('AppBundle:Servicio')->find($id);

    }

    public function getHorariosServicios($id){

      
      $query = $this->getDoctrine()->createQuery('SELECT hs FROM AppBundle:HorariosServicio WHERE hs.servicioId ='.$id.' ORDER BY hs.hora_inicio, hs.hora_fin asc' );$query->getResult();

      return $query->getResult();
    }

    public function getCliente($array_filtro=array()){

      $em = $this->getDoctrine()->getManager();
      
      return $em->getRepository('AppBundle:Cliente')->findOneBy($array_filtro);
      
    }


    public function getServiciosReservables($array_filtro=array()){
      
      return $this->getDoctrine()->getRepository('AppBundle:ServiciosReservables')->findBy($array_filtro,array('id' => 'ASC'));

    }

    public function getFormasPagoServicio($array_filtro=array()){
      
      return $this->getDoctrine()->getRepository('AppBundle:FormasDePago')->findBy($array_filtro,array('tipoPago' => 'ASC'));

    }

    public function getEstadoReserva($array_filtro=array()){

      $estadoReserva = $this->getDoctrine()->getRepository('AppBundle:EstadoReserva')->findOneBy($array_filtro,array('id' => 'ASC'));
      return $estadoReserva;
    }

    public function getReserva($array_filtro=array()){

      $Reserva = $this->getDoctrine()->getRepository('AppBundle:Reserva')->findOneBy($array_filtro,array('id' => 'ASC'));
      return $Reserva;
    }

    public function getUsuario($array_filtro=array()){

      $em = $this->getDoctrine()->getManager();
      return  $em->getRepository('AppBundle:Usuario')->findOneBy($array_filtro);
      
    }

    public function  getHabitacionesDeReserva($reservaId){

      $rhs = $this->getDoctrine()->getRepository('AppBundle:ReservasHabitaciones')->findBy(array('reserva' => $reservaId));
      $habitaciones = array();
      if($rhs !=null){

        foreach ($rhs as $rh) {
          array_push($habitaciones, $rh->getHabitaciones());
        }
      }
      return $habitaciones;
    }


    /**
    * Ajax Reservas
    *
    * @Route("/ajaxServicios/reservarServicio", name="ajax_reservar_servicio")
    *
    * @param Request $request
    *
    * @return Response
    */

    public function ajaxReservarServicioAction(Request $request){
      $idServicio = 1 ;
      $idHorarioServicio= 1;
      $fechaDesde =1 ;
      $fechaHasta = 1 ; 
      $cantPersonas =1 ; 

      $habitaciones = 1; 



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
    * @Route("/ajaxServicios/pagarReserva", name="ajax_pagar_reserva")
    *
    * @param Request $request
    *
    * @return Response
    */

    public function ajaxPagarReservaAction(Request $request){

        $em = $this->getDoctrine()->getManager(); 

        $idReserva      = $request->get("id_reserva");     
        $idTipoPago     = $request->get("id_tipo_pago"); //"tipoPago" => "4_12"
        $cuota          = $request->get("cuotas");
        $nombreApellido = $request->get("nombre");
        $numeroTarjeta  = $request->get("num_tarjeta");
        $mesVencimiento = $request->get("vencimiento_mes");
        $anioVencimiento= $request->get("vencimiento_anio");
        $codSeguridad   = $request->get("cod_seguridad");          

        $montoTotal = $request->get("monto_abonado");
        $monto_abonado = $request->get("monto_abonado");

        $respuesta="";  

        /*Obtengo la reserva*/
        $reserva = $this->getReserva(array("id"=>$idReserva));

        if($reserva == null){
            $respuesta= "ERROR";
        }
        else{

            $tipoPago = $this->getDoctrine()->getRepository('AppBundle:TipoPago')->find($idTipoPago);

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

            $facturaConsumo = new FacturaConsumo();
            $facturaConsumo->setNumeroTarjeta( $numeroTarjeta);
            $facturaConsumo->setValidaHasta( $mesVencimiento."-".$anioVencimiento);
            $facturaConsumo->setNombreApellidoTarjeta($nombreApellido);
            $facturaConsumo->setDniTitular($reserva->getCliente()->getDni());
            $facturaConsumo->setCuil("30".$reserva->getCliente()->getDni()."6");
            $facturaConsumo->setCodSeguridad($codSeguridad);
            $facturaConsumo->setConsumoCliente($consumosCliente);

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
      $fechaSalida = $request->get("fecha_fin");

      //Se le agregan comillas dobles a los valores para ser tomados como string
      $habitacionesDisponibles = $this->getHabitacionesDisponibles("$fechaArribo","$fechaSalida");

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

      $horarios = $this->getHorariosServicios($idServicio);

      $encoders = array(new JsonEncoder());
      $normalizers = array(new ObjectNormalizer());

      $serializer = new Serializer($normalizers, $encoders);

      $jsonHorarios = $serializer->serialize($horarios, 'json');

      return new JsonResponse(array('horarios' => $jsonHabitaciones));  
    }

    /**
    * Ajax Reservas : Valida si un servicio está disponible para esa fecha y horario.
    *
    * @Route("/ajaxServicios/horarioServicio", name="ajax_diponibilidad_servicio")
    *
    * @param Request $request
    *
    * @return Response
    */
    public function ajaxDisponibilidadServicioAction(Request $request){

      $idServicio = $request->get("id_servicio");

      $horarios = $this->getHorariosServicios();

      $encoders = array(new JsonEncoder());
      $normalizers = array(new ObjectNormalizer());

      $serializer = new Serializer($normalizers, $encoders);

      $jsonHorarios = $serializer->serialize($horarios, 'json');

      return new JsonResponse(array('horarios' => $jsonHabitaciones));  
    }

    /*
      Envio de Email
    */

    public function sendEmailAction($nombreCliente, $idCliente, $emailCliente, $asunto,$mensaje)
    {
      $message = \Swift_Message::newInstance()
        ->setSubject('[Consulta] Cliente:'.$idCliente.' - '.$asunto)
        ->setFrom("ac.ecoturismo@gmail.com")
        ->setTo("ac.ecoturismo@gmail.com")
        ->setBody($mensaje)
      ;

      $this->get('mailer')->send($message);
    }





















}
