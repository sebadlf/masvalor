<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
  <tr>
  <td colspan="2">
	<div id="footer" role="contentinfo">
			
			
			<div class="pie-links" >
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'fourth' ) ); ?>
			</div>
						
			<div class="site-info">
				<p><span class="pie-title">Programa +VALOR.Doc</span> <br />
				Consejo Nacional de Investigaciones Cient&iacute;ficas y T&eacute;cnicas <br />
				Ministerio de Ciencia, Tecnolog&iacute;a e Innovaci&oacute;n Productiva <br />
				</p>
  Av. Rivadavia 1917 - 4&ordm; piso - C1033AAJ <br />
                            Ciudad Aut&oacute;noma de Buenos Aires -  Rep&uacute;blica Argentina <br />
			  Tel: (+54-11) 5983-1420 Int. 257  <br />
                            masVALORDoc@conicet.gov.ar <br />
                            www.masVALORDoc.conicet.gov.ar			</div><!-- #site-info -->

			<div class="pie-logos">				
					<div class="b-image-masva"><img WIDTH="284" HEIGHT="82" src="wp-content/themes/rollpix/images/custom/masvalor_foot.png" alt="Mincyt" /></div>
					<div class="b-image"><a href="http://www.conicet.gob.ar/" target="_blank" >
                    <img src="wp-content/themes/rollpix/images/custom/conicetpie.png" alt="Conicet" /></a></div>
			        <div class="b-image"><a href="http://www.mincyt.gob.ar/"  target="_blank" >
                    <img src="wp-content/themes/rollpix/images/custom/mcytpie.png" alt="Mincyt" /></a></div>
					
			</div><!-- #site-generator -->

		<div style="clear:both;"></div>
	</div><!-- #footer -->
 
  </td>
  </tr>
 </tbody>
</table>

<?php
	
	wp_footer();
?>
 