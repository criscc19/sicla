<?php
	/* Copyright (C) 2007-2017  Laurent Destailleur <eldy@users.sourceforge.net>
		* Copyright (C) 2014-2016  Juanjo Menent       <jmenent@2byte.es>
		* Copyright (C) 2015       Florian Henry       <florian.henry@open-concept.pro>
		* Copyright (C) 2015       Raphaël Doursenaud  <rdoursenaud@gpcsolutions.fr>
		* Copyright (C) ---Put here your own copyright and developer email---
		*
		* This program is free software; you can redistribute it and/or modify
		* it under the terms of the GNU General Public License as published by
		* the Free Software Foundation; either version 3 of the License, or
		* (at your option) any later version.
		*
		* This program is distributed in the hope that it will be useful,
		* but WITHOUT ANY WARRANTY; without even the implied warranty of
		* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		* GNU General Public License for more details.
		*
		* You should have received a copy of the GNU General Public License
		* along with this program. If not, see <http://www.gnu.org/licenses/>.
	*/
	
	/**
		* \file        htdocs/modulebuilder/template/class/cotizaciones.class.php
		* \ingroup     mymodule
		* \brief       This file is a CRUD class file for cotizaciones (Create/Read/Update/Delete)
	*/
	
	// Put here all includes required by your class file
	require_once DOL_DOCUMENT_ROOT . '/core/class/commonobject.class.php';
	require_once DOL_DOCUMENT_ROOT . '/societe/class/societe.class.php';
	require_once DOL_DOCUMENT_ROOT . '/product/class/product.class.php';
	
	/**
		* Class for cotizaciones
	*/
	class Cotizaciones extends CommonObject
	{
		public $element='cotizaciones';
		public $table_element='cotizaciones';
		public $table_element_line = 'cotizaciondet';
		public $fk_element = 'fk_cotizacion';
		public $picto='cotizaciones';
		/**
			* 0=No test on entity, 1=Test with field entity, 2=Test with link by societe
			* @var int
		*/
		public $ismultientitymanaged = 1;
		/**
			* 0=Default, 1=View may be restricted to sales representative only if no permission to see all or to company of external user if external user
			* @var integer
		*/
		public $restrictiononfksoc = 1;
		
		/**
			* {@inheritdoc}
		*/
		protected $table_ref_field = 'ref';
		public $id;
		public $ref;
		public $fk_ticketsup;
		public $ref_client;
		public $socid;
		public $fecha;
		public $cond_reglement_id;
		public $mode_reglement_id;
		public $demand_reason_id;
		public $availability_id;
		public $shipping_method_id;
		public $date_livraison;
		public $note_public;
		public $note_private;
		public $fk_user;
		public $entrega;
		public $tipodias;
		public $marca;
		public $contacto;
		public $fk_user_res;
		public $tiempo_isnt;
		public $uid;
		public $login;
		public $firstname;
		public $lastname;
		public $cid;
		public $nom;
		public $name_alias;
		public $code_client;
		public $total_gra;
		public $thirdparty;	
		public $entity;	
		public $datec;
		public $lineas;
		var $error;							//!< To return error code (or message)
		var $errors=array();
		
		
		/**
			* Constructor
			*
			* @param DoliDb $db Database handler
		*/
		public function __construct(DoliDB $db)
		{
			$this->db = $db;
		}
		
		
		
		/**
			*  Create object into database
			*
			*  @param	User	$user        User that creates
			*  @param  int		$notrigger   0=launch triggers after, 1=disable triggers
			*  @return int      		   	 <0 if KO, Id of created object if OK
		*/
		function create($user, $notrigger=0)
		{
			global $conf, $langs;
			$error=0;
			
			// Clean parameters
			/*  $fk_product = $_POST['fk_product'];
				$fk_societe = $_POST['fk_societe'];
				$fk_user = $_POST['fk_user'];
				$cantidad = $_POST['cantidad'];
			*/
			if (isset($this->fk_ticketsup)) $this->fk_ticketsup=trim($this->fk_ticketsup);
			if (isset($this->ref)) $this->ref=trim($this->ref);
			if (isset($this->ref_client)) $this->ref_client=trim($this->ref_client);
			if (isset($this->socid)) $this->socid=trim($this->socid);
			if (isset($this->fecha)) $this->fecha=trim($this->fecha);
			if (isset($this->cond_reglement_id)) $this->cond_reglement_id=trim($this->cond_reglement_id);
			if (isset($this->mode_reglement_id)) $this->mode_reglement_id=trim($this->mode_reglement_id);
			if (isset($this->demand_reason_id)) $this->demand_reason_id=trim($this->demand_reason_id);
			if (isset($this->availability_id)) $this->availability_id=trim($this->availability_id);
			if (isset($this->shipping_method_id)) $this->shipping_method_id=trim($this->shipping_method_id);
			if (isset($this->date_livraison)) $this->date_livraison=trim($this->date_livraison);
			if (isset($this->date_livraisonday)) $this->date_livraisonday=trim($this->date_livraisonday);
			if (isset($this->date_livraisonmonth)) $this->date_livraisonmonth=trim($this->date_livraisonmonth);
			if (isset($this->date_livraisonyear)) $this->date_livraisonyear=trim($this->date_livraisonyear);
			if (isset($this->multicurrency_code)) $this->multicurrency_code=trim($this->multicurrency_code);
			if (isset($this->note_public)) $this->note_public=trim($this->note_public);
			if (isset($this->note_private)) $this->note_private=trim($this->note_private);
			if (isset($this->fk_user)) $this->fk_user=trim($this->fk_user);
			if (isset($this->entrega)) $this->entrega=trim($this->entrega);
			if (isset($this->tipodias)) $this->tipodias=trim($this->tipodias);
			if (isset($this->marca)) $this->marca=trim($this->marca);
			if (isset($this->contacto)) $this->contacto=trim($this->contacto);
			if (isset($this->fk_user_res)) $this->fk_user_res=trim($this->fk_user_res);
			if (isset($this->tiempo_isnt)) $this->tiempo_isnt=trim($this->tiempo_isnt);
			
			
			// Check parameters
			// Put here code to add control on parameters values
			
			// Insert request
			$sql = 'INSERT INTO '.MAIN_DB_PREFIX.'cotizaciones(';
			
			
			$sql.= 'ref,';
			$sql.= 'fk_ticketsup,';
			$sql.= 'ref_client,';
			$sql.= 'socid,';
			$sql.= 'fecha,';
			$sql.= 'cond_reglement_id,';
			$sql.= 'mode_reglement_id,';
			$sql.= 'demand_reason_id,';
			$sql.= 'availability_id,';
			$sql.= 'shipping_method_id,';
			$sql.= 'date_livraison,';
			$sql.= 'multicurrency_code,';
			$sql.= 'note_public,';
			$sql.= 'note_private,';
			$sql.= 'fk_user,';
			$sql.= 'entrega,';
			$sql.= 'tipodias,';
			$sql.= 'marca,';
			$sql.= 'contacto,';
			$sql.= 'fk_user_res,';
			$sql.= 'tiempo_isnt';
			
			$sql.= ')'; 
			$sql.= ' VALUES (';  
			$sql.= ''.(! isset($this->ref)?"NULL":'"'.$this->db->escape($this->ref).'"').',';
			$sql.= ''.(! isset($this->fk_ticketsup)?"NULL":'"'.$this->db->escape($this->fk_ticketsup).'"').',';
			$sql.= ''.(! isset($this->ref_client)?"NULL":'"'.$this->db->escape($this->ref_client).'"').',';
			$sql.= ''.(! isset($this->socid)?"NULL":'"'.$this->db->escape($this->socid).'"').',';
			$sql.= ''.(! isset($this->fecha)?"NULL":'"'.$this->db->escape($this->fecha).'"').',';
			$sql.= ''.(! isset($this->cond_reglement_id)?"NULL":'"'.$this->db->escape($this->cond_reglement_id).'"').',';
			$sql.= ''.(! isset($this->mode_reglement_id)?"NULL":'"'.$this->db->escape($this->mode_reglement_id).'"').',';
			$sql.= ''.(! isset($this->demand_reason_id)?"NULL":'"'.$this->db->escape($this->demand_reason_id).'"').',';
			$sql.= ''.(! isset($this->availability_id)?"NULL":'"'.$this->db->escape($this->availability_id).'"').',';
			$sql.= ''.(! isset($this->shipping_method_id)?"NULL":'"'.$this->db->escape($this->shipping_method_id).'"').',';
			$sql.= ''.(! isset($this->date_livraison)?"NULL":'"'.$this->db->escape($this->date_livraison).'"').',';
			$sql.= ''.(! isset($this->multicurrency_code)?"NULL":'"'.$this->db->escape($this->multicurrency_code).'"').',';
			$sql.= ''.(! isset($this->note_public)?"NULL":'"'.$this->db->escape($this->note_public).'"').',';
			$sql.= ''.(! isset($this->note_private)?"NULL":'"'.$this->db->escape($this->note_private).'"').',';
			$sql.= '"'.$user->id.'",';
			$sql.= ''.(! isset($this->options_entrega)?"NULL":'"'.$this->db->escape($this->options_entrega).'"').',';
			$sql.= ''.(! isset($this->options_tipodias)?"NULL":'"'.$this->db->escape($this->options_tipodias).'"').',';
			$sql.= ''.(! isset($this->options_marca)?"NULL":'"'.$this->db->escape($this->options_marca).'"').',';
			$sql.= ''.(! isset($this->contacto)?"NULL":'"'.$this->db->escape($this->contacto).'"').',';
			$sql.= ''.(! isset($this->options_fk_user_res)?"NULL":'"'.$this->db->escape($this->options_fk_user_res).'"').',';
			$sql.= ''.(! isset($this->options_tiempo_isnt)?"NULL":'"'.$this->db->escape($this->options_tiempo_isnt).'"').'';
			$sql.= ')';  
			
			
			$this->db->begin();
			
			dol_syslog(get_class($this)."::create sql=".$sql, LOG_DEBUG);
			$resql=$this->db->query($sql);
			if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }
			
			if (! $error)
			{
				$this->id = $this->db->last_insert_id(MAIN_DB_PREFIX."cotizaciones");
				
				if (! $notrigger)
				{
					// Uncomment this and change MYOBJECT to your own tag if you
					// want this action calls a trigger.
					
					//// Call triggers
					//include_once DOL_DOCUMENT_ROOT . '/core/class/interfaces.class.php';
					//$interface=new Interfaces($this->db);
					//$result=$interface->run_triggers('MYOBJECT_CREATE',$this,$user,$langs,$conf);
					//if ($result < 0) { $error++; $this->errors=$interface->errors; }
					//// End call triggers
				}
			}
			
			// Commit or rollback
			if ($error)
			{
				foreach($this->errors as $errmsg)
				{
					dol_syslog(get_class($this)."::create ".$errmsg, LOG_ERR);
					$this->error.=($this->error?', '.$errmsg:$errmsg);
				}
				$this->db->rollback();
				return -1*$error;
			}
			else
			{
				$this->db->commit();
				return $this->id;
			}
		}
		
		
		
		
		
		/**
			*  Load object in memory from the database
			*
			*  @param	int		$id    Id object
			*  @return int          	<0 if KO, >0 if OK
		*/
		function fetch($id)
		{
			$sql.= 'ref,';
			$sql.= 'fk_ticketsup,';
			
			$sql.= 'fecha,';
			$sql.= 'cond_reglement_id,';
			$sql.= 'mode_reglement_id,';
			
			
			$sql = 'SELECT';
			$sql .= ' co.rowid,';
			$sql .= 'co.ref,';
			$sql.= 'co.ref_client,';
			$sql.= 'co.socid,';
			$sql .= 'co.entity,';
			$sql .= 'co.fk_ticketsup,';
			$sql .= 'co.fecha,';
			$sql .= 'co.estado,';
			$sql.= 'co.cond_reglement_id,';
			$sql.= 'co.mode_reglement_id,';
			$sql.= 'co.demand_reason_id,';
			$sql.= 'co.availability_id,';
			$sql.= 'co.shipping_method_id,';
			$sql.= 'co.date_livraison,';
			$sql.= 'co.date_livraisonday,';
			$sql.= 'co.date_livraisonmonth,';
			$sql.= 'co.date_livraisonyear,';
			$sql.= 'co.multicurrency_code,';
			$sql.= 'co.note_public,';
			$sql.= 'co.note_private,';
			$sql.= 'co.fk_user,';
			$sql.= 'co.entrega,';
			$sql.= 'co.tipodias,';
			$sql.= 'co.marca,';
			$sql.= 'co.contacto,';
			$sql.= 'co.fk_user_res,';
			$sql.= 'co.tiempo_isnt,';
			$sql.= 'co.datec,';
			$sql .= 'u.rowid uid,';
			$sql .= 'u.login,';
			$sql .= 'u.firstname,';
			$sql .= 'u.lastname,';
			$sql .= 's.rowid cid,'; 
			$sql .= 's.nom,';
			$sql .= 's.name_alias,';
			$sql .= 's.code_client,';
			$sql .= '(SELECT SUM(cd.total_gra) FROM llx_cotizaciondet cd WHERE cd.fk_cotizacion=co.rowid) total_gra';
			$sql .= ' FROM llx_cotizaciones co';
			$sql .= ' JOIN llx_user u ON co.fk_user=u.rowid';
			$sql .= ' JOIN llx_societe s ON co.socid=s.rowid';
			$sql .= ' WHERE co.rowid='.$id.'';
			
			dol_syslog(get_class($this)."::fetch sql=".$sql, LOG_DEBUG);
			
			$resql=$this->db->query($sql);
			if ($resql)
			{
				if ($this->db->num_rows($resql))
				{
					$obj = $this->db->fetch_object($resql);
					
					
					
					$this->id = $obj->rowid;
					$this->ref = $obj->ref;
					$this->entity = $obj->entity;
					$this->fk_ticketsup = $obj->fk_ticketsup;
					$this->fecha = $obj->fecha;
					$this->estado = $obj->estado;
					$this->uid = $obj->uid;
					$this->login = $obj->login;
					$this->firstname = $obj->firstname;
					$this->lastname = $obj->lastname;
					$this->cond_reglement_id = $obj->cond_reglement_id;
					$this->mode_reglement_id = $obj->mode_reglement_id;  
					$this->socid = $obj->socid;  
					$this->name_alias = $obj->name_alias;
					$this->code_client = $obj->code_client;
					$this->total_gra = $obj->total_gra;
					$this->demand_reason_id = $obj->demand_reason_id;
					$this->availability_id = $obj->availability_id;
					$this->shipping_method_id = $obj->shipping_method_id;
					$this->date_livraison = $obj->date_livraison;
					$this->date_livraisonday = $obj->date_livraisonday;
					$this->date_livraisonmonth = $obj->date_livraisonmonth;
					$this->date_livraisonyear = $obj->date_livraisonyear;
					$this->multicurrency_code = $obj->multicurrency_code;
					$this->note_public = $obj->note_public;
					$this->note_private = $obj->note_private;
					$this->fk_user = $obj->fk_user;
					$this->entrega = $obj->entrega;
					$this->tipodias = $obj->tipodias;
					$this->marca = $obj->marca;
					$this->contacto = $obj->contacto;
					$this->fk_user_res = $obj->fk_user_res;
					$this->tiempo_isnt= $obj->tiempo_isnt;
					$this->uid = $obj->uid;
					$this->login = $obj->login;
					$this->firstname = $obj->firstname;
					$this->lastname = $obj->lastname;
					$this->cid = $obj->rowid;
					$this->nom = $obj->nom;
					$this->name_alias = $obj->name_alias;
					$this->code_client = $obj->code_client;	
					$this->datec = $obj->datec;	
				}
				$this->db->free($resql);
				
				return $obj;
			}
			else
			{
				$this->error="Error ".$this->db->lasterror();
				dol_syslog(get_class($this)."::fetch ".$this->error, LOG_ERR);
				return -1;
			}
		}
		
		
		
		/**
			*  Update object into database
			*
			*  @param	User	$user        User that modifies
			*  @param  int		$notrigger	 0=launch triggers after, 1=disable triggers
			*  @return int     		   	 <0 if KO, >0 if OK
		*/
		function update($id=0, $notrigger=0)
		{
			global $conf, $langs;
			$error=0;
			
			// Clean parameters
			
			if (isset($this->ref)) $this->ref=trim($this->ref);
			if (isset($this->ref_client)) $this->ref_client=trim($this->ref_client);
			if (isset($this->socid)) $this->socid=trim($this->socid);
			if (isset($this->fecha)) $this->fecha=trim($this->fecha);
			if (isset($this->cond_reglement_id)) $this->cond_reglement_id=trim($this->cond_reglement_id);
			if (isset($this->mode_reglement_id)) $this->mode_reglement_id=trim($this->mode_reglement_id);
			if (isset($this->demand_reason_id)) $this->demand_reason_id=trim($this->demand_reason_id);
			if (isset($this->availability_id)) $this->availability_id=trim($this->availability_id);
			if (isset($this->shipping_method_id)) $this->shipping_method_id=trim($this->shipping_method_id);
			if (isset($this->date_livraison)) $this->date_livraison=trim($this->date_livraison);
			if (isset($this->date_livraisonday)) $this->date_livraisonday=trim($this->date_livraisonday);
			if (isset($this->date_livraisonmonth)) $this->date_livraisonmonth=trim($this->date_livraisonmonth);
			if (isset($this->date_livraisonyear)) $this->date_livraisonyear=trim($this->date_livraisonyear);
			if (isset($this->multicurrency_code)) $this->multicurrency_code=trim($this->multicurrency_code);
			if (isset($this->note_public)) $this->note_public=trim($this->note_public);
			if (isset($this->note_private)) $this->note_private=trim($this->note_private);
			if (isset($this->fk_user)) $this->fk_user=trim($this->fk_user);
			if (isset($this->entrega)) $this->entrega=trim($this->entrega);
			if (isset($this->tipodias)) $this->tipodias=trim($this->tipodias);
			if (isset($this->marca)) $this->marca=trim($this->marca);
			if (isset($this->contacto)) $this->contacto=trim($this->contacto);
			if (isset($this->fk_user_res)) $this->fk_user_res=trim($this->fk_user_res);
			if (isset($this->tiempo_isnt)) $this->tiempo_isnt=trim($this->tiempo_isnt);
			
			
			
			// Check parameters
			// Put here code to add a control on parameters values
			
			// Update request
			$sql = 'UPDATE '.MAIN_DB_PREFIX.'cotizaciones SET';
			
			
			if(isset($this->id))$sql .= ' rowid='.(isset($this->id)?'"'.$this->db->escape($this->id).'"':'NULL').'';
			if(isset($this->estado))$sql.= ' ,estado='.(isset($this->estado)?'"'.$this->db->escape($this->estado).'"':'NULL').'';
			if(isset($this->ref_client))$sql.= ' , ,ref_client='.(isset($this->ref_client)?'"'.$this->db->escape($this->ref_client).'"':'NULL').'';
			if(isset($this->socid))$sql.= ' ,socid='.(isset($this->socid)?'"'.$this->db->escape($this->socid).'"':'NULL').'';
			if(isset($this->fecha))$sql.= ' ,fecha='.(isset($this->fecha)?'"'.$this->db->escape($this->fecha).'"':'NULL').'';
			if(isset($this->cond_reglement_id))$sql.= ' ,cond_reglement_id='.(isset($this->cond_reglement_id)?'"'.$this->db->escape($this->cond_reglement_id).'"':'NULL').'';
			if(isset($this->mode_reglement_id))$sql.= ' ,mode_reglement_id='.(isset($this->mode_reglement_id)?'"'.$this->db->escape($this->mode_reglement_id).'"':'NULL').'';
			if(isset($this->demand_reason_id))$sql.= ' ,demand_reason_id='.(isset($this->demand_reason_id)?'"'.$this->db->escape($this->demand_reason_id).'"':'NULL').'';
			if(isset($this->availability_id))$sql.= ' ,availability_id='.(isset($this->availability_id)?'"'.$this->db->escape($this->availability_id).'"':'NULL').'';
			if(isset($this->shipping_method_id))$sql.= ' ,shipping_method_id='.(isset($this->shipping_method_id)?'"'.$this->db->escape($this->shipping_method_id).'"':'NULL').'';
			if(isset($this->date_livraison))$sql.= ' ,date_livraison='.(isset($this->date_livraison)?'"'.$this->db->escape($this->date_livraison).'"':'NULL').'';
			if(isset($this->date_livraisonday))$sql.= ' ,date_livraisonday='.(isset($this->date_livraisonday)?'"'.$this->db->escape($this->date_livraisonday).'"':'NULL').'';
			if(isset($this->date_livraisonmonth))$sql.= ' ,date_livraisonmonth='.(isset($this->date_livraisonmonth)?'"'.$this->db->escape($this->date_livraisonmonth).'"':'NULL').'';
			if(isset($this->date_livraisonyear))$sql.= ' ,date_livraisonyear='.(isset($this->date_livraisonyear)?'"'.$this->db->escape($this->date_livraisonyear).'"':'NULL').'';
			if(isset($this->multicurrency_code))$sql.= ' ,='.(isset($this->multicurrency_code)?'"'.$this->db->escape($this->multicurrency_code).'"':'NULL').'';
			if(isset($this->note_public))$sql.= ' ,note_public='.(isset($this->note_public)?'"'.$this->db->escape($this->note_public).'"':'NULL').'';
			if(isset($this->note_private))$sql.= ' ,note_private='.(isset($this->note_private)?'"'.$this->db->escape($this->note_private).'"':'NULL').'';
			if(isset($this->fk_user))$sql.= ' ,fk_user='.(isset($this->fk_user)?'"'.$this->db->escape($this->fk_user).'"':'NULL').'';
			if(isset($this->entrega))$sql.= ' ,entrega='.(isset($this->entrega)?'"'.$this->db->escape($this->entrega).'"':'NULL').'';
			if(isset($this->tipodias))$sql.= ' ,tipodias='.(isset($this->tipodias)?'"'.$this->db->escape($this->tipodias).'"':'NULL').'';
			if(isset($this->marca))$sql.= ' ,marca='.(isset($this->marca)?'"'.$this->db->escape($this->marca).'"':'NULL').'';
			if(isset($this->contacto))$sql.= ' ,contacto='.(isset($this->contacto)?'"'.$this->db->escape($this->contacto).'"':'NULL').'';
			if(isset($this->fk_user_res))$sql.= ' ,fk_user_res='.(isset($this->fk_user_res)?'"'.$this->db->escape($this->fk_user_res).'"':'NULL').'';
			if(isset($this->tiempo_isnt))$sql.= ' ,tiempo_isnt='.(isset($this->tiempo_isnt)?'"'.$this->db->escape($this->tiempo_isnt).'"':'NULL').'';
			
			$sql .= ' WHERE rowid='.$id.'';

			$this->db->begin();
			
			dol_syslog(get_class($this)."::update sql=".$sql, LOG_DEBUG);
			$resql = $this->db->query($sql);
			if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }
			
			if (! $error)
			{
				if (! $notrigger)
				{
					// Uncomment this and change MYOBJECT to your own tag if you
					// want this action calls a trigger.
					
					//// Call triggers
					//include_once DOL_DOCUMENT_ROOT . '/core/class/interfaces.class.php';
					//$interface=new Interfaces($this->db);
					//$result=$interface->run_triggers('MYOBJECT_MODIFY',$this,$user,$langs,$conf);
					//if ($result < 0) { $error++; $this->errors=$interface->errors; }
					//// End call triggers
				}
			}
			
			// Commit or rollback
			if ($error)
			{
				foreach($this->errors as $errmsg)
				{
					dol_syslog(get_class($this)."::update ".$errmsg, LOG_ERR);
					$this->error.=($this->error?', '.$errmsg:$errmsg);
				}
				$this->db->rollback();
				return -1*$error;
			}
			else
			{
				$this->db->commit();
				return 1;
			}
		}
		
		
		
		
		
		/**
			*  Delete object in database
			*
			*	@param  User	$user        User that deletes
			*  @param  int		$notrigger	 0=launch triggers after, 1=disable triggers
			*  @return	int					 <0 if KO, >0 if OK
		*/
		function delete($id, $notrigger=0)
		{
			global $conf, $langs;
			$error=0;
			
			$this->db->begin();
			
			if (! $error)
			{
				if (! $notrigger)
				{
					// Uncomment this and change MYOBJECT to your own tag if you
					// want this action calls a trigger.
					
					//// Call triggers
					//include_once DOL_DOCUMENT_ROOT . '/core/class/interfaces.class.php';
					//$interface=new Interfaces($this->db);
					//$result=$interface->run_triggers('MYOBJECT_DELETE',$this,$user,$langs,$conf);
					//if ($result < 0) { $error++; $this->errors=$interface->errors; }
					//// End call triggers
				}
			}
			
			
			
			
			if (! $error)
			{
				$sql = "DELETE FROM ".MAIN_DB_PREFIX."cotizaciones";
				$sql.= " WHERE rowid=".$id;
				
				dol_syslog(get_class($this)."::delete sql=".$sql);
				$resql = $this->db->query($sql);
				if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }
			}
			
			// Commit or rollback
			if ($error)
			{
				foreach($this->errors as $errmsg)
				{
					dol_syslog(get_class($this)."::delete ".$errmsg, LOG_ERR);
					$this->error.=($this->error?', '.$errmsg:$errmsg);
				}
				$this->db->rollback();
				return -1*$error;
			}
			else
			{
				$this->db->commit();
				return 1;
			}
		}
		
		
		
		
		
		public function generateDocument($modele, $outputlangs, $hidedetails=0, $hidedesc=0, $hideref=0, $moreparams=null)
		{
			global $conf,$langs;
			
			$langs->load("bills");
			
			if (! dol_strlen($modele)) {
				
				$modele = 'uranus';
				
				if ($this->modelpdf) {
					$modele = $this->modelpdf;
					} elseif (! empty($conf->global->COTIZACIONES_ADDON_PDF)) {
					$modele = $conf->global->COTIZACIONES_ADDON_PDF;
				}
			}
			
			$modelpath = "cotizaciones/doc/";
			
			return $this->commonGenerateDocument($modelpath, $modele, $outputlangs, $hidedetails, $hidedesc, $hideref, $moreparams);
		}
		
		
		
		
		
		/**
			*  Return if at least one photo is available
			*
			*  @param      string		$sdir       Directory to scan
			*  @return     boolean     			True if at least one photo is available, False if not
		*/
		function is_photo_available($sdir)
		{
			include_once DOL_DOCUMENT_ROOT .'/core/lib/files.lib.php';
			include_once DOL_DOCUMENT_ROOT .'/core/lib/images.lib.php';
			
			global $conf;
			
			$dir = $sdir;
			if (! empty($conf->global->PRODUCT_USE_OLD_PATH_FOR_PHOTO)) $dir .= '/'. get_exdir($this->id,2,0,0,$this,'cotizaciones') . $this->id ."/photos/";
			else $dir .= '/'.get_exdir(0,0,0,0,$this,'cotizaciones').dol_sanitizeFileName($this->ref).'/';
			
			$nbphoto=0;
			
			$dir_osencoded=dol_osencode($dir);
			if (file_exists($dir_osencoded))
			{
				$handle=opendir($dir_osencoded);
				if (is_resource($handle))
				{
					while (($file = readdir($handle)) !== false)
					{
						if (! utf8_check($file)) $file=utf8_encode($file);	// To be sure data is stored in UTF8 in memory
						if (dol_is_file($dir.$file) && image_format_supported($file) > 0) return true;
					}
				}
			}
			return false;
		}
		
		
		
		
		
		
		
		
		
		/**
			*  Return a link to the object card (with optionaly the picto)
			*
			*	@param	int		$withpicto			Include picto in link (0=No picto, 1=Include picto into link, 2=Only picto)
			*	@param	string	$option				On what the link point to
			*  @param	int  	$notooltip			1=Disable tooltip
			*  @param  string  $morecss            Add more css on link
			*	@return	string						String with URL
		*/
		function getNomUrl($withpicto=0, $option='', $notooltip=0, $morecss='')
		{
			global $db, $conf, $langs;
			global $dolibarr_main_authentication, $dolibarr_main_demo;
			global $menumanager;
			
			if (! empty($conf->dol_no_mouse_hover)) $notooltip=1;   // Force disable tooltips
			
			$result = '';
			$companylink = '';
			
			$label = '<u>' . $langs->trans("cotizaciones") . '</u>';
			$label.= '<br>';
			$label.= '<b>' . $langs->trans('Ref') . ':</b> ' . $this->ref;
			
			$url = $url = dol_buildpath('/cotizaciones/lista.php',1).'?mainmenu=cotizaciones&id='.$this->id;
			
			$linkclose='';
			if (empty($notooltip))
			{
				if (! empty($conf->global->MAIN_OPTIMIZEFORTEXTBROWSER))
				{
					$label=$langs->trans("Showcotizaciones");
					$linkclose.=' alt="'.dol_escape_htmltag($label, 1).'"';
				}
				$linkclose.=' title="'.dol_escape_htmltag($label, 1).'"';
				$linkclose.=' class="classfortooltip'.($morecss?' '.$morecss:'').'"';
			}
			else $linkclose = ($morecss?' class="'.$morecss.'"':'');
			
			$linkstart = '<a href="'.$url.'"';
			$linkstart.=$linkclose.'>';
			$linkend='</a>';
			
			if ($withpicto)
			{
				$result.=($linkstart.img_object(($notooltip?'':$label), 'label', ($notooltip?'':'class="classfortooltip"')).$linkend);
				if ($withpicto != 2) $result.=' ';
			}
			$result.= $linkstart . $this->ref . $linkend;
			return $result;
		}
		
		
		

	/**
	 *	Load all detailed lines into this->lines
	 *
	 *	@return     int         1 if OK, < 0 if KO
	 */
	function fetch_lineas()
	{
		$this->lineas=array();

            $sql = 'SELECT'; 
			$sql .= ' cd.rowid,'; 
			$sql .= 'cd.fk_product,';
			$sql .= 'cd.ref cref,';
			$sql .= 'cd.descripcion cdescripcion,';
			$sql .= 'p.ref,';
			$sql .= 'p.label,';
			$sql .= 'p.description,'; 
			$sql .= 'cd.fk_cotizacion,'; 
			$sql .= 'cd.cantidad,'; 
			$sql .= 'cd.pu,'; 
			$sql .= 'cd.total_ex,'; 
			$sql .= 'cd.total_gra,'; 
			$sql .= 'cd.lista_pu,'; 
			$sql .= 'cd.lista_desc,'; 
			$sql .= 'cd.lista_total,'; 
			$sql .= 'cd.flete_porcentaje,'; 
			$sql .= 'cd.flete_unitario,'; 
			$sql .= 'cd.flete_total,'; 
			$sql .= 'cd.utilidad_porcentaje,'; 
			$sql .= 'cd.utilidad_unitaria,'; 
			$sql .= 'cd.utilidad_total,'; 
			$sql .= 'cd.costo_fob_unitario,'; 
			$sql .= 'cd.costo_fob_total,'; 
			$sql .= 'cd.costo_cif_unitario,'; 
			$sql .= 'cd.costo_cif_total,'; 
			$sql .= 'cd.comision,'; 
			$sql .= 'cd.tipo,'; 
			$sql .= 'cd.descripcion,';
			$sql .= 'cd.clase,';
			$sql .= 'cd.tva_tx,';
			$sql .= 'cd.total_tva_tx';
			$sql .= ' FROM '.MAIN_DB_PREFIX.'cotizaciondet cd';
			$sql .= ' LEFT JOIN '.MAIN_DB_PREFIX.'product p ON cd.fk_product=p.rowid';
			$sql .= ' WHERE cd.fk_cotizacion='.$this->id.' ORDER BY cd.rowid DESC';

		dol_syslog(get_class($this).'::fetch_lines', LOG_DEBUG);
		$result = $this->db->query($sql);
		if ($result)
		{
			$num = $this->db->num_rows($result);
			$i = 0;
			while ($i < $num)
			{
				$objp = $this->db->fetch_object($result);
				$line = new CotizacionLigne($this->db);

				$line->id               = $objp->rowid;
				$line->rowid = $objp->rowid;
				$line->fk_product = $objp->fk_product;
				$line->cref = $objp->cref;
				$line->cdescripcion = $objp->cdescripcion;
				$line->ref = $objp->ref;
				$line->label = $objp->label;
				$line->description = $objp->description;
				$line->fk_cotizacion = $objp->fk_cotizacion;
				$line->cantidad = $objp->cantidad;
				$line->pu = $objp->pu;
				$line->total_ex = $objp->total_ex;
				$line->total_gra = $objp->total_gra;
				$line->lista_pu = $objp->lista_pu;
				$line->lista_desc = $objp->lista_desc;
				$line->lista_total = $objp->lista_total;
				$line->flete_porcentaje = $objp->flete_porcentaje;
				$line->flete_unitario = $objp->flete_unitario;
				$line->flete_total = $objp->flete_total;
				$line->utilidad_porcentaje = $objp->utilidad_porcentaje;
				$line->utilidad_unitaria = $objp->utilidad_unitaria;
				$line->utilidad_total = $objp->utilidad_total;
				$line->costo_fob_unitario = $objp->costo_fob_unitario;
				$line->costo_fob_total = $objp->costo_fob_total;
				$line->costo_cif_unitario = $objp->costo_cif_unitario;
				$line->costo_cif_total = $objp->costo_cif_total;
				$line->comision = $objp->comision;
				$line->tipo = $objp->tipo;
				$line->descripcion = $objp->descripcion;
				$line->clase = $objp->clase;
				$line->tva_tx = $objp->tva_tx;
				$line->total_tva_tx = $objp->total_tva_tx;

               //$line->fetch_optionals();

				$this->lineas[$i] = $line;

				$i++;
			}
			$this->db->free($result);
			return 1;
		}
		else
		{
			$this->error=$this->db->error();
			return -3;
		}
	}
		
		
		
		
		
		
		
		/**
			*  Retourne le libelle du status d'un user (actif, inactif)
			*
			*  @param	int		$mode          0=libelle long, 1=libelle court, 2=Picto + Libelle court, 3=Picto, 4=Picto + Libelle long, 5=Libelle court + Picto
			*  @return	string 			       Label of status
		*/
		function getLibStatut($mode=0)
		{
			return $this->LibStatut($this->status,$mode);
		}
		
		/**
			*  Return the status
			*
			*  @param	int		$status        	Id status
			*  @param  int		$mode          	0=long label, 1=short label, 2=Picto + short label, 3=Picto, 4=Picto + long label, 5=Short label + Picto, 5=Long label + Picto
			*  @return string 			       	Label of status
		*/
		static function LibStatut($status,$mode=0)
		{
			global $langs;
			
			if ($mode == 0)
			{
				$prefix='';
				if ($status == 1) return $langs->trans('Enabled');
				if ($status == 0) return $langs->trans('Disabled');
			}
			if ($mode == 1)
			{
				if ($status == 1) return $langs->trans('Enabled');
				if ($status == 0) return $langs->trans('Disabled');
			}
			if ($mode == 2)
			{
				if ($status == 1) return img_picto($langs->trans('Enabled'),'statut4').' '.$langs->trans('Enabled');
				if ($status == 0) return img_picto($langs->trans('Disabled'),'statut5').' '.$langs->trans('Disabled');
			}
			if ($mode == 3)
			{
				if ($status == 1) return img_picto($langs->trans('Cerrado'),'statut1.png');
				if ($status == 0) return img_picto($langs->trans('Abierto'),'statut0');
			}
			if ($mode == 4)
			{
				if ($status == 1) return img_picto($langs->trans('Enabled'),'statut4').' '.$langs->trans('Enabled');
				if ($status == 0) return img_picto($langs->trans('Disabled'),'statut5').' '.$langs->trans('Disabled');
			}
			if ($mode == 5)
			{
				if ($status == 1) return $langs->trans('Enabled').' '.img_picto($langs->trans('Enabled'),'statut4');
				if ($status == 0) return $langs->trans('Disabled').' '.img_picto($langs->trans('Disabled'),'statut5');
			}
			if ($mode == 6)
			{
				if ($status == 1) return $langs->trans('Enabled').' '.img_picto($langs->trans('Enabled'),'statut4');
				if ($status == 0) return $langs->trans('Disabled').' '.img_picto($langs->trans('Disabled'),'statut5');
			}
		}
		
		
		/**
			* Initialise object with example values
			* Id must be 0 if object instance is a specimen
			*
			* @return void
		*/
		public function initAsSpecimen()
		{
			$this->initAsSpecimenCommon();
		}
		
		
		
		
		/**
		*	devuelve la referencia de una linea.
		*  
	*/
	static function isExistingItem($element, $id, $ref='')
	{
		global $db,$conf;

		$sql = "SELECT rowid, ref, ref_ext";
		$sql.= " FROM ".MAIN_DB_PREFIX.$element;
		$sql.= " WHERE entity IN (".getEntity($element).")" ;

		if ($id > 0){ $sql.= " AND rowid = ".$db->escape($id);$res = -1;}
		else if ($ref) {$sql.= " AND ref = '".$db->escape($ref)."'";$res = -1;}
	
		else {
			$error='ErrorWrongParameters';
			dol_print_error(get_class()."::isExistingItem ".$error, LOG_ERR);
			return -1;
		}
		if ($ref || $ref_ext) $sql.= " AND entity = ".$conf->entity;

		dol_syslog(get_class()."::isExistingItem", LOG_DEBUG);
		$resql = $db->query($sql);
		if ($resql)
		{

			$num=$db->num_rows($resql);
			if ($num > 0) {
		    $res = array();
			for ($e3 = 1; $e3 <= $db->num_rows($sql); $e3++) {
			$obc3 = $db->fetch_object($sql);
			$res['ref'] = $obc3->ref;
			$res['id'] = $obc3->rowid;
			$res['fk_product'] = $obc3->fk_product;
			$res['cantidad'] = $obc3->cantidad;			
		}		
			return $res;
				}
			else return 0;
		}
		return -1;
	}			
		
	}
	
	
	
		



	/**
		*	Class to manage invoice lines.
		*  Saved into database table llx_facturedet
	*/
	class CotizacionLigne
	{
		public $element='cotizaciondet';
		public $table_element='cotizaciondet';
		
		public $id;	
		public $fk_product;
		public $ref; 
		public $fk_cotizacion; 
		public $cantidad; 
		public $pu; 
		public $total_ex; 
		public $total_gra; 
		public $lista_pu; 
		public $lista_desc; 
		public $lista_total; 
		public $flete_porcentaje; 
		public $flete_unitario; 
		public $flete_total; 
		public $utilidad_porcentaje; 
		public $utilidad_unitaria; 
		public $utilidad_total; 
		public $costo_fob_unitario; 
		public $costo_fob_total; 
		public $costo_cif_unitario; 
		public $costo_cif_total; 
		public $comision; 
		public $tipo; 
		public $clase; 
		public $descripcion;
		public $tva_tx;
		public $total_tva_tx;
		public $label;
		public $description;
		public $cref;
		public $cdescripcion;
		
	function __construct($db)
	{
		$this->db = $db;
	}

		/**
			*	Load cotizacion line from database
			*
			*	@param	int		$rowid      id of invoice line to get
			*	@return	int					<0 if KO, >0 if OK
		*/
		function fetch($id)
		{
			
			$sql = 'SELECT'; 
			$sql .= ' cd.rowid,'; 
			$sql .= 'cd.fk_product,';
			$sql .= 'cd.ref cref,';
			$sql .= 'cd.descripcion cdescripcion,';
			$sql .= 'p.ref,';
			$sql .= 'p.label,';
			$sql .= 'p.description,'; 
			$sql .= 'cd.fk_cotizacion,'; 
			$sql .= 'cd.cantidad,'; 
			$sql .= 'cd.pu,'; 
			$sql .= 'cd.total_ex,'; 
			$sql .= 'cd.total_gra,'; 
			$sql .= 'cd.lista_pu,'; 
			$sql .= 'cd.lista_desc,'; 
			$sql .= 'cd.lista_total,'; 
			$sql .= 'cd.flete_porcentaje,'; 
			$sql .= 'cd.flete_unitario,'; 
			$sql .= 'cd.flete_total,'; 
			$sql .= 'cd.utilidad_porcentaje,'; 
			$sql .= 'cd.utilidad_unitaria,'; 
			$sql .= 'cd.utilidad_total,'; 
			$sql .= 'cd.costo_fob_unitario,'; 
			$sql .= 'cd.costo_fob_total,'; 
			$sql .= 'cd.costo_cif_unitario,'; 
			$sql .= 'cd.costo_cif_total,'; 
			$sql .= 'cd.comision,'; 
			$sql .= 'cd.tipo,'; 
			$sql .= 'cd.descripcion,';
			$sql .= 'cd.clase,';
			$sql .= 'cd.tva_tx,';
			$sql .= 'cd.total_tva_tx';
			$sql .= ' FROM '.MAIN_DB_PREFIX.'cotizaciondet cd';
			$sql .= ' LEFT JOIN '.MAIN_DB_PREFIX.'product p ON cd.fk_product=p.rowid';
			$sql .= ' WHERE cd.rowid='.$id.' ORDER BY cd.rowid DESC';
			
			$result = $this->db->query($sql);
			if ($result)
			{
				$objp = $this->db->fetch_object($result);
				$this->id = $objp->rowid;
				$this->fk_product = $objp->fk_product;
				$this->cref = $objp->cref;
				$this->cdescripcion = $objp->cdescripcion;
				$this->ref = $objp->ref;
				$this->label = $objp->label;
				$this->description = $objp->description;
				$this->fk_cotizacion = $objp->fk_cotizacion;
				$this->cantidad = $objp->cantidad;
				$this->pu = $objp->pu;
				$this->total_ex = $objp->total_ex;
				$this->total_gra = $objp->total_gra;
				$this->lista_pu = $objp->lista_pu;
				$this->lista_desc = $objp->lista_desc;
				$this->lista_total = $objp->lista_total;
				$this->flete_porcentaje = $objp->flete_porcentaje;
				$this->flete_unitario = $objp->flete_unitario;
				$this->flete_total = $objp->flete_total;
				$this->utilidad_porcentaje = $objp->utilidad_porcentaje;
				$this->utilidad_unitaria = $objp->utilidad_unitaria;
				$this->utilidad_total = $objp->utilidad_total;
				$this->costo_fob_unitario = $objp->costo_fob_unitario;
				$this->costo_fob_total = $objp->costo_fob_total;
				$this->costo_cif_unitario = $objp->costo_cif_unitario;
				$this->costo_cif_total = $objp->costo_cif_total;
				$this->comision = $objp->comision;
				$this->tipo = $objp->tipo;
				$this->descripcion = $objp->descripcion;
				$this->clase = $objp->clase;
				$this->tva_tx = $objp->tva_tx;
				$this->total_tva_tx = $objp->total_tva_tx;
				
				
				$this->db->free($result);
				
				return 1;
			}
			else
			{
				$this->error = $this->db->lasterror();
				return -1;
			}
		}
		
		/**
			*	Insert line into database
			*
			*	@param      int		$notrigger		                 1 no triggers
			*  @param      int     $noerrorifdiscountalreadylinked  1=Do not make error if lines is linked to a discount and discount already linked to another
			*	@return		int						                 <0 if KO, >0 if OK
		*/
		function insert($notrigger=0, $noerrorifdiscountalreadylinked=0)
		{
			global $langs,$user,$conf;
			
			$error=0;
			
			$pa_ht_isemptystring = (empty($this->pa_ht) && $this->pa_ht == ''); // If true, we can use a default value. If this->pa_ht = '0', we must use '0'.
			
			dol_syslog(get_class($this)."::insert rang=".$this->rang, LOG_DEBUG);
			
			// Clean parameters
			
			
			if (empty($this->fk_product)) $this->fk_product=0;
			if (empty($this->ref)) $this->ref=0; 
			if (empty($this->fk_cotizacion)) $this->fk_cotizacion=0; 
			if (empty($this->cantidad)) $this->cantidad=0; 
			if (empty($this->pu)) $this->pu=0; 
			if (empty($this->total_ex)) $this->total_ex=0; 
			if (empty($this->total_gra)) $this->total_gra=0; 
			if (empty($this->lista_pu)) $this->lista_pu=0; 
			if (empty($this->lista_desc)) $this->lista_desc=0; 
			if (empty($this->lista_total)) $this->lista_total=0; 
			if (empty($this->flete_porcentaje)) $this->flete_porcentaje=0; 
			if (empty($this->flete_unitario)) $this->flete_unitario=0; 
			if (empty($this->flete_total)) $this->flete_total=0; 
			if (empty($this->utilidad_porcentaje)) $this->utilidad_porcentaje=0; 
			if (empty($this->utilidad_unitaria)) $this->utilidad_unitaria=0; 
			if (empty($this->utilidad_total)) $this->utilidad_total=0; 
			if (empty($this->costo_fob_unitario)) $this->costo_fob_unitario=0; 
			if (empty($this->costo_fob_total)) $this->costo_fob_total=0; 
			if (empty($this->costo_cif_unitario)) $this->costo_cif_unitario=0; 
			if (empty($this->costo_cif_total)) $this->costo_cif_total=0; 
			if (empty($this->comision)) $this->comision=0; 
			if (empty($this->tipo)) $this->tipo=0; 
			if (empty($this->clase)) $this->clase=0; 
			if (empty($this->descripcion)) $this->descripcion=0;
			if (empty($this->tva_tx)) $this->tva_tx=0;
			if (empty($this->total_tva_tx)) $this->total_tva_tx=0;
			
			// Check parameters
			if ($this->tipo < 0)
			{
				$this->error='ErrorProductTypeMustBe0orMore';
				return -1;
			}
			if (! empty($this->fk_product))
			{
				// Check product exists
				$result=Product::isExistingObject('product', $this->fk_product);
				if ($result <= 0)
				{
					$this->error='ErrorProductIdDoesNotExists';
					return -1;
				}
			}
			
			$this->db->begin();
			
			// Insertion dans base de la ligne
			$sql = 'INSERT INTO '.MAIN_DB_PREFIX.'cotizaciondet';
			$sql.= ' (';		
			$sql.= 'fk_product,';
			$sql.= 'ref,'; 
			$sql.= 'fk_cotizacion,'; 
			$sql.= 'cantidad,'; 
			$sql.= 'pu,'; 
			$sql.= 'total_ex,'; 
			$sql.= 'total_gra,'; 
			$sql.= 'lista_pu,'; 
			$sql.= 'lista_desc,'; 
			$sql.= 'lista_total,'; 
			$sql.= 'flete_porcentaje,'; 
			$sql.= 'flete_unitario,'; 
			$sql.= 'flete_total,'; 
			$sql.= 'utilidad_porcentaje,'; 
			$sql.= 'utilidad_unitaria,'; 
			$sql.= 'utilidad_total,'; 
			$sql.= 'costo_fob_unitario,'; 
			$sql.= 'costo_fob_total,'; 
			$sql.= 'costo_cif_unitario,'; 
			$sql.= 'costo_cif_total,'; 
			$sql.= 'comision,'; 
			$sql.= 'tipo,'; 
			$sql.= 'clase,'; 
			$sql.= 'descripcion,';
			$sql.= 'tva_tx,';
			$sql.= 'total_tva_tx';
			
			$sql.= ')';
			
			$sql.= " VALUES (";		
			
			
			$sql.= " ".(! empty($this->fk_product)?"'".$this->db->escape($this->fk_product)."'":"0").",";
			$sql.= " ".(! empty($this->ref)?"'".$this->db->escape($this->ref)."'":"0").","; 
			$sql.= " ".(! empty($this->fk_cotizacion)?"'".$this->db->escape($this->fk_cotizacion)."'":"0").","; 
			$sql.= " ".(! empty($this->cantidad)?"'".$this->db->escape($this->cantidad)."'":"0").","; 
			$sql.= " ".(! empty($this->pu)?"'".$this->db->escape(price2num($this->pu))."'":"0").","; 
			$sql.= " ".(! empty($this->total_ex)?"'".$this->db->escape(price2num($this->total_ex))."'":"0").","; 
			$sql.= " ".(! empty($this->total_gra)?"'".$this->db->escape(price2num($this->total_gra))."'":"0").","; 
			$sql.= " ".(! empty($this->lista_pu)?"'".$this->db->escape(price2num($this->lista_pu))."'":"0").","; 
			$sql.= " ".(! empty($this->lista_desc)?"'".$this->db->escape(price2num($this->lista_desc))."'":"0").","; 
			$sql.= " ".(! empty($this->lista_total)?"'".$this->db->escape(price2num($this->lista_total))."'":"0").","; 
			$sql.= " ".(! empty($this->flete_porcentaje)?"'".$this->db->escape(price2num($this->flete_porcentaje))."'":"0").","; 
			$sql.= " ".(! empty($this->flete_unitario)?"'".$this->db->escape(price2num($this->flete_unitario))."'":"0").","; 
			$sql.= " ".(! empty($this->flete_total)?"'".$this->db->escape(price2num($this->flete_total))."'":"0").","; 
			$sql.= " ".(! empty($this->utilidad_porcentaje)?"'".$this->db->escape(price2num($this->utilidad_porcentaje))."'":"0").","; 
			$sql.= " ".(! empty($this->utilidad_unitaria)?"'".$this->db->escape(price2num($this->utilidad_unitaria))."'":"0").","; 
			$sql.= " ".(! empty($this->utilidad_total)?"'".$this->db->escape(price2num($this->utilidad_total))."'":"0").","; 
			$sql.= " ".(! empty($this->costo_fob_unitario)?"'".$this->db->escape(price2num($this->costo_fob_unitario))."'":"0").","; 
			$sql.= " ".(! empty($this->costo_fob_total)?"'".$this->db->escape(price2num($this->costo_fob_total))."'":"0").","; 
			$sql.= " ".(! empty($this->costo_cif_unitario)?"'".$this->db->escape(price2num($this->costo_cif_unitario))."'":"0").","; 
			$sql.= " ".(! empty($this->costo_cif_total)?"'".$this->db->escape(price2num($this->costo_cif_total))."'":"0").","; 
			$sql.= " ".(! empty($this->comision)?"'".$this->db->escape(price2num($this->comision))."'":"0").","; 
			$sql.= " ".(! empty($this->tipo)?"'".$this->db->escape($this->tipo)."'":"0").","; 
			$sql.= " ".(! empty($this->clase)?"'".$this->db->escape($this->clase)."'":"0").","; 
			$sql.= " ".(! empty($this->descripcion)?"'".$this->db->escape($this->descripcion)."'":"0").",";
			$sql.= " ".(! empty($this->tva_tx)?"'".$this->db->escape(price2num($this->tva_tx))."'":"0").",";
			$sql.= " ".(! empty($this->total_tva_tx)?"'".$this->db->escape(price2num($this->total_tva_tx))."'":"0")."";
			
			$sql.= ')';
			
			dol_syslog(get_class($this)."::insert", LOG_DEBUG);
			$resql=$this->db->query($sql);
			if ($resql)
			{
				$this->id=$this->db->last_insert_id(MAIN_DB_PREFIX.'cotizaciondet');
				$this->rowid=$this->id;	// For backward compatibility
				
				if (empty($conf->global->MAIN_EXTRAFIELDS_DISABLED)) // For avoid conflicts if trigger used
				{
					//$result=$this->insertExtraFields();
					if ($result < 0)
					{
						$error++;
					}
				}
				
				
/* 				if (! $error && ! $notrigger)
				{
					// Call trigger
					$result=$this->call_trigger('LINECOT_INSERT',$user);
					if ($result < 0)
					{
						$this->db->rollback();
						return -2;
					}
					// End call triggers
				} */
				$this->db->commit();
				return $this->id;
				
			}
			else
			{
				$this->error=$this->db->lasterror();
				$this->db->rollback();
				return -2;
			}
		}
		
		/**
			*	Update line into database
			*
			*	@param		User	$user		User object
			*	@param		int		$notrigger	Disable triggers
			*	@return		int					<0 if KO, >0 if OK
		*/
		function update($user='',$notrigger=0)
		{
			global $user,$conf;
			
			$error=0;
			
			$pa_ht_isemptystring = (empty($this->pa_ht) && $this->pa_ht == ''); // If true, we can use a default value. If this->pa_ht = '0', we must use '0'.
			
			// Clean parameters

			
			// Check parameters
			if ($this->product_type < 0) return -1;
			

			
			$this->db->begin();
			
			// Mise a jour ligne en base
			$sql = "UPDATE ".MAIN_DB_PREFIX."cotizaciondet SET";
			if(isset($this->id))$sql .= ' rowid='.(isset($this->id)?'"'.$this->db->escape($this->id).'"':'NULL').'';
			if(isset($this->fk_product))$sql .= ' ,fk_product='.(isset($this->fk_product)?'"'.$this->db->escape($this->fk_product).'"':'NULL').'';
			if(isset($this->ref))$sql .= ' ,ref='.(isset($this->ref)?'"'.$this->db->escape($this->ref).'"':'NULL').''; 
			if(isset($this->fk_cotizacion))$sql .= ' ,fk_cotizacion='.(isset($this->fk_cotizacion)?'"'.$this->db->escape($this->fk_cotizacion).'"':'NULL').''; 
			if(isset($this->cantidad))$sql .= ' ,cantidad='.(isset($this->cantidad)?'"'.$this->db->escape($this->cantidad).'"':'NULL').''; 
			if(isset($this->pu))$sql .= ' ,pu='.(isset($this->pu)?'"'.$this->db->escape($this->pu).'"':'NULL').''; 
			if(isset($this->total_ex))$sql .= ' ,total_ex='.(isset($this->total_ex)?'"'.$this->db->escape($this->total_ex).'"':'NULL').''; 
			if(isset($this->total_gra))$sql .= ' ,total_gra='.(isset($this->total_gra)?'"'.$this->db->escape($this->total_gra).'"':'NULL').''; 
			if(isset($this->lista_pu))$sql .= ' ,lista_pu='.(isset($this->lista_pu)?'"'.$this->db->escape($this->lista_pu).'"':'NULL').''; 
			if(isset($this->lista_desc))$sql .= ' ,lista_desc='.(isset($this->lista_desc)?'"'.$this->db->escape($this->lista_desc).'"':'NULL').''; 
			if(isset($this->lista_total))$sql .= ' ,lista_total='.(isset($this->lista_total)?'"'.$this->db->escape($this->lista_total).'"':'NULL').''; 
			if(isset($this->flete_porcentaje))$sql .= ' ,flete_porcentaje='.(isset($this->flete_porcentaje)?'"'.$this->db->escape($this->flete_porcentaje).'"':'NULL').''; 
			if(isset($this->flete_unitario))$sql .= ' ,flete_unitario='.(isset($this->flete_unitario)?'"'.$this->db->escape($this->flete_unitario).'"':'NULL').''; 
			if(isset($this->flete_total))$sql .= ' ,flete_total='.(isset($this->flete_total)?'"'.$this->db->escape($this->flete_total).'"':'NULL').''; 
			if(isset($this->utilidad_porcentaje))$sql .= ' ,utilidad_porcentaje='.(isset($this->utilidad_porcentaje)?'"'.$this->db->escape($this->utilidad_porcentaje).'"':'NULL').''; 
			if(isset($this->utilidad_unitaria))$sql .= ' ,utilidad_unitaria='.(isset($this->utilidad_unitaria)?'"'.$this->db->escape($this->utilidad_unitaria).'"':'NULL').''; 
			if(isset($this->utilidad_total))$sql .= ' ,utilidad_total='.(isset($this->utilidad_total)?'"'.$this->db->escape($this->utilidad_total).'"':'NULL').''; 
			if(isset($this->costo_fob_unitario))$sql .= ' ,costo_fob_unitario='.(isset($this->costo_fob_unitario)?'"'.$this->db->escape($this->costo_fob_unitario).'"':'NULL').''; 
			if(isset($this->costo_fob_total))$sql .= ' ,costo_fob_total='.(isset($this->costo_fob_total)?'"'.$this->db->escape($this->costo_fob_total).'"':'NULL').''; 
			if(isset($this->costo_cif_unitario))$sql .= ' ,costo_cif_unitario='.(isset($this->costo_cif_unitario)?'"'.$this->db->escape($this->costo_cif_unitario).'"':'NULL').''; 
			if(isset($this->costo_cif_total))$sql .= ' ,costo_cif_total='.(isset($this->costo_cif_total)?'"'.$this->db->escape($this->costo_cif_total).'"':'NULL').''; 
			if(isset($this->comision))$sql .= ' ,comision='.(isset($this->comision)?'"'.$this->db->escape($this->comision).'"':'NULL').''; 
			if(isset($this->tipo))$sql .= ' ,tipo='.(isset($this->tipo)?'"'.$this->db->escape($this->tipo).'"':'NULL').''; 
			if(isset($this->clase))$sql .= ' ,clase='.(isset($this->clase)?'"'.$this->db->escape($this->clase).'"':'NULL').''; 
			if(isset($this->descripcion))$sql .= ' ,descripcion='.(isset($this->descripcion)?'"'.$this->db->escape($this->descripcion).'"':'NULL').'';
			if(isset($this->tva_tx))$sql .= ' ,tva_tx='.(isset($this->tva_tx)?'"'.$this->db->escape($this->tva_tx).'"':'NULL').'';
			if(isset($this->total_tva_tx))$sql .= ' ,total_tva_tx='.(isset($this->total_tva_tx)?'"'.$this->db->escape($this->total_tva_tx).'"':'NULL').'';
			
			$sql.= " WHERE rowid = ".$this->id;
			
			dol_syslog(get_class($this)."::update", LOG_DEBUG);
			$resql=$this->db->query($sql);
			if ($resql)
			{
/* 				if (empty($conf->global->MAIN_EXTRAFIELDS_DISABLED)) // For avoid conflicts if trigger used
				{
					$this->id=$this->rowid;
					$result=$this->insertExtraFields();
					if ($result < 0)
					{
						$error++;
					}
				}
				 */
/* 				if (! $error && ! $notrigger)
				{
					// Call trigger
					$result=$this->call_trigger('LINECOT_UPDATE',$user);
					if ($result < 0)
					{
						$this->db->rollback();
						return -2;
					}
					// End call triggers
				} */
				$this->db->commit();
				return 1;
			}
			else
			{
				$this->error=$this->db->error();
				$this->db->rollback();
				return -2;
			}
		}
		
		/**
			* 	Delete line in database
			*  TODO Add param User $user and notrigger (see skeleton)
			*
			*	@return	    int		           <0 if KO, >0 if OK
		*/
		function delete()
		{
			global $user;
			
			$this->db->begin();
			
			// Call trigger
			//$result=$this->call_trigger('LINECOT_DELETE',$user);
			if ($result < 0)
			{
				$this->db->rollback();
				return -1;
			}
			// End call triggers
			
			
			$sql = "DELETE FROM ".MAIN_DB_PREFIX."cotizaciondet WHERE rowid = ".$this->id;
			dol_syslog(get_class($this)."::delete", LOG_DEBUG);
			if ($this->db->query($sql) )
			{
				$this->db->commit();
				return 1;
			}
			else
			{
				$this->error=$this->db->error()." sql=".$sql;
				$this->db->rollback();
				return -1;
			}
		}
		

		
		
	}	