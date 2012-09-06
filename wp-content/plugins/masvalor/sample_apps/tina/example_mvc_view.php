<?php
/**
* The view file for the example_mvc page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
* @see        example_mvc_page.php the page controller
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
?>
<h2>This is a view loaded from 'example-mvc_page.php'</h2>

<p>This is a page of paragraph.</p>

<p>Some data added using add_var_e():<br><br>
    $V->var_e['var1'] => <?php echo $V->var_e['var1'] ?><br>
    $V->var_e['arrVar'] => <?php print_r( $V->var_e['arrVar'] ) ?> (echo'd using print_r() )<br>
    $V->var_e['var2'] => <?php echo $V->var_e['var2'] ?><br>
</p>

<p>Some data added using add_var():<br><br>
    $V->var_valid => <?php echo $V->var_valid ?>
</p>

<p>Some invalid data added using add_var() - use add_var_e() instead:<br><br>
    $V->var_invalid => <?php echo $V->var_invalid ?>
</p>

<p>    
Looping over the array using foreach():
</p>    
<table>
    <tr>
        <td>Array Index</td><td>Array Value</td>
    </tr>
    
    <?php foreach( $V->var_e['arrVar'] as $i => $v): ?>
        <tr>
            <td><?php echo  $i ?></td><td><?php echo  $v ?></td>
        </tr>
    <?php  endforeach; ?>
    
</table>    

<hr>
