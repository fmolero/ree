<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */
/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';
class ree extends eqLogic {
    /*     * *************************Attributs****************************** */
     public static $_horas = array('00h', '01h', '02h', '03h', '04h', '05h', '06h', '07h', '08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h');
    /*     * ***********************Methode static*************************** */
    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {
      }
     */
    /*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly() {
      }
     */
    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom */
      public static function cron30() {
		 if ($_eqLogic_id == null) { // La fonction n’a pas d’argument donc on recherche tous les équipements du plugin
                        $eqLogics = self::byType('ree', true);
                } else {// La fonction a l’argument id(unique) d’un équipement(eqLogic)
                        $eqLogics = array(self::byId($_eqLogic_id));
                }
                foreach ($eqLogics as $ree) {
                        if ($ree->getIsEnable() == 1) {//vérifie que l'équipement est acitf
                                $cmd = $ree->getCmd(null, 'refresh');//retourne la commande "refresh si elle exxiste
                                if (!is_object($cmd)) {//Si la commande n'existe pas
                                  continue; //continue la boucle
                                }
                                $cmd->execCmd(); // la commande existe on la lance
                        }
                }
      }
    /*     * *********************Méthodes d'instance************************* */
    public function preInsert() {
        
    }
    public function postInsert() {
        
    }
    public function preSave() {
         $this->setDisplay("width","225px");
    }
    public function postSave() {
        $refresh = $this->getCmd(null, 'refresh');
                if (!is_object($refresh)) {
                        $refresh = new reeCmd();
                        $refresh->setName(__('Rafraichir', __FILE__));
                }
                $refresh->setEqLogic_id($this->getId());
                $refresh->setLogicalId('refresh');
                $refresh->setType('action');
                $refresh->setSubType('other');
                $refresh->save();

        for ($x = 0; $x <= 23; $x++) {
                    $info = $this->getCmd(null, self::$_horas[$x]);
                    if (!is_object($info)) {
                            $info = new reeCmd();
                            $info->setName(__(self::$_horas[$x], __FILE__));
                    }
                    $info->setLogicalId(self::$_horas[$x]);
                    $info->setEqLogic_id($this->getId());
                    $info->setType('info');
		    $info->setTemplate('dashboard', 'line');
		    $info->setTemplate('mobile', 'line');
		    $info->setUnite('€/KWh');
		    $info->setSubType('numeric');
                    $info->save();
        }
		    $info = $this->getCmd(null, 'name');
                    if (!is_object($info)) {
                            $info = new reeCmd();
                            $info->setName(__('name', __FILE__));
                    }
                    $info->setLogicalId('name');
                    $info->setEqLogic_id($this->getId());
                    $info->setType('info');
                    $info->setSubType('string');
                    $info->save();
		    $info = $this->getCmd(null, 'date');
                    if (!is_object($info)) {
                            $info = new reeCmd();
                            $info->setName(__('date', __FILE__));
                    }
                    $info->setLogicalId('date');
                    $info->setEqLogic_id($this->getId());
                    $info->setType('info');
                    $info->setSubType('string');
                    $info->save();

			$info1 = $this->getCmd(null, 'hour');
                    if (!is_object($info1)) {
                            $info1 = new reeCmd();
                            $info1->setName(__('hour', __FILE__));
                    }
                    $info1->setLogicalId('hour');
                    $info1->setEqLogic_id($this->getId());
                    $info1->setType('info');
		    $info1->setTemplate('dashboard', 'line');
                    $info1->setTemplate('mobile', 'line');
                    $info1->setUnite('€/KWh');
                    $info1->setSubType('numeric');
                    $info1->save();

		    $info2 = $this->getCmd(null, 'cheaphour');
                    if (!is_object($info2)) {
                            $info2 = new reeCmd();
                            $info2->setName(__('cheaphour', __FILE__));
                    }
                    $info2->setLogicalId('cheaphour');
                    $info2->setEqLogic_id($this->getId());
                    $info2->setType('info');
                    $info2->setSubType('string');
                    $info2->save();

                $info3 = $this->getCmd(null, 'expensivehour');
                if (!is_object($info3)) {
                        $info3 = new reeCmd();
                        $info3->setName(__('expensivehour', __FILE__));
                }
                $info3->setLogicalId('expensivehour');
                $info3->setEqLogic_id($this->getId());
                $info3->setType('info');
                $info3->setSubType('string');
                $info3->save();
	    
	    	//Modificación para añdir gráfica
	    	$info4 = $this->getCmd(null, 'graph');
                if (!is_object($info4)) {
                        $info4 = new reeCmd();
                        $info4->setName(__('graph', __FILE__));
                }
                $info4->setLogicalId('graph');
                $info4->setEqLogic_id($this->getId());
                $info4->setType('info');
                $info4->setSubType('string');
                $info4->save();
    }
    public function preUpdate() {
        
    }
	
    public function postUpdate() {
       // self::cronHourly($this->getId());// lance la fonction cronHourly
          $refresh = $this->getCmd(null, 'refresh');
                if (!is_object($refresh)) {
                        $refresh = new reeCmd();
                        $refresh->setName(__('Rafraichir', __FILE__));
                
                $refresh->setEqLogic_id($this->getId());
                $refresh->setLogicalId('refresh');
                $refresh->setType('action');
                $refresh->setSubType('other');
                $refresh->save();}

        for ($x = 0; $x <= 23; $x++) {
                    $info = $this->getCmd(null, self::$_horas[$x]);
                    if (!is_object($info)) {
                            $info = new reeCmd();
                            $info->setName(__(self::$_horas[$x], __FILE__));
                    
                    $info->setLogicalId(self::$_horas[$x]);
                    $info->setEqLogic_id($this->getId());
                    $info->setType('info');
		    $info->setTemplate('dashboard', 'line');                    //$info->setDisplay('title_placeholder', __('Options', __FILE__));
			$info->setTemplate('mobile', 'line');
			$info->setUnite('€/KWh');
			$info->setSubType('numeric');
                    $info->save();}
        }
		    $info = $this->getCmd(null, 'name');
                    if (!is_object($info)) {
                            $info = new reeCmd();
                            $info->setName(__('name', __FILE__));
                    
                    $info->setLogicalId('name');
                    $info->setEqLogic_id($this->getId());
                    $info->setType('info');
                    $info->setSubType('string');
                    $info->save();}
		    
		    $info = $this->getCmd(null, 'date');
                    if (!is_object($info)) {
                            $info = new reeCmd();
                            $info->setName(__('date', __FILE__));
                    
                    $info->setLogicalId('date');
                    $info->setEqLogic_id($this->getId());
                    $info->setType('info');
                    $info->setSubType('string');
                    $info->save();}

			$info1 = $this->getCmd(null, 'hour');
                    if (!is_object($info1)) {
                            $info1 = new reeCmd();
                            $info1->setName(__('hour', __FILE__));
                    
                    $info1->setLogicalId('hour');
                    $info1->setEqLogic_id($this->getId());
                    $info1->setType('info');
                    $info1->setTemplate('dashboard', 'line');
                    $info1->setTemplate('mobile', 'line');
                    $info1->setUnite('€/KWh');
                    $info1->setSubType('numeric');
                    $info1->save();}

		    $info2 = $this->getCmd(null, 'cheaphour');
                    if (!is_object($info2)) {
                            $info2 = new reeCmd();
                            $info2->setName(__('cheaphour', __FILE__));
                    
                    $info2->setLogicalId('cheaphour');
                    $info2->setEqLogic_id($this->getId());
                    $info2->setType('info');
                    $info2->setSubType('string');
                    $info2->save();}

                $info3 = $this->getCmd(null, 'expensivehour');
                if (!is_object($info3)) {
                        $info3 = new reeCmd();
                        $info3->setName(__('expensivehour', __FILE__));
                
                $info3->setLogicalId('expensivehour');
                $info3->setEqLogic_id($this->getId());
                $info3->setType('info');
                $info3->setSubType('string');
                $info3->save();}
	    
	    	//Modificaciín para añadir gráfica
	    	$info4 = $this->getCmd(null, 'graph');
                if (!is_object($info4)) {
                        $info4 = new reeCmd();
                        $info4->setName(__('graph', __FILE__));
                
                $info4->setLogicalId('graph');
                $info4->setEqLogic_id($this->getId());
                $info4->setType('info');
                $info4->setSubType('string');
                $info4->save();}
		
		self::cron30($this->getId());// lance la fonction cronHourly
    }
    public function preRemove() {
        
    }
    public function postRemove() {
       
    }
    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {
      }
     */
    /*
     * Non obligatoire mais ca permet de déclencher une action après modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */
    /*
     * Non obligatoire mais ca permet de déclencher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */
    /*     * **********************Getteur Setteur*************************** */
}
class reeCmd extends cmd {
    /*     * *************************Attributs****************************** */
    public static $_horas2 = array('00h', '01h', '02h', '03h', '04h', '05h', '06h', '07h', '08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h');
    /*     * ***********************Methode static*************************** */
    /*     * *********************Methode d'instance************************* */
    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */
    public function execute($_options = array()) {
	        if ($this->getLogicalId() == 'refresh')
	        {
                $fecha_actual = date("Y-m-d");
		//$eqConfig = $this->getConfigKey();
                $token = config::byKey('param1', 'ree');
                $eqLogic = $this->getEqLogic();
		$selhora = $eqLogic->getConfiguration('hora');
                //sumo 1 dÃ­a
                $fecha_siguiente = date("Y-m-d",strtotime($fecha_actual."+ 1 days"));
		$fecha_actual_hora = strtotime(date("Y-m-d H:i:00",time()));
		/*$fecha_entrada_hora = strtotime($fecha_actual . "23:59:00");*/
		$fecha_entrada_hora = strtotime($fecha_actual . $selhora);
		/*$fecha_entrada_hora = strtotime($fecha_actual . "21:59:00");*/
		if($fecha_actual_hora > $fecha_entrada_hora)
		{
			 $fecha_siguiente = date("Y-m-d",strtotime($fecha_actual."+ 1 days"));
		}else
		{
			 $fecha_siguiente = $fecha_actual;
		}
                $ch = curl_init();
                
                //$eqConfig = $this->getConfigKey();
                //$token = config::byKey('param1', 'ree');
                //$eqLogic = $this->getEqLogic();
		$seltaux = $eqLogic->getConfiguration('taux');
                switch ($seltaux) {
 		 case "PVPC":
        		$taux = "1013";
        		break;
    		case "PVPC 2.0 DHA":
        		$taux = "1014";
        		break;
    		case "PVPC 2.0 DHS":
        		$taux = "1015";
        		break;
		}
                $headers = array(
                        "Accept: application/json; application/vnd.esios-api-v1+json",
                        "Content-Type: application/json",
                        "Host: api.esios.ree.es",
                        "Authorization: Token token=" . $token,
                        "Cookie: "
                );
                curl_setopt($ch, CURLOPT_URL,"https://api.esios.ree.es/indicators/" . $taux . "?start_date=" . $fecha_siguiente . "T00:00:00&end_date=" . $fecha_siguiente . "T23:50:00");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($ch);
                curl_close($ch);
                $obj=json_decode($response,true);
		// Imprime el JSON en el log para poder consultarlo
		log::add('ree', 'debug', 'Datos json: ' . print_r($response, True));
               // On rÃ©cupÃ¨re l'Ã©quipement Ã  partir de l'identifiant fournit par la commande
               $reeObj = ree::byId($this->getEqlogic_id());
		//Objeto para manejar los datos de gráfico
		$dataGraph = $reeObj->getCmd('info', 'graph');
		$graph = "";
               // On rÃ©cupÃ¨re la commande 'data' appartenant Ã  l'Ã©quipement
               for ($x = 0; $x <= 23; $x++) {
                   $graph = $graph . ($obj['indicator']['values'][$x]['value'] / 1000) . ", ";
		   //$graph = $obj['indicator']['values'][$x]['value'] / 1000;
		   $dataCmd = $reeObj->getCmd('info', self::$_horas2[$x]);
                   $dataCmd->event($obj['indicator']['values'][$x]['value'] / 1000);
                   //$dataCmd->event($globalp1);
                   $dataCmd->save();
			$tarifa[] = $obj['indicator']['values'][$x]['value'] / 1000;
                   }
               //grabamos los datos de gráfico
	    	$dataGraph->event($graph);
	    	$dataGraph->save();
		}
	    	
	    
		$dataCmd = $reeObj->getCmd('info', 'name');
                   $dataCmd->event($obj['indicator']['short_name']);
                   //$dataCmd->event($globalp1);
                   $dataCmd->save();

    		 $dataCmd = $reeObj->getCmd('info', 'date');
                   $dataCmd->event(substr($obj['indicator']['values'][0]['datetime'], 0, 10));
                   $dataCmd->save();

		$dt = new DateTime();
		$dataCmd1 = $reeObj->getCmd('info', 'hour');//incluimos un comando con la tarifa de la hora actual
                        $dataCmd1->event($obj['indicator']['values'][(string)$dt->format('G')]['value'] / 1000);
                        //$dataCmd1->event($dt->format('G'));
                        $dataCmd1->save();
                        //$dataCmd->event($obj['indicator']['values'][0]['datetime']);
                        //$dataCmd->save();

		asort($tarifa); //ordenamos las este arriba el primer elecmento sera el mas barato y el ultimo el mas caro
		 reset($tarifa); //nos aseguramos de estar en el primer elemento ya ordenador del array que incluye las tarifas de todas las horas de$
                        //end($tarifa);
                        $dataCmd2 = $reeObj->getCmd('info', 'cheaphour'); //incluimos un elemento en el equipo con la hora mas barata del dia
                        if (key($tarifa) < 10) {
				$cheaphour = "0" . key($tarifa);
			}else 
			{
				$cheaphour = key($tarifa);
			}
			$dataCmd2->event($cheaphour . "h");
                        $dataCmd2->save();

                        reset($tarifa);//nos aseguramos de estar en el primer elemento ya ordenador del array que incluye las tarifas de todas las horas del$
                        end($tarifa);//nos vamos al ultimo elemento del array de tarifas y por tanto a la hora mas cara del dia
                        $dataCmd3 = $reeObj->getCmd('info', 'expensivehour');
                        if (key($tarifa) < 10) {
                                $expensivehour = "0" . key($tarifa);
                        }else
                        {
                                $expensivehour = key($tarifa);
                        }
			$dataCmd3->event($expensivehour . "h");
                        $dataCmd3->save();

    }
    /*     * **********************Getteur Setteur*************************** */
}
