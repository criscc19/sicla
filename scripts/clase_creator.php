
<?php 
require '../main.inc.php';	
$tabla = $db->query('SHOW FIELDS FROM llx_cotizaciones');

			for ($e = 1; $e <= $db->num_rows($tabla); $e++) {
			$objs = $db->fetch_object($tabla);
			echo 'public $'.$objs->Field.';<br>';

			}
?>
<br><br><br>

//LIMPIANDO<br>
<?php 
$tabla = $db->query('SHOW FIELDS FROM llx_cotizaciones');
			for ($e = 1; $e <= $db->num_rows($tabla); $e++) {
            $objs = $db->fetch_object($tabla);?>
			if (isset($this-><?php echo $objs->Field; ?>)) $this-><?php echo $objs->Field; ?>=trim($this-><?php echo $objs->Field; ?>);<br>	
           <?php }?>
<br><br><br>
//INSERT<br>
<?php 
$tabla = $db->query('SHOW FIELDS FROM llx_cotizaciones');
			for ($e = 1; $e <= $db->num_rows($tabla); $e++) {
            $objs = $db->fetch_object($tabla);?>
			$sql.= '<?php echo $objs->Field; ?>,';<br>	
           <?php }?>
//INSERT<br>
<?php 
$tabla = $db->query('SHOW FIELDS FROM llx_cotizaciones');
			for ($e = 1; $e <= $db->num_rows($tabla); $e++) {
            $objs = $db->fetch_object($tabla);?>
			$sql.= ''.(! isset($this-><?php echo $objs->Field; ?>)?"NULL":'"'.$this->db->escape($this-><?php echo $objs->Field; ?>).'"').',';<br>	
           <?php }?>
<br><br><br>
//FETCH<br>
<?php 
$tabla = $db->query('SHOW FIELDS FROM llx_cotizaciones');
			for ($e = 1; $e <= $db->num_rows($tabla); $e++) {
            $objs = $db->fetch_object($tabla);?>
						$sql.= '<?php echo $objs->Field; ?>,';<br>	
           <?php }?>
//FETCH<br>
<?php 
	$tabla = $db->query('SHOW FIELDS FROM llx_cotizaciones');
			for ($e = 1; $e <= $db->num_rows($tabla); $e++) {
            $objs = $db->fetch_object($tabla);?>
			$this-><?php echo $objs->Field; ?> = $obj-><?php echo $objs->Field; ?>;<br>	
           <?php }?>
<br><br><br>		   
//UPDATE<br>
<?php 
	$tabla = $db->query('SHOW FIELDS FROM llx_cotizaciones');
			for ($e = 1; $e <= $db->num_rows($tabla); $e++) {
            $objs = $db->fetch_object($tabla);?>
			if(isset($this-><?php echo $objs->Field; ?>))$sql.= ' ,<?php echo $objs->Field; ?>='.(isset($this-><?php echo $objs->Field; ?>)?'"'.$this->db->escape($this-><?php echo $objs->Field; ?>).'"':'NULL').'';<br>	
           <?php }?>